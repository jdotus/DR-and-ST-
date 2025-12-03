<?php
$stock_no = $_POST['stock_no'] ?? '';
$conn = new mysqli('localhost', 'root', '', 'stock_transfer_db');
if ($conn->connect_error) {
    echo 'error';
    exit;
}
$stmt = $conn->prepare("SELECT id FROM multipleserial_transfers WHERE stock_no = ?");
$stmt->bind_param("s", $stock_no);
$stmt->execute();
$stmt->store_result();
echo ($stmt->num_rows > 0) ? 'exists' : 'ok';
$stmt->close();
$conn->close();
?>