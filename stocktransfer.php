<!DOCTYPE html>
<html>
<head>
<title>A4 Table with Logo</title>
<style>
    body {
        background-color: #f0f0f0; 
        margin: 0;
        padding: 20px;
    }

    .a4-container {
        width: 210mm;
        min-height: 297mm;
        margin: 0 auto;
        background-color: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        padding: 10mm;
        box-sizing: border-box;
        position: relative;
        page-break-after: always; /* Ensure page break after each container */
    }

    table {
        border-collapse: collapse;
        width: 100%;
        table-layout: fixed;
        font-family: Arial, sans-serif;
        font-size: 9pt;
        margin-bottom: 10mm; /* Space between tables */
    }

    th, td {
        text-align: center;
        overflow: visible;
        white-space: nowrap;
        vertical-align: middle;
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
        top: 10mm;
        left: calc(10mm + 49.72% - 13%); /* moved a bit left */
        width: calc(8.43% + 8.43% + 11.57%);
        height: 46.5px;
        object-fit: contain;
        z-index: 10;
        pointer-events: none;
    }

    /* Second table logo positioning */
    .second-table-logo {
        top: calc(6mm + 144mm); /* Positioned for the second table */
    }

    /* Print formatting */
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
    <img src="otus logo.png" alt="OTUS Logo" class="table-logo">
    
    <!-- First table -->
    <table>
        <colgroup>
            <col class="col-1"><col class="col-2"><col class="col-3"><col class="col-4"><col class="col-5">
            <col class="col-6"><col class="col-7"><col class="col-8"><col class="col-9"><col class="col-10">
        </colgroup>

        <thead>
            <tr style="height: 15px;">
                <th colspan="9"> </th>
                <th> </th>
            </tr>
        </thead>

        <tbody>
            <!-- Row 2: merged 7-9 -->
            <tr style="height: 15.75px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>
            <!-- Row 3: merged 7-9 -->
            <tr style="height: 15px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>
            <!-- Row 4: merged 7-9 -->
            <tr style="height: 12.75px;">
                <td style="text-align: left;">Stock No</td>
                <td>2025 - NE10022</td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 8.5px; color: blue;">OTUS COPY SYSTEMS, INC.</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 5: merged 6-8 -->
            <tr style="height: 12px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;">North East</td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="4" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;">10F MG Tower #75 Brgy. Daang Bakal Shaw Blvd.</td>
                
                <td></td>
            </tr>
<!-- Row 6: merged 7-9 -->
            <tr style="height: 12px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;"> </td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;">Mandaluyong City</td>
                <td> </td>
                <td> </td>
                <td> </td>
            </tr>
            <!-- Row 7: merged 7-9 -->
            <tr style="height: 12px;">
                <td style="font-weight: bold; text-align: left;">Date:</td>
                <td colspan="2" class="merged-block" style="text-align: left;">October 21, 2025</td>
                <td></td>
                <td></td>
                <td colspan="4" class="merged-block" style="font-weight: bold;font-size: 9px; text-align: left;">Philippines Tel. 8631 - 9454 (Telefax: 535 - 8731)</td>
                <td></td>
            </tr>
            <!-- Row 80: merged 7-9 -->
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

            <!-- Row 9: merged 3-9 -->
            <tr style="height: 27px;">
                <td></td>
                <td></td>
                <td colspan="6" style="font-family: 'Bodoni Moda', serif; font-size: 24px; font-weight: 900; text-align: center;">
    STOCK TRANSFER
