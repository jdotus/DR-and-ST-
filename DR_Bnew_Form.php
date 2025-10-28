<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delivery Form - Mono or Colored Machine</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 40px;
      background: #f9f9f9;
    }

    h2 {
      margin-bottom: 10px;
    }

    .radio-group {
      margin-bottom: 20px;
    }

    .input-group {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      padding: 15px;
      border-radius: 6px;
      background: #fff;
    }

    label {
      flex: 1 1 120px;
      font-weight: bold;
      min-width: 120px;
    }

    input {
      flex: 1 1 200px;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      margin-top: 10px;
      padding: 10px 18px;
      border: none;
      background: #0078d7;
      color: #fff;
      cursor: pointer;
      border-radius: 6px;
      transition: background 0.2s ease;
    }

    button:hover {
      background: #005fa3;
    }

    .input-section {
      display: none;
      margin-top: 10px;
    }

    .visible {
      display: block;
    }

    @media (max-width: 600px) {
      body {
        margin: 20px;
      }

      label, input {
        flex: 1 1 100%;
      }

      button {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <h2>Delivery Form for Mono and Colored Machine</h2>

  <div class="radio-group">
    <label><input type="radio" name="machineType" value="mono" onclick="toggleInputs('mono')" checked> Mono Machine</label>
    <label><input type="radio" name="machineType" value="color" onclick="toggleInputs('color')"> Colored Machine</label>
  </div>

  <form id="deliveryForm" action="DR_Both_delivery.php" method="post">
    <!-- Mono Machine Form -->
    <div id="monoFields" class="input-section visible">
      <div class="input-group">
        <label>SI Number</label>
        <input type="text" name="siNumber" placeholder="Enter SI Number" required>

        <label>Delivered To</label>
        <input type="text" name="deliveredTo" placeholder="Enter Name" required>

        <label>SI Date</label>
        <input type="date" name="siDate" required>

        <label>Address</label>
        <input type="text" name="address" placeholder="Enter Address" required>

        <label>Terms</label>
        <input type="text" name="terms" placeholder="Enter Terms" required>

        <label>Particulars</label>
        <input type="text" name="particulars" placeholder="Enter Particulars" required>

        <label>Machine Model</label>
        <input type="text" name="machineModel" placeholder="Enter Machine Model" required>

        <label>TIN</label>
        <input type="text" name="tin" placeholder="Enter TIN" required>

        <label>Units</label>
        <input type="text" name="units" placeholder="Enter Units" required>
      </div>

      <div id="monoContainer" class="input-group">
        <label>MR Start</label>
        <input type="text" name="mrStart[]" placeholder="Enter MR Start">

        <label>Black Impression</label>
        <input type="text" name="blackImpression[]" placeholder="Enter Black Impression">
      </div>

      <button type="button" onclick="addMonoInput()">➕ Add Another</button>
    </div>

    <!-- Colored Machine Form -->
    <div id="colorFields" class="input-section">
      <div class="input-group">
        <label>SI Number</label>
        <input type="text" name="siNumber" placeholder="Enter SI Number" required>

        <label>Delivered To</label>
        <input type="text" name="deliveredTo" placeholder="Enter Name" required>

        <label>SI Date</label>
        <input type="date" name="siDate" required>

        <label>Address</label>
        <input type="text" name="address" placeholder="Enter Address" required>

        <label>Terms</label>
        <input type="text" name="terms" placeholder="Enter Terms" required>

        <label>Particulars</label>
        <input type="text" name="particulars" placeholder="Enter Particulars" required>

        <label>Machine Model</label>
        <input type="text" name="machineModel" placeholder="Enter Machine Model" required>

        <label>TIN</label>
        <input type="text" name="tin" placeholder="Enter TIN" required>

        <label>Units</label>
        <input type="text" name="units" placeholder="Enter Units" required>
      </div>

      <div id="colorContainer" class="input-group">
        <label>MR Start</label>
        <input type="text" name="mrStart[]" placeholder="Enter MR Start">

        <label>Color Impression</label>
        <input type="text" name="colorImpression[]" placeholder="Enter Color Impression">

        <label>Black Impression</label>
        <input type="text" name="blackImpression[]" placeholder="Enter Black Impression">

        <label>Color Large Impression</label>
        <input type="text" name="colorLargeImpression[]" placeholder="Enter Color Large Impression">
      </div>

      <button type="button" onclick="addColorInput()">➕ Add Another</button>
    </div>

    <button type="submit">Submit</button>
  </form>

  <script>
    function toggleInputs(selected) {
      document.getElementById('monoFields').classList.remove('visible');
      document.getElementById('colorFields').classList.remove('visible');

      if (selected === 'mono') {
        document.getElementById('monoFields').classList.add('visible');
      } else {
        document.getElementById('colorFields').classList.add('visible');
      }
    }

    let monoCount = 1;
    let colorCount = 1;
    const maxFields = 7;

    function addMonoInput() {
      if (monoCount >= maxFields) {
        alert("Maximum of 7 entries reached.");
        return;
      }
      monoCount++;

      const container = document.getElementById('monoContainer');
      const newGroup = document.createElement('div');
      newGroup.classList.add('input-group');
      newGroup.innerHTML = `
        <label>MR Start</label>
        <input type="text" name="mrStart[]" placeholder="Enter MR Start">
        <label>Black Impression</label>
        <input type="text" name="blackImpression[]" placeholder="Enter Black Impression">
        <button type="button" onclick="this.parentElement.remove(); monoCount--;">🗑 Remove</button>
      `;
      container.after(newGroup);
    }

    function addColorInput() {
      if (colorCount >= maxFields) {
        alert("Maximum of 7 entries reached.");
        return;
      }
      colorCount++;

      const container = document.getElementById('colorContainer');
      const newGroup = document.createElement('div');
      newGroup.classList.add('input-group');
      newGroup.innerHTML = `
        <label>MR Start</label>
        <input type="text" name="mrStart[]" placeholder="Enter MR Start">
        <label>Color Impression</label>
        <input type="text" name="colorImpression[]" placeholder="Enter Color Impression">
        <label>Black Impression</label>
        <input type="text" name="blackImpression[]" placeholder="Enter Black Impression">
        <label>Color Large Impression</label>
        <input type="text" name="colorLargeImpression[]" placeholder="Enter Color Large Impression">
        <button type="button" onclick="this.parentElement.remove(); colorCount--;">🗑 Remove</button>
      `;
      container.after(newGroup);
    }
  </script>

</body>
</html>
