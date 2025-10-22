<!DOCTYPE html>
<html>
<head>
<title>A4 Table with Detailed Row Heights</title>
<style>
    /* A4 Page Simulation for Display */
    body {
        background-color: #f0f0f0; 
        margin: 0;
        padding: 20px;
    }

    .a4-container {
        width: 210mm;
        height: auto; 
        min-height: 297mm;
        margin: 0 auto; 
        background-color: white; 
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.5); 
        padding: 10mm; 
        box-sizing: border-box; 
    }

    /* Table Styles */
    table {
        border-collapse: collapse; 
        width: 100%;
        table-layout: fixed;
        font-family: Arial, sans-serif;
        font-size: 9pt; 
    }
    
    th, td {
        border: 1px solid #aaa;
        padding: 1px; /* Reduced padding to maximize vertical space for fixed heights */
        text-align: center;
        overflow: hidden;
        white-space: nowrap; 
        vertical-align: middle; /* Center text vertically */
    }
    th {
        background-color: #e0e0e0;
        font-size: 8pt;
    }
    
    /* Column Width Calculation (unchanged) */
    .col-1 { width: calc(9.43 / 101.58 * 100%); }.col-2 { width: calc(18.14 / 101.58 * 100%); }
    .col-3 { width: calc(1.86 / 101.58 * 100%); }.col-4 { width: calc(10 / 101.58 * 100%); }
    .col-5 { width: calc(10.29 / 101.58 * 100%); }.col-6 { width: calc(8.43 / 101.58 * 100%); }
    .col-7 { width: calc(8.43 / 101.58 * 100%); }.col-8 { width: calc(11.57 / 101.58 * 100%); }
    .col-9 { width: calc(15 / 101.58 * 100%); }.col-10 { width: calc(8.43 / 101.58 * 100%); }

</style>
</head>
<body>

