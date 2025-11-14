<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request method.";
    exit;
}

// Main form fields
$si_number = $_POST['si_number'] ?? '';
$delivered_to = $_POST['delivered_to'] ?? '';
$date = $_POST['date'] ?? '';
$address = $_POST['address'] ?? '';
$terms = $_POST['terms'] ?? '';
$particulars = $_POST['particulars'] ?? '';
$tin = $_POST['tin'] ?? '';
$unit_type = $_POST['unit_type'] ?? '';

// Form type selections
$dr_format = $_POST['dr_format'] ?? '';
$pullout_type = $_POST['pullout_type'] ?? '';

// Used Machines & Brand New Machines
$model = $_POST['model'] ?? [];
$serial = $_POST['serial'] ?? array_fill(0, 7, '________');
$mr_start = $_POST['mr_start'] ?? array_fill(0, 7, '________');
$mr_end = $_POST['mr_end'] ?? array_fill(0, 7, '________');
$color_imp = $_POST['color_imp'] ?? array_fill(0, 7, '0');
$black_imp = $_POST['black_imp'] ?? array_fill(0, 7, '0');
$color_large_imp = $_POST['color_large_imp'] ?? array_fill(0, 7, '0');

// DR with Prices
$price = $_POST['price'] ?? [];
$quantity = $_POST['quantity'] ?? [];
$item_desc = $_POST['item_desc'] ?? [];

// Replacement Machines (in pullout-replacement section)
$replace_model = $_POST['replace_model'] ?? [];
$replace_serial = $_POST['replace_serial'] ?? [];
$replace_mr_start = $_POST['replace_mr_start'] ?? [];
$replace_color_imp = $_POST['replace_color_imp'] ?? [];
$replace_black_imp = $_POST['replace_black_imp'] ?? [];
$replace_color_large_imp = $_POST['replace_color_large_imp'] ?? [];

// Pullout Machines (in pullout-replacement section)
$pullout_model = $_POST['pullout_model'] ?? [];
$pullout_serial = $_POST['pullout_serial'] ?? [];
$pullout_mr_end = $_POST['pullout_mr_end'] ?? [];
$pullout_color_imp = $_POST['pullout_color_imp'] ?? [];
$pullout_black_imp = $_POST['pullout_black_imp'] ?? [];
$pullout_color_large_imp = $_POST['pullout_color_large_imp'] ?? [];

// DR with Invoice
$po_number = $_POST['po_number'] ?? [];
$invoice_number = $_POST['invoice_number'] ?? [];
$note = $_POST['note'] ?? [];

// Used DR
$tech_name = $_POST['tech_name'] ?? [];
$pr_number = $_POST['pr_number'] ?? [];

// Fill arrays with default values if empty to prevent undefined index errors
$model = !empty($model) ? $model : array_fill(0, 7, '');
$serial = !empty($serial) ? $serial : array_fill(0, 7, '________');
$mr_start = !empty($mr_start) ? $mr_start : array_fill(0, 7, '________');
$color_imp = !empty($color_imp) ? $color_imp : array_fill(0, 7, '0');
$black_imp = !empty($black_imp) ? $black_imp : array_fill(0, 7, '0');
$color_large_imp = !empty($color_large_imp) ? $color_large_imp : array_fill(0, 7, '0');

