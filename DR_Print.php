<?php
session_start();

if (!isset($_SESSION['form_data'])) {
    die("No form data found. Please submit the form first.");
}

// Use session data instead of direct POST
$form_data = $_SESSION['form_data'];

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && empty($form_data)) {
    echo "Invalid request method or no form data.";
    exit;
}

// Main form fields
$si_number = $form_data['si_number'] ?? '';
$delivered_to = $form_data['delivered_to'] ?? '';
$date = $form_data['date'] ?? '';
$address = $form_data['address'] ?? '';
$terms = $form_data['terms'] ?? '';
$particulars = $form_data['particulars'] ?? '';
$tin = $form_data['tin'] ?? '';
$unit_type = $form_data['unit_type'] ?? [];

// Form type selections - FIXED: Access directly, not as array
$dr_format = $form_data['dr_format'] ?? '';
$pullout_type = $form_data['pullout_type'] ?? '';

// Used Machines & Brand New Machines
$model = $form_data['model'] ?? [];
$serial = $form_data['serial'] ?? array_fill(0, 7, '________');
$mr_start = $form_data['mr_start'] ?? array_fill(0, 7, '________');
$mr_end = $form_data['mr_end'] ?? array_fill(0, 7, '________');
$color_imp = $form_data['color_imp'] ?? array_fill(0, 7, '0');
$black_imp = $form_data['black_imp'] ?? array_fill(0, 7, '0');
$color_large_imp = $form_data['color_large_imp'] ?? array_fill(0, 7, '0');

// DR with Prices
$price = $form_data['price'] ?? [];
$quantity = $form_data['quantity'] ?? [];
$item_desc = $form_data['item_desc'] ?? [];

// Replacement Machines (in pullout-replacement section)
$replace_model = $form_data['replace_model'] ?? [];
$replace_serial = $form_data['replace_serial'] ?? [];
$replace_mr_start = $form_data['replace_mr_start'] ?? [];
$replace_color_imp = $form_data['replace_color_imp'] ?? [];
$replace_black_imp = $form_data['replace_black_imp'] ?? [];
$replace_color_large_imp = $form_data['replace_color_large_imp'] ?? [];

// Pullout Machines (in pullout-replacement section)
$pullout_model = $form_data['pullout_model'] ?? [];
$pullout_serial = $form_data['pullout_serial'] ?? [];
$pullout_mr_end = $form_data['pullout_mr_end'] ?? [];
$pullout_color_imp = $form_data['pullout_color_imp'] ?? [];
$pullout_black_imp = $form_data['pullout_black_imp'] ?? [];
$pullout_color_large_imp = $form_data['pullout_color_large_imp'] ?? [];

// DR with Invoice
$po_number = $form_data['po_number'] ?? [];
$invoice_number = $form_data['invoice_number'] ?? [];
$note = $form_data['note'] ?? [];

// Used DR
$tech_name = $form_data['tech_name'] ?? [];
$pr_number = $form_data['pr_number'] ?? [];

// Fill arrays with default values if empty to prevent undefined index errors
$model = !empty($model) ? $model : array_fill(0, 7, '');
$serial = !empty($serial) ? $serial : array_fill(0, 7, '________');
$mr_start = !empty($mr_start) ? $mr_start : array_fill(0, 7, '________');
$color_imp = !empty($color_imp) ? $color_imp : array_fill(0, 7, '0');
$black_imp = !empty($black_imp) ? $black_imp : array_fill(0, 7, '0');
$color_large_imp = !empty($color_large_imp) ? $color_large_imp : array_fill(0, 7, '0');

// Fill other arrays with empty values if not set
$price = !empty($price) ? $price : [];
$quantity1 = !empty($quantity) ? $quantity : [];
$item_desc = !empty($item_desc) ? $item_desc : [];
$replace_model = !empty($replace_model) ? $replace_model : [];
$pullout_model = !empty($pullout_model) ? $pullout_model : [];
$po_number = !empty($po_number) ? $po_number : [];
$invoice_number = !empty($invoice_number) ? $invoice_number : [];
$note = !empty($note) ? $note : [];
$tech_name = !empty($tech_name) ? $tech_name : [];
$pr_number = !empty($pr_number) ? $pr_number : [];

