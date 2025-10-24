<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delivery for Mono And Colored Machine</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
    }

    h2 {
      margin-bottom: 10px;
    }

    .input-group {
      margin-bottom: 10px;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 6px;
    }

    label {
      display: inline-block;
      width: 120px;
      font-weight: bold;
    }

    input {
      padding: 6px;
      width: 200px;
      margin-bottom: 5px;
    }

    button {
      margin-top: 10px;
      padding: 8px 16px;
      border: none;
      background: #0078d7;
      color: #fff;
      cursor: pointer;
      border-radius: 5px;
    }

    button:hover {
      background: #005fa3;
    }
  </style>
</head>
<body>

  <h2>Delivery for Mono And Colored Machine</h2>

  <form id="myForm" action="DR_Both_delivery.php" method="post">
    <div id="inputContainer">
        <div class="input-group">
            <label>SI Number</label>
            <input type="text" name="siNumber[]" placeholder="Enter SI Number" required><br>
            <label>Delivered to</label>
            <input type="text" name="deliveredTo[]" placeholder="Enter NAME" required><br>
            <label>SI Date:</label>
            <input type="date" name="date[]"  placeholder="Enter Date" required><br>
            <label>Address:</label>
            <input type="text" name="address[]" placeholder="Enter address" required><br>
            <label>Terms:</label>
            <input type="text" name="terms[]" placeholder="Enter Terms" required><br>
            <label>Particulars:</label>
            <input type="text" name="particulars[]" placeholder="Enter particulars" required><br>
            <label>Machine Model:</label>
            <input type="text" name="machineModel[]" placeholder="Enter Machine Model" required><br>
            <label>Tin:</label>
            <input type="text" name="tin[]" placeholder="Enter Tin" required><br>
            <label>Units:</label>
            <input type="text" name="units[]" placeholder="Enter Units" required><br>
        </div>
        
        <div class="input-group">
            <label>Serial No.: </label>
            <input type="text" name="serialNo[]" placeholder="Enter Item Description" >
            <label>MR Start: </label>
            <input type="text" name="mrStart[]" placeholder="Enter Item Description" >
            <label>Color Impression: </label>
            <input type="text" name="colorImpression[]" placeholder="Enter Item Description" >
            <label>Black Impression: </label>
            <input type="text" name="blackImpression[]" placeholder="Enter Item Description" >
            <label>Color Large Impression: </label>
            <input type="text" name="colorLargeImpression[]" placeholder="Enter Item Description" >
        </div>
      
    </div>

    <button type="button" onclick="addInput()">➕ Add Another</button>
    <button type="submit">Submit</button>
  </form>

  <script>
    function addInput() {
        const container = document.getElementById('inputContainer');
        const newGroup = document.createElement('div');
        newGroup.classList.add('input-group');
        newGroup.innerHTML = `
            <label>Serial No.: </label>
            <input type="text" name="serialNo[]" placeholder="Enter Item Description" >
            <label>MR Start: </label>
            <input type="text" name="mrStart[]" placeholder="Enter Item Description" >
            <label>Color Impression: </label>
            <input type="text" name="colorImpression[]" placeholder="Enter Item Description" >
            <label>Black Impression: </label>
            <input type="text" name="blackImpression[]" placeholder="Enter Item Description" >
            <label>Color Large Impression: </label>
            <input type="text" name="colorLargeImpression[]" placeholder="Enter Item Description" >
        `;
        container.appendChild(newGroup);
    }
  </script>

</body>
</html>
