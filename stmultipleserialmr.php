<!DOCTYPE html>
<html>
<head>
    <title>Multiple Serial Stock Transfer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 700px;
            background: white;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="date"], textarea, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
        }
        button {
            margin-top: 15px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .add-btn {
            background: #28a745;
        }
        .add-btn:hover {
            background: #1e7e34;
        }
        .remove-btn {
            background: #dc3545;
        }
        .remove-btn:hover {
            background: #b02a37;
        }
        .additional-fields {
            margin-top: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .additional-fields h4 {
            margin-top: 0;
            color: #333;
        }
        .add-btn[disabled] {
            background: #888 !important;
            color: #fff !important;
            cursor: not-allowed;
        }

        .serial-mr-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }
        .serial-mr-row label {
            margin: 0;
            font-weight: normal;
        }
        .serial-mr-row input[type="text"] {
            width: 120px;
        }
        .serial-mr-row .remove-btn {
            margin-top: 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Stock Transfer Input Form</h2>
    <form action="multipleserial.php" method="POST">
        <label>From Location:</label> 
        <select name="from_location" required> 
            <option value="North-east">North-east</option> 
            <option value="South-West">South-West</option> 
        </select>

        <label>Stock No:</label>
        <input type="text" name="stock_no" required>

        <label>Date:</label>
        <input type="date" name="date" required>

        <label>Account Name:</label>
        <input type="text" name="account_name" required>

        <label>Address:</label>
        <input type="text" name="to_location" required>

        <h3>Item Details</h3>
        <table id="itemsTable">
            <thead>
                <tr>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Description</th>
                    <th>Model</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="number" name="quantity[]" required></td>
                    <td><input type="text" name="unit[]" required></td>
                    <td><input type="text" name="description[]" required></td>
                    <td><input type="text" name="model[]" required></td>
                    <td><button type="button" class="remove-btn" onclick="removeRow(this)">×</button></td>
                </tr>
            </tbody>
        </table>
        <div id="serialMrContainer">
    <div class="serial-mr-row">
        <label>Serial No.:</label>
        <input type="text" name="serial_no[]" required>
        <label>MR:</label>
        <input type="text" name="mr[]" required>
        <button type="button" class="remove-btn" onclick="removeSerialMrRow(this)">×</button>
    </div>
</div>
<button type="button" class="add-btn" id="addSerialMrBtn" onclick="addSerialMrRow()">+ Add Another Serial/MR</button>
        

        <!-- Additional Fields Section -->
        <div class="additional-fields">
            <h4>Additional Information</h4>
            <label>Tech:</label>
            <input type="text" name="delivered_by" placeholder="Enter tech name"required>
        </div>

        <!-- <label>Delivered By:</label>
        <input type="text" name="delivered_by" required> -->

        <button type="submit" id="submitBtn">Submit to Stock Transfer</button>
    </form>
</div>

<script>
const maxSerialMrRows = 8;

function updateAddSerialMrBtn() {
    const container = document.getElementById('serialMrContainer');
    const addBtn = document.getElementById('addSerialMrBtn');
    const currentRows = container.querySelectorAll('.serial-mr-row').length;
    const remaining = maxSerialMrRows - currentRows;
    addBtn.textContent = remaining > 0 ? `+ Add Another Serial/MR (${remaining} remaining)` : '+ Add Another Serial/MR (0 remaining)';
    addBtn.disabled = currentRows >= maxSerialMrRows;
}

function addSerialMrRow() {
    const container = document.getElementById('serialMrContainer');
    const currentRows = container.querySelectorAll('.serial-mr-row').length;
    if (currentRows >= maxSerialMrRows) return;
    const div = document.createElement('div');
    div.className = 'serial-mr-row';
    div.innerHTML = `
        <label>Serial No.:</label>
        <input type="text" name="serial_no[]" required>
        <label>MR:</label>
        <input type="text" name="mr[]" required>
        <button type="button" class="remove-btn" onclick="removeSerialMrRow(this)">×</button>
    `;
    container.appendChild(div);
    updateAddSerialMrBtn();
}

function removeSerialMrRow(btn) {
    btn.parentElement.remove();
    updateAddSerialMrBtn();
}

document.getElementById('submitBtn').addEventListener('click', function(e) {
    e.preventDefault();
    const form = document.querySelector('form');
    const formData = new FormData(form);

    fetch('multipleserial.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        if (result.trim() === 'exists') {
            alert('Stock No already exists. Please use a unique Stock No.');
        } else if (result.trim() === 'success') {
            alert('Stock Transfer saved successfully!');
            // Open print view
            const stockNo = form.querySelector('input[name="stock_no"]').value;
            window.open('multipleserial.php?stock_no=' + encodeURIComponent(stockNo), '_blank');
            form.reset();
            document.getElementById('serialMrContainer').innerHTML = `
                <div class="serial-mr-row">
                    <label>Serial No.:</label>
                    <input type="text" name="serial_no[]" required>
                    <label>MR:</label>
                    <input type="text" name="mr[]" required>
                    <button type="button" class="remove-btn" onclick="removeSerialMrRow(this)">×</button>
                </div>
            `;
            updateAddSerialMrBtn();
        } else {
            alert('Error saving Stock Transfer. Please try again.');
        }
    })
    .catch(() => {
        alert('Error connecting to server.');
    });
});


document.addEventListener('DOMContentLoaded', updateAddSerialMrBtn);

</script>

</body>
</html>