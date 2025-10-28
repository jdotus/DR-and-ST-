<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Delivery for Mono and Colored Machine</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background-color: #f9f9f9;
      text-transform: uppercase;
    }

    h2 {
      margin-bottom: 15px;
      text-align: center;
    }

    form {
      max-width: 900px;
      margin: auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .input-group-used,
    .input-group-bnew {
      border: 1px solid #ddd;
      padding: 28px 15px;
      border-radius: 8px;
      margin-bottom: 15px;
      background: #fdfdfd;
      position: relative;
    }

    .flex-row {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
    }

    .form-control {
      flex: 0.444 1 250px;
      display: flex;
      flex-direction: column;
    }

    .machine-section label,
    .input-group label {
      font-weight: bold;
      font-size: 14px;
    }

    input {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
    }

    button {
      padding: 10px 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 15px;
    }

    .btn-add {
      background: #0078d7;
      color: #fff;
      margin-top: 5px;
    }

    .btn-add:hover {
      background: #005fa3;
    }

    .btn-remove {
      position: absolute;
      top: 8px;
      right: 8px;
      background: #dc3545;
      color: #fff;
      border: none;
      border-radius: 4px;
      padding: 5px 10px;
      cursor: pointer;
    }

    .btn-remove:hover {
      background: #b02a37;
    }

    .btn-submit {
      background: #28a745;
      color: #fff;
      display: block;
      width: 100%;
      margin-top: 20px;
    }

    .btn-submit:hover {
      background: #218838;
    }

    .radio-group {
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      margin: 50px 0 25px 0;
    }

    .radio-group label {
      margin-right: 10px;
      font-weight: bold;
    }

    input[type="radio" i] {
      margin: 0 3px 3px 3px !important;
    }

    .machine-section {
      display: none;
    }

    .visible {
      display: block;
    }

    @media (max-width: 600px) {
      .form-control {
        flex: 1 1 100%;
      }
    }
  </style>
</head>

<body>
  <h2>Delivery Rental Machine</h2>

  <form id="myForm" action="DR_Both_delivery.php" method="post">
    <!-- Fixed main details -->
    <div class="input-group">
      <div class="flex-row">
        <div class="form-control">
          <label>S.I Number</label>
          <input type="text" name="siNumber" required placeholder="Enter SI Number">
        </div>
        <div class="form-control">
          <label>Delivered To</label>
          <input type="text" name="deliveredTo" required placeholder="Enter Name">
        </div>
        <div class="form-control">
          <label>TIN</label>
          <input type="text" name="tin" required placeholder="Enter TIN">
        </div>
        <div class="form-control">
          <label>Address</label>
          <input type="text" name="address" required placeholder="Enter Address">
        </div>
        <div class="form-control">
          <label>Terms</label>
          <input type="text" name="terms" required placeholder="Enter Terms">
        </div>
        <div class="form-control">
          <label>Particulars</label>
          <input type="text" name="particulars" required placeholder="Enter Particulars">
        </div>
        <div class="form-control">
          <label>S.I Date</label>
          <input type="date" name="date" required>
        </div>
        <div class="form-control">
          <label>Machine Model</label>
          <input type="text" name="machineModel" required placeholder="Enter Machine Model">
        </div>
        <div class="form-control">
          <label>Unit Type</label>
          <input type="text" name="units" required placeholder="Enter Units">
        </div>
      </div>
    </div>

    <!-- Radio buttons -->
    <div class="radio-group">
      <input type="radio" name="machineType" id="usedMachine" value="used" checked>
      <label for="usedMachine">Used Machines</label>
      <input type="radio" name="machineType" id="bnewMachine" value="bnew">
      <label for="bnewMachine">Brand New Machines</label>
      <input type="radio" name="machineType" id="pulloutDelivery" value="pullout-delivery">
      <label for="pulloutDelivery">Pull Out Replacement</label>
    </div>

    <!-- Used Machine Section -->
    <div id="usedMachineFields" class="machine-section visible">
      <div id="usedContainer">
        <div class="input-group-used">
          <div class="flex-row">
            <div class="form-control"><label>Serial No.</label><input type="text" name="serialNo[]" placeholder="Enter Serial Number"></div>
            <div class="form-control"><label>MR Start</label><input type="text" name="mrStart[]" placeholder="Enter MR Start"></div>
            <div class="form-control"><label>Color Impression</label><input type="text" name="colorImpression[]" placeholder="Enter Color Impression"></div>
            <div class="form-control"><label>Black Impression</label><input type="text" name="blackImpression[]" placeholder="Enter Black Impression"></div>
            <div class="form-control"><label>Color Large Impression</label><input type="text" name="colorLargeImpression[]" placeholder="Enter Color Large Impression"></div>
          </div>
        </div>
      </div>
      <button type="button" class="btn-add" onclick="addInput('used')">➕ Add Another (Max 7)</button>
    </div>

    <!-- Brand New Machine Section -->
    <div id="bnewMachineFields" class="machine-section">
      <div id="bnewContainer">
        <div class="input-group-bnew">
          <div class="flex-row">
            <div class="form-control"><label>Serial No.</label><input type="text" name="serialNo[]" placeholder="Enter Serial Number"></div>
          </div>
        </div>
      </div>
      <button type="button" class="btn-add" onclick="addInput('bnew')">➕ Add Another</button>
    </div>

    <button type="submit" class="btn-submit">Submit</button>
  </form>

  <script>
    const maxGroupsUsed = 7;
    const maxGroupsBnew = 14;

    function toggleInputs(selected) {
      const usedSection = document.getElementById('usedMachineFields');
      const bnewSection = document.getElementById('bnewMachineFields');

      usedSection.classList.remove('visible');
      bnewSection.classList.remove('visible');

      // disable inputs in both first
      usedSection.querySelectorAll('input').forEach(i => i.disabled = true);
      bnewSection.querySelectorAll('input').forEach(i => i.disabled = true);

      if (selected === 'used') {
        usedSection.classList.add('visible');
        usedSection.querySelectorAll('input').forEach(i => i.disabled = false);
      } else {
        bnewSection.classList.add('visible');
        bnewSection.querySelectorAll('input').forEach(i => i.disabled = false);
      }
    }

    function addInput(type) {
      const container = type === 'used' ? document.getElementById('usedContainer') : document.getElementById('bnewContainer');
      const currentGroupsUsed = container.getElementsByClassName('input-group-used').length;
      const currentGroupsBnew = container.getElementsByClassName('input-group-bnew').length;

      if (currentGroupsUsed >= maxGroupsUsed) {
        alert(`You can only add up to ${maxGroupsUsed} sets.`);
        return;
      }else if(currentGroupsBnew >= maxGroupsBnew){
        alert(`You can only add up to ${maxGroupsBnew} sets.`);
        return;
      }

      const newGroupUsed = document.createElement('div');
      newGroupUsed.classList.add('input-group-used');

      const newGroupBnew = document.createElement('div');
      newGroupBnew.classList.add('input-group-bnew');

      if (type === 'used') {
        newGroupUsed.innerHTML = `
          <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
          <div class="flex-row">
            <div class="form-control"><label>Serial No.</label><input type="text" name="serialNo[]" placeholder="Enter Serial Number"></div>
            <div class="form-control"><label>MR Start</label><input type="text" name="mrStart[]" placeholder="Enter MR Start"></div>
            <div class="form-control"><label>Color Impression</label><input type="text" name="colorImpression[]" placeholder="Enter Color Impression"></div>
            <div class="form-control"><label>Black Impression</label><input type="text" name="blackImpression[]" placeholder="Enter Black Impression"></div>
            <div class="form-control"><label>Color Large Impression</label><input type="text" name="colorLargeImpression[]" placeholder="Enter Color Large Impression"></div>
          </div>
        `;
      } else {
        newGroupBnew.innerHTML = `
          <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
          <div class="flex-row">
             <div class="form-control"><label>Serial No.</label><input type="text" name="serialNo[]" placeholder="Enter Serial Number"></div>
          </div>
        `;
      }

      // container.appendChild(newGroup);
      container.appendChild(type === 'used' ? newGroupUsed : newGroupBnew);
    }

    function removeGroup(button) {
      button.parentNode.remove();
    }

    document.addEventListener("DOMContentLoaded", function() {
      toggleInputs(document.querySelector('input[name="machineType"]:checked').value);
    });

    document.querySelectorAll('input[name="machineType"]').forEach(radio => {
      radio.addEventListener('change', function() {
        toggleInputs(this.value);
      });
    });
  </script>
</body>

</html>