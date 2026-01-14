<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Viewing/printing: fetch the invoice from the database using $_GET['stock_no']
    $stock_no = $_GET['stock_no'] ?? '';
    $conn = new mysqli('localhost', 'root', '', 'stock_transfer_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("SELECT * FROM multipleserial_transfers WHERE stock_no = ?");
    $stmt->bind_param("s", $stock_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $invoice = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    if ($invoice) {
        // Assign variables from DB
        $stock_no = $invoice['stock_no'];
        $date = $invoice['date'];
        $account_name = $invoice['account_name'];
        $from_location = $invoice['from_location'];
        $to_location = $invoice['to_location'];
        $delivered_by = $invoice['delivered_by'];
        $quantities = json_decode($invoice['quantity'], true) ?? [];
        $units = json_decode($invoice['unit'], true) ?? [];
        $descriptions = json_decode($invoice['description'], true) ?? [];
        $models = json_decode($invoice['model'], true) ?? [];
        $serial_nos = json_decode($invoice['serial_no'], true) ?? [];
        $mrs = json_decode($invoice['mr'], true) ?? [];
    } else {
        echo "<h2>Invoice not found.</h2>";
        exit;
    }
    // Continue to render the invoice HTML below using these variables
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stock_no = $_POST['stock_no'] ?? '';
    $quantities = $_POST['quantity'] ?? [];
    $units = $_POST['unit'] ?? [];
    $descriptions = $_POST['description'] ?? [];
    $models = $_POST['model'] ?? [];
    $serial_nos = $_POST['serial_no'] ?? [];
    $mrs = $_POST['mr'] ?? [];
    $delivered_by = $_POST['delivered_by'] ?? '';
    $date = $_POST['date'] ?? '';
    $account_name = $_POST['account_name'] ?? '';
    $from_location = $_POST['from_location'] ?? '';
    $to_location = $_POST['to_location'] ?? '';

    $conn = new mysqli('localhost', 'root', '', 'stock_transfer_db');
    if ($conn->connect_error) {
        echo 'error';
        exit;
    }

    // Check for duplicate in BOTH tables
    $check_stmt1 = $conn->prepare("SELECT id FROM multipleserial_transfers WHERE stock_no = ?");
    $check_stmt1->bind_param("s", $stock_no);
    $check_stmt1->execute();
    $check_stmt1->store_result();

    $check_stmt2 = $conn->prepare("SELECT id FROM stock_transfers WHERE stock_no = ?");
    $check_stmt2->bind_param("s", $stock_no);
    $check_stmt2->execute();
    $check_stmt2->store_result();

    if ($check_stmt1->num_rows > 0 || $check_stmt2->num_rows > 0) {
        echo 'exists';
        $check_stmt1->close();
        $check_stmt2->close();
        $conn->close();
        exit;
    }
    $check_stmt1->close();
    $check_stmt2->close();

    // Prepare arrays as JSON
    $quantity_json = json_encode($quantities);
    $unit_json = json_encode($units);
    $description_json = json_encode($descriptions);
    $model_json = json_encode($models);
    $serial_json = json_encode($serial_nos);
    $mr_json = json_encode($mrs);

    // Insert data
    $stmt = $conn->prepare("INSERT INTO multipleserial_transfers 
        (stock_no, date, account_name, from_location, to_location, quantity, unit, description, model, serial_no, mr, delivered_by)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssssssssss",
        $stock_no, $date, $account_name, $from_location, $to_location,
        $quantity_json, $unit_json, $description_json, $model_json, $serial_json, $mr_json, $delivered_by
    );

    if ($stmt->execute()) {
        echo 'success';
        exit;
    } else {
        echo 'error';
        exit;
    }
    $stmt->close(); 
    $conn->close();
}

// Only display the first item detail
$item_html = '';
if (count($quantities) > 0) {
    $quantity = htmlspecialchars($quantities[0] ?? '');
    $unit = htmlspecialchars($units[0] ?? '');
    $description = htmlspecialchars($descriptions[0] ?? '');
    $item_html .= '
        <tr style="height: 15px;">
            <td style="text-align: center;">' . $quantity . '</td>
            <td style="text-align: center;">' . $unit . '</td>
            <td></td>
            <td colspan="6" class="merged-block" style="text-align: left;">' . $description . '</td>
            <td></td>
        </tr>';
}

// Model row (below item detail)
$model_html = '';
if (!empty($models[0])) {
    $model_html = '
        <tr style="height: 15px;">
            <td></td>
            <td></td>
            <td></td>
            <td colspan="6" class="merged-block" style="text-align: left;">Model: ' . htmlspecialchars($models[0]) . '</td>
            <td></td>
        </tr>
        <tr style="height: 15px;">
            <td></td>
            <td></td>
            <td></td>
            <td colspan="6" class="merged-block" style="text-align: left;">Serial Nos.</td>
            <td></td>
        </tr>
        ';
}


// Serial No. and MR rows (each pair per line)
$serial_mr_html = '';
$max_serial_rows = 9;
$used_serial_rows = 0;
if (!empty($serial_nos) && !empty($mrs)) {
    $count = min(count($serial_nos), count($mrs));
    for ($i = 0; $i < $count; $i++) {
        $serial = htmlspecialchars($serial_nos[$i] ?? '');
        $mr = htmlspecialchars($mrs[$i] ?? '');
        if ($serial !== '' || $mr !== '') {
            $serial_mr_html .= '
                <tr style="height: 15px;">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="6" class="merged-block" style="text-align: left;">
                        ' . $serial . ' &nbsp; MR: ' . $mr . '
                    </td>
                    <td></td>
                </tr>';
            $used_serial_rows++;
        }
    }
}

$tech_html = '';
if (!empty($delivered_by)) {
    $tech_html = '

        <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

        <tr style="height: 15px;">
            <td></td>
            <td></td>
            <td></td>
            <td colspan="6" class="merged-block" style="text-align: left; font-weight: bold;">
                Tech: ' . htmlspecialchars($delivered_by) . '
            </td>
            <td></td>
        </tr>';
}


// Calculate blank rows to add between serials and signature rows
$blank_rows = $max_serial_rows - $used_serial_rows;
$blank_rows_html = '';
for ($i = 0; $i < $blank_rows; $i++) {
    $blank_rows_html .= '
        <tr style="height: 15px;">
            <td></td>
            <td></td>
            <td></td>
            <td colspan="6" class="merged-block" style="text-align: left;">&nbsp;</td>
            <td></td>
        </tr>';
}

?>

<!DOCTYPE html>
<html>
<head>
<title>A4 Stock Transfer</title>
<style>
    body {
        background-color: #f0f0f0; 
        margin: 0;
        padding: 0;
    }

    .a4-container {
        width: 210mm;
        height: 300mm;
        margin: 0 auto;
        background-color: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        padding: 10mm;
        box-sizing: border-box;
        position: relative;
        page-break-after: always;
    }

    .a4-container:last-child {
        page-break-after: auto;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        table-layout: fixed;
        font-family: Arial, sans-serif;
        font-size: 9pt;
        margin-bottom: 5mm;
    }

    th, td {
        text-align: center;
        overflow: visible;
        white-space: nowrap;
        vertical-align: middle;
        border: none
    }

    th {
        font-size: 8pt;
    }

    .merged-block {
        text-align: center;
        vertical-align: middle;
    }

    .col-1 { width: calc(9.43 / 101.58 * 100%); }
    .col-2 { width: calc(18.14 / 101.58 * 100%); }
    .col-3 { width: calc(1.86 / 101.58 * 100%); }
    .col-4 { width: calc(10 / 101.58 * 100%); }
    .col-5 { width: calc(10.29 / 101.58 * 100%); }
    .col-6 { width: calc(8.43 / 101.58 * 100%); }
    .col-7 { width: calc(8.43 / 101.58 * 100%); }
    .col-8 { width: calc(11.57 / 101.58 * 100%); }
    .col-9 { width: calc(15 / 101.58 * 100%); }
    .col-10 { width: calc(8.43 / 101.58 * 100%); }

    .table-logo {
        position: absolute;
        width: calc(8.43% + 8.43% + 11.57%);
        height: 46.5px;
        object-fit: contain;
        z-index: 10;
        pointer-events: none;
    }

    .first-logo {
        top: 10mm;
        left: calc(10mm + 49.72% - 13%);
    }

    .second-logo {
        top: calc(12mm + 140mm); 
        left: calc(10mm + 49.72% - 13%);
    }

    @page {
        size: A4;
        margin: 0;
    }

    @media print {
        body {
            background: none;
            margin: 0;
            padding: 0;
        }

        .a4-container {
            box-shadow: none;
            width: 210mm;
            height: 297mm;
            page-break-after: always;
        }

        .a4-container:last-child {
            page-break-after: auto;
        }

        table {
            page-break-inside: avoid;
        }

        .merged-block {
            background-color: transparent;
        }
        
        .table-logo {
            display: block;
        }
    }
</style>
<link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:wght@700;900&display=swap" rel="stylesheet">
</head>
<body>

<!-- First Page -->
<div class="a4-container">
    <!-- First table logo -->
    <img src="otus logo.png" alt="OTUS Logo" class="table-logo first-logo">
    
    <!-- First table -->
    <table>
        <colgroup>
            <col class="col-1"><col class="col-2"><col class="col-3"><col class="col-4"><col class="col-5">
            <col class="col-6"><col class="col-7"><col class="col-8"><col class="col-9"><col class="col-10">
        </colgroup>

        <tbody>
            <!-- Row 1 -->
            <tr style="height: 15px;">
                <td colspan="9"> </td>
                <td> </td>
            </tr>

            <!-- Row 2 -->
            <tr style="height: 15.75px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>

            <!-- Row 3 -->
            <tr style="height: 15px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>

            <!-- Row 4 -->
            <tr style="height: 12.75px;">
                <td style="text-align: left;">Stock No.:</td>
                <td><?php echo htmlspecialchars($stock_no); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 8.5px; color: blue;">OTUS COPY SYSTEMS, INC.</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 5 -->
            <tr style="height: 12px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;"><?php echo htmlspecialchars($from_location); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="4" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;">10F MG Tower #75 Brgy. Daang Bakal Shaw Blvd.</td>
                <td></td>
            </tr>

            <!-- Row 6 -->
            <tr style="height: 12px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;"> </td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;">Mandaluyong City</td>
                <td colspan="2"> </td>
                <td> </td>
                <td> </td>
            </tr>

            <!-- Row 7 -->
            <tr style="height: 12px;">
                <td style="font-weight: bold; text-align: left;">Date:</td>
                <td colspan="2" class="merged-block" style="text-align: left;"><?php echo htmlspecialchars($date); ?></td>
                <td></td>
                <td></td>
                <td colspan="4" class="merged-block" style="font-weight: bold;font-size: 9px; text-align: left;">Philippines Tel. 8631 - 9454 (Telefax: 535 - 8731)</td>
                <td></td>
            </tr>

            <!-- Row 8 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 9 -->
            <tr style="height: 27px;">
                <td></td>
                <td></td>
                <td colspan="6" style="font-family: 'Bodoni Moda', serif; font-size: 24px; font-weight: 900; text-align: center;">
                    STOCK TRANSFER
                </td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 10 -->
            <tr style="height: 15px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>

            <!-- Row 11 -->
            <tr style="height: 15.75px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;">Account Name:</td>
                <td></td>
                <td style="font-weight: bold; text-align: left;"><?php echo htmlspecialchars($account_name); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 12 -->
            <tr style="height: 15.75px;">
                <td style="font-weight: bold; text-align: left;">Address:</td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 12px;">
                    <?php echo htmlspecialchars($to_location); ?>
                </td>
                <td></td>
            </tr>

            <!-- Row 13 -->
            <tr style="height: 15.75px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>

            <!-- Row 14 -->
            <tr>
                <td style="font-weight: bold; font-size: 10px">QUANTITY</td>
                <td style="font-weight: bold;font-size: 10px">UNITS</td>
                <td></td>
                <td colspan="3" class="merged-block" style="text-align:left;font-weight: bold;font-size: 10px;">ITEMS DESCRIPTION</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Single Item Row -->
            <?php echo $item_html; ?>

            <!-- Model Row -->
            <?php echo $model_html; ?>

            <!-- Serial No. and MR Rows -->
            <?php echo $serial_mr_html; ?>
            <?php echo $tech_html; ?>
            <?php echo $blank_rows_html; ?>

            <tr style="height: 10px;">
                <td colspan="10"></td>
            </tr>

            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Signature Rows -->
            <tr style="height: 15px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;border-top: 2px solid black;">Acknowledged by- End-user</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="3" class="merged-block" style="font-weight: bold; text-align: center;border-top: 2px solid black;">OTUS Authorized Representative</td>
                <td></td>
            </tr>

            <tr style="height: 15px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;">Signature over Printed Name</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
             </tr>
        </tbody>
    </table>

    <!-- Second table logo -->
    <img src="otus logo.png" alt="OTUS Logo" class="table-logo second-logo">
    
    <!-- Second table (Office Copy) -->
    <table style="margin-top: 5mm;">
        <colgroup>
            <col class="col-1"><col class="col-2"><col class="col-3"><col class="col-4"><col class="col-5">
            <col class="col-6"><col class="col-7"><col class="col-8"><col class="col-9"><col class="col-10">
        </colgroup>

        <thead>
            <tr style="height: 15px;">
                <th style="font-weight: bold; font-style: italic;text-align: left;border-bottom:2px solid black"> OFFICE COPY</th>
                <th colspan="8"> </th>
                <th> </th>
            </tr>
        </thead>

        <tbody>
            <!-- Row 2 -->
            <tr style="height: 15.75px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>

            <!-- Row 4 -->
            <tr style="height: 12.75px;">
                <td style="text-align: left;">Stock No.:</td>
                <td><?php echo htmlspecialchars($stock_no); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 8.5px; color: blue;">OTUS COPY SYSTEMS, INC.</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 5 -->
            <tr style="height: 12px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;"><?php echo htmlspecialchars($from_location); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="4" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;">10F MG Tower #75 Brgy. Daang Bakal Shaw Blvd.</td>
                <td></td>
            </tr>

            <!-- Row 6 -->
            <tr style="height: 12px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;"> </td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;">Mandaluyong City</td>
                <td colspan="2"> </td>
                <td> </td>
                <td> </td>
            </tr>

            <!-- Row 7 -->
            <tr style="height: 12px;">
                <td style="font-weight: bold; text-align: left;">Date:</td>
                <td colspan="2" class="merged-block" style="text-align: left;"><?php echo htmlspecialchars($date); ?></td>
                <td></td>
                <td></td>
                <td colspan="4" class="merged-block" style="font-weight: bold;font-size: 9px; text-align: left;">Philippines Tel. 8631 - 9454 (Telefax: 535 - 8731)</td>
                <td></td>
            </tr>

            <!-- Row 8 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 9 -->
            <tr style="height: 27px;">
                <td></td>
                <td></td>
                <td colspan="6" style="font-family: 'Bodoni Moda', serif; font-size: 24px; font-weight: 900; text-align: center;">
                    STOCK TRANSFER
                </td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 10 -->
            <tr style="height: 15px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>

            <!-- Row 11 -->
            <tr style="height: 15.75px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;">Account Name:</td>
                <td></td>
                <td style="font-weight: bold; text-align: left;"><?php echo htmlspecialchars($account_name); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 12 -->
            <tr style="height: 15.75px;">
                <td style="font-weight: bold; text-align: left;">Address:</td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 12px;">
                    <?php echo htmlspecialchars($to_location); ?>
                </td>
                <td></td>
            </tr>

            <!-- Row 13 -->
            <tr style="height: 15.75px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>

            <!-- Row 14 -->
            <tr>
                <td style="font-weight: bold; font-size: 10px">QUANTITY</td>
                <td style="font-weight: bold;font-size: 10px">UNITS</td>
                <td></td>
                <td colspan="3" class="merged-block" style="text-align:left;font-weight: bold;font-size: 10px;">ITEMS DESCRIPTION</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

        <?php echo $item_html; ?>
        <?php echo $model_html; ?>
        <?php echo $serial_mr_html; ?>
        <?php echo $tech_html; ?>
        <?php echo $blank_rows_html; ?>

            <tr style="height: 10px;">
                <td colspan="10"></td>
            </tr>
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <!-- Signature Rows -->
            <tr style="height: 15px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;border-top: 2px solid black;">Acknowledged by- End-user</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="3" class="merged-block" style="font-weight: bold; text-align: center;border-top: 2px solid black;">OTUS Authorized Representative</td>
                <td></td>
            </tr>

            <tr style="height: 15px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;">Signature over Printed Name</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

</div>

<!-- First Page -->
<div class="a4-container">
    <!-- First table logo -->
    <img src="otus logo.png" alt="OTUS Logo" class="table-logo first-logo">
    
    <!-- First table -->
    <table>
        <colgroup>
            <col class="col-1"><col class="col-2"><col class="col-3"><col class="col-4"><col class="col-5">
            <col class="col-6"><col class="col-7"><col class="col-8"><col class="col-9"><col class="col-10">
        </colgroup>

        <tbody>
            <!-- Row 1 -->
            <tr style="height: 15px;">
                <td colspan="9"> </td>
                <td> </td>
            </tr>

            <!-- Row 2 -->
            <tr style="height: 15.75px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>

            <!-- Row 3 -->
            <tr style="height: 15px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>

            <!-- Row 4 -->
            <tr style="height: 12.75px;">
                <td style="text-align: left;">Stock No.:</td>
                <td><?php echo htmlspecialchars($stock_no); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 8.5px; color: blue;">OTUS COPY SYSTEMS, INC.</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 5 -->
            <tr style="height: 12px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;"><?php echo htmlspecialchars($from_location); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="4" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;">10F MG Tower #75 Brgy. Daang Bakal Shaw Blvd.</td>
                <td></td>
            </tr>

            <!-- Row 6 -->
            <tr style="height: 12px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;"> </td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;">Mandaluyong City</td>
                <td colspan="2"> </td>
                <td> </td>
                <td> </td>
            </tr>

            <!-- Row 7 -->
            <tr style="height: 12px;">
                <td style="font-weight: bold; text-align: left;">Date:</td>
                <td colspan="2" class="merged-block" style="text-align: left;"><?php echo htmlspecialchars($date); ?></td>
                <td></td>
                <td></td>
                <td colspan="4" class="merged-block" style="font-weight: bold;font-size: 9px; text-align: left;">Philippines Tel. 8631 - 9454 (Telefax: 535 - 8731)</td>
                <td></td>
            </tr>

            <!-- Row 8 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 9 -->
            <tr style="height: 27px;">
                <td></td>
                <td></td>
                <td colspan="6" style="font-family: 'Bodoni Moda', serif; font-size: 24px; font-weight: 900; text-align: center;">
                    STOCK TRANSFER
                </td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 10 -->
            <tr style="height: 15px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>

            <!-- Row 11 -->
            <tr style="height: 15.75px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;">Account Name:</td>
                <td></td>
                <td style="font-weight: bold; text-align: left;"><?php echo htmlspecialchars($account_name); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 12 -->
            <tr style="height: 15.75px;">
                <td style="font-weight: bold; text-align: left;">Address:</td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 12px;">
                    <?php echo htmlspecialchars($to_location); ?>
                </td>
                <td></td>
            </tr>

            <!-- Row 13 -->
            <tr style="height: 15.75px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>

            <!-- Row 14 -->
            <tr>
                <td style="font-weight: bold; font-size: 10px">QUANTITY</td>
                <td style="font-weight: bold;font-size: 10px">UNITS</td>
                <td></td>
                <td colspan="3" class="merged-block" style="text-align:left;font-weight: bold;font-size: 10px;">ITEMS DESCRIPTION</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Single Item Row -->
            <?php echo $item_html; ?>

            <!-- Model Row -->
            <?php echo $model_html; ?>

            <!-- Serial No. and MR Rows -->
            <?php echo $serial_mr_html; ?>
            <?php echo $tech_html; ?>
            <?php echo $blank_rows_html; ?>

            <tr style="height: 10px;">
                <td colspan="10"></td>
            </tr>

            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Signature Rows -->
            <tr style="height: 15px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;border-top: 2px solid black;">Acknowledged by- End-user</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="3" class="merged-block" style="font-weight: bold; text-align: center;border-top: 2px solid black;">OTUS Authorized Representative</td>
                <td></td>
            </tr>

            <tr style="height: 15px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;">Signature over Printed Name</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
             </tr>
        </tbody>
    </table>
</body>
</html>