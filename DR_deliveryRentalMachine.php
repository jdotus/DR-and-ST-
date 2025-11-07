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
    .input-group-pullout,
    .input-group-pullout-only,
    .input-group-replacement,
    .input-group-replacement-only,
    .input-group-invoice,
    .input-group-partial,
    .input-group-price{
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

    .no-margin {
      margin-top: 0 !important;
      margin: 0 0 12px 0 !important;
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

    .pullout-replacement-group{
      margin-bottom: 15px;
      display: flex;
      flex-direction: column;
      margin: 10px 0 25px 0;
    }

    .radio-group label,
    .pullout-replacement-group label {
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

  <form id="myForm" action="DR_Both_delivery.php" method="post" target="_blank">
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
        <div class="form-control" id="basedUnit">
          <label >Unit Type</label>
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
        <option value="drWithPrice">DR with Unit Price </option>
        <option value="drWithInvoice">DR with Invoice (Patrial and Complete)</option>
      </select>
    </div>

    <div class="pullout-replacement-group" id="pullout-replacement-group">
      <label for="pulloutReplacementTypeSelect">Select Type</label>
      <select name="machineType2" id="pulloutReplacementTypeSelect" required style="width: 40%;">
        <option value="pulloutReplacement" selected>Replacement & Pullout Machines</option>
        <option value="replacementOnly">Replacement Machines</option>
        <option value="pulloutOnly">Pullout Machines</option>
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
    <div id="pulloutReplaceFieldMain">
      <div id="pulloutReplaceField" class="machine-section">
        <div id="replacementContainerMain">
          <div id="replacementContainer">
            <div class="input-group-replacement">
              <h3>Replacement Machine</h3>
                <div class="flex-row">
                  <div class="form-control"><label>Machine Model</label><input type="text" name="replacementMachineModel" required placeholder="Enter Machine Model"></div>
                  <div class="form-control"><label>Serial No.</label><input type="text" name="replacementSerialNo[]" placeholder="Enter Serial Number"></div>
                  <div class="form-control"><label>MR Start</label><input type="text" name="replacementMrStart[]" placeholder="Enter MR Start"></div>
                  <div class="form-control"><label>Color Impression</label><input type="text" name="replacementColorImpression[]" placeholder="Enter Color Impression"></div>
                  <div class="form-control"><label>Black Impression</label><input type="text" name="replacemenBlackImpression[]" placeholder="Enter Black Impression"></div>
                  <div class="form-control"><label>Color Large Impression</label><input type="text" name="replacemenColorLargeImpression[]" placeholder="Enter Color Large Impression"></div>
                </div>
              </div>
            </div>
            <button type="button" class="btn-add no-margin" onclick="addInput('replacement')">➕ Add Another (Max 2)</button>
          </div>
        
            
          <div id="pulloutContainerMain">
            <div id="pulloutContainer">
              <div class="input-group-pullout">
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
            <button type="button" class="btn-add no-margin" onclick="addInput('pullout')">➕ Add Another (Max 2)</button>
        </div> 
      </div>
        
        <div id="replacementOnlyContainerMain" class="machine-section">
          <div id="replacementOnlyContainer">
            <div class="input-group-replacement-only">
              <h3>Replacement Machine</h3>
                <div class="flex-row">
                  <div class="form-control"><label>Machine Model</label><input type="text" name="replacementMachineModel" required placeholder="Enter Machine Model"></div>
                  <div class="form-control"><label>Serial No.</label><input type="text" name="replacementSerialNo[]" placeholder="Enter Serial Number"></div>
                  <div class="form-control"><label>MR Start</label><input type="text" name="replacementMrStart[]" placeholder="Enter MR Start"></div>
                  <div class="form-control"><label>Color Impression</label><input type="text" name="replacementColorImpression[]" placeholder="Enter Color Impression"></div>
                  <div class="form-control"><label>Black Impression</label><input type="text" name="replacemenBlackImpression[]" placeholder="Enter Black Impression"></div>
                  <div class="form-control"><label>Color Large Impression</label><input type="text" name="replacemenColorLargeImpression[]" placeholder="Enter Color Large Impression"></div>
                </div>
              </div>
            </div>
            <button type="button" class="btn-add no-margin" onclick="addInput('replacement-only')">➕ Add Another (Max 7)</button>
          </div>
        
        <div id="pulloutOnlyContainerMain" class="machine-section">
          <div id="pulloutOnlyContainer">
            <div class="input-group-pullout-only">
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
          <button type="button" class="btn-add no-margin" onclick="addInput('pullout-only')">➕ Add Another (Max 7)</button>
        </div> 
    </div>

    <!-- DR for Complete Delivery -->
    <div id="drWithInvoiceField" class="machine-section ">
      <div id="drWithInvoiceContainer">
        <div class="input-group-invoice">
          <div class="flex-row">
            <div class="form-control"><label>Machine Model</label><input type="text" name="drInvoiceMachineModel" required placeholder="Enter Machine Model"></div>
            <div class="form-control"><label>Under PO No.</label><input type="text" name="drInvoiceUnderPo" required placeholder="Enter P.O No."></div>
            <div class="form-control"><label>Under Invoice No.</label><input type="text"  name="drInvoiceUnderInvoice" placeholder="Enter Invoice No."></div>
            <div class="form-control"><label>Note</label><input type="text" name="drInvoiceNote"  placeholder="Enter Note"></div>
          </div>
        </div>
      </div>
      <button type="button" class="btn-add" onclick="addInput('invoice')">➕ Add Another (Max 4)</button>
    </div>

    <!-- DR with Prices -->
    <div id="drWithPriceField" class="machine-section">
      <div id="drWithPriceContainer">
        <div class="input-group-price">
          <div class="flex-row">
            <div class="form-control"><label>Machine Model</label><input type="text" name="drInvoiceMachineModel" required placeholder="Enter Machine Model"></div>
            <div class="form-control"><label>Quantity</label><input type="number" name="drInvoiceMachineModel" required placeholder="Enter Machine Model"></div>
            <div class="form-control"><label>price</label><input type="text" name="drInvoiceMachineModel" required placeholder="Enter Machine Model"></div>
            <div class="form-control" id="basedUnit"><label >Unit Type</label><input type="text" name="units" required placeholder="Enter Units"></div>
            <div class="form-control"><label>Item Description</label><input type="text" name="drInvoiceMachineModel" required placeholder="Enter Machine Model"></div>
          </div>
        </div>
      </div>
      <button type="button" class="btn-add" onclick="addInput('invoice')">➕ Add Another (Max )</button>
    </div>


    <button type="submit" class="btn-submit" >Save & Generate</button>
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
  function toggleInputs(selected, secondarySelected) {
    const usedSection = document.getElementById('usedMachineFields');
    const bnewSection = document.getElementById('bnewMachineFields');
    const pulloutReplaceSection = document.getElementById('pulloutReplaceField');
    const drWithInvoiceSection = document.getElementById('drWithInvoiceField');
    const drWithPriceSection = document.getElementById('drWithPriceField');

    const pulloutOnlyContainer = document.getElementById('pulloutOnlyContainerMain');
    const replacementOnlyContainer = document.getElementById('replacementOnlyContainerMain');

    const basedUnitInput = document.getElementById('basedUnit');
    const pulloutReplacementSelect = document.getElementById('pullout-replacement-group');

    // --- Reset visibility ---
    const allSections = [
      usedSection,
      bnewSection,
      pulloutReplaceSection,
      drWithInvoiceSection,
      pulloutOnlyContainer,
      replacementOnlyContainer,
      drWithPriceSection
    ];

    allSections.forEach(sec => {
      sec.classList.remove('visible');
      sec.style.display = 'none';
      // Only disable inputs, not buttons
      sec.querySelectorAll('input:not([type="button"]):not([type="submit"])').forEach(i => (i.disabled = true));
    });

    // Hide and disable pullout replacement select
    pulloutReplacementSelect.style.display = 'none';
    pulloutReplacementSelect.querySelector('select').disabled = true;
    pulloutReplacementSelect.querySelector('label').disabled = true;

    // Hide and disable based unit field
    basedUnitInput.style.display = 'none';
    basedUnitInput.querySelector('label').disabled = true;
    basedUnitInput.querySelector('input').disabled = true;

    // --- MAIN LOGIC ---
    if (selected === 'used') {
      usedSection.classList.add('visible');
      usedSection.style.display = 'block';
      usedSection.querySelectorAll('input').forEach(i => (i.disabled = false));

      basedUnitInput.style.display = 'flex';
      basedUnitInput.querySelector('label').disabled = false;
      basedUnitInput.querySelector('input').disabled = false;

    } else if (selected === 'bnew') {
      bnewSection.classList.add('visible');
      bnewSection.style.display = 'block';
      bnewSection.querySelectorAll('input').forEach(i => (i.disabled = false));

      basedUnitInput.style.display = 'flex';
      basedUnitInput.querySelector('label').disabled = false;
      basedUnitInput.querySelector('input').disabled = false;

    } else if (selected === 'drWithInvoice') {
      drWithInvoiceSection.classList.add('visible');
      drWithInvoiceSection.style.display = 'block';
      drWithInvoiceSection.querySelectorAll('input').forEach(i => (i.disabled = false));

      basedUnitInput.style.display = 'none';
      basedUnitInput.querySelector('label').disabled = true;
      basedUnitInput.querySelector('input').disabled = true;

    } else if(selected === 'drWithPrice') {
      drWithPriceSection.classList.add('visible');
      drWithPriceSection.style.display = 'block';

      // Enable all inputs inside this section
      drWithPriceSection.querySelectorAll('input').forEach(i => (i.disabled = false));
      drWithPriceSection.querySelectorAll('label').forEach(l => (l.disabled = false));

      basedUnitInput.style.display = 'none';
      basedUnitInput.querySelector('label').disabled = true;
      basedUnitInput.querySelector('input').disabled = true;
    }else if (selected === 'pullout-delivery') {
      // Always show dropdown for pullout type
      pulloutReplacementSelect.style.display = 'flex';
      pulloutReplacementSelect.querySelector('select').disabled = false;
      pulloutReplacementSelect.querySelector('label').disabled = false;

      basedUnitInput.style.display = 'flex';
      basedUnitInput.querySelector('label').disabled = false;
      basedUnitInput.querySelector('input').disabled = false;

      // Handle secondary selection
      if (secondarySelected === 'replacementOnly') {
        replacementOnlyContainer.style.display = 'block';
        replacementOnlyContainer.querySelectorAll('input').forEach(i => (i.disabled = false));
      } else if (secondarySelected === 'pulloutOnly') {
        pulloutOnlyContainer.style.display = 'block';
        pulloutOnlyContainer.querySelectorAll('input').forEach(i => (i.disabled = false));
      } else {
        pulloutReplaceSection.classList.add('visible');
        pulloutReplaceSection.style.display = 'block';
        pulloutReplaceSection.querySelectorAll('input').forEach(i => (i.disabled = false));
      }
    }
  }
  
    // --- ADD & REMOVE INPUTS ---
    function addInput(type) {
      let container;

      // Determine which container to use
      if (type === 'used') {
        container = document.getElementById('usedContainer');
      } else if (type === 'bnew') {
        container = document.getElementById('bnewContainer');
      } else if (type === 'invoice') {
        container = document.getElementById('drWithInvoiceContainer'); // make sure this div exists in HTML
      }else if (type === 'replacement') {
        container = document.getElementById('replacementContainer');
      }else if (type === 'pullout') {
        container = document.getElementById('pulloutContainer');
      }else if (type === 'replacement-only') { 
        container = document.getElementById('replacementOnlyContainer');
      } else if (type === 'pullout-only') {
        container = document.getElementById('pulloutOnlyContainer');
      } 

      const currentGroupsUsed = container.getElementsByClassName('input-group-used').length;
      const currentGroupsBnew = container.getElementsByClassName('input-group-bnew').length;
      const currentGroupsInvoice = container.getElementsByClassName('input-group-invoice').length;
      const currentGroupsReplacement = container.getElementsByClassName('input-group-replacement').length;
      const currentGroupsPullout = container.getElementsByClassName('input-group-pullout').length;
      const currentGroupsPulloutOnly = container.getElementsByClassName('input-group-pullout-only').length;
      const currentGroupsReplacementOnly = container.getElementsByClassName('input-group-replacement-only').length;

      // Limit per section
      const maxGroupsUsed = 7;
      const maxGroupsBnew = 2;
      const maxGroupsInvoice = 5;
      const maxGroupsReplacementAndPullout = 2;

      if (type === 'used' && currentGroupsUsed >= maxGroupsUsed) {
        alert(`You can only add up to ${maxGroupsUsed} sets.`);
        return;
      } else if (type === 'bnew' && currentGroupsBnew >= maxGroupsBnew) {
        alert(`You can only add up to ${maxGroupsBnew} sets.`);
        return;
      } else if (type === 'invoice' && currentGroupsInvoice >= maxGroupsInvoice) {
        alert(`You can only add up to 4 invoice rows.`);
        return;
      } else if (type === 'replacement' && currentGroupsReplacement >= maxGroupsReplacementAndPullout) {
        alert(`You can only add up to ${maxGroupsReplacementAndPullout} replacement sets.`);
        return;
      } else if (type === 'pullout' && currentGroupsPullout >= maxGroupsReplacementAndPullout) {
        alert(`You can only add up to ${maxGroupsReplacementAndPullout} pullout sets.`);
        return; 
      }else if ((type === 'replacement-only' && currentGroupsReplacementOnly >= maxGroupsUsed) || (type === 'pullout-only' && currentGroupsPulloutOnly >= maxGroupsUsed)) {
        alert(`You can only add up to ${maxGroupsUsed} sets.`);
      }

      // Create new group container
      const newGroup = document.createElement('div');
      newGroup.classList.add(
        type === 'used' ? 'input-group-used' :
        type === 'bnew' ? 'input-group-bnew' :
        type === 'invoice' ? 'input-group-invoice':
        type === 'replacement' ? 'input-group-replacement':
        type === 'pullout' ? 'input-group-pullout':
        type === 'replacement-only' ? 'input-group-replacement-only':
        type === 'pullout-only' ? 'input-group-pullout-only':
        ''
      );

      // HTML structure based on type
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
      } else if (type === 'invoice') {
        newGroup.innerHTML = `
          <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
          <div class="flex-row">
            <div class="form-control"><label>Quantity</label><input type="number" name="drInvoiceQuantity[]" required placeholder="Enter Quantity"></div>
            <div class="form-control"><label>Unit Type</label><input type="text" name="drInvoiceUnits[]" required placeholder="Enter Units"></div>
            <div class="form-control"><label>Item Description</label><input type="text" name="drInvoiceItemDescription[]" required placeholder="Enter Item Description"></div>
          </div>`;
      } else if (type === 'pullout') {
        newGroup.innerHTML = `
          <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
          <div class="flex-row">
             
              <div class="form-control"><label>Serial No.</label><input type="text" name="pulloutSerialNo[]" placeholder="Enter Serial Number"></div>
              <div class="form-control"><label>MR End</label><input type="text" name="pulloutMrEnd[]" placeholder="Enter MR End"></div>
              <div class="form-control"><label>Color Impression</label><input type="text" name="pulloutColorImpression[]" placeholder="Enter Color Impression"></div>
              <div class="form-control"><label>Black Impression</label><input type="text" name="pulloutBlackImpression[]" placeholder="Enter Black Impression"></div>
              <div class="form-control"><label>Color Large Impression</label><input type="text" name="pulloutColorLargeImpression[]" placeholder="Enter Color Large Impression"></div>
          </div>`;
      } else if (type === 'replacement') {
        newGroup.innerHTML = `
          <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
          <div class="flex-row">
              
              <div class="form-control"><label>Serial No.</label><input type="text" name="replacementSerialNo[]" placeholder="Enter Serial Number"></div>
              <div class="form-control"><label>MR Start</label><input type="text" name="replacementMrStart[]" placeholder="Enter MR Start"></div>
              <div class="form-control"><label>Color Impression</label><input type="text" name="replacementColorImpression[]" placeholder="Enter Color Impression"></div>
              <div class="form-control"><label>Black Impression</label><input type="text" name="replacemenBlackImpression[]" placeholder="Enter Black Impression"></div>
              <div class="form-control"><label>Color Large Impression</label><input type="text" name="replacemenColorLargeImpression[]" placeholder="Enter Color Large Impression"></div>
          </div>`;
      } else if (type === 'replacement-only') {
        newGroup.innerHTML = `
          <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>

            <div class="flex-row">
             
              <div class="form-control"><label>Serial No.</label><input type="text" name="replacementSerialNo[]" placeholder="Enter Serial Number"></div>
              <div class="form-control"><label>MR Start</label><input type="text" name="replacementMrStart[]" placeholder="Enter MR Start"></div>
              <div class="form-control"><label>Color Impression</label><input type="text" name="replacementColorImpression[]" placeholder="Enter Color Impression"></div>
              <div class="form-control"><label>Black Impression</label><input type="text" name="replacemenBlackImpression[]" placeholder="Enter Black Impression"></div>
              <div class="form-control"><label>Color Large Impression</label><input type="text" name="replacemenColorLargeImpression[]" placeholder="Enter Color Large Impression"></div>
            </div>
          `;
        } else if (type === 'pullout-only') {
          newGroup.innerHTML = `
          <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
          <div class="flex-row">
            
            <div class="form-control"><label>Serial No.</label><input type="text" name="pulloutSerialNo[]" placeholder="Enter Serial Number"></div>
            <div class="form-control"><label>MR End</label><input type="text" name="pulloutMrEnd[]" placeholder="Enter MR End"></div>
            <div class="form-control"><label>Color Impression</label><input type="text" name="pulloutColorImpression[]" placeholder="Enter Color Impression"></div>
            <div class="form-control"><label>Black Impression</label><input type="text" name="pulloutBlackImpression[]" placeholder="Enter Black Impression"></div>
            <div class="form-control"><label>Color Large Impression</label><input type="text" name="pulloutColorLargeImpression[]" placeholder="Enter Color Large Impression"></div>
          </div>
          `;
      }else {
        newGroup.innerHTML = `
          <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
          <div class="flex-row">
            <div class="form-control"><label>Machine Model</label><input type="text" name="bnewMachineModel[]" required placeholder="Enter Machine Model"></div>
            <div class="form-control"><label>Serial No.</label><input type="text" class="serialInput" name="serialNo[]" placeholder="Enter Serial Number"></div>
          </div>`;
      }

      // Append the new group to the correct container
      container.appendChild(newGroup);
    }

    function removeGroup(button) {
      button.parentNode.remove();
      updateSerialCountDisplay();
    }
    document.addEventListener("DOMContentLoaded", function() {
      const selectFirst = document.getElementById('machineTypeSelect');
      const selectSecond = document.getElementById('pulloutReplacementTypeSelect');

      if (typeof toggleInputs !== 'function' || !selectFirst) return;

      const firstVal = selectFirst.value || '';
      const secondVal = selectSecond ? selectSecond.value : '';

      // initial toggle
      toggleInputs(firstVal, secondVal);

      selectFirst.addEventListener('change', function() {
        toggleInputs(this.value, selectSecond ? selectSecond.value : '');
      });

      if (selectSecond) {
        selectSecond.addEventListener('change', function() {
          toggleInputs(selectFirst.value, this.value);
        });
      }
    });
  </script>
</body>
</html>