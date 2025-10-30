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
    .input-group-bnew,
    .input-group-pulloutreplace,
    .input-group-invoice {
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

    input, select {
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
      flex-direction: column;
      margin: 50px 0 25px 0;
    }

    .radio-group label {
      font-weight: bold;
      margin-bottom: 5px;
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
    <!-- Main details -->
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
          <label>Unit Type</label>
          <input type="text" name="units" required placeholder="Enter Units">
        </div>
      </div>
    </div>

    <!-- Dropdown replacing radio buttons -->
    <div class="radio-group">
      <label for="machineTypeSelect">Select DR Format</label>
      <select name="machineType" id="machineTypeSelect" required style="width: 40%;">
        <option value="used" selected>Used Machines</option>
        <option value="bnew">Brand New Machines</option>
        <option value="pullout-delivery">Pull Out Replacement</option>
        <option value="drWithInvoice">DR With Invoice</option>
      </select>
    </div>

    <!-- Used Machine Section -->
    <div id="usedMachineFields" class="machine-section visible">
      <div id="usedContainer">
        <div class="input-group-used">
          <div class="flex-row">
            <div class="form-control"><label>Machine Model</label><input type="text" name="machineModel" required placeholder="Enter Machine Model"></div>
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
            <div class="form-control"><label>Machine Model</label><input type="text" name="bnewMachineModel[]" required placeholder="Enter Machine Model"></div>
            <div class="form-control"><label>Serial No.</label><input type="text" class="serialInput" name="serialNo[]" placeholder="Enter Serial Number"></div>
          </div>
        </div>
      </div>
      <button type="button" class="btn-add" onclick="addInput('bnew')">➕ Add Another (Max 2)</button>
      <p id="totalSerialCount" style="font-weight:bold; color:#333; margin-top:10px;">Total Serials: 0 / 15</p>
    </div>

    <!-- Pullout Replace Machine Section -->
    <div id="pulloutReplaceField" class="machine-section">
      <div id="pulloutReplaceContainer">
        <div class="input-group-pulloutreplace">
          <h3>Replacement Machine</h3>
          <div class="flex-row">
            <div class="form-control"><label>Machine Model</label><input type="text" name="replacementMachineModel" required placeholder="Enter Machine Model"></div>
            <div class="form-control"><label>Serial No.</label><input type="text" name="replacementSerialNo[]" placeholder="Enter Serial Number"></div>
            <div class="form-control"><label>MR Start</label><input type="text" name="replacementMrStart[]" placeholder="Enter MR Start"></div>
            <div class="form-control"><label>Color Impression</label><input type="text" name="replacementColorImpression[]" placeholder="Enter Color Impression"></div>
            <div class="form-control"><label>Black Impression</label><input type="text" name="replacemenBlackImpression[]" placeholder="Enter Black Impression"></div>
            <div class="form-control"><label>Color Large Impression</label><input type="text" name="replacemenColorLargeImpression[]" placeholder="Enter Color Large Impression"></div>
          </div>

          <h3>Pull Out Machine</h3>
          <div class="flex-row">
            <div class="form-control"><label>Machine Model</label><input type="text" name="pulloutMachineModel" required placeholder="Enter Machine Model"></div>
            <div class="form-control"><label>Serial No.</label><input type="text" name="pulloutSerialNo[]" placeholder="Enter Serial Number"></div>
            <div class="form-control"><label>MR End</label><input type="text" name="pulloutMrEnd[]" placeholder="Enter MR End"></div>
            <div class="form-control"><label>Color Impression</label><input type="text" name="pulloutColorImpression[]" placeholder="Enter Color Impression"></div>
            <div class="form-control"><label>Black Impression</label><input type="text" name="pulloutBlackImpression[]" placeholder="Enter Black Impression"></div>
            <div class="form-control"><label>Color Large Impression</label><input type="text" name="pulloutColorLargeImpression[]" placeholder="Enter Color Large Impression"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- DR with Invoice Section -->
    <div id="drWithInvoiceField" class="machine-section ">
      <div id="drWithInvoiceContainer">
        <div class="input-group-invoice">
          <div class="flex-row">
            <div class="form-control"><label>Machine Model</label><input type="text" name="machineModel" required placeholder="Enter Machine Model"></div>
            <div class="form-control"><label>Serial No.</label><input type="text" name="serialNo[]" placeholder="Enter Serial Number"></div>
            <div class="form-control"><label>MR Start</label><input type="text" name="mrStart[]" placeholder="Enter MR Start"></div>
            <div class="form-control"><label>Color Impression</label><input type="text" name="colorImpression[]" placeholder="Enter Color Impression"></div>
            <div class="form-control"><label>Black Impression</label><input type="text" name="blackImpression[]" placeholder="Enter Black Impression"></div>
            <div class="form-control"><label>Color Large Impression</label><input type="text" name="colorLargeImpression[]" placeholder="Enter Color Large Impression"></div>
          </div>
        </div>
      </div>
      <button type="button" class="btn-add" onclick="addInput('invoice')">➕ Add Another (Max 7)</button>
    </div>

    <button type="submit" class="btn-submit">Submit</button>
  </form>

  <script>
    const maxGroupsUsed = 7;
    const maxGroupsBnew = 2;
    const maxSerials = 15;

    // --- SERIAL COUNT HANDLING FOR BRAND NEW ---
    function countTotalSerials() {
      const inputs = document.querySelectorAll('#bnewMachineFields .serialInput');
      let total = 0;
      inputs.forEach(input => {
        const serials = input.value.split(',').map(s => s.trim()).filter(s => s !== '');
        total += serials.length;
      });
      return total;
    }

    function updateSerialCountDisplay() {
      const total = countTotalSerials();
      const counter = document.getElementById('totalSerialCount');
      if (counter) counter.textContent = `Total Serials: ${total} / ${maxSerials}`;
    }

    document.addEventListener('input', function (e) {
      if (e.target.classList.contains('serialInput')) {
        const totalSerials = countTotalSerials();
        updateSerialCountDisplay();

        const currentSerials = e.target.value
          .split(',')
          .map(s => s.trim())
          .filter(s => s !== '');

        if (totalSerials > maxSerials) {
          e.target.style.border = '2px solid red';
          alert(`Total of ${maxSerials} serial numbers reached for all Brand New Machines.`);

          const excess = totalSerials - maxSerials;
          const allowedCount = currentSerials.length - excess;
          e.target.value = currentSerials.slice(0, allowedCount).join(', ');
          updateSerialCountDisplay();
        } else {
          e.target.style.border = '1px solid #ccc';
        }
      }
    });

    // --- TOGGLE INPUT SECTIONS ---
    function toggleInputs(selected) {
      const usedSection = document.getElementById('usedMachineFields');
      const bnewSection = document.getElementById('bnewMachineFields');
      const pulloutReplaceSection = document.getElementById('pulloutReplaceField');
      const drWithInvoiceSection = document.getElementById('drWithInvoiceField');

      usedSection.classList.remove('visible');
      bnewSection.classList.remove('visible');
      pulloutReplaceSection.classList.remove('visible');
      drWithInvoiceSection.classList.remove('visible');

      [usedSection, bnewSection, pulloutReplaceSection, drWithInvoiceSection].forEach(sec => {
        sec.querySelectorAll('input').forEach(i => i.disabled = true);
      });

      if (selected === 'used') {
        usedSection.classList.add('visible');
        usedSection.querySelectorAll('input').forEach(i => i.disabled = false);
      } else if (selected === 'bnew') {
        bnewSection.classList.add('visible');
        bnewSection.querySelectorAll('input').forEach(i => i.disabled = false);
      } else if(selected === 'drWithInvoice') {
        drWithInvoiceSection.classList.add('visible');
        drWithInvoiceSection.querySelectorAll('input').forEach(i => i.disabled = false);
      } else {
        pulloutReplaceSection.classList.add('visible');
        pulloutReplaceSection.querySelectorAll('input').forEach(i => i.disabled = false);
      }
    }

    // --- ADD & REMOVE INPUTS ---
    function addInput(type) {
      const container = type === 'used' ? document.getElementById('usedContainer') : document.getElementById('bnewContainer');
      const currentGroupsUsed = container.getElementsByClassName('input-group-used').length;
      const currentGroupsBnew = container.getElementsByClassName('input-group-bnew').length;
      const currentGroupInvoice = container.getElementsByClassName('input-group-invoice').length;

      if (type === 'used' && currentGroupsUsed >= maxGroupsUsed) {
        alert(`You can only add up to ${maxGroupsUsed} sets.`);
        return;
      } else if (type === 'bnew' && currentGroupsBnew >= maxGroupsBnew) {
        alert(`You can only add up to ${maxGroupsBnew} sets.`);
        return;
      }

      const newGroup = document.createElement('div');
      newGroup.classList.add(type === 'used' ? 'input-group-used' : 'input-group-bnew');

      if (type === 'used') {
        newGroup.innerHTML = `
          <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
          <div class="flex-row">
            <div class="form-control"><label>Serial No.</label><input type="text" name="serialNo[]" placeholder="Enter Serial Number"></div>
            <div class="form-control"><label>MR Start</label><input type="text" name="mrStart[]" placeholder="Enter MR Start"></div>
            <div class="form-control"><label>Color Impression</label><input type="text" name="colorImpression[]" placeholder="Enter Color Impression"></div>
            <div class="form-control"><label>Black Impression</label><input type="text" name="blackImpression[]" placeholder="Enter Black Impression"></div>
            <div class="form-control"><label>Color Large Impression</label><input type="text" name="colorLargeImpression[]" placeholder="Enter Color Large Impression"></div>
          </div>`;
      } else if(type === 'invoice') {

      }else {
        newGroup.innerHTML = `
          <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
          <div class="flex-row">
            <div class="form-control"><label>Machine Model</label><input type="text" name="bnewMachineModel[]" required placeholder="Enter Machine Model"></div>
            <div class="form-control"><label>Serial No.</label><input type="text" class="serialInput" name="serialNo[]" placeholder="Enter Serial Number"></div>
          </div>`;
      }

      container.appendChild(newGroup);
    }

    function removeGroup(button) {
      button.parentNode.remove();
      updateSerialCountDisplay();
    }

    document.addEventListener("DOMContentLoaded", function() {
      const select = document.getElementById('machineTypeSelect');
      toggleInputs(select.value);
      select.addEventListener('change', function() {
        toggleInputs(this.value);
      });
    });
  </script>
</body>
</html>
