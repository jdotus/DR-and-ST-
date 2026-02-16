<?php
// Database configuration
$host = 'localhost';
$dbname = 'final_dr';
$username = 'root';
$password = '';

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request method.";
    exit;
}

// Get the form type
$dr_format = $_POST['dr_format'] ?? '';

// Common fields for all formats
$si_number = $_POST['si_number'] ?? '';
$dr_number = $_POST['dr_number'] ?? '';
$delivered_to = $_POST['delivered_to'] ?? '';
$date = $_POST['date'] ?? '';
$address = $_POST['address'] ?? '';
$terms = $_POST['terms'] ?? '';
$particulars = $_POST['particulars'] ?? '';
$tin = $_POST['tin'] ?? '';
$unit_type = $_POST['unit_type'] ?? '';

try {
    // Start transaction
    $pdo->beginTransaction();

    // Save based on the selected format
    switch ($dr_format) {
        case 'used':
            $record_id = saveUsedFormat2($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $_POST);
            break;

        case 'bnew':
            $record_id = saveBNewFormat2($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $_POST);
            break;

        case 'pullout-delivery':
            $record_id = savePulloutDeliveryFormat($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $_POST);
            break;

        case 'drWithPrice':
            $record_id = saveDrWithPriceFormat($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $_POST);
            break;

        case 'drWithInvoice':
            $record_id = saveDrWithInvoiceFormat($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $_POST);
            break;

        case 'usedDr':
            $record_id = saveUsedDrFormat($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $_POST);
            break;

        default:
            throw new Exception("Invalid form format selected.");
    }

    // Commit transaction
    $pdo->commit();

    // Store the data in session for the print page
    session_start();
    $_SESSION['form_data'] = $_POST;
    $_SESSION['saved_record_id'] = $record_id;

    // Redirect to print page
    header("Location: DR_Print.php");
    exit;
} catch (Exception $e) {
    // Rollback transaction on error
    $pdo->rollBack();
    echo "Error saving data: " . $e->getMessage();
    exit;
}

