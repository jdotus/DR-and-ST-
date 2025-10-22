<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DR and ST</title>
</head>
<style>
   * {
    font-family: Arial black, sans-serif;
    font-weight: 700;
    font-size: 10px; 
    margin: 0;
    padding: 0;
    background: #fff;
    text-transform: uppercase;
}

/* A5 paper layout */
.a5 {
  width: 203.2mm;     /* A5 width */
  height: 139.7mm;    /* A5 height */
  background: white;
  /* margin: 10px auto; */
  /* box-shadow: 0 0 10px rgba(0,0,0,0.2); */
  /* border: 1px solid black;  */
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
td, th { 
    /* border: 1px solid red;  */
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

/* Column widths (scaled from A4) */
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

/* Print adjustments */
@media print {
    body, html {
        width: 148mm;
        height: 210mm;
        margin: 0;
        padding: 0;
    }
    .portrait-container {
        width: 138mm;
        margin: 0mm 2mm;
        padding-top: 20mm;
        /* border: 1px solid #000; */
    }
}

.margin_a5 {
  margin:  20px 0 20px; /* Adjust margin as needed */
}

</style>
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
                        <td class="col-terms" colspan="1"> TERMS</td>
                        <td class="col-particulars">PARTICULARS</td>
                    </tr>
                </table>
                <table>
                    <tr class="dr-2nd-row-header">
                        <td class="col-quantity" ></td> <!-- QUANTITY -->
                        <td class="col-units"></td><!-- UNIT -->
                        <td class="col-description"></td><!-- DESCRIPTION -->
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