</td>
                <td></td>
                <td></td>
            </tr>
            <!-- Row 10: merged 1-9 -->
            <tr style="height: 15px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>
            <!-- Row 11: merged 1-2 -->
            <tr style="height: 15.75px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;">Account Name:</td>
                <td></td>
                <td style="font-weight: bold; text-align: left;">LTO-HR</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 12: merged 4-9 -->
            <tr style="height: 15.75px;">
                <td style="font-weight: bold; text-align: left;">Address:</td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 12px;">LTO Comp. East Ave, Diliman, Quezon City</td>
                <td></td>
            </tr>

            <!-- Row 13: merged 1-9 -->
            <tr style="height: 15.75px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>

            <!-- Row 14: merged 4-6 -->
            <tr>
                <td style="font-weight: bold; font-size: 10px">QUANTITY</td>
                <td style="font-weight: bold;font-size: 10px">UNITS</td>
                <td></td>
                <td colspan="3" class="merged-block" style="font-weight: bold;font-size: 10px">ITEMS DESCRIPTION</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 15–29 merged as before -->
            <tr style="height: 9.75px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
           <!-- Row 16: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 17: merged 7-9 -->
            <tr style="height: 15px; ">
                <td style="text-align: center;">1</td>
                <td style="text-align: center;">pc</td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">Toner Cartridge</td>
                <td></td>
            </tr>
            <!-- Row 18: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 19: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 20: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 21: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 22: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">MR: 222,429</td>
                <td></td>
            </tr>
           <!-- Row 23: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">Model: DCIV- 3065</td>
                <td></td>
            </tr>
            <!-- Row 24: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">Serial No.: 306596</td>
                <td></td>
            </tr>
            <!-- Row 25: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">Tech: Walter</td>
                <td></td>
            </tr>
            <!-- Row 26: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
           <!-- Row 27: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 28: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 29: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>

            <!-- Row 30: merged 7-9 -->
            <tr style="height: 15px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;border-top: 2px solid black;">Acknowledged by- End-user</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="3" class="merged-block" style="font-weight: bold; text-align: center;border-top: 2px solid black;">OTUS Authorized Representative</td>
                <td></td>
            </tr>

            <!-- Row 31: merged 7-9 -->
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

    <!-- Second table logo -->
    <img src="otus logo.png" alt="OTUS Logo" class="table-logo second-table-logo">
    
    <!-- Second table -->
    <table>
        <colgroup>
            <col class="col-1"><col class="col-2"><col class="col-3"><col class="col-4"><col class="col-5">
            <col class="col-6"><col class="col-7"><col class="col-8"><col class="col-9"><col class="col-10">
        </colgroup>

        <thead>
            <tr style="height: 15px;">
                <th style="font-weight: bold; font-style: italic;text-align: left; border-bottom: 2px solid black;"> OFFICE COPY</th>
                <th> </th>
                <th> </th>
                <th> </th>
                <th> </th>
                <th> </th>
                <th> </th>
                <th> </th>
                <th> </th>
                <th> </th>
            </tr>
        </thead>

        <tbody>
            <!-- Row 2: merged 7-9 -->
            <tr style="height: 15.75px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>
            <!-- Row 3: merged 7-9 -->
            <tr style="height: 15px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>
            <!-- Row 4: merged 7-9 -->
            <tr style="height: 12.75px;">
                <td style="text-align: left;">Stock No</td>
                <td>2025 - NE10022</td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 8.5px; color: blue;">OTUS COPY SYSTEMS, INC.</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 5: merged 6-8 -->
            <tr style="height: 12px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;">North East</td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="4" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;">10F MG Tower #75 Brgy. Daang Bakal Shaw Blvd.</td>
                
                <td></td>
            </tr>