function saveUsedFormat2($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $post)
{
    $serials = $post['serial'] ?? [];
    $models = $post['model'] ?? [];
    $mr_starts = $post['mr_start'] ?? [];
    $color_imps = $post['color_imp'] ?? [];
    $black_imps = $post['black_imp'] ?? [];
    $color_large_imps = $post['color_large_imp'] ?? [];

    $stmnt = $pdo->prepare("
        INSERT INTO main
        (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, type) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'usedmachine')");

    $stmnt->execute([
        $si_number,
        $dr_number,
        $delivered_to,
        $tin,
        $address,
        $terms,
        $particulars,
        $date
    ]);

    $main_id = $pdo->lastInsertId();

    // Prepare used_machine insert
    $stmtMachine = $pdo->prepare("
        INSERT INTO used_machine 
        (dr_number, unit_type, machine_model, serial_no, mr_start, color_impression, black_impression, color_large_impression) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    // Prepare history insert (once outside loop)
    $stmtHistory = $pdo->prepare("
        INSERT INTO historyv2
        (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, unit_type, machine_model, serial_no, mr_start, color_impression, black_impression, color_large_impression, type, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'usedmachine', 'CREATED')");

    // Collect all values for history with comma-separated impressions
    $all_mr_starts = [];
    $all_color_imps = [];
    $all_black_imps = [];
    $all_color_large_imps = [];

    for ($i = 0; $i < count($serials); $i++) {
        // Clean numeric values
        $color_imp = isset($color_imps[$i]) ? str_replace(',', '', $color_imps[$i]) : "0";
        $black_imp = isset($black_imps[$i]) ? str_replace(',', '', $black_imps[$i]) : "0";
        $color_large_imp = isset($color_large_imps[$i]) ? str_replace(',', '', $color_large_imps[$i]) : "0";
        $mr_start = isset($mr_starts[$i]) ? str_replace(',', '', $mr_starts[$i]) : "0";
        $mr_start = substr($mr_start, 0, 6);


        // Collect for comma-separated history
        $all_mr_starts[] = $mr_start;
        $all_color_imps[] = $color_imp;
        $all_black_imps[] = $black_imp;
        $all_color_large_imps[] = $color_large_imp;

        // Insert into used_machine individually
        $stmtMachine->execute([
            $dr_number,
            $unit_type,
            $models[0] ?? '',
            $serials[$i],
            $mr_start,
            $color_imp,
            $black_imp,
            $color_large_imp
        ]);
    }

    // Combine all impressions as comma-separated strings for single history record
    $mr_starts_combined = implode(', ', $all_mr_starts);
    $color_imps_combined = implode(', ', $all_color_imps);
    $black_imps_combined = implode(', ', $all_black_imps);
    $color_large_imps_combined = implode(', ', $all_color_large_imps);
    $serials_combined = implode(', ', $serials);

    // Insert single history record with all comma-separated values
    $stmtHistory->execute([
        $si_number,
        $dr_number,
        $delivered_to,
        $tin,
        $address,
        $terms,
        $particulars,
        $date,
        $unit_type,
        $models[0] ?? '',
        $serials_combined,
        $mr_starts_combined,
        $color_imps_combined,
        $black_imps_combined,
        $color_large_imps_combined
    ]);

    return $main_id;
}

//Bnew Testing Only 
function saveBNewFormat2($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $post)
{
    $serials = $post['serial'] ?? [];
    $models = $post['model'] ?? [];

    // 1. Insert into the MAIN table (main)
    $stmtMain = $pdo->prepare("
        INSERT INTO main 
        (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, type) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'bnew')
    ");

    $stmtMain->execute([
        $si_number,
        $dr_number,
        $delivered_to,
        $tin,
        $address,
        $terms,
        $particulars,
        $date
    ]);

    // Get the ID of the newly created header record
    $main_id = $pdo->lastInsertId();

    // 2. Insert into the MACHINE DETAILS table (bnew_machine)
    $stmtMachine = $pdo->prepare("
    INSERT INTO bnew_machine 
    (dr_number, unit_type, machine_model, serial_no) 
    VALUES (?, ?, ?, ?)
    ");

    foreach ($serials as $i => $serial_input) {

        // Split comma-separated serials if multiple are entered in one field
        $individual_serials = array_filter(array_map('trim', explode(',', $serial_input)), function ($s) {
            return $s !== '';
        });
        $model_name = $models[$i] ?? '';

        // Combine serials into one comma-separated string for history
        $serials_combined = implode(', ', $individual_serials);

        //For the History Table (one row per model/group with combined serials)
        $stmtHistory = $pdo->prepare("
                INSERT INTO historyv2
                (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, unit_type, machine_model, serial_no, type, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'bnew', 'CREATED')");
        $stmtHistory->execute([
            $si_number,
            $dr_number,
            $delivered_to,
            $tin,
            $address,
            $terms,
            $particulars,
            $date,
            $unit_type,
            $model_name,
            $serials_combined
        ]);

        foreach ($individual_serials as $serial) {
            if (!empty($serial)) {
                $stmtMachine->execute([
                    $dr_number,
                    $unit_type,
                    $model_name,
                    $serial
                ]);
            }
        }
    }

    // Return the ID to the main script so it can be stored in the session
    return $main_id;
}

// Function to save Pullout Delivery format
function savePulloutDeliveryFormat($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $post)
{
    $pullout_type = $post['pullout_type'] ?? '';

    if ($pullout_type === 'replacementOnly') {
        saveReplacementOnly2($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $post);
        return;
    } elseif ($pullout_type === 'pulloutOnly') {
        savePulloutOnly($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $post);
        return;
    } else {
        saveBothPulloutReplacement($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $post);
        return;
    }
}

/// Dynamic Replacement Only - based on serials
function saveReplacementOnly2($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $post)
{
    $stmtMain = $pdo->prepare("
        INSERT INTO main
        (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, type) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'replacementmachine')");

    $stmtMain->execute([
        $si_number,
        $dr_number,
        $delivered_to,
        $tin,
        $address,
        $terms,
        $particulars,
        $date
    ]);

    $main_id = $pdo->lastInsertId();

    // Prepare statements
    $stmtReplacement = $pdo->prepare("
        INSERT INTO replacement_machine
        (dr_number, unit_type, machine_model, serial_no, mr_start, color_impression, black_impression, color_large_impression) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmtHistoryReplacement = $pdo->prepare("
        INSERT INTO historyv2
        (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, 
         unit_type, machine_model, serial_no, mr_start, color_impression, black_impression, 
         color_large_impression, type, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'replacementmachine', 'CREATED')");

    // Process each machine group
    foreach ($post['replace_only_machines'] as $machineGroup) {
        $model_name = $machineGroup['model'] ?? '';

        if (!empty(trim($model_name)) && isset($machineGroup['serials']) && is_array($machineGroup['serials'])) {

            // Arrays to store all values for this model group
            $serialNumbers = [];
            $mr_start_values = [];
            $color_imp_values = [];
            $black_imp_values = [];
            $color_large_imp_values = [];

            foreach ($machineGroup['serials'] as $serialData) {
                $serial_no = trim($serialData['serial'] ?? '');

                if (!empty($serial_no)) {
                    // Add to serial numbers array
                    $serialNumbers[] = $serial_no;

                    // Add impression values to arrays
                    // $mr_start_values[] = $serialData['mr_start'] ?? '';
                    $mr_start_values[] = isset($serialData['mr_start']) ? (int)str_replace(',', '', $serialData['mr_start']) : 0;
                    $color_imp_values[] = isset($serialData['color_imp']) ? (int)str_replace(',', '', $serialData['color_imp']) : 0;
                    $black_imp_values[] = isset($serialData['black_imp']) ? (int)str_replace(',', '', $serialData['black_imp']) : 0;
                    $color_large_imp_values[] = isset($serialData['color_large_imp']) ? (int)str_replace(',', '', $serialData['color_large_imp']) : 0;

                    // Insert individual record into replacement_machine table (keeping individual records)
                    try {
                        $stmtReplacement->execute([
                            $dr_number,
                            $unit_type,
                            $model_name,
                            $serial_no,
                            $serialData['mr_start'] ?? '',
                            isset($serialData['color_imp']) ? (int)str_replace(',', '', $serialData['color_imp']) : 0,
                            isset($serialData['black_imp']) ? (int)str_replace(',', '', $serialData['black_imp']) : 0,
                            isset($serialData['color_large_imp']) ? (int)str_replace(',', '', $serialData['color_large_imp']) : 0
                        ]);
                    } catch (PDOException $e) {
                        error_log("Database error in replacement_machine: " . $e->getMessage());
                    }
                }
            }

            // If we have serials for this model, insert ONE record into historyv2 with comma-separated values
            if (!empty($serialNumbers)) {
                // Combine all values with commas
                $serialCombined = implode(', ', $serialNumbers);
                $mr_start_combined = implode(', ', $mr_start_values);
                $color_imp_combined = implode(', ', $color_imp_values);
                $black_imp_combined = implode(', ', $black_imp_values);
                $color_large_imp_combined = implode(', ', $color_large_imp_values);

                try {
                    $stmtHistoryReplacement->execute([
                        $si_number,
                        $dr_number,
                        $delivered_to,
                        $tin,
                        $address,
                        $terms,
                        $particulars,
                        $date,
                        $unit_type,
                        $model_name,                    // Machine model (single value - same for all in group)
                        $serialCombined,                 // Comma-separated serials
                        $mr_start_combined,               // Comma-separated MR start values
                        $color_imp_combined,              // Comma-separated color impression values
                        $black_imp_combined,               // Comma-separated black impression values
                        $color_large_imp_combined           // Comma-separated color large impression values
                    ]);
                } catch (PDOException $e) {
                    error_log("Database error in historyv2: " . $e->getMessage());
                }
            }
        }
    }

    return $main_id;
}

// Dynamic Pullout Only - based on serials
function savePulloutOnly($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $post)
{
    $stmt = $pdo->prepare("INSERT INTO main (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pulloutmachine')");

    $stmt->execute([
        $si_number,
        $dr_number,
        $delivered_to,
        $tin,
        $address,
        $terms,
        $particulars,
        $date
    ]);

    $record_id = $pdo->lastInsertId();

    // Prepare statements
    $stmt_pullout = $pdo->prepare('INSERT INTO pullout_machine (dr_number, unit_type, machine_model, serial_no, mr_end, color_impression, black_impression, color_large_impression) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

    $stmtHistoryPullout = $pdo->prepare("
        INSERT INTO historyv2
        (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, 
         unit_type, machine_model, serial_no, mr_end, color_impression, black_impression, 
         color_large_impression, type, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pulloutmachine', 'CREATED')");

    foreach ($post['pullout_machines'] as $machineGroup) {
        $model_name = $machineGroup['model'] ?? '';

        if (!empty(trim($model_name)) && isset($machineGroup['serials']) && is_array($machineGroup['serials'])) {

            // Arrays to store all values for this model group
            $serialNumbers = [];
            $mr_end_values = [];
            $color_imp_values = [];
            $black_imp_values = [];
            $color_large_imp_values = [];

            foreach ($machineGroup['serials'] as $serialData) {
                $serial_no = trim($serialData['serial'] ?? '');

                if (!empty(trim($serial_no))) {
                    // Add to serial numbers array
                    $serialNumbers[] = $serial_no;

                    // Clean and add impression values to arrays
                    $mr_end = isset($serialData['mr_end']) ? (int)str_replace(',', '', $serialData['mr_end']) : 0;
                    $color_imp = isset($serialData['color_imp']) ? (int)str_replace(',', '', $serialData['color_imp']) : 0;
                    $black_imp = isset($serialData['black_imp']) ? (int)str_replace(',', '', $serialData['black_imp']) : 0;
                    $color_large_imp = isset($serialData['color_large_imp']) ? (int)str_replace(',', '', $serialData['color_large_imp']) : 0;

                    $mr_end_values[] = $mr_end;
                    $color_imp_values[] = $color_imp;
                    $black_imp_values[] = $black_imp;
                    $color_large_imp_values[] = $color_large_imp;

                    // Insert individual record into pullout_machine table (keeping individual records)
                    try {
                        $stmt_pullout->execute([
                            $dr_number,
                            $unit_type,
                            $model_name,
                            $serial_no,
                            $mr_end,
                            $color_imp,
                            $black_imp,
                            $color_large_imp
                        ]);
                    } catch (PDOException $e) {
                        error_log("Database error in pullout_machine: " . $e->getMessage());
                    }
                }
            }

            // If we have serials for this model, insert ONE record into historyv2 with comma-separated values
            if (!empty($serialNumbers)) {
                // Combine all values with commas
                $serialCombined = implode(', ', $serialNumbers);
                $mr_end_combined = implode(', ', $mr_end_values);
                $color_imp_combined = implode(', ', $color_imp_values);
                $black_imp_combined = implode(', ', $black_imp_values);
                $color_large_imp_combined = implode(', ', $color_large_imp_values);

                try {
                    $stmtHistoryPullout->execute([
                        $si_number,
                        $dr_number,
                        $delivered_to,
                        $tin,
                        $address,
                        $terms,
                        $particulars,
                        $date,
                        $unit_type,
                        $model_name,                    // Machine model (single value - same for all in group)
                        $serialCombined,                 // Comma-separated serials
                        $mr_end_combined,                 // Comma-separated MR end values
                        $color_imp_combined,              // Comma-separated color impression values
                        $black_imp_combined,               // Comma-separated black impression values
                        $color_large_imp_combined           // Comma-separated color large impression values
                    ]);
                } catch (PDOException $e) {
                    error_log("Database error in historyv2: " . $e->getMessage());
                }
            }
        }
    }

    return $record_id;
}



// Dynamic Both Pullout Replacement - based on serials
function saveBothPulloutReplacement($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $post)
{
    $record_id = null;

    // Save replacement machines
    $replace_serials = $post['replace_serial'] ?? [];
    $replace_models = $post['replace_model'] ?? [];
    $replace_mr_starts = $post['replace_mr_start'] ?? [];
    $replace_color_imps = $post['replace_color_imp'] ?? [];
    $replace_black_imps = $post['replace_black_imp'] ?? [];
    $replace_color_large_imps = $post['replace_color_large_imp'] ?? [];

    // Save pullout machines
    $pullout_serials = $post['pullout_serial'] ?? [];
    $pullout_models = $post['pullout_model'] ?? [];
    $pullout_mr_ends = $post['pullout_mr_end'] ?? [];
    $pullout_color_imps = $post['pullout_color_imp'] ?? [];
    $pullout_black_imps = $post['pullout_black_imp'] ?? [];
    $pullout_color_large_imps = $post['pullout_color_large_imp'] ?? [];

    if (!empty($replace_serials) && !empty($replace_serials)) {
        // $stmt = $pdo->prepare("INSERT INTO replacement_machine_dr (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, unit_type, machine_model, serial_no, mr_start, color_impression, black_impression, color_large_impression) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt = $pdo->prepare("INSERT INTO main (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pulloutandreplacement')");

        $stmt->execute([
            $si_number,
            $dr_number,
            $delivered_to,
            $tin,
            $address,
            $terms,
            $particulars,
            $date
        ]);

        //For the History Table
        $stmtHistory = $pdo->prepare("
        INSERT INTO history
        (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, type, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pulloutandreplacement', 'CREATED')");

        $stmtHistory->execute([
            $si_number,
            $dr_number,
            $delivered_to,
            $tin,
            $address,
            $terms,
            $particulars,
            $date
        ]);

        $record_id = $pdo->lastInsertId();

        $stmt_replacement = $pdo->prepare("INSERT INTO replacement_machine (dr_number, unit_type, machine_model, serial_no, mr_start, color_impression, black_impression, color_large_impression) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        for ($i = 0; $i < count($replace_serials); $i++) {
            // if (!empty(trim($replace_serials[$i]))) {
            // Clean numeric values
            $color_imp = isset($replace_color_imps[$i]) ? (int)str_replace(',', '', $replace_color_imps[$i]) : 0;
            $black_imp = isset($replace_black_imps[$i]) ? (int)str_replace(',', '', $replace_black_imps[$i]) : 0;
            $color_large_imp = isset($replace_color_large_imps[$i]) ? (int)str_replace(',', '', $replace_color_large_imps[$i]) : 0;

            $stmt_replacement->execute([
                $dr_number,
                $unit_type,
                $replace_models[0] ?? '',
                $replace_serials[$i],
                $replace_mr_starts[$i] ?? '',
                $color_imp,
                $black_imp,
                $color_large_imp
            ]);

            if ($record_id === null) {
                $record_id = $pdo->lastInsertId();
            }
        }



        $stmt_pullout = $pdo->prepare('INSERT INTO pullout_machine(dr_number, unit_type, machine_model, serial_no, mr_end, color_impression, black_impression, color_large_impression) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

        for ($i = 0; $i < count($pullout_serials); $i++) {
            if (!empty(trim($pullout_serials[$i]))) {
                // Clean numeric values
                $color_imp = isset($pullout_color_imps[$i]) ? (int)str_replace(',', '', $pullout_color_imps[$i]) : 0;
                $black_imp = isset($pullout_black_imps[$i]) ? (int)str_replace(',', '', $pullout_black_imps[$i]) : 0;
                $color_large_imp = isset($pullout_color_large_imps[$i]) ? (int)str_replace(',', '', $pullout_color_large_imps[$i]) : 0;

                $stmt_pullout->execute([
                    $dr_number,
                    $unit_type,
                    $pullout_models[0] ?? '',
                    $pullout_serials[$i],
                    $pullout_mr_ends[$i] ?? '',
                    $color_imp,
                    $black_imp,
                    $color_large_imp
                ]);
            }
        }
    }
    return $record_id;
}

// Function to save DR with Price format - One main record with multiple items
function saveDrWithPriceFormat($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $post)
{

    if (empty($post['quantity']) || !is_array($post['quantity'])) {
        throw new Exception("No items provided for DR with Price format.");
    }

    $models = $post['model'] ?? [];
    $quantities = $post['quantity'] ?? [];
    $prices = $post['price'] ?? [];
    $unit_types = $post['unit_type'] ?? [];
    $item_descs = $post['item_desc'] ?? [];

    // Insert main record (only once)
    // $main_stmt = $pdo->prepare("INSERT INTO dr_with_price (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, machine_model) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $main_stmt = $pdo->prepare("INSERT INTO main (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'drwithprice')");

    $main_stmt->execute([
        $si_number,
        $dr_number,
        $delivered_to,
        $tin,
        $address,
        $terms,
        $particulars,
        $date
    ]);

    //For the History Table
    $stmtHistory = $pdo->prepare("
        INSERT INTO history
        (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, type, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'drwithprice', 'CREATED')");

    $stmtHistory->execute([
        $si_number,
        $dr_number,
        $delivered_to,
        $tin,
        $address,
        $terms,
        $particulars,
        $date
    ]);

    $record_id = $pdo->lastInsertId();

    // Insert item records dynamically based on quantity length
    $items_stmt = $pdo->prepare("INSERT INTO dr_with_price (dr_number, machine_model, quantity, price, total, unit_type, item_description) VALUES (?, ?, ?, ?, ?, ?, ?)");

    $valid_items_count = 0;

    for ($i = 0; $i < count($quantities); $i++) {
        // Only insert if both quantity and description are not empty
        if (!empty(trim($quantities[$i])) && !empty(trim($item_descs[$i]))) {

            // Clean numeric values
            $price_val = isset($prices[$i]) ? floatval(str_replace([',', ' '], '', $prices[$i])) : 0.0;
            $quantity_val = (int)str_replace([',', ' '], '', $quantities[$i]);

            // Get the total price for the item
            if ($price_val < 0 && $quantity_val < 0) {
                $price_val = 0.0;
                $quantity_val = 0;
            }
            $total_price = $quantity_val * $price_val;

            // Use item-specific unit_type if available, otherwise use main unit_type
            $current_unit_type = isset($unit_types[$i]) ? $unit_types[$i] : $unit_type;

            $items_stmt->execute([
                $dr_number,
                $models[0] ?? '',
                $quantity_val,
                $price_val,
                $total_price,
                $current_unit_type,
                $item_descs[$i]
            ]);

            $valid_items_count++;
        }
    }

    // Optional: Update grand total in main record if you have that column

    return $record_id;
}

// Function to save DR with Invoice format - Dynamic based on items
function saveDrWithInvoiceFormat($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $post)
{
    if (!empty($post['quantity']) && is_array($post['quantity'])) {

        $po_numbers = $post['po_number'] ?? [];
        $invoice_numbers = $post['invoice_number'] ?? [];
        $notes = $post['note'] ?? [];
        $models = $post['model'] ?? [];

        // Determine delivery type
        $delivery_type = (!empty($invoice_numbers[0])) ? 'complete' : 'partial';

        $stmt = $pdo->prepare("INSERT INTO main (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'drinvoice')");

        $stmt->execute([
            $si_number,
            $dr_number,
            $delivered_to,
            $tin,
            $address,
            $terms,
            $particulars,
            $date
        ]);

        //For the History Table
        $stmtHistory = $pdo->prepare("
        INSERT INTO history
        (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, type, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'drinvoice', 'CREATED')");

        $stmtHistory->execute([
            $si_number,
            $dr_number,
            $delivered_to,
            $tin,
            $address,
            $terms,
            $particulars,
            $date
        ]);

        $record_id = $pdo->lastInsertId();

        // Save items dynamically
        $quantities = $post['quantity'] ?? [];
        $unit_types = $post['unit_type'] ?? [];
        $item_descs = $post['item_desc'] ?? [];

        $stmtinvoice = $pdo->prepare("INSERT INTO dr_invoice (unit_type, dr_number, quantity, item_description, machine_model, under_po_no, under_invoice_no, note, delivery_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        for ($i = 0; $i < count($quantities); $i++) {
            if (!empty($quantities[$i]) && !empty($item_descs[$i])) {
                $quantity_val = (int)str_replace([',', ' '], '', $quantities[$i] ?? '0');

                $stmtinvoice->execute([
                    $unit_types[$i] ?? '',
                    $dr_number,
                    $quantity_val,
                    $item_descs[$i],
                    $models[0] ?? '',
                    $po_numbers[0] ?? '',
                    $invoice_numbers[0] ?? '',
                    $notes[0] ?? '',
                    $delivery_type
                ]);
            }
        }
    }
    return $record_id;
}

//Function to save Used DR format - Dynamic based on items
function saveUsedDrFormat($pdo, $si_number, $dr_number, $delivered_to, $date, $address, $terms, $particulars, $tin, $unit_type, $post)
{
    $models = $post['model'] ?? '';
    $serials = $post['serial'] ?? '';
    $mr_starts = $post['mr_start'] ?? '';
    $tech_names = $post['tech_name'] ?? '';
    $pr_numbers = $post['pr_number'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO main (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'useddr')");

    $stmt->execute([
        $si_number,
        $dr_number,
        $delivered_to,
        $tin,
        $address,
        $terms,
        $particulars,
        $date
    ]);

    //For the History Table
    $stmtHistory = $pdo->prepare("
        INSERT INTO history
        (si_number, dr_number, delivered_to, tin, address, terms, particulars, si_date, type, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'useddr', 'CREATED')");

    $stmtHistory->execute([
        $si_number,
        $dr_number,
        $delivered_to,
        $tin,
        $address,
        $terms,
        $particulars,
        $date
    ]);

    $record_id = $pdo->lastInsertId();

    // Save items dynamically
    $quantities = $post['quantity'] ?? [];
    $unit_types = $post['unit_type'] ?? [];
    $item_descs = $post['item_desc'] ?? [];

    $stmt = $pdo->prepare("INSERT INTO used_dr(dr_number, quantity, unit_type, item_description, machine_model, serial_no, mr_start, technician_name, pr_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    for ($i = 0; $i < count($quantities); $i++) {
        if (!empty($quantities[$i]) && !empty($item_descs[$i])) {
            $quantity_val = (int)str_replace([',', ' '], '', $quantities[$i] ?? '0');

            $stmt->execute([
                $dr_number,
                $quantity_val,
                $unit_types[$i] ?? '',
                $item_descs[$i],
                $models[0] ?? '',
                $serials[0] ?? '',
                $mr_starts[0] ?? '',
                $tech_names[0] ?? '',
                $pr_numbers[0] ?? ''
            ]);
        }
    }

    return $record_id;
}
