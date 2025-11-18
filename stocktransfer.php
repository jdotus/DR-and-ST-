<?php
$stock_no = $_POST['stock_no'] ?? '';
$date = $_POST['date'] ?? '';
$account_name = $_POST['account_name'] ?? '';
$from_location = $_POST['from_location'] ?? '';
$to_location = $_POST['to_location'] ?? '';
$delivered_by = $_POST['delivered_by'] ?? '';
$received_by = $_POST['received_by'] ?? '';

// Get the additional fields
$mr = $_POST['mr'] ?? '';
$model = $_POST['model'] ?? '';
$serial_no = $_POST['serial_no'] ?? '';
$tech = $_POST['tech'] ?? '';
$prno = $_POST['prno'] ?? '';

// Get the item arrays
$quantities = $_POST['quantity'] ?? [];
$units = $_POST['unit'] ?? [];
$descriptions = $_POST['description'] ?? [];

// Count how many items we have
$item_count = count($quantities);

// Calculate how many blank rows we need (total 11 rows for items section)
$total_rows_needed = 10;
$blank_rows_needed = max(0, $total_rows_needed - $item_count);

// Function to generate item rows
function generateItemRows($quantities, $units, $descriptions, $blank_rows_needed) {
    $html = '';
    $item_count = count($quantities);
    
    // Add actual item rows
    for ($i = 0; $i < $item_count; $i++) {
        $quantity = htmlspecialchars($quantities[$i] ?? '');
        $unit = htmlspecialchars($units[$i] ?? '');
        $description = htmlspecialchars($descriptions[$i] ?? '');
        
        $html .= '
            <tr style="height: 15px;">
                <td style="text-align: center;">' . $quantity . '</td>
                <td style="text-align: center;">' . $unit . '</td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left; font-family:\'Gill Sans\', \'Gill Sans MT\', Calibri, \'Trebuchet MS\', sans-serif">' . $description . '</td>
                <td></td>
            </tr>';
    }
    
    // Add blank rows to reach total of 11 rows
    for ($i = 0; $i < $blank_rows_needed; $i++) {
        $html .= '
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>';
    }
    
    return $html;
}

// Function to generate additional info rows
function generateAdditionalInfoRows($mr, $model, $serial_no, $tech,$prno) {
    $html = '';

    // Add MR row if not empty
    if (!empty($mr)) {
        $html .= '
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">MR: ' . htmlspecialchars($mr) . '</td>
                <td></td>
            </tr>';
    }
    
    // Add Model row if not empty
    if (!empty($model)) {
        $html .= '
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">Model: ' . htmlspecialchars($model) . '</td>
                <td></td>
            </tr>';
    }
    
    // Add Serial No row if not empty
    if (!empty($serial_no)) {
        $html .= '
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">Serial No.: ' . htmlspecialchars($serial_no) . '</td>
                <td></td>
            </tr>';
    }
    
    // Add Tech row if not empty
    if (!empty($tech)) {
        $html .= '
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">Tech: ' . htmlspecialchars($tech) . '</td>
                <td></td>
            </tr>';
    }
    if (!empty($prno)) {
        $html .= '
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;"><strong>PR No:</strong>' . htmlspecialchars($prno) . '</td>
                <td></td>
            </tr>';
    }
    
    return $html;
}

$item_rows_html = generateItemRows($quantities, $units, $descriptions, $blank_rows_needed);
$additional_info_html = generateAdditionalInfoRows($mr, $model, $serial_no, $tech, $prno);
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

    /* Remove page break after for the last container */
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
        border: none;
    }

    th {
        font-size: 8pt;
    }

    .merged-block {
        text-align: center;
        vertical-align: middle;
    }

    /* Column widths (proportional to Excel) */
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

    /* Logo positioning */
    .table-logo {
        position: absolute;
        width: calc(8.43% + 8.43% + 11.57%);
        height: 46.5px;
        object-fit: contain;
        z-index: 10;
        pointer-events: none;
    }

    /* First logo in each container */
    .first-logo {
        top: 10mm;
        left: calc(10mm + 49.72% - 13%);
    }

    /* Second logo in first container */
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

            <!-- Dynamic Item Rows -->
            <?php echo $item_rows_html; ?>

            <tr style="height: 10px;">
                <td colspan="10"></td>
            </tr>

            <!-- Additional Information Rows -->
            <?php echo $additional_info_html; ?>
              
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

            <!-- Row 3 -->
            <!-- <tr style="height: 15px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr> -->

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

            <!-- Dynamic Item Rows -->
            <?php echo $item_rows_html; ?>

            <tr style="height: 10px;">
                <td colspan="10"></td>
            </tr>

            <!-- Additional Information Rows -->
            <?php echo $additional_info_html; ?>
            
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
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;border-top: 2px solid black;">OTUS Authorized Representative</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="3" class="merged-block" style="font-weight: bold; text-align: center;"> </td>
                <td></td>
            </tr>

            <tr style="height: 15px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;"> </td>
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

<!-- Second Page -->
<div class="a4-container">
    <!-- Logo for second page -->
    <img src="otus logo.png" alt="OTUS Logo" class="table-logo first-logo">
    
    <!-- Third table-->
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

            <!-- Dynamic Item Rows -->
            <?php echo $item_rows_html; ?>

            <tr style="height: 10px;">
                <td colspan="10"></td>
            </tr>

            <!-- Additional Information Rows -->
            <?php echo $additional_info_html; ?>
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

</body>
</html>