<!-- Row 6: merged 7-9 -->
            <tr style="height: 12px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;"> </td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;">Mandaluyong City</td>
                <td> </td>
                <td> </td>
                <td> </td>
            </tr>
            <!-- Row 7: merged 7-9 -->
            <tr style="height: 12px;">
                <td style="font-weight: bold; text-align: left;">Date:</td>
                <td colspan="2" class="merged-block" style="text-align: left;">October 21, 2025</td>
                <td></td>
                <td></td>
                <td colspan="4" class="merged-block" style="font-weight: bold;font-size: 9px; text-align: left;">Philippines Tel. 8631 - 9454 (Telefax: 535 - 8731)</td>
                <td></td>
            </tr>
            <!-- Row 80: merged 7-9 -->
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

            <!-- Row 9: merged 3-9 -->
            <tr style="height: 27px;">
                <td></td>
                <td></td>
                <td colspan="6" style="font-family: 'Bodoni Moda', serif; font-size: 24px; font-weight: 900; text-align: center;">STOCK TRANSFER</td>
                <td></td>
                <td></td>
            </tr>
            <!-- Row 10: merged 1-9 -->
            <tr style="height: 15px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>
            <!-- Row 11: merged 1-2 -->
            <tr style="height: 15.75px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;">Account Name:</td>
                <td></td>
                <td style="font-weight: bold;text-align: left;">LTO-HR</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 12: merged 4-9 -->
            <tr style="height: 15.75px;">
                <td style="font-weight: bold; text-align: left;">Address:</td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 12px">LTO Comp. East Ave, Diliman, Quezon City</td>
                <td></td>
            </tr>

            <!-- Row 13: merged 1-9 -->
            <tr style="height: 15.75px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>

            <!-- Row 14: merged 4-6 -->
            <tr>
                <td style="font-weight: bold; font-size: 10px">QUANTITY</td>
                <td style="font-weight: bold;font-size: 10px">UNITS</td>
                <td></td>
                <td colspan="3" class="merged-block" style="font-weight: bold;font-size: 10px">ITEMS DESCRIPTION</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 15–29 merged as before -->
            <tr style="height: 9.75px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
           <!-- Row 16: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 17: merged 7-9 -->
            <tr style="height: 15px; ">
                <td style="text-align: center;">1</td>
                <td style="text-align: center;">pc</td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">Toner Cartridge</td>
                <td></td>
            </tr>
            <!-- Row 18: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 19: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 20: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 21: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 22: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">MR: 222,429</td>
                <td></td>
            </tr>
           <!-- Row 23: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">Model: DCIV- 3065</td>
                <td></td>
            </tr>
            <!-- Row 24: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">Serial No.: 306596</td>
                <td></td>
            </tr>
            <!-- Row 25: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">Tech: Walter</td>
                <td></td>
            </tr>
            <!-- Row 26: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
           <!-- Row 27: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 28: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 29: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>

            <!-- Row 30: merged 7-9 -->
            <tr style="height: 15px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;border-top: 2px solid black;">Acknowledged by- End-user</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="3" class="merged-block" style="font-weight: bold; text-align: center;border-top: 2px solid black;">OTUS Authorized Representative</td>
                <td></td>
            </tr>

            <!-- Row 31: merged 7-9 -->
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

<!-- Second Page (Duplicate of First Page) -->
<div class="a4-container">
    <!-- First table logo -->
    <img src="otus logo.png" alt="OTUS Logo" class="table-logo">
    
    <!-- First table -->
    <table>
        <colgroup>
            <col class="col-1"><col class="col-2"><col class="col-3"><col class="col-4"><col class="col-5">
            <col class="col-6"><col class="col-7"><col class="col-8"><col class="col-9"><col class="col-10">
        </colgroup>

        <thead>
            <tr style="height: 15px;">
                <th colspan="9"> </th>
                <th> </th>
            </tr>
        </thead>

        <tbody>
            <!-- Row 2: merged 7-9 -->
            <tr style="height: 15.75px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>
            <!-- Row 3: merged 7-9 -->
            <tr style="height: 15px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>
            <!-- Row 4: merged 7-9 -->
            <tr style="height: 12.75px;">
                <td style="text-align: left;">Stock No</td>
                <td>2025 - NE10022</td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 8.5px; color: blue;">OTUS COPY SYSTEMS, INC.</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 5: merged 6-8 -->
            <tr style="height: 12px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;">North East</td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="4" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;">10F MG Tower #75 Brgy. Daang Bakal Shaw Blvd.</td>
                
                <td></td>
            </tr>
