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
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            gap: 10px;
        }
        .pagination button {
            padding: 6px 12px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.2s;
        }
        .pagination button:hover:not(:disabled) {
            background: #f0f4fa;
            border-color: #007bff;
        }
        .pagination button.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        .pagination button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .pagination-info {
            font-size: 13px;
            color: #666;
            margin-right: 10px;
        }
        @media (max-width: 700px) {
            .container { padding: 10px; }
            table, th, td { font-size: 11px; }
            .filter-bar { flex-direction: column; gap: 8px; }
            .pagination { flex-wrap: wrap; }
        }

        .custom-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 5px;
            font-size: 16px;
            margin: 8px;
            cursor: pointer;
            transition: background 0.2s;
            }
            .custom-btn:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
<div class="container">
    <h2>Stock Transfer List</h2>
    <button class="custom-btn" onclick="window.open('stmultipleserialmr.php', '_blank')">
        Go to Multiple Serial MR
    </button>

    <button class="custom-btn" onclick="window.open('stocktransfer_form.php', '_blank')">
        Go to Stock Transfer Form
    </button>

    <div class="filter-bar">
        <label>Filter Invoice No: <input type="text" id="filterInvoice"></label>
        <label>Filter Date: <input type="text" id="filterDate" placeholder="YYYY-MM-DD"></label>
        <label>Filter Account Name: <input type="text" id="filterAccount"></label>
        <label>Show 
            <select id="showRows">
                <option value="10">10</option>
                <option value="25" selected>25</option>
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
        <tbody id="tableBody">
            <!-- Rows will be populated by JavaScript -->
        </tbody>
    </table>
    
    <div class="pagination" id="pagination">
        <!-- Pagination will be generated by JavaScript -->
    </div>
</div>