<div class="a4-container">
    
    <table>
        <colgroup>
            <col class="col-1"><col class="col-2"><col class="col-3"><col class="col-4"><col class="col-5">
            <col class="col-6"><col class="col-7"><col class="col-8"><col class="col-9"><col class="col-10">
        </colgroup>
        
        <thead>
            <tr style="height: 15px;">
                <th>C1 (9.43)</th><th>C2 (18.14)</th><th>C3 (1.86)</th><th>C4 (10.00)</th><th>C5 (10.29)</th>
                <th>C6 (8.43)</th><th>C7 (8.43)</th><th>C8 (11.57)</th><th>C9 (15.00)</th><th>C10 (8.43)</th>
            </tr>
        </thead>
        
        <tbody>
            <tr style="height: 15.75px;"><td>Row 2-1</td><td>Row 2-2</td><td>R 2-3</td><td>Row 2-4</td><td>Row 2-5</td><td>Row 2-6</td><td>Row 2-7</td><td>Row 2-8</td><td>Row 2-9</td><td>Row 2-10</td></tr>
            <tr style="height: 15px;"><td>Row 3-1</td><td>Row 3-2</td><td>R 3-3</td><td>Row 3-4</td><td>Row 3-5</td><td>Row 3-6</td><td>Row 3-7</td><td>Row 3-8</td><td>Row 3-9</td><td>Row 3-10</td></tr>
            <tr style="height: 12.75px;"><td>Row 4-1</td><td>Row 4-2</td><td>R 4-3</td><td>Row 4-4</td><td>Row 4-5</td><td>Row 4-6</td><td>Row 4-7</td><td>Row 4-8</td><td>Row 4-9</td><td>Row 4-10</td></tr>
            
            <tr style="height: 12px;"><td>Row 5-1</td><td>Row 5-2</td><td>R 5-3</td><td>Row 5-4</td><td>Row 5-5</td><td>Row 5-6</td><td>Row 5-7</td><td>Row 5-8</td><td>Row 5-9</td><td>Row 5-10</td></tr>
            <tr style="height: 12px;"><td>Row 6-1</td><td>Row 6-2</td><td>R 6-3</td><td>Row 6-4</td><td>Row 6-5</td><td>Row 6-6</td><td>Row 6-7</td><td>Row 6-8</td><td>Row 6-9</td><td>Row 6-10</td></tr>
            <tr style="height: 12px;"><td>Row 7-1</td><td>Row 7-2</td><td>R 7-3</td><td>Row 7-4</td><td>Row 7-5</td><td>Row 7-6</td><td>Row 7-7</td><td>Row 7-8</td><td>Row 7-9</td><td>Row 7-10</td></tr>
            
            <tr style="height: 15px;"><td>Row 8-1</td><td>Row 8-2</td><td>R 8-3</td><td>Row 8-4</td><td>Row 8-5</td><td>Row 8-6</td><td>Row 8-7</td><td>Row 8-8</td><td>Row 8-9</td><td>Row 8-10</td></tr>
            
            <tr style="height: 27px;"><td>Row 9-1</td><td>Row 9-2</td><td>R 9-3</td><td>Row 9-4</td><td>Row 9-5</td><td>Row 9-6</td><td>Row 9-7</td><td>Row 9-8</td><td>Row 9-9</td><td>Row 9-10</td></tr>
            
            <tr style="height: 15px;"><td>Row 10-1</td><td>Row 10-2</td><td>R 10-3</td><td>Row 10-4</td><td>Row 10-5</td><td>Row 10-6</td><td>Row 10-7</td><td>Row 10-8</td><td>Row 10-9</td><td>Row 10-10</td></tr>
            
            <tr style="height: 15.75px;"><td>Row 11-1</td><td>Row 11-2</td><td>R 11-3</td><td>Row 11-4</td><td>Row 11-5</td><td>Row 11-6</td><td>Row 11-7</td><td>Row 11-8</td><td>Row 11-9</td><td>Row 11-10</td></tr>
            <tr style="height: 15.75px;"><td>Row 12-1</td><td>Row 12-2</td><td>R 12-3</td><td>Row 12-4</td><td>Row 12-5</td><td>Row 12-6</td><td>Row 12-7</td><td>Row 12-8</td><td>Row 12-9</td><td>Row 12-10</td></tr>
            <tr style="height: 15.75px;"><td>Row 13-1</td><td>Row 13-2</td><td>R 13-3</td><td>Row 13-4</td><td>Row 13-5</td><td>Row 13-6</td><td>Row 13-7</td><td>Row 13-8</td><td>Row 13-9</td><td>Row 13-10</td></tr>
            
            <tr><td>Row 14-1</td><td>Row 14-2</td><td>R 14-3</td><td>Row 14-4</td><td>Row 14-5</td><td>Row 14-6</td><td>Row 14-7</td><td>Row 14-8</td><td>Row 14-9</td><td>Row 14-10</td></tr>
            
            <tr style="height: 9.75px;"><td>Row 15-1</td><td>Row 15-2</td><td>R 15-3</td><td>Row 15-4</td><td>Row 15-5</td><td>Row 15-6</td><td>Row 15-7</td><td>Row 15-8</td><td>Row 15-9</td><td>Row 15-10</td></tr>
            
            <tr style="height: 15px;"><td>Row 16-1</td><td>Row 16-2</td><td>R 16-3</td><td>Row 16-4</td><td>Row 16-5</td><td>Row 16-6</td><td>Row 16-7</td><td>Row 16-8</td><td>Row 16-9</td><td>Row 16-10</td></tr>
            <tr style="height: 15px;"><td>Row 17-1</td><td>Row 17-2</td><td>R 17-3</td><td>Row 17-4</td><td>Row 17-5</td><td>Row 17-6</td><td>Row 17-7</td><td>Row 17-8</td><td>Row 17-9</td><td>Row 17-10</td></tr>
            <tr style="height: 15px;"><td>Row 18-1</td><td>Row 18-2</td><td>R 18-3</td><td>Row 18-4</td><td>Row 18-5</td><td>Row 18-6</td><td>Row 18-7</td><td>Row 18-8</td><td>Row 18-9</td><td>Row 18-10</td></tr>
            <tr style="height: 15px;"><td>Row 19-1</td><td>Row 19-2</td><td>R 19-3</td><td>Row 19-4</td><td>Row 19-5</td><td>Row 19-6</td><td>Row 19-7</td><td>Row 19-8</td><td>Row 19-9</td><td>Row 19-10</td></tr>
            <tr style="height: 15px;"><td>Row 20-1</td><td>Row 20-2</td><td>R 20-3</td><td>Row 20-4</td><td>Row 20-5</td><td>Row 20-6</td><td>Row 20-7</td><td>Row 20-8</td><td>Row 20-9</td><td>Row 20-10</td></tr>
            <tr style="height: 15px;"><td>Row 21-1</td><td>Row 21-2</td><td>R 21-3</td><td>Row 21-4</td><td>Row 21-5</td><td>Row 21-6</td><td>Row 21-7</td><td>Row 21-8</td><td>Row 21-9</td><td>Row 21-10</td></tr>
            <tr style="height: 15px;"><td>Row 22-1</td><td>Row 22-2</td><td>R 22-3</td><td>Row 22-4</td><td>Row 22-5</td><td>Row 22-6</td><td>Row 22-7</td><td>Row 22-8</td><td>Row 22-9</td><td>Row 22-10</td></tr>
            <tr style="height: 15px;"><td>Row 23-1</td><td>Row 23-2</td><td>R 23-3</td><td>Row 23-4</td><td>Row 23-5</td><td>Row 23-6</td><td>Row 23-7</td><td>Row 23-8</td><td>Row 23-9</td><td>Row 23-10</td></tr>
            <tr style="height: 15px;"><td>Row 24-1</td><td>Row 24-2</td><td>R 24-3</td><td>Row 24-4</td><td>Row 24-5</td><td>Row 24-6</td><td>Row 24-7</td><td>Row 24-8</td><td>Row 24-9</td><td>Row 24-10</td></tr>
            <tr style="height: 15px;"><td>Row 25-1</td><td>Row 25-2</td><td>R 25-3</td><td>Row 25-4</td><td>Row 25-5</td><td>Row 25-6</td><td>Row 25-7</td><td>Row 25-8</td><td>Row 25-9</td><td>Row 25-10</td></tr>
            <tr style="height: 15px;"><td>Row 26-1</td><td>Row 26-2</td><td>R 26-3</td><td>Row 26-4</td><td>Row 26-5</td><td>Row 26-6</td><td>Row 26-7</td><td>Row 26-8</td><td>Row 26-9</td><td>Row 26-10</td></tr>
            <tr style="height: 15px;"><td>Row 27-1</td><td>Row 27-2</td><td>R 27-3</td><td>Row 27-4</td><td>Row 27-5</td><td>Row 27-6</td><td>Row 27-7</td><td>Row 27-8</td><td>Row 27-9</td><td>Row 27-10</td></tr>
            <tr style="height: 15px;"><td>Row 28-1</td><td>Row 28-2</td><td>R 28-3</td><td>Row 28-4</td><td>Row 28-5</td><td>Row 28-6</td><td>Row 28-7</td><td>Row 28-8</td><td>Row 28-9</td><td>Row 28-10</td></tr>
            <tr style="height: 15px;"><td>Row 29-1</td><td>Row 29-2</td><td>R 29-3</td><td>Row 29-4</td><td>Row 29-5</td><td>Row 29-6</td><td>Row 29-7</td><td>Row 29-8</td><td>Row 29-9</td><td>Row 29-10</td></tr>
            <tr style="height: 15px;"><td>Row 30-1</td><td>Row 30-2</td><td>R 30-3</td><td>Row 30-4</td><td>Row 30-5</td><td>Row 30-6</td><td>Row 30-7</td><td>Row 30-8</td><td>Row 30-9</td><td>Row 30-10</td></tr>
            <tr style="height: 15px;"><td>Row 31-1</td><td>Row 31-2</td><td>R 31-3</td><td>Row 31-4</td><td>Row 31-5</td><td>Row 31-6</td><td>Row 31-7</td><td>Row 31-8</td><td>Row 31-9</td><td>Row 31-10</td></tr>
        </tbody>
    </table>
    
</div>

</body>
</html>