<?php 
    $info1 = ['si_number' => '98765432', 'delivered_to' => 'john doe', 'address' => '123 main st', 'tin' => '123-456-789', 'term' => 'temr 25', 'si_date' => '10-22-205', 'particulars' => 'various items'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DR and ST</title>
    <style>
        * {
            font-family: "Arial Narrow", sans-serif;
            font-weight: 900;
            font-size: 9.5px;
            margin: 0;
            padding: 0;
            background: #fff;
            text-transform: uppercase;
        }

        /* Keep your A5 layout size */
        .a5 {
            width: 203.2mm;
            /* Your custom A5-like width */
            height: 139.7mm;
            /* Your A5-like height */
            background: white;
            box-sizing: border-box;
            /* margin: 0 auto; */
            position: relative;
        }

        .portrait-container {
            width: 138mm;
            margin: 0mm 7mm 0mm 5mm;
            padding-top: 22mm;
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
            padding: 4px;
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
            max-height: 10mm !important;
            min-height: 9.8mm !important;
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

        .col-item-desc {
            width: 64mm !important;
        }

        .col-unit-cost,
        .col-amount {
            width: 23mm !important;
        }

        .dr-row {
            height: 10mm;
        }

        .dr-2nd-row {
            height: 7.5mm !important;
        }

        .dr-2nd-row-header {
            height: 6mm !important;
        }

        .text-align {
            text-align: left !important;
        }

        .si-date {
            height: 9mm;
        }

        .no-space {
            margin: 0;
            padding: 0;
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
                display: flex;
                /* justify-content: center; */
                /* center horizontally */
                /* align-items: center; */
                /* center vertically */
                background: none !important;
            }

            .a5 {
                /* margin: auto; */
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
                        <?= htmlspecialchars($info1['si_number'])?>
                    </td>
                    <td class="col-sold-to">
                         <?= htmlspecialchars($info1['delivered_to'])?><br>
                         <?= htmlspecialchars($info1['tin'])?>
                    </td>
                </tr>
                <tr class="dr-row">
                    <td class="col-si-date"> <?= htmlspecialchars($info1['si_date'])?></td>
                    <td class="col-sold-to"> <?= htmlspecialchars($info1['address'])?></td>
                </tr>
                <tr class="dr-row">
                    <td class="col-terms" colspan="1"> <?= htmlspecialchars($info1['term'])?></td>
                    <td class="col-particulars"> <?= htmlspecialchars($info1['si_number'])?></td>
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
                    $info = [ ['quantity' => '5', 'unit' => 'PC', 'description' => 'Toner Cartridge, Black CT20249 6'],
                              ['quantity' => '4', 'unit' => 'PC', 'description' => 'Toner Cartridge, Black CT202496'],
                              ['quantity' => '3', 'unit' => 'PC', 'description' => 'Toner Cartridge, Black CT202496'],
                              ['quantity' => '2', 'unit' => 'PC', 'description' => 'Toner Cartridge, Black CT202496']
                            ];
                ?>

                <?php foreach ($info as $infos): ?>
                    <tr class="dr-2nd-row">
                        <td> <?= htmlspecialchars($infos['quantity'])?></td>
                        <td><?= htmlspecialchars($infos['unit'])?></td>
                        <td><?= htmlspecialchars($infos['description'])?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="dr-2nd-row">
                    <td></td>
                    <td></td>
                    <td class="text-align">Model: Apeos C2560</td>
                </tr>
                <tr class="dr-2nd-row">
                    <td></td>
                    <td></td>
                    <td class="text-align">Under PO No.: 2025-351</td>
                </tr>
                <tr class="dr-2nd-row">
                    <td></td>
                    <td></td>
                    <td class="text-align">Under Invoice No: 5131</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>