<script>
    let allData = <?php echo json_encode($all); ?>;
    let currentPage = 1;
    let rowsPerPage = 25;
    let sortDirections = [true, true, true, true];
    
    const tableBody = document.getElementById('tableBody');
    const paginationDiv = document.getElementById('pagination');
    const showRowsSelect = document.getElementById('showRows');
    const filterInputs = [
        document.getElementById('filterInvoice'),
        document.getElementById('filterDate'),
        document.getElementById('filterAccount')
    ];
    
    // Initialize
    showRowsSelect.value = rowsPerPage;
    renderTable();
    
    function getFilteredData() {
        const invoiceVal = filterInputs[0].value.toLowerCase();
        const dateVal = filterInputs[1].value.toLowerCase();
        const accountVal = filterInputs[2].value.toLowerCase();
        
        return allData.filter(row => {
            const invoice = row.invoice_no.toString().toLowerCase();
            const date = row.date.toString().toLowerCase();
            const account = row.account_name.toString().toLowerCase();
            return invoice.includes(invoiceVal) && 
                   date.includes(dateVal) && 
                   account.includes(accountVal);
        });
    }
    
    function renderTable() {
        const filteredData = getFilteredData();
        const totalRows = filteredData.length;
        const totalPages = rowsPerPage === 'all' ? 1 : Math.ceil(totalRows / rowsPerPage);
        
        if (currentPage > totalPages && totalPages > 0) {
            currentPage = totalPages;
        }
        
        // Calculate start and end index
        let startIndex, endIndex;
        if (rowsPerPage === 'all') {
            startIndex = 0;
            endIndex = totalRows;
        } else {
            startIndex = (currentPage - 1) * rowsPerPage;
            endIndex = Math.min(startIndex + rowsPerPage, totalRows);
        }
        
        // Get data for current page
        const pageData = filteredData.slice(startIndex, endIndex);
        
        // Clear table body
        tableBody.innerHTML = '';
        
        // Populate table rows
        pageData.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${escapeHtml(row.invoice_no)}</td>
                <td>${escapeHtml(row.date)}</td>
                <td>${escapeHtml(row.account_name)}</td>
                <td>${row.type === 'single' ? 'Single Serial' : 'Multiple Serial'}</td>
                <td>
                    <button class="print-btn" onclick="printInvoice('${row.type}','${escapeHtml(row.invoice_no)}')">Print</button>
                </td>
            `;
            tableBody.appendChild(tr);
        });
        
        // Render pagination
        renderPagination(totalPages, totalRows, startIndex, endIndex);
    }
    
    function renderPagination(totalPages, totalRows, startIndex, endIndex) {
        paginationDiv.innerHTML = '';
        
        if (rowsPerPage === 'all' || totalPages <= 1) {
            // Show only info when no pagination needed
            const infoSpan = document.createElement('span');
            infoSpan.className = 'pagination-info';
            infoSpan.textContent = `Showing ${totalRows} of ${totalRows} entries`;
            paginationDiv.appendChild(infoSpan);
            return;
        }
        
        // Previous button
        const prevButton = document.createElement('button');
        prevButton.innerHTML = '&laquo; Previous';
        prevButton.disabled = currentPage === 1;
        prevButton.onclick = () => {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        };
        paginationDiv.appendChild(prevButton);
        
        // Page numbers
        const maxVisiblePages = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
        let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
        
        if (endPage - startPage + 1 < maxVisiblePages) {
            startPage = Math.max(1, endPage - maxVisiblePages + 1);
        }
        
        for (let i = startPage; i <= endPage; i++) {
            const pageButton = document.createElement('button');
            pageButton.textContent = i;
            if (i === currentPage) {
                pageButton.classList.add('active');
            }
            pageButton.onclick = () => {
                currentPage = i;
                renderTable();
            };
            paginationDiv.appendChild(pageButton);
        }
        
        // Next button
        const nextButton = document.createElement('button');
        nextButton.innerHTML = 'Next &raquo;';
        nextButton.disabled = currentPage === totalPages;
        nextButton.onclick = () => {
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        };
        paginationDiv.appendChild(nextButton);
        
        // Info text
        const infoSpan = document.createElement('span');
        infoSpan.className = 'pagination-info';
        infoSpan.textContent = `Showing ${startIndex + 1} to ${endIndex} of ${totalRows} entries`;
        paginationDiv.appendChild(infoSpan);
    }
    
    function sortTable(colIndex) {
        sortDirections[colIndex] = !sortDirections[colIndex];
        const asc = sortDirections[colIndex];
        
        allData.sort((a, b) => {
            let valA, valB;
            
            if (colIndex === 0) {
                valA = a.invoice_no.toString().toLowerCase();
                valB = b.invoice_no.toString().toLowerCase();
            } else if (colIndex === 1) {
                valA = new Date(a.date);
                valB = new Date(b.date);
            } else if (colIndex === 2) {
                valA = a.account_name.toString().toLowerCase();
                valB = b.account_name.toString().toLowerCase();
            } else if (colIndex === 3) {
                valA = a.type;
                valB = b.type;
            }
            
            if (valA < valB) return asc ? -1 : 1;
            if (valA > valB) return asc ? 1 : -1;
            return 0;
        });
        
        currentPage = 1; // Reset to first page after sorting
        renderTable();
    }
    
    function printInvoice(type, invoiceNo) {
        if (type === 'single') {
            window.open('stocktransfer.php?stock_no=' + encodeURIComponent(invoiceNo), '_blank');
        } else {
            window.open('multipleserial.php?stock_no=' + encodeURIComponent(invoiceNo), '_blank');
        }
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Event listeners
    showRowsSelect.addEventListener('change', function() {
        rowsPerPage = this.value === 'all' ? 'all' : parseInt(this.value);
        currentPage = 1;
        renderTable();
    });
    
    filterInputs.forEach(input => {
        input.addEventListener('input', () => {
            currentPage = 1;
            renderTable();
        });
    });
</script>
</body>
</html>