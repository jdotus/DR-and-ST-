<?php
$conn = new mysqli('localhost', 'root', '', 'stock_transfer_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all invoices from both tables
$all = [];
$query1 = "SELECT stock_no AS invoice_no, date, account_name, 'single' AS type FROM stock_transfers";
$query2 = "SELECT stock_no AS invoice_no, date, account_name, 'multiple' AS type FROM multipleserial_transfers";

$result1 = $conn->query($query1);
while ($row = $result1->fetch_assoc()) $all[] = $row;
$result2 = $conn->query($query2);
while ($row = $result2->fetch_assoc()) $all[] = $row;

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stock Transfer List</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f5f5f5; 
            padding: 20px; 
        }
        .container { 
            background: white; 
            padding: 30px; 
            border-radius: 8px; 
            box-shadow: 0 0 8px rgba(0,0,0,0.1); 
            max-width: 900px; 
            margin: 0 auto; 
        }
        h2 { 
            text-align: center; 
            color: #007bff;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }
        .filter-bar {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            align-items: center;
            flex-wrap: wrap;
        }
        .filter-bar label {
            font-size: 14px;
            color: #333;
        }
        .filter-bar input[type="text"], .filter-bar select {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 13px;
            margin-left: 5px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
            background: #fff;
        }
        th, td { 
            border: 1px solid #e0e0e0; 
            padding: 8px; 
            text-align: center; 
            font-size: 13px;
        }
        th { 
            background: #f0f4fa; 
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        th:hover {
            background: #e2e8f0;
        }
        tr:nth-child(even) { 
            background: #f9f9f9; 
        }
        .print-btn { 
            background: #007bff; 
            color: white; 
            border: none; 
            padding: 6px 12px; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 13px;
            transition: background 0.2s;
        }
        .print-btn:hover { 
            background: #0056b3; 
        }
        @media (max-width: 700px) {
            .container { padding: 10px; }
            table, th, td { font-size: 11px; }
            .filter-bar { flex-direction: column; gap: 8px; }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Stock Transfer List</h2>
    <div class="filter-bar">
        <label>Filter Invoice No: <input type="text" id="filterInvoice"></label>
        <label>Filter Date: <input type="text" id="filterDate" placeholder="YYYY-MM-DD"></label>
        <label>Filter Account Name: <input type="text" id="filterAccount"></label>
        <label>Show 
            <select id="showRows">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="all">All</option>
            </select>
            entries
        </label>
    </div>
    <table id="transferTable">
        <thead>
            <tr>
                <th onclick="sortTable(0)" style="cursor:pointer;">Invoice No &#8597;</th>
                <th onclick="sortTable(1)" style="cursor:pointer;">Date &#8597;</th>
                <th onclick="sortTable(2)" style="cursor:pointer;">Account Name &#8597;</th>
                <th onclick="sortTable(3)" style="cursor:pointer;">Type &#8597;</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($all as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['invoice_no']) ?></td>
                <td><?= htmlspecialchars($row['date']) ?></td>
                <td><?= htmlspecialchars($row['account_name']) ?></td>
                <td><?= $row['type'] === 'single' ? 'Single Serial' : 'Multiple Serial' ?></td>
                <td>
                    <button class="print-btn" onclick="printInvoice('<?= $row['type'] ?>','<?= htmlspecialchars($row['invoice_no']) ?>')">Print</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
        function printInvoice(type, invoiceNo) {
            if (type === 'single') {
                window.open('stocktransfer.php?stock_no=' + encodeURIComponent(invoiceNo), '_blank');
            } else {
                window.open('multipleserial.php?stock_no=' + encodeURIComponent(invoiceNo), '_blank');
            }
        }

        let sortDirections = [true, true, true, true];// true = ascending, false = descending

        const showRowsSelect = document.getElementById('showRows');
        const filterInputs = [
            document.getElementById('filterInvoice'),
            document.getElementById('filterDate'),
            document.getElementById('filterAccount')
        ];
        const table = document.getElementById('transferTable');
        const tbody = table.tBodies[0];

        function getFilteredRows() {
            const invoiceVal = filterInputs[0].value.toLowerCase();
            const dateVal = filterInputs[1].value.toLowerCase();
            const accountVal = filterInputs[2].value.toLowerCase();
            return Array.from(tbody.rows).filter(row => {
                const invoice = row.cells[0].textContent.toLowerCase();
                const date = row.cells[1].textContent.toLowerCase();
                const account = row.cells[2].textContent.toLowerCase();
                return invoice.includes(invoiceVal) && date.includes(dateVal) && account.includes(accountVal);
            });
        }

        function updateVisibleRows() {
            let showCount = showRowsSelect.value;
            let filteredRows = getFilteredRows();
            Array.from(tbody.rows).forEach(row => row.style.display = 'none');
            filteredRows.forEach((row, idx) => {
                if (showCount === 'all' || idx < showCount) {
                    row.style.display = '';
                }
            });
        }

        // Initial display
        updateVisibleRows();

        // Update on dropdown change
        showRowsSelect.addEventListener('change', updateVisibleRows);

        // Update after filtering
        filterInputs.forEach(function(input) {
            input.addEventListener('input', updateVisibleRows);
        });

        function sortTable(colIndex) {
            const rows = Array.from(tbody.rows);
            const filteredRows = getFilteredRows();

            sortDirections[colIndex] = !sortDirections[colIndex];
            const asc = sortDirections[colIndex];

            filteredRows.sort((a, b) => {
                let valA = a.cells[colIndex].textContent.trim().toLowerCase();
                let valB = b.cells[colIndex].textContent.trim().toLowerCase();

                // For date column, compare as date
                if (colIndex === 1) {
                    valA = Date.parse(valA) || 0;
                    valB = Date.parse(valB) || 0;
                }

                if (valA < valB) return asc ? -1 : 1;
                if (valA > valB) return asc ? 1 : -1;
                return 0;
            });

            filteredRows.forEach(row => tbody.appendChild(row));
            rows.filter(row => !filteredRows.includes(row)).forEach(row => tbody.appendChild(row));

            updateVisibleRows();
        }

</script>
</body>
</html>