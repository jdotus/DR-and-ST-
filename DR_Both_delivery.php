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

    /* for Delivery of Brand New Machines and Used Machines */ 
    // Accept one or more inputs in serialNo[] fields. Each input may contain
    // comma-separated serial numbers. Flatten and trim into $serialNo array.
    // $rawSerialInputs = isset($_POST['serialNo']) ? $_POST['serialNo'] : [];
    // $serialNo = [];
    // foreach ((array)$rawSerialInputs as $input) {
    //     // split by comma, trim and discard empty parts
    //     $parts = array_filter(array_map('trim', explode(',', (string)$input)), function($v){ return $v; });
    //     foreach ($parts as $p) $serialNo[] = $p;
    // }
    $bnewMachineModel = isset($_POST['bnewMachineModel']) ? $_POST['bnewMachineModel'] : '0';
    $serialNo = isset($_POST['serialNo']) ? $_POST['serialNo'] : array_fill(0, 7, '________');
    $mrStart = isset($_POST['mrStart']) ? $_POST['mrStart'] : array_fill(0, 7, '________');
    $colorImpression = $_POST['colorImpression'] ?? 0;
    $blackImpression = $_POST['blackImpression'] ?? 0;
    $colorLargeImpression = $_POST['colorLargeImpression'] ?? 0;

    /* for Pull Out Replacement Machines */
    $replacementMachineModel = $_POST['replacementMachineModel'] ?? '';
    $replacementSerialNo = $_POST['replacementSerialNo'] ?? '';
    $replacementMrStart = isset($_POST['replacementMrStart']) ? $_POST['replacementMrStart'] : '0';
    $replacementColorImpression = isset($_POST['replacementColorImpression']) ? $_POST['replacementColorImpression'] : '0';
    $replacementBlackImpression = isset($_POST['replacemenBlackImpression']) ? $_POST['replacemenBlackImpression'] : '0';
    $replacementColorLargeImpression = isset($_POST['replacemenColorLargeImpression']) ? $_POST['replacemenColorLargeImpression'] : "0";

    $pulloutMachineModel = isset($_POST['pulloutMachineModel']) ? $_POST['pulloutMachineModel'] : '';
    $pulloutSerialNo = isset($_POST['pulloutSerialNo']) ? $_POST['pulloutSerialNo'] : '';
    $pulloutMrEnd = isset($_POST['pulloutMrEnd']) ? $_POST['pulloutMrEnd'] : '0';
    $pulloutColorImpression = isset($_POST['pulloutColorImpression']) ? $_POST['pulloutColorImpression'] : '';
    $pulloutBlackImpression = isset($_POST['pulloutBlackImpression']) ? $_POST['pulloutBlackImpression'] : '';
    $pulloutColorLargeImpression = isset($_POST['pulloutColorLargeImpression']) ? $_POST['pulloutColorLargeImpression'] : '';

    /* DR with Complete Delivery and Partial*/
    $drInvoiceMachineModel = $_POST['drInvoiceMachineModel'] ?? '';
    $drInvoiceNote = $_POST['drInvoiceNote'] ?? '';
    $drInvoiceUnderPo = isset($_POST['drInvoiceUnderPo']) ? $_POST['drInvoiceUnderPo'] : '';
    $drInvoiceUnderInvoice = isset($_POST['drInvoiceUnderInvoice']) ? $_POST['drInvoiceUnderInvoice'] : '';
    $drInvoiceQuantity = isset($_POST['drInvoiceQuantity']) ? $_POST['drInvoiceQuantity'] : '';
    $drInvoiceUnits = isset($_POST['drInvoiceUnits']) ? $_POST['drInvoiceUnits'] : '';
    $drInvoiceItemDescription = isset($_POST['drInvoiceItemDescription']) ? $_POST['drInvoiceItemDescription'] : '';
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
            min-width: 55px;
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
                        
                        $ci = trim((string)($colorImpression[$i] ?? ''));
                        $bi = trim((string)($blackImpression[$i] ?? ''));
                        $cli = trim((string)($colorLargeImpression[$i] ?? ''));

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
                    
                    <?php }?>
                    <?php for($j = count($serialNo); $j < 7; $j++) {?>
                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                <?php } ?>
                    
                    <!-- For the Brand New Machine Delivery -->
               <?php } else if (isset($_POST['machineType']) && $_POST['machineType'] == 'bnew') { ?>
                <?php
                    // ✅ Clean serial list for each machine (assume $_POST['serialNo'] is an array, one per machine)
                    $countTableRows = 0;
                    $perRow = 3; // how many serials per row

                    if (!empty($bnewMachineModel) && !empty($_POST['serialNo']) && count($serialNo) < 18) {
                        for ($i = 0; $i < count($bnewMachineModel); $i++) {
                            if(count($_POST['serialNo']) > 15) {
                                continue;
                            }

                            // Each machine has its own serial input field (comma-separated)
                            $serialInput = $_POST['serialNo'][$i] ?? '';
                            $serialsClean = array_values(array_filter(array_map('trim', explode(',', $serialInput))));
                            $serialsCount = count($serialsClean);

                            if ($serialsCount === 0) continue; // skip if no serials

                            ?>
                            <!-- Machine Header Row -->
                            <tr class="dr-2nd-row">
                                <td><?= htmlspecialchars($serialsCount) ?></td>
                                <td><?= htmlspecialchars($units ?? '') ?></td>
                                <td class="text-align" style="font-size: 10px">
                                    Deliver Brand New Machine<br>
                                    Model: <?= htmlspecialchars($bnewMachineModel[$i]) ?>
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
                    for ($s = $countTableRows; $s < 6; $s++) {
                        echo '<tr class="dr-2nd-row-new">
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>';
                    }
                ?>

                <!-- For the Pullout Replacement Section -->
                <?php } else if(isset($_POST['machineType']) && $_POST['machineType'] == 'pullout-delivery') { 

                    if(isset($_POST['machineType2']) && $_POST['machineType2'] == 'replacementOnly') { ?>
                         <tr class="dr-2nd-row">
                            <td><?= htmlspecialchars(count($replacementSerialNo)) ?></td>
                            <td><?= htmlspecialchars($units) ?></td>
                            <td class="text-align" style="font-size: 10px">Deliever Replacement Machine <br>Model: <?= htmlspecialchars($replacementMachineModel) ?></td>
                        </tr>

                        <?php for($i = 0; $i < count($replacementSerialNo); $i++) { 
                            $srReplacementDisplay = trim($replacementSerialNo[$i]) !== '' ? htmlspecialchars($replacementSerialNo[$i]) : '<span class="underline-empty"></span>';
                            $mrReplacementDisplay = trim($replacementMrStart[$i]) !== '' ? htmlspecialchars($replacementMrStart[$i]) : '<span class="underline-empty"></span>';

                            $ciDisplay = trim($replacementColorImpression[$i]) !== '' ? htmlspecialchars($replacementColorImpression[$i]) : '<span class="underline-empty"></span>';
                            $biDisplay = trim($replacementBlackImpression[$i]) !== '' ? htmlspecialchars($replacementBlackImpression[$i]) : '<span class="underline-empty"></span>';
                            $cliDisplay = trim($replacementColorLargeImpression[$i]) !== '' ? htmlspecialchars($replacementColorLargeImpression[$i]) : '<span class="underline-empty"></span>';
                            
                            $mrReplacementFormat = "MR Start:" . $mrReplacementDisplay . " (CI:" . $ciDisplay . "; BI:" . $biDisplay . "; CLI:" . $cliDisplay . ")";
                        ?>
                        <tr class="dr-2nd-row">
                            <td></td>
                            <td></td>
                            <td class="text-align">Serial No.: <?= $srReplacementDisplay ?> <?= $mrReplacementFormat ?> </td>
                        </tr>
                        <?php }?>

                        <?php for($i = count($replacementSerialNo); $i < 6; $i++) { ?>
                        <tr class="dr-2nd-row">
                            <td></td>
                            <td></td>
                            <td class="text-align"></td>
                        </tr>
                    <?php } ?>

                   <?php } else if (isset($_POST['machineType2']) && $_POST['machineType2'] == 'pulloutOnly') { ?>
                        <tr class="dr-2nd-row">
                            <td><?= htmlspecialchars(count($pulloutSerialNo)) ?></td>
                            <td><?= htmlspecialchars($units) ?></td>
                            <td class="text-align" style="font-size: 10px">Pull Out Machine <br>Model: <?= htmlspecialchars($pulloutMachineModel) ?></td>
                        </tr>

                        <?php for($i = 0; $i < count($pulloutSerialNo); $i++) {
                            $srPulloutDisplay = trim($pulloutSerialNo[$i]) !== '' ? htmlspecialchars($pulloutSerialNo[0]) : '<span class="underline-empty"></span>';
                            $mrPulloutDisplay = trim($pulloutMrEnd[$i]) !== '' ? htmlspecialchars($pulloutMrEnd[0]) : '<span class="underline-empty"></span>';
    
                            $ciDisplay = trim($pulloutColorImpression[$i]) !== '' ? htmlspecialchars($pulloutColorImpression[$i]) : '<span class="underline-empty"></span>';
                            $biDisplay = trim($pulloutBlackImpression[$i]) !== '' ? htmlspecialchars($pulloutBlackImpression[$i]) : '<span class="underline-empty"></span>';
                            $cliDisplay = trim($pulloutColorLargeImpression[$i]) !== '' ? htmlspecialchars($pulloutColorLargeImpression[$i]) : '<span class="underline-empty"></span>';
                            
                            $mrPulloutFormat = "MR End:" . $mrPulloutDisplay . " (CI:" . $ciDisplay . "; BI:" . $biDisplay . "; CLI:" . $cliDisplay . ")";
                        ?>

                            <tr class="dr-2nd-row">
                                <td></td>
                                <td></td>
                                <td class="text-align">Serial No.:<?= $srPulloutDisplay ?> <?= $mrPulloutFormat ?> </td>
                            </tr>
                        <?php } ?>
                        
                        <?php for($i = count($pulloutSerialNo); $i < 6; $i++) {?>
                            <tr class="dr-2nd-row">
                                <td></td>
                                <td></td>
                                <td class="text-align"></td>
                            </tr>
                        <?php } ?>
                    <?php } else { 
                        if(!empty($replacementMachineModel) && !empty($replacementSerialNo)) { ?>

                        <tr class="dr-2nd-row">
                            <td><?= htmlspecialchars(count($replacementSerialNo)) ?></td>
                            <td><?= htmlspecialchars($units) ?></td>
                            <td class="text-align" style="font-size: 10px">Deliever Replacement Machine <br>Model: <?= htmlspecialchars($replacementMachineModel) ?></td>
                        </tr>
                        
                        <?php for($i = 0; $i < count($replacementSerialNo); $i++) {  
                            $srReplacementDisplay = trim($replacementSerialNo[$i]) !== '' ? htmlspecialchars($replacementSerialNo[$i]) : '<span class="underline-empty"></span>';
                            $mrReplacementDisplay = trim($replacementMrStart[$i]) !== '' ? htmlspecialchars($replacementMrStart[$i]) : '<span class="underline-empty"></span>';

                            $ciDisplay = trim($replacementColorImpression[$i]) !== '' ? htmlspecialchars($replacementColorImpression[$i]) : '<span class="underline-empty"></span>';
                            $biDisplay = trim($replacementBlackImpression[$i]) !== '' ? htmlspecialchars($replacementBlackImpression[$i]) : '<span class="underline-empty"></span>';
                            $cliDisplay = trim($replacementColorLargeImpression[$i]) !== '' ? htmlspecialchars($replacementColorLargeImpression[$i]) : '<span class="underline-empty"></span>';
                            
                            
                            $mrReplacementFormat = "MR Start:" . $mrReplacementDisplay . " (CI:" . $ciDisplay . "; BI:" . $biDisplay . "; CLI:" . $cliDisplay . ")";
                        ?>
                                
                        <tr class="dr-2nd-row">
                            <td></td>
                            <td></td>
                            <td class="text-align">Serial No.: <?= $srReplacementDisplay ?> <?= $mrReplacementFormat ?> </td>
                        </tr>
                        
                        <?php }
                        for($j = count($replacementSerialNo); $j < 2; $j++) {?>
                            <tr class="dr-2nd-row">
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <?php } 
                    } ?>

                    <?php if(!empty($pulloutMachineModel) && !empty($pulloutSerialNo)) {?>
                        <tr class="dr-2nd-row">
                            <td><?= htmlspecialchars(count($pulloutSerialNo)) ?></td>
                            <td><?= htmlspecialchars($units) ?></td>
                            <td class="text-align" style="font-size: 10px">Pull Out Machine <br>Model: <?= htmlspecialchars($pulloutMachineModel) ?></td>
                        </tr>
                        <?php for($i = 0; $i < count($pulloutSerialNo); $i++) {
                            $srPulloutDisplay = trim($pulloutSerialNo[$i]) !== '' ? htmlspecialchars($pulloutSerialNo[0]) : '<span class="underline-empty"></span>';
                            $mrPulloutDisplay = trim($pulloutMrEnd[$i]) !== '' ? htmlspecialchars($pulloutMrEnd[0]) : '<span class="underline-empty"></span>';
    
                            $ciDisplay = trim($pulloutColorImpression[$i]) !== '' ? htmlspecialchars($pulloutColorImpression[$i]) : '<span class="underline-empty"></span>';
                            $biDisplay = trim($pulloutBlackImpression[$i]) !== '' ? htmlspecialchars($pulloutBlackImpression[$i]) : '<span class="underline-empty"></span>';
                            $cliDisplay = trim($pulloutColorLargeImpression[$i]) !== '' ? htmlspecialchars($pulloutColorLargeImpression[$i]) : '<span class="underline-empty"></span>';
                            
                            $mrPulloutFormat = "MR End:" . $mrPulloutDisplay . " (CI:" . $ciDisplay . "; BI:" . $biDisplay . "; CLI:" . $cliDisplay . ")";
                        ?>
                            <tr class="dr-2nd-row">
                                <td></td>
                                <td></td>
                                <td class="text-align">Serial No.:<?= $srPulloutDisplay ?> <?= $mrPulloutFormat ?> </td>
                            </tr>
                        <?php }

                        for($j = count($pulloutSerialNo); $j < 2; $j++) {?>
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
                <?php } ?>

                <!-- For the DR with Invoice Section -->
                <?php } else if (isset($_POST['machineType']) && $_POST['machineType'] == 'drWithInvoice') { ?>
                        
                        <?php for($i = 0; $i < count($drInvoiceQuantity); $i++) {?>
                            <tr class="dr-2nd-row">
                                <td> <?= htmlspecialchars($drInvoiceQuantity[$i])?></td>
                                <td><?= htmlspecialchars($drInvoiceUnits[$i])?></td>
                                <td class="text-align"><?= htmlspecialchars($drInvoiceItemDescription[$i])?></td>
                            </tr>
                        <?php } ?>

                        <?php for($j = count($drInvoiceQuantity); $j < 4; $j++) {?>
                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td class="text-align"></td> 
                        </tr>
                        <?php } ?>
                        
                        <tr class="dr-2nd-row-new">
                            <td></td>
                            <td></td>
                            <td class="text-align">Model: <?= htmlspecialchars($drInvoiceMachineModel)?> </td> <!-- Echo here -->
                        </tr>

                        <?php if(!empty($drInvoiceUnderPo) && !empty($drInvoiceUnderInvoice)) { ?>
                            <tr class="dr-2nd-row-new">
                                <td></td>
                                <td></td>
                                <td class="text-align">Under PO No.: <?= htmlspecialchars($drInvoiceUnderPo) ?></td> <!-- Echo here -->
                            </tr>
                            
                            <tr class="dr-2nd-row-new">
                                <td></td>
                                <td></td>
                                <td class="text-align">Under Invoice No: <?= htmlspecialchars($drInvoiceUnderInvoice) ?><br> <span style="font-style: italic;"><?= htmlspecialchars($drInvoiceNote); ?></span><td> <!-- Echo here -->
                            </tr>
                            
                        <?php } else if(empty($drInvoiceUnderPo) && !empty($drInvoiceUnderInvoice)) {?>
                            <tr class="dr-2nd-row-new">
                                <td></td>
                                <td></td>
                                <td class="text-align">Under Invoice No: <?= htmlspecialchars($drInvoiceUnderInvoice) ?><br> <span style="font-style: italic;"><?= htmlspecialchars($drInvoiceNote); ?></span><td> <!-- Echo here -->
                            </tr>
                            <tr class="dr-2nd-row-new">
                                <td></td>
                                <td></td>
                                <td class="text-align"></td> 
                            </tr>
                        <?php } else if(!empty($drInvoiceUnderPo) && empty($drInvoiceUnderInvoice)) { ?>
                            <tr class="dr-2nd-row-new">
                                <td></td>
                                <td></td>
                                <td class="text-align">Under PO No.: <?= htmlspecialchars($drInvoiceUnderPo) ?><br><span style="font-style: italic;"><?= htmlspecialchars($drInvoiceNote); ?></span></td> <!-- Echo here -->
                            </tr>
                            <tr class="dr-2nd-row-new">
                                <td></td>
                                <td></td>
                                <td class="text-align"></td> 
                            </tr>
                        <?php } else {?>
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
                    <?php }else if (isset($_POST['machineType']) && $_POST['machineType'] == 'drWithPrice') { ?>
                            
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