// Optional: Clear the session data after use to prevent re-display on refresh
unset($_SESSION['form_data']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DR and ST</title>
    <style>
        * {
            font-family: "Arial", sans-serif;
            font-weight: 700;
            font-size: 10px;
            margin: 0;
            padding: 0;
            background: #fff;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        /* Keep your A5 layout size */
        .a5 {
            width: 203.2mm;
            /* Your custom A5-like width */
            height: 139.7mm;
            /* Your A5-like height */
            background: white;
            box-sizing: border-box;
            position: relative;
        }

        .portrait-container {
            width: 138mm;
            margin: 0mm 7mm 0mm 5mm;
            padding-top: 29mm;
            box-sizing: border-box;
            background: #fff;
        }

        /* Tables */
        table {
            border-collapse: collapse;
            margin: 0;
            table-layout: fixed;
        }

        td,
        th {
            border: 1px solid red;
            text-align: center;
            box-sizing: border-box;
            vertical-align: top;
        }

        .header td {
            font-weight: bold;
        }

        /* First table */
        table:first-of-type {
            width: 90mm !important;
        }

        /* Third Table */
        table:last-of-type {
            width: 188.5mm !important;
        }

        /* Column widths */
        .col-si-number,
        .col-si-date,
        .col-terms {
            width: 32mm !important;
        }

        .col-sold-to {
            width: 91.5mm !important;
        }

        .col-particulars {
            padding: 1mm 0 0 0;
            width: 64mm !important;
        }

        .col-price {
            width: 38mm !important;
        }

        .col-quantity {
            width: 17.7mm !important;
        }

        .col-units {
            width: 14.3mm !important;
        }

        .col-description {
            padding: 0 5px;
            width: 156.5mm !important;
        }

        .col-description-price {
            width: 96.5mm !important;
        }

        .col-description-header {
            width: 96.5mm !important;
        }

        .col-price {
            width: 30mm !important;
        }

        .dr-row {
            height: 9.5mm;
        }

        .dr-2nd-row {
            height: 6.7mm !important;
        }

        .dr-2nd-row-header {
            height: 5.5mm !important;
        }

        .text-align {
            text-align: left !important;
        }

        .underline-empty {
            text-decoration: underline;
            text-decoration-style: solid;
            text-decoration-thickness: 1px;
            display: inline-block;
            min-width: 55px;
        }

        .dr-2nd-row-new {
            height: 5.4mm !important;
        }

        /* Print setup — centers A5 content on A4 paper */
        @media print {
            @page {
                size: A4 portrait;
                /* A4 paper */
                margin: 0;
                /* no browser margin */
            }

            html,
            body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
                background: none !important;
            }

            .a5 {
                page-break-after: always;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>
    <div class="a5">
        <div class="portrait-container">
            <table>
                <tr class="dr-row">
                    <td class="col-si-number">
                        <br>
                        <?= htmlspecialchars($si_number) ?>
                    </td>
                    <td class="col-sold-to">
                        <?= htmlspecialchars($delivered_to) ?><br>
                        <?= htmlspecialchars($tin) ?>
                    </td>
                </tr>
                <tr class="dr-row">
                    <td class="col-si-date"><br> <?= htmlspecialchars($date) ?></td>
                    <td class="col-sold-to"> <?= htmlspecialchars($address) ?></td>
                </tr>
                <tr class="dr-row">
                    <td class="col-terms"><br> <?= htmlspecialchars($terms) ?></td>
                    <td class="col-particulars"> <?= htmlspecialchars($particulars) ?></td>
                </tr>
            </table>

            <table>
                <!-- HEADINGS -->
                <tr class="dr-2nd-row-header">
                    <td class="col-quantity"></td> <!-- QUANTITY -->
                    <td class="col-units"></td> <!-- UNIT -->
                    <?php if ($dr_format === 'drWithPrice') { ?>
                        <td class="col-description-price"></td> <!-- DESCRIPTION for drWithPrice -->
                        <td class="col-price"></td> <!-- PRICE for drWithPrice -->
                    <?php } else { ?>
                        <td class="col-description"></td> <!-- DESCRIPTION for other formats -->
                    <?php } ?>
                </tr>

                <?php

                if (isset($form_data['dr_format']) && $form_data['dr_format'] === 'used') { ?>
                    <tr class="dr-2nd-row">
                        <td><?= htmlspecialchars(count($serial)) ?></td>
                        <td><?= htmlspecialchars($unit_type) ?></td>
                        <td class=" text-align" style="font-size: 10px">Deliver Machine<br>Model: <?= htmlspecialchars($model[0] ?? '') ?></td>
                    </tr>

                    <?php
                    for ($i = 0; $i < count($serial); $i++) { ?>

                        <?php
                        $srDisplay = trim($serial[$i]) !== '' ? htmlspecialchars($serial[$i]) : '<span class="underline-empty"></span>';
                        $mrDisplay = trim($mr_start[$i]) !== '' ? htmlspecialchars($mr_start[$i]) : '<span class="underline-empty"></span>';

                        $ci = trim((string)($color_imp[$i] ?? ''));
                        $bi = trim((string)($black_imp[$i] ?? ''));
                        $cli = trim((string)($color_large_imp[$i] ?? ''));

                        if ($ci === '' && $bi === '' && $cli === '') {
                            $messageFormat = "Serial No.: " . $srDisplay .  " MR Start: "  . $mrDisplay;
                        } else {
                            $messageFormat = "Serial No.: " . $srDisplay . " MR Start: " . $mrDisplay
                                . " (CI: " . htmlspecialchars($ci) . "; BI: " . htmlspecialchars($bi) . "; CLI: " . htmlspecialchars($cli) . ")";
                        }
                        ?>

                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td class="text-align" style="font-size: 11px; "><?= $messageFormat ?></td>
                        </tr>



                    <?php } ?>
                    <?php for ($j = count($serial); $j < 7; $j++) { ?>
                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>

                    <!-- For the Brand New Machine Delivery -->
                <?php } else if (isset($form_data['dr_format']) && $form_data['dr_format'] == 'bnew') {  ?>
                    <?php
                    // ✅ Clean serial list for each machine (assume $_POST['serial'] is an array, one per machine)
                    $countTableRows = 0;
                    $perRow = 3; // how many serials per row

                    if (!empty($model) && !empty($serial) && count($serial) < 18) {
                        for ($i = 0; $i < count($model); $i++) {
                            if (count($serial) > 15) {
                                continue;
                            }

                            // Each machine has its own serial input field (comma-separated)
                            $serialInput = $serial[$i] ?? '';
                            $serialsClean = array_values(array_filter(array_map('trim', explode(',', $serialInput))));
                            $serialsCount = count($serialsClean);

                            if ($serialsCount === 0) continue; // skip if no serials
                    ?>

                            <!-- Machine Header Row -->
                            <tr class="dr-2nd-row">
                                <td><?= htmlspecialchars($serialsCount) ?></td>
                                <td><?= htmlspecialchars($unit_type ?? '') ?></td>
                                <td class="text-align" style="font-size: 10px">
                                    Deliver Brand New Machine<br>
                                    Model: <?= htmlspecialchars($model[$i]) ?>
                                </td>
                            </tr>
                    <?php
                            // ✅ Display serials for this machine
                            $printed = 0;

                            foreach ($serialsClean as $sr) {
                                if ($printed % $perRow == 0) {
                                    if ($printed > 0) echo '</td></tr>';
                                    echo '<tr class="dr-2nd-row-new">
                                            <td></td>
                                            <td></td>
                                            <td class="text-align" style="font-size: 11px;">';
                                    $countTableRows++;
                                }

                                echo 'Serial No.: ' . htmlspecialchars($sr) . str_repeat('&nbsp;', 5);
                                $printed++;

                                if ($printed % $perRow == 0 || $printed == $serialsCount) {
                                    echo '</td></tr>';
                                }
                            }
                        }
                    }

                    // ✅ Fill remaining blank rows up to 7 total
                    for ($s = $countTableRows; $s < 5; $s++) {
                        echo '<tr class="dr-2nd-row-new">
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>';
                    }

                    ?>

                    <!-- For the Pullout Replacement Section -->
                    <?php } else if (isset($form_data['dr_format']) && $form_data['dr_format'] == 'pullout-delivery') {

                    if (isset($form_data['pullout_type']) && $form_data['pullout_type'] == 'replacementOnly') {
                        $machines_by_model = [];
                        $total_rows_used = 0; // Counter for total rows used

                        $replaceGroups = [];
                        if (!empty($form_data['replace_machines']) && is_array($form_data['replace_machines'])) {
                            $replaceGroups = $form_data['replace_machines'];
                        } elseif (!empty($form_data['replace_only_machines']) && is_array($form_data['replace_only_machines'])) {
                            $replaceGroups = $form_data['replace_only_machines'];
                        }

                        if (!empty($replaceGroups)) {
                            foreach ($replaceGroups as $machineGroup) {
                                $model_name = $machineGroup['model'] ?? 'Unknown Model';
                                if (!isset($machines_by_model[$model_name])) {
                                    $machines_by_model[$model_name] = [];
                                }

                                if (isset($machineGroup['serials']) && is_array($machineGroup['serials'])) {
                                    foreach ($machineGroup['serials'] as $serialData) {
                                        if (!empty(trim($serialData['serial'] ?? ''))) {
                                            // normalize unit type to a string for display
                                            $unit_display = is_array($unit_type) ? ($unit_type[0] ?? '') : $unit_type;
                                            $machines_by_model[$model_name][] = [
                                                'serial' => $serialData['serial'] ?? '',
                                                'mr_start' => $serialData['mr_start'] ?? '',
                                                'color_imp' => $serialData['color_imp'] ?? '',
                                                'black_imp' => $serialData['black_imp'] ?? '',
                                                'color_large_imp' => $serialData['color_large_imp'] ?? '',
                                                'unit_type' => $unit_display
                                            ];
                                        }
                                    }
                                }
                            }
                        }

                        // Display grouped data and count rows
                        foreach ($machines_by_model as $model_name => $machines) {
                            $total_machines = count($machines);
                            if ($total_machines > 0) {
                                $total_rows_used += 1; // Count header row for this model
                    ?>
                                <!-- MODEL HEADER -->
                                <tr class="dr-2nd-row">
                                    <td><?= htmlspecialchars($total_machines) ?></td>
                                    <td><?= htmlspecialchars($unit_type) ?></td>
                                    <td class="text-align" style="font-size: 10px">Deliver Replacement Machine <br>Model: <?= htmlspecialchars($model_name) ?></td>
                                </tr>

                                <?php
                                // DISPLAY ALL SERIALS FOR THIS MODEL
                                foreach ($machines as $machine) {
                                    $total_rows_used += 1; // Count each serial row
                                    $srReplacementDisplay = trim($machine['serial']) !== '' ? htmlspecialchars($machine['serial']) : '<span class="underline-empty"></span>';
                                    $mrReplacementDisplay = trim($machine['mr_start']) !== '' ? htmlspecialchars($machine['mr_start']) : '<span class="underline-empty"></span>';

                                    $ciDisplay = trim($machine['color_imp']) !== '' ? htmlspecialchars($machine['color_imp']) : '<span class="underline-empty"></span>';
                                    $biDisplay = trim($machine['black_imp']) !== '' ? htmlspecialchars($machine['black_imp']) : '<span class="underline-empty"></span>';
                                    $cliDisplay = trim($machine['color_large_imp']) !== '' ? htmlspecialchars($machine['color_large_imp']) : '<span class="underline-empty"></span>';

                                    $mrReplacementFormat = "MR Start:" . $mrReplacementDisplay . " (CI:" . $ciDisplay . "; BI:" . $biDisplay . "; CLI:" . $cliDisplay . ")";
                                ?>
                                    <tr class="dr-2nd-row">
                                        <td></td>
                                        <td></td>
                                        <td class="text-align">Serial No.: <?= $srReplacementDisplay ?> <?= $mrReplacementFormat ?> </td>
                                    </tr>
                                <?php } ?>

                            <?php
                            }
                        } // END OF MODEL GROUP

                        // ADD EMPTY ROWS AT THE END FOR THE ENTIRE TABLE
                        // Determine how many rows per "page" you want (e.g., 6, 10, 12)
                        $rows_per_page = 7; // Change this to your desired row count

                        // Calculate how many empty rows needed to fill the page
                        $empty_rows_needed = $rows_per_page - ($total_rows_used % $rows_per_page);

                        // If total_rows_used is exactly divisible by rows_per_page, don't add extra rows
                        if ($empty_rows_needed == $rows_per_page) {
                            $empty_rows_needed = 0;
                        }

                        // Debug: Show counts
                        // echo "Total rows used: $total_rows_used<br>";
                        // echo "Empty rows needed: $empty_rows_needed<br>";

                        // Add empty rows at the end
                        for ($i = 0; $i < $empty_rows_needed; $i++) { ?>
                            <tr class="dr-2nd-row">
                                <td></td>
                                <td></td>
                                <td class="text-align"></td>
                            </tr>
                        <?php } ?>

                        <?php } else if (isset($form_data['pullout_type']) && $form_data['pullout_type'] == 'pulloutOnly') {
                        $machines_by_model = [];
                        $total_rows_used = 0; // Counter for total rows used

                        $pulloutGroups = [];
                        if (!empty($form_data['pullout_machines']) && is_array($form_data['pullout_machines'])) {
                            $pulloutGroups = $form_data['pullout_machines'];
                        } elseif (!empty($form_data['pullout_only_machines']) && is_array($form_data['pullout_only_machines'])) {
                            $pulloutGroups = $form_data['pullout_only_machines'];
                        }

                        // Group machines by model (assuming $models contains model names)
                        if (!empty($pulloutGroups)) {
                            foreach ($pulloutGroups as $machineGroup) {
                                $model_name = $machineGroup['model'] ?? 'Unknown Model';
                                if (!isset($machines_by_model[$model_name])) {
                                    $machines_by_model[$model_name] = [];
                                }

                                if (isset($machineGroup['serials']) && is_array($machineGroup['serials'])) {
                                    foreach ($machineGroup['serials'] as $serialData) {
                                        if (!empty(trim($serialData['serial'] ?? ''))) {
                                            // normalize unit type to a string for display
                                            $unit_display = is_array($unit_type) ? ($unit_type[0] ?? '') : $unit_type;
                                            $machines_by_model[$model_name][] = [
                                                'serial' => $serialData['serial'] ?? '',
                                                'mr_end' => $serialData['mr_end'] ?? '',
                                                'color_imp' => $serialData['color_imp'] ?? '',
                                                'black_imp' => $serialData['black_imp'] ?? '',
                                                'color_large_imp' => $serialData['color_large_imp'] ?? '',
                                                'unit_type' => $unit_display
                                            ];
                                        }
                                    }
                                }

                                // Check if we have data for this index
                                // if (isset($pullout_serial[$index]) && !empty(trim($pullout_serial[$index] ?? ''))) {
                                //     $machines_by_model[$model_name][] = [
                                //         'serial' => $pullout_serial[$index] ?? '',
                                //         'mr_end' => $pullout_mr_end[$index] ?? '',
                                //         'color_imp' => $pullout_color_imp[$index] ?? '',
                                //         'black_imp' => $pullout_black_imp[$index] ?? '',
                                //         'color_large_imp' => $pullout_color_large_imp[$index] ?? '',
                                //         'unit_type' => $unit_type
                                //     ];
                                // }
                            }
                        }

                        // Display grouped data and count rows
                        foreach ($machines_by_model as $model_name => $machines) {
                            $total_machines = count($machines);
                            if ($total_machines > 0) {
                                $total_rows_used += 1; // Count header row for this model
                        ?>
                                <!-- MODEL HEADER -->
                                <tr class="dr-2nd-row">
                                    <td><?= htmlspecialchars($total_machines) ?></td>
                                    <td><?= htmlspecialchars($unit_type) ?></td>
                                    <td class="text-align" style="font-size: 10px">Pull Out Machine <br>Model: <?= htmlspecialchars($model_name) ?></td>
                                </tr>

                                <?php
                                // DISPLAY ALL SERIALS FOR THIS MODEL
                                foreach ($machines as $machine) {
                                    $total_rows_used += 1; // Count each serial row
                                    $srPulloutDisplay = trim($machine['serial']) !== '' ? htmlspecialchars($machine['serial']) : '<span class="underline-empty"></span>';
                                    $mrPulloutDisplay = trim($machine['mr_end']) !== '' ? htmlspecialchars($machine['mr_end']) : '<span class="underline-empty"></span>';

                                    $ciDisplay = trim($machine['color_imp']) !== '' ? htmlspecialchars($machine['color_imp']) : '<span class="underline-empty"></span>';
                                    $biDisplay = trim($machine['black_imp']) !== '' ? htmlspecialchars($machine['black_imp']) : '<span class="underline-empty"></span>';
                                    $cliDisplay = trim($machine['color_large_imp']) !== '' ? htmlspecialchars($machine['color_large_imp']) : '<span class="underline-empty"></span>';

                                    $mrPulloutFormat = "MR End:" . $mrPulloutDisplay . " (CI:" . $ciDisplay . "; BI:" . $biDisplay . "; CLI:" . $cliDisplay . ")";
                                ?>
                                    <tr class="dr-2nd-row">
                                        <td></td>
                                        <td></td>
                                        <td class="text-align">Serial No.: <?= $srPulloutDisplay ?> <?= $mrPulloutFormat ?> </td>
                                    </tr>
                                <?php } ?>

                            <?php
                            }
                        } // END OF MODEL GROUP

                        // ADD EMPTY ROWS AT THE END FOR THE ENTIRE TABLE
                        // Determine how many rows per "page" you want (e.g., 6, 10, 12)
                        $rows_per_page = 7; // Change this to your desired row count

                        // Calculate how many empty rows needed to fill the page
                        $empty_rows_needed = $rows_per_page - ($total_rows_used % $rows_per_page);

                        // If total_rows_used is exactly divisible by rows_per_page, don't add extra rows
                        if ($empty_rows_needed == $rows_per_page) {
                            $empty_rows_needed = 0;
                        }

                        // Add empty rows at the end
                        for ($i = 0; $i < $empty_rows_needed; $i++) { ?>
                            <tr class="dr-2nd-row">
                                <td></td>
                                <td></td>
                                <td class="text-align"></td>
                            </tr>
                        <?php } ?>

                    <?php } else if (!empty($replace_model) && !empty($replace_serial)) { ?>

                        <tr class="dr-2nd-row">
                            <td><?= htmlspecialchars(count($replace_serial)) ?></td>
                            <td><?= htmlspecialchars($unit_type) ?></td>
                            <td class="text-align" style="font-size: 10px">Deliever Replacement Machine <br>Model: <?= htmlspecialchars($replace_model[0] ?? '') ?></td>
                        </tr>

                        <?php for ($i = 0; $i < count($replace_serial); $i++) {
                            $srReplacementDisplay = trim($replace_serial[$i]) !== '' ? htmlspecialchars($replace_serial[$i]) : '<span class="underline-empty"></span>';
                            $mrReplacementDisplay = trim($replace_mr_start[$i]) !== '' ? htmlspecialchars($replace_mr_start[$i]) : '<span class="underline-empty"></span>';

                            $ciDisplay = trim($replace_color_imp[$i]) !== '' ? htmlspecialchars($replace_color_imp[$i]) : '<span class="underline-empty"></span>';
                            $biDisplay = trim($replace_black_imp[$i]) !== '' ? htmlspecialchars($replace_black_imp[$i]) : '<span class="underline-empty"></span>';
                            $cliDisplay = trim($replace_color_large_imp[$i]) !== '' ? htmlspecialchars($replace_color_large_imp[$i]) : '<span class="underline-empty"></span>';

                            $mrReplacementFormat = "MR Start:" . $mrReplacementDisplay . " (CI:" . $ciDisplay . "; BI:" . $biDisplay . "; CLI:" . $cliDisplay . ")";

                        ?>

                            <tr class="dr-2nd-row">
                                <td></td>
                                <td></td>
                                <td class="text-align">Serial No.: <?= $srReplacementDisplay ?> <?= $mrReplacementFormat ?> </td>
                            </tr>

                        <?php }

                        for ($j = count($replace_serial); $j < 2; $j++) { ?>
                            <tr class="dr-2nd-row">
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                    <?php }
                    } ?>


                    <?php if (!empty($pullout_model) && !empty($pullout_serial)) { ?>
                        <tr class="dr-2nd-row">
                            <td><?= htmlspecialchars(count($pullout_serial)) ?></td>
                            <td><?= htmlspecialchars($unit_type) ?></td>
                            <td class="text-align" style="font-size: 10px">Pull Out Machine <br>Model: <?= htmlspecialchars($pullout_model[0] ?? '') ?></td>
                        </tr>

                        <?php for ($i = 0; $i < count($pullout_serial); $i++) {
                            $srPulloutDisplay = trim($pullout_serial[$i]) !== '' ? htmlspecialchars($pullout_serial[$i]) : '<span class="underline-empty"></span>';
                            $mrPulloutDisplay = trim($pullout_mr_end[$i]) !== '' ? htmlspecialchars($pullout_mr_end[$i]) : '<span class="underline-empty"></span>';

                            $ciDisplay = trim($pullout_color_imp[$i]) !== '' ? htmlspecialchars($pullout_color_imp[$i]) : '<span class="underline-empty"></span>';
                            $biDisplay = trim($pullout_black_imp[$i]) !== '' ? htmlspecialchars($pullout_black_imp[$i]) : '<span class="underline-empty"></span>';
                            $cliDisplay = trim($pullout_color_large_imp[$i]) !== '' ? htmlspecialchars($pullout_color_large_imp[$i]) : '<span class="underline-empty"></span>';

                            $mrPulloutFormat = "MR End:" . $mrPulloutDisplay . " (CI:" . $ciDisplay . "; BI:" . $biDisplay . "; CLI:" . $cliDisplay . ")";

                        ?>

                            <tr class="dr-2nd-row">
                                <td></td>
                                <td></td>
                                <td class="text-align">Serial No.:<?= $srPulloutDisplay ?> <?= $mrPulloutFormat ?> </td>
                            </tr>
                        <?php }

                        for ($j = count($pullout_serial); $j < 6; $j++) { ?>
                            <tr class="dr-2nd-row">
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                        <?php } ?>

                        <tr class="dr-2nd-row">
                            <td></td>
                            <td></td>
                            <td class="text-align"></td>
                        </tr>

                    <?php } ?>

                    <!-- For the DR with Invoice Section -->
                <?php } else if (isset($dr_format['dr_format']) && $dr_format['dr_format'] === 'drWithInvoice') { ?>
                    <?php for ($i = 0; $i < count($quantity); $i++) { ?>
                        <tr class="dr-2nd-row">
                            <td> <?= htmlspecialchars($quantity[$i]) ?></td>
                            <td><?= htmlspecialchars($unit_type[$i] ?? '') ?></td>
                            <td class="text-align"><?= htmlspecialchars($item_desc[$i] ?? '') ?></td>
                        </tr>
                    <?php } ?>

                    <?php for ($j = count($quantity); $j < 4; $j++) { ?>
                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td class="text-align"></td>
                        </tr>
                    <?php } ?>

                    <tr class="dr-2nd-row-new">
                        <td></td>
                        <td></td>
                        <td class="text-align">Model: <?= htmlspecialchars($model[0] ?? '') ?> </td> <!-- Echo here -->
                    </tr>



                    <?php if (!empty($po_number[0]) && !empty($invoice_number[0])) { ?>
                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td class="text-align">Under PO No.: <?= htmlspecialchars($po_number[0]) ?></td> <!-- Echo here -->
                        </tr>

                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td class="text-align">Under Invoice No: <?= htmlspecialchars($invoice_number[0]) ?><br> <span style="font-style: italic;"><?= htmlspecialchars($note[0] ?? ''); ?></span>
                            <td> <!-- Echo here -->
                        </tr>

                    <?php } else if (empty($po_number[0]) && !empty($invoice_number[0])) { ?>

                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td class="text-align">Under Invoice No: <?= htmlspecialchars($invoice_number[0]) ?><br> <span style="font-style: italic;"><?= htmlspecialchars($note[0] ?? ''); ?></span>
                            <td> <!-- Echo here -->

                        </tr>

                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td class="text-align"></td>
                        </tr>

                    <?php } else if (!empty($po_number[0]) && empty($invoice_number[0])) { ?>
                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td class="text-align">Under PO No.: <?= htmlspecialchars($po_number[0]) ?><br><span style="font-style: italic;"><?= htmlspecialchars($note[0] ?? ''); ?></span></td> <!-- Echo here -->
                        </tr>

                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td class="text-align"></td>
                        </tr>

                    <?php } else { ?>
                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td class="text-align"></td>
                        </tr>

                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td class="text-align"></td>
                        </tr>

                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td class="text-align"></td>
                        </tr>

                    <?php } ?>

                    <!-- For the DR with Price Section -->
                <?php } else if (isset($dr_format) && $dr_format == 'drWithPrice') { ?>

                    <?php
                    $totalPerItem = 0;
                    $grandTotal = 0;
                    ?>

                    <?php for ($i = 0; $i < count($quantity); $i++) {

                        $priceVal = isset($price[$i]) ? floatval(str_replace([',', ' '], '', (string)$price[$i])) : 0.0;
                        $qtyVal   = isset($quantity[$i]) ? floatval(str_replace([',', ' '], '', (string)$quantity[$i])) : 0.0;

                        $totalPerItem = $priceVal * $qtyVal;
                        $grandTotal += $totalPerItem;

                        // Fix: Get unit_type from the right source
                        $current_unit_type = '';
                        if (isset($unit_type[$i]) && is_string($unit_type[$i])) {
                            $current_unit_type = $unit_type[$i];
                        } elseif (isset($form_data['unit_type'][$i])) {
                            $current_unit_type = $form_data['unit_type'][$i];
                        } else {
                            $current_unit_type = $unit_type; // fallback to main unit_type
                        }
                    ?>
                        <tr class="dr-2nd-row">
                            <td class="col-quantity"> <?= htmlspecialchars($quantity[$i]) ?></td>
                            <td class="col-units"><?= htmlspecialchars($current_unit_type) ?></td>
                            <td class="col-description-price text-align"><?= htmlspecialchars($item_desc[$i] ?? '') ?></td>
                            <td class="col-price"><?= htmlspecialchars(number_format((int)$priceVal)) ?></td>
                            <td class="col-price"><?= htmlspecialchars(number_format((int)$totalPerItem)) ?></td>
                        </tr>
                    <?php } ?>

                    <?php for ($j = count($quantity); $j < 5; $j++) { ?>
                        <tr class="dr-2nd-row">
                            <td class="col-quantity"> </td>
                            <td class="col-units"></td>
                            <td class="col-description-price text-align"></td>
                            <td class="col-price"></td>
                            <td class="col-price"></td>
                        </tr>
                    <?php } ?>
                    <tr class="dr-2nd-row">
                        <td class="col-quantity"> </td>
                        <td class="col-units"></td>
                        <td class="col-description-price text-align">Machine Model: <?= htmlspecialchars($model[0] ?? '') ?></td>
                        <td class="col-price"></td>
                        <td class="col-price"></td>
                    </tr>

                    <tr class="dr-2nd-row">
                        <td class="col-quantity"> </td>
                        <td class="col-units"></td>
                        <td class="col-description-price text-align"></td>
                        <td class="col-price">TOTAL: </td>
                        <td class="col-price"><?= htmlspecialchars(number_format((int)$grandTotal)) ?></td>
                    </tr>

                <?php } else if (isset($dr_format) && $dr_format == 'drWithPrice') { ?>

                    <?php for ($i = 0; $i < count($quantity); $i++) { ?>
                        <tr class="dr-2nd-row-header">
                            <td> <?= htmlspecialchars($quantity[$i]) ?> </td>
                            <td> <?= htmlspecialchars($unit_type[$i]) ?> </td>
                            <td class="col-description text-align"> <?= htmlspecialchars($item_desc[$i]) ?> </td>
                        </tr>
                    <?php } ?>

                    <?php for ($j = count($quantity); $j < 4; $j++) { ?>
                        <tr class="dr-2nd-row-header">
                            <td> </td>
                            <td> </td>
                            <td class="col-description text-align"> </td>
                        </tr>
                    <?php } ?>

                    <tr class="dr-2nd-row-header">
                        <td></td>
                        <td></td>
                        <td class="col-description text-align">
                            <?= !empty($model[0]) ? "Machine Model: " . htmlspecialchars($model[0]) . "<br>" : "" ?>
                            <?= !empty($tech_name[0]) ? "Technician Name: " . htmlspecialchars($tech_name[0]) . "<br>" : "" ?>
                            <?= !empty($serial[0]) ? "Serial No.: " . htmlspecialchars($serial[0]) . "<br>" : "" ?>
                            <?= !empty($mr_start[0]) ? "MR Start: " . htmlspecialchars($mr_start[0]) . "<br>" : "" ?>
                            <?= !empty($pr_number[0]) ? "PR No.: " . htmlspecialchars($pr_number[0]) : "" ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>

<script>
    window.onload = function() {
        window.print();
    }
</script>

</html>