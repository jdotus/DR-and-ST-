<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DR and ST</title>
    <style>
        * {
            font-family: "Arial Black", sans-serif;
            font-weight: 700;
            font-size: 10px;
            margin: 0;
            padding: 0;
            background: #fff;
            text-transform: uppercase;
        }

        /* A5 paper layout (Landscape) */
        .a5 {
            width: 210mm;
            /* A5 landscape width */
            height: 148mm;
            /* A5 landscape height */
            background: white;
            box-sizing: border-box;
            margin: 0 auto;
            position: relative;
        }

        .portrait-container {
            width: 190mm;
            margin: 0 auto;
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
            border: 1px solid #000;
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
            width: 120mm !important;
        }

        /* Second table */
        table:last-of-type {
            width: 190mm !important;
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

        .no-space {
            margin: 0;
            padding: 0;
        }

        /* Print setup */
        @media print {
            @page {
                size: A5 landscape;
                /* Ensures correct paper size */
                margin: 0;
                /* Adjust printer margin as needed */
            }

            html,
            body {
                width: 210mm;
                height: 148mm;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                /* centers horizontally */
                align-items: center;
                /* centers vertically */
                background: none !important;
            }

            .a5 {
                margin: auto;
                page-break-after: always;
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
                        <p>9123123</p>
                    </td>
                    <td class="col-sold-to">
                        DELIVERED TO<br>
                        123123123123
                    </td>
                </tr>
                <tr class="dr-row">
                    <td class="col-si-date">10-10-1010</td>
                    <td class="col-sold-to">ASASASASASASASAS</td>
                </tr>
                <tr class="dr-row">
                    <td class="col-terms" colspan="1">TERMS</td>
                    <td class="col-particulars">PARTICULARS</td>
                </tr>
            </table>

            <table>
                <tr class="dr-2nd-row-header">
                    <td class="col-quantity"></td>
                    <td class="col-units"></td>
                    <td class="col-description"></td>
                </tr>
                <tr class="dr-2nd-row">
                    <td>5</td>
                    <td>PC</td>
                    <td>Toner Cartridge, Black CT202496</td>
                </tr>
                <tr class="dr-2nd-row">
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="dr-2nd-row">
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="dr-2nd-row">
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
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