// Fill other arrays with empty values if not set
$price = !empty($price) ? $price : [];
$quantity = !empty($quantity) ? $quantity : [];
$item_desc = !empty($item_desc) ? $item_desc : [];
$replace_model = !empty($replace_model) ? $replace_model : [];
$pullout_model = !empty($pullout_model) ? $pullout_model : [];
$po_number = !empty($po_number) ? $po_number : [];
$invoice_number = !empty($invoice_number) ? $invoice_number : [];
$note = !empty($note) ? $note : [];
$tech_name = !empty($tech_name) ? $tech_name : [];
$pr_number = !empty($pr_number) ? $pr_number : [];
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
            /* width: 100%;   */
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
            /* width: 138.5mm !important;  */
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

        .col.price {
            width: 38mm !important;
        }

        .col-quantity {
            width: 17.7mm !important;
            /* width: 14.7mm !important; */
        }

        .col-units {
            width: 14.3mm !important;
            /* width: 11.3mm !important; */
        }

        .col-description {
            padding: 0 5px;
            width: 156.5mm !important;
            /* width: 96.5mm !important; */
        }

        .col-description-header {
            /* width: 156.5mm !important; */
            width: 96.5mm !important;
        }

        .col-price {
            /* padding: 1mm 0 0 0; */
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
                    <?php if (isset($_POST['dr_format']) && $_POST['dr_format'] == 'drWithPrice') { ?>
                        <td class="col-description-header"></td> <!-- DESCRIPTION -->
                    <?php } else { ?>
                        <td class="col-description"></td> <!-- DESCRIPTION -->
                    <?php } ?>
                </tr>

                <?php

                if (isset($_POST['dr_format']) && $_POST['dr_format'] === 'used') { ?>
                    <tr class="dr-2nd-row">
                        <td><?= htmlspecialchars(count($serial)) ?></td>
                        <td><?= htmlspecialchars($unit_type) ?></td>
                        <td class="text-align" style="font-size: 10px">Deliver Machine<br>Model: <?= htmlspecialchars($model[0] ?? '') ?></td>
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
                <?php } else if (isset($_POST['dr_format']) && $_POST['dr_format'] == 'bnew') { ?>

                    <?php

                    // ✅ Clean serial list for each machine (assume $_POST['serial'] is an array, one per machine)
                    $countTableRows = 0;
                    $perRow = 3; // how many serials per row

                    if (!empty($model) && !empty($_POST['serial']) && count($serial) < 18) {
                        for ($i = 0; $i < count($model); $i++) {
                            if (count($_POST['serial']) > 15) {
                                continue;
                            }



                            // Each machine has its own serial input field (comma-separated)
                            $serialInput = $_POST['serial'][$i] ?? '';
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
                    for ($s = $countTableRows; $s < 6; $s++) {
                        echo '<tr class="dr-2nd-row-new">
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>';
                    }

                    ?>

                    <!-- For the Pullout Replacement Section -->
                    <?php } else if (isset($_POST['dr_format']) && $_POST['dr_format'] == 'pullout-delivery') {

                    if (isset($_POST['pullout_type']) && $_POST['pullout_type'] == 'replacementOnly') { ?>
                        <tr class="dr-2nd-row">
                            <td><?= htmlspecialchars(count($serial)) ?></td>
                            <td><?= htmlspecialchars($unit_type) ?></td>
                            <td class="text-align" style="font-size: 10px">Deliever Replacement Machine <br>Model: <?= htmlspecialchars($model[0] ?? '') ?></td>
                        </tr>

                        <?php for ($i = 0; $i < count($serial); $i++) {
                            $srReplacementDisplay = trim($serial[$i]) !== '' ? htmlspecialchars($serial[$i]) : '<span class="underline-empty"></span>';
                            $mrReplacementDisplay = trim($mr_start[$i]) !== '' ? htmlspecialchars($mr_start[$i]) : '<span class="underline-empty"></span>';

                            $ciDisplay = trim($color_imp[$i]) !== '' ? htmlspecialchars($color_imp[$i]) : '<span class="underline-empty"></span>';
                            $biDisplay = trim($black_imp[$i]) !== '' ? htmlspecialchars($black_imp[$i]) : '<span class="underline-empty"></span>';
                            $cliDisplay = trim($color_large_imp[$i]) !== '' ? htmlspecialchars($color_large_imp[$i]) : '<span class="underline-empty"></span>';

                            $mrReplacementFormat = "MR Start:" . $mrReplacementDisplay . " (CI:" . $ciDisplay . "; BI:" . $biDisplay . "; CLI:" . $cliDisplay . ")";

                        ?>
                            <tr class="dr-2nd-row">
                                <td></td>
                                <td></td>
                                <td class="text-align">Serial No.: <?= $srReplacementDisplay ?> <?= $mrReplacementFormat ?> </td>
                            </tr>
                        <?php } ?>

                        <?php for ($i = count($replace_serial); $i < 6; $i++) { ?>
                            <tr class="dr-2nd-row">
                                <td></td>
                                <td></td>
                                <td class="text-align"></td>
                            </tr>
                        <?php } ?>



                    <?php } else if (isset($_POST['pullout_type']) && $_POST['pullout_type'] == 'pulloutOnly') { ?>
                        <tr class="dr-2nd-row">
                            <td><?= htmlspecialchars(count($serial)) ?></td>
                            <td><?= htmlspecialchars($unit_type) ?></td>
                            <td class="text-align" style="font-size: 10px">Pull Out Machine <br>Model: <?= htmlspecialchars($models[0] ?? '') ?></td>
                        </tr>

                        <?php for ($i = 0; $i < count($serial); $i++) {
                            $srPulloutDisplay = trim($serial[$i]) !== '' ? htmlspecialchars($serial[$i]) : '<span class="underline-empty"></span>';
                            $mrPulloutDisplay = trim($mr_end[$i]) !== '' ? htmlspecialchars($mr_end[$i]) : '<span class="underline-empty"></span>';

                            $ciDisplay = trim($color_imp[$i]) !== '' ? htmlspecialchars($color_imp[$i]) : '<span class="underline-empty"></span>';
                            $biDisplay = trim($black_imp[$i]) !== '' ? htmlspecialchars($black_imp[$i]) : '<span class="underline-empty"></span>';
                            $cliDisplay = trim($color_large_imp[$i]) !== '' ? htmlspecialchars($color_large_imp[$i]) : '<span class="underline-empty"></span>';

                            $mrPulloutFormat = "MR End:" . $mrPulloutDisplay . " (CI:" . $ciDisplay . "; BI:" . $biDisplay . "; CLI:" . $cliDisplay . ")";
                        ?>

                            <tr class="dr-2nd-row">
                                <td></td>
                                <td></td>
                                <td class="text-align">Serial No.:<?= $srPulloutDisplay ?> <?= $mrPulloutFormat ?> </td>
                            </tr>
                        <?php } ?>


                        <?php for ($i = count($pullout_serial); $i < 6; $i++) { ?>
                            <tr class="dr-2nd-row">
                                <td></td>
                                <td></td>
                                <td class="text-align"></td>
                            </tr>
                        <?php } ?>

                        <?php } else {

                        if (!empty($replace_model) && !empty($replace_serial)) { ?>

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

                            for ($j = count($pullout_serial); $j < 2; $j++) { ?>
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
                <?php } else if (isset($_POST['dr_format']) && $_POST['dr_format'] == 'drWithInvoice') { ?>
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
                <?php } else if (isset($_POST['dr_format']) && $_POST['dr_format'] == 'drWithPrice') { ?>

                    <?php
                    $totalPerItem = 0;
                    $grandTotal = 0;
                    ?>

                    <?php for ($i = 0; $i < count($quantity); $i++) {

                        $priceVal = isset($price[$i]) ? floatval(str_replace([',', ' '], '', (string)$price[$i])) : 0.0;
                        $qtyVal   = isset($quantity[$i]) ? floatval(str_replace([',', ' '], '', (string)$quantity[$i])) : 0.0;

                        $totalPerItem = $priceVal * $qtyVal;
                        $grandTotal += $totalPerItem;

                    ?>
                        <tr class="dr-2nd-row">
                            <td class="col-quantity"> <?= htmlspecialchars($quantity[$i]) ?></td> <!-- 1. Quantity -->
                            <td class="col-units"><?= htmlspecialchars($unit_type[$i] ?? '') ?></td> <!-- 2. Unit -->
                            <td class="col-description text-align"><?= htmlspecialchars($item_desc[$i] ?? '') ?></td> <!-- 3. Description (WIDE) -->
                            <td class="col-price"><?= htmlspecialchars(number_format((int)$priceVal)) ?></td>
                            <td class="col-price"><?= htmlspecialchars(number_format((int)$totalPerItem)) ?></td>
                        </tr>
                    <?php } ?>

                    <?php for ($j = count($quantity); $j < 5; $j++) { ?>
                        <tr class="dr-2nd-row">
                            <td class="col-quantity"> </td>
                            <td class="col-units"></td>
                            <td class="col-description text-align"></td>
                            <td class="col-price"></td>
                            <td class="col-price"></td>
                        </tr>
                    <?php } ?>
                    <tr class="dr-2nd-row">
                        <td class="col-quantity"> </td>
                        <td class="col-units"></td>
                        <td class="col-description text-align">Machine Model: <?= htmlspecialchars($model[0] ?? '') ?></td>
                        <td class="col-price"></td>
                        <td class="col-price"></td>
                    </tr>

                    <tr class="dr-2nd-row">
                        <td class="col-quantity"> </td>
                        <td class="col-units"></td>
                        <td class="col-description text-align"></td>
                        <td class="col-price">TOTAL: </td>
                        <td class="col-price"><?= htmlspecialchars(number_format((int)$grandTotal)) ?></td>
                    </tr>

                <?php } else if (isset($_POST['dr_format']) && $_POST['dr_format'] == 'usedDr') { ?>
                    <?php for ($i = 0; $i < count($quantity); $i++) { ?>

                        <tr class="dr-2nd-row">
                            <td> <?= htmlspecialchars($quantity[$i]) ?> </td>
                            <td> <?= htmlspecialchars($unit_type[$i]) ?> </td>
                            <td class="col-description text-align"> <?= htmlspecialchars($item_desc[$i]) ?> </td>
                        </tr>
                    <?php } ?>
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