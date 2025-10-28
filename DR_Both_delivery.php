<?php
    if($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo "Invalid request method.";
        exit;
    }


    $siNo = $_POST['siNumber'] ?? ''; 
    $deliveredTo = $_POST['deliveredTo'] ?? '';
    $date = $_POST['date'] ?? '';
    $address = $_POST['address'] ?? '';
    $terms = $_POST['terms'] ?? '';
    $particulars = $_POST['particulars'] ?? '';
    $machineModel = $_POST['machineModel'] ?? '';
    $units = $_POST['units'] ?? '';
    $tin = $_POST['tin'] ?? '';

    $serialNo = isset($_POST['serialNo']) ? $_POST['serialNo'] : array_fill(0, 7, '__________');
    $mrStart = isset($_POST['mrStart']) ? $_POST['mrStart'] : array_fill(0, 7, '__________');
    $colorImpression = $_POST['colorImpression'] ?? 0;
    $blackImpression = $_POST['blackImpression'] ?? 0;
    $colorLargeImpression = $_POST['colorLargeImpression'] ?? 0;

    
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

        /* Second table */
        table:last-of-type {
            width: 138mm !important;
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

        .col-quantity {
            width: 17.7mm !important;
        }

        .col-units {
            width: 14.3mm !important;
        }

        .col-description {
            width: 156.5mm !important;
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
            min-width: 50px;
        }
        
        .dr-2nd-row-new {
            /* height: 7.5mm !important; */
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
                        <?= htmlspecialchars($siNo)?>
                    </td>
                    <td class="col-sold-to">
                         <?= htmlspecialchars($deliveredTo)?><br>
                         <?= htmlspecialchars($tin)?>
                    </td>
                </tr>
                <tr class="dr-row">
                    <td class="col-si-date"><br> <?= htmlspecialchars($date)?></td>
                    <td class="col-sold-to"> <?= htmlspecialchars($address)?></td>
                </tr>
                <tr class="dr-row">
                    <td class="col-terms"><br> <?= htmlspecialchars($terms)?></td>
                    <td class="col-particulars"> <?= htmlspecialchars($particulars)?></td>
                </tr>
            </table>

            <table>
                <!-- HEADINGS -->
                <tr class="dr-2nd-row-header">
                    <td class="col-quantity"></td> <!-- QUANTITY -->
                    <td class="col-units"></td> <!-- UNIT -->
                    <td class="col-description"></td> <!-- DESCRIPTION -->
                </tr>
                
                <?php 
                if(isset($_POST['machineType']) && $_POST['machineType'] === 'used') { ?>
                    <tr class="dr-2nd-row">
                        <td><?= htmlspecialchars(count($serialNo)) ?></td>
                        <td><?= htmlspecialchars($units) ?></td>
                        <td class="text-align" style="font-size: 10px">Deliver Machine<br>Model: <?= htmlspecialchars($machineModel) ?></td>
                    </tr>

                    <?php
                    for($i = 0; $i < count($serialNo); $i++) {?>
                    <?php 
                        $srDisplay = trim($serialNo[$i]) !== '' ? htmlspecialchars($serialNo[$i]) : '<span class="underline-empty"></span>';
                        $mrDisplay = trim($mrStart[$i]) !== '' ? htmlspecialchars($mrStart[$i]) : '<span class="underline-empty"></span>';
                            
                        
                        if($colorImpression[$i] === 0 || $colorImpression[$i] === ''){
                                $messageFormat = "Serial No.: " . $srDisplay .  " MR Start: "  . $mrDisplay; 
                            }else{
                                $messageFormat = "Serial No.: " . $srDisplay . " MR Start: " . $mrDisplay . " (CI: " . $colorImpression[$i] . "; BI: " . $blackImpression[$i] . "; CLI: " . $colorLargeImpression[$i] . ")"; 
                            }
                        ?>
                    
                    <tr class="dr-2nd-row-new">
                        <td></td>
                        <td></td>
                        <td class="text-align" style="font-size: 11px; "><?= $messageFormat ?></td>
                    </tr>
                    
                    <?php }?>
                    <?php for($j = count($serialNo); $j < 7; $j++) {?>
                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                <?php } ?>

                <?php } else if (isset($_POST['machineType']) && $_POST['machineType'] == 'bnew') { ?>
                    <tr class="dr-2nd-row">
                        <td><?= htmlspecialchars(count($serialNo)) ?></td>
                        <td><?= htmlspecialchars($units) ?></td>
                        <td class="text-align" style="font-size: 10px">Deliver Brand New Machine<br>Model: <?= htmlspecialchars($machineModel) ?></td>
                    </tr>

                    <?php
                        if (!empty($serialNo)) {
                            $countTableRows = 0;
                            $count = 0;
                            $perRow = 3; // ✅ how many serials per row
                            $total = count($serialNo);

                            foreach ($serialNo as $index => $sr) {
                                $sr = trim($sr);
                                if ($sr === '') continue; // skip empty entries

                                // Start a new row every $perRow serials
                                if ($count % $perRow == 0) {
                                    if ($count > 0) echo '</td></tr>'; // close previous row
                                    echo '<tr class="dr-2nd-row-new">';
                                    echo '<td></td>';
                                    echo '<td></td>';
                                    echo '<td class="text-align" style="font-size: 11px;">';
                                    $countTableRows++;
                                }

                                // Print serial number
                                echo 'Serial No. ' . htmlspecialchars($sr) . str_repeat('&nbsp;', 5);
                                $count++;

                                // If last serial, close row
                                if ($count == $total) {
                                    echo '</td></tr>';
                                }
                            }   
                        }
                        // ✅ Fill remaining blank rows up to 7 total
                        for ($s = $countTableRows; $s < 7; $s++) {
                            echo '<tr class="dr-2nd-row-new">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>';
                        }
                        ?>
                <?php } ?>
            </table>
        </div>
    </div>
</body>

</html>