<!-- Row 6: merged 7-9 -->
            <tr style="height: 12px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;"> </td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2" class="merged-block" style="font-weight: bold; font-size: 9px; text-align: left;">Mandaluyong City</td>
                <td> </td>
                <td> </td>
                <td> </td>
            </tr>
            <!-- Row 7: merged 7-9 -->
            <tr style="height: 12px;">
                <td style="font-weight: bold; text-align: left;">Date:</td>
                <td colspan="2" class="merged-block" style="text-align: left;">October 21, 2025</td>
                <td></td>
                <td></td>
                <td colspan="4" class="merged-block" style="font-weight: bold;font-size: 9px; text-align: left;">Philippines Tel. 8631 - 9454 (Telefax: 535 - 8731)</td>
                <td></td>
            </tr>
            <!-- Row 80: merged 7-9 -->
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

            <!-- Row 9: merged 3-9 -->
            <tr style="height: 27px;">
                <td></td>
                <td></td>
                <td colspan="6" style="font-family: 'Bodoni Moda', serif; font-size: 24px; font-weight: 900; text-align: center;">
    STOCK TRANSFER
</td>
                <td></td>
                <td></td>
            </tr>
            <!-- Row 10: merged 1-9 -->
            <tr style="height: 15px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>
            <!-- Row 11: merged 1-2 -->
            <tr style="height: 15.75px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;">Account Name:</td>
                <td></td>
                <td style="font-weight: bold;text-align: left;">LTO-HR</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 12: merged 4-9 -->
            <tr style="height: 15.75px;">
                <td style="font-weight: bold; text-align: left;">Address:</td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 12px">LTO Comp. East Ave, Diliman, Quezon City</td>
                <td></td>
            </tr>

            <!-- Row 13: merged 1-9 -->
            <tr style="height: 15.75px;">
                <td colspan="9" class="merged-block"> </td>
                <td></td>
            </tr>

            <!-- Row 14: merged 4-6 -->
            <tr>
                <td style="font-weight: bold; font-size: 10px">QUANTITY</td>
                <td style="font-weight: bold;font-size: 10px">UNITS</td>
                <td></td>
                <td colspan="3" class="merged-block" style="font-weight: bold;font-size: 10px">ITEMS DESCRIPTION</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- Row 15–29 merged as before -->
            <tr style="height: 9.75px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
           <!-- Row 16: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 17: merged 7-9 -->
            <tr style="height: 15px; ">
                <td style="text-align: center;">1</td>
                <td style="text-align: center;">pc</td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">Toner Cartridge</td>
                <td></td>
            </tr>
            <!-- Row 18: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 19: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 20: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 21: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 22: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">MR: 222,429</td>
                <td></td>
            </tr>
           <!-- Row 23: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">Model: DCIV- 3065</td>
                <td></td>
            </tr>
            <!-- Row 24: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">Serial No.: 306596</td>
                <td></td>
            </tr>
            <!-- Row 25: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block" style="text-align: left;">Tech: Walter</td>
                <td></td>
            </tr>
            <!-- Row 26: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
           <!-- Row 27: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 28: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>
            <!-- Row 29: merged 7-9 -->
            <tr style="height: 15px;">
                <td></td>
                <td></td>
                <td></td>
                <td colspan="6" class="merged-block"></td>
                <td></td>
            </tr>

            <!-- Row 30: merged 7-9 -->
            <tr style="height: 15px;">
                <td colspan="2" class="merged-block" style="font-weight: bold; text-align: left;border-top: 2px solid black;">Acknowledged by- End-user</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="3" class="merged-block" style="font-weight: bold; text-align: center;border-top: 2px solid black;">OTUS Authorized Representative</td>
                <td></td>
            </tr>

            <!-- Row 31: merged 7-9 -->
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