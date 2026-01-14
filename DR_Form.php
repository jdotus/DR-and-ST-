<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Delivery for Mono and Colored Machine</title>
  <style>
    /* Base Styles */
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      background-color: #f5f5f5;
      text-transform: uppercase;
      color: #333;
    }

    h2 {
      margin-bottom: 20px;
      text-align: center;
      color: #2c3e50;
      font-size: 24px;
      padding-bottom: 10px;
      /* border-bottom: 2px solid #3498db; */
    }

    form {
      max-width: 980px;
      margin: 0 auto;
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    /* Consistent Input Groups */
    .input-group,
    .input-group-used,
    .input-group-bnew,
    .input-group-pullout,
    .input-group-pullout-only,
    .input-group-replacement,
    .input-group-replacement-only,
    .input-group-invoice,
    .input-group-partial,
    .input-group-price,
    .input-group-used-dr {
      border: 1px solid #e0e0e0;
      padding: 25px;
      border-radius: 8px;
      margin-bottom: 20px;
      background: linear-gradient(to bottom, #fff, #f9f9f9);
      position: relative;
      transition: border-color 0.3s ease;
    }

    .input-group:hover,
    .input-group-used:hover,
    .input-group-bnew:hover {
      border-color: #3498db;
    }

    /* Flex Layouts */
    .flex-row,
    .flex-row-serial {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      align-items: flex-start;
    }

    .flex-row-serial {
      margin-top: 30px;
      padding-left: 10px;
    }

    .form-control {
      flex: 1 1 200px;
      display: flex;
      flex-direction: column;
      min-width: 180px;
    }

    .form-control label {
      font-weight: 600;
      font-size: 13px;
      margin-bottom: 6px;
      color: #2c3e50;
      letter-spacing: 0.5px;
    }

    input,
    select {
      padding: 10px 12px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 14px;
      transition: all 0.3s ease;
      background: #fff;
      color: #333;
    }

    input:focus,
    select:focus {
      outline: none;
      border-color: #3498db;
      box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
    }

    input::placeholder {
      color: #999;
      text-transform: none;
    }

    /* Button Styles */
    button {
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 600;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .btn-add {
      background: #3498db;
      color: #fff;
      margin-top: 10px;
      margin-bottom: 15px;
    }

    .btn-add:hover {
      background: #2980b9;
      transform: translateY(-1px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .no-margin {
      margin-top: 0 !important;
      margin-bottom: 15px !important;
    }

    .btn-remove {
      position: absolute;
      top: 12px;
      right: 12px;
      background: #e74c3c;
      color: #fff;
      border: none;
      border-radius: 4px;
      padding: 6px 12px;
      cursor: pointer;
      font-size: 12px;
    }

    .btn-remove:hover {
      background: #c0392b;
    }

    .btn-submit {
      background: #2ecc71;
      color: #fff;
      display: block;
      width: 100%;
      margin-top: 30px;
      padding: 14px;
      font-size: 16px;
    }

    .btn-submit:hover {
      background: #27ae60;
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    /* Selection Groups */
    .radio-group,
    .pullout-replacement-group {
      margin-bottom: 25px;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .radio-group {
      margin: 40px 0 30px 0;
    }

    .pullout-replacement-group {
      margin: 15px 0 25px 0;
    }

    .radio-group label,
    .pullout-replacement-group label {
      font-weight: 600;
      font-size: 14px;
      color: #2c3e50;
    }

    select {
      width: 300px;
      padding: 10px;
      border-radius: 6px;
      background: #fff;
      cursor: pointer;
    }

    /* Machine Sections */
    .machine-section {
      display: none;
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
    }

    .visible {
      display: block;
    }

    /* Machine Model Groups */
    .machine-model-group {
      border: 1px solid #ddd;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 8px;
      background: linear-gradient(to bottom, #f8fafc, #fff);
      position: relative;
    }

    .machine-model-header {
      display: flex;
      align-items: flex-end;
      gap: 20px;
      margin-bottom: 20px;
      padding-bottom: 15px;
      border-bottom: 1px solid #eee;
    }

    .serial-group {
      margin-left: 20px;
      margin-bottom: 15px;
      padding: 15px;
      border-left: 3px solid #3498db;
      background: #f8fafc;
      border-radius: 4px;
      position: relative;
      height: 180px;
    }

    .add-serial-btn {
      background: #17a2b8;
      color: white;
      margin-left: 20px;
      margin-bottom: 15px;
    }

    .add-serial-btn:hover {
      background: #138496;
    }

    .machine-model-remove {
      position: absolute;
      top: 15px;
      right: 15px;
      background: #e74c3c;
      color: #fff;
      border: none;
      border-radius: 4px;
      padding: 6px 12px;
      cursor: pointer;
      font-size: 12px;
    }

    .machine-model-remove:hover {
      background: #c0392b;
    }

    /* Section Headers */
    h3 {
      margin: 0 0 20px 0;
      color: #2c3e50;
      font-size: 18px;
      padding-bottom: 8px;
      border-bottom: 1px solid #eee;
    }

    /* Counter Display */
    #totalSerialCount {
      font-weight: bold;
      color: #2c3e50;
      margin-top: 10px;
      padding: 8px 15px;
      background: #f8f9fa;
      border-radius: 4px;
      display: inline-block;
    }

    /* Validation Styles */
    /* input:invalid {
      border-color: #e74c3c;
    }

    input:valid {
      border-color: #2ecc71;
    } */

    /* Responsive Design */
    @media (max-width: 768px) {
      .form-control {
        flex: 1 1 100%;
      }

      .flex-row,
      .flex-row-serial {
        gap: 15px;
      }

      .machine-model-header {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
      }

      select {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <h2>Delivery Rental Machine</h2>

  <form id="myForm" action="DR_save_data.php" method="post" target="_blank">
    <!-- Main details -->
    <div class="input-group">
      <div class="flex-row">
        <div class="form-control">
          <label>S.I Number</label>
          <input type="text" name="si_number" oninput="inputOnlyNumber(this)" required placeholder="Enter SI Number">
        </div>
        <div class="form-control">
          <label>DR Number</label>
          <input type="text" name="dr_number" oninput="inputOnlyNumber(this)" required placeholder="Enter DR Number">
        </div>
        <div class="form-control">
          <label>Delivered To</label>
          <input type="text" name="delivered_to" required placeholder="Enter Name">
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
          <label>Unit Type</label>
          <input type="text" name="unit_type" required placeholder="Enter Units">
        </div>
      </div>
    </div>

    <!-- Dropdown replacing radio buttons -->
    <div class="radio-group">
      <label for="machineTypeSelect">Select DR Format</label>
      <select name="dr_format" id="machineTypeSelect" required>
        <option value="used" selected>Used Machines</option>
        <option value="bnew">Brand New Machines</option>
        <option value="pullout-delivery">Pull Out Replacement</option>
        <option value="drWithPrice">DR with Unit Price</option>
        <option value="drWithInvoice">DR with Invoice (Partial and Complete)</option>
        <option value="usedDr">Used DR</option>
      </select>
    </div>

    <div class="pullout-replacement-group" id="pullout-replacement-group">
      <label for="pulloutReplacementTypeSelect">Select Type</label>
      <select name="pullout_type" id="pulloutReplacementTypeSelect" required>
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
            <div class="form-control"><label>Machine Model</label><input type="text" name="model[]" required placeholder="Enter Machine Model"></div>
            <div class="form-control"><label>Serial No.</label><input type="text" name="serial[]" placeholder="Enter Serial Number"></div>
            <div class="form-control"><label>MR Start</label><input type="text" oninput="formatPrice(this)" name="mr_start[]" placeholder="Enter MR Start"></div>
            <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="color_imp[]" placeholder="Enter Color Impression"></div>
            <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="black_imp[]" placeholder="Enter Black Impression"></div>
            <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="color_large_imp[]" placeholder="Enter Color Large Impression"></div>
          </div>
        </div>
      </div>
      <button type="button" class="btn-add" onclick="addInput('used')">➕ Add Another Serial (Max 7)</button>
    </div>

    <!-- Brand New Machine Section -->
    <div id="bnewMachineFields" class="machine-section">
      <div id="bnewContainer">
        <div class="input-group-bnew">
          <div class="flex-row">
            <div class="form-control"><label>Machine Model</label><input type="text" name="model[]" required placeholder="Enter Machine Model"></div>
            <div class="form-control"><label>Serial No.</label><input type="text" class="serialInput" name="serial[]" placeholder="Enter Serial Number"></div>
          </div>
        </div>
      </div>
      <button type="button" class="btn-add" onclick="addInput('bnew')">➕ Add Another Model and Serials (Max 2)</button>
      <p id="totalSerialCount" style="font-weight:bold; color:#2c3e50; margin-top:10px; padding:8px 15px; background:#f8f9fa; border-radius:4px; display:inline-block;">Total Serials: 0 / 15</p>
    </div>

    <!-- Pullout Replacement Machine Section -->
    <div id="pulloutReplaceFieldMain">
      <div id="pulloutReplaceField" class="machine-section">
        <div id="replacementContainerMain">
          <div id="replacementContainer">
            <div class="input-group-replacement">
              <h3>Replacement Machine</h3>
              <div class="flex-row">
                <div class="form-control"><label>Machine Model</label><input type="text" name="replace_model[]" required placeholder="Enter Machine Model"></div>
                <div class="form-control"><label>Serial No.</label><input type="text" name="replace_serial[]" placeholder="Enter Serial Number"></div>
                <div class="form-control"><label>MR Start</label><input type="text" oninput="formatPrice(this)" name="replace_mr_start[]" placeholder="Enter MR Start"></div>
                <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="replace_color_imp[]" placeholder="Enter Color Impression"></div>
                <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="replace_black_imp[]" placeholder="Enter Black Impression"></div>
                <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="replace_color_large_imp[]" placeholder="Enter Color Large Impression"></div>
              </div>
            </div>
          </div>
          <button type="button" class="btn-add no-margin" onclick="addInput('replacement')">➕ Add Another Serial (Max 2)</button>
        </div>

        <div id="pulloutContainerMain">
          <div id="pulloutContainer">
            <div class="input-group-pullout">
              <h3>Pull Out Machine</h3>
              <div class="flex-row">
                <div class="form-control"><label>Machine Model</label><input type="text" name="pullout_model[]" required placeholder="Enter Machine Model"></div>
                <div class="form-control"><label>Serial No.</label><input type="text" name="pullout_serial[]" placeholder="Enter Serial Number"></div>
                <div class="form-control"><label>MR End</label><input type="text" oninput="formatPrice(this)" name="pullout_mr_end[]" placeholder="Enter MR End"></div>
                <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_color_imp[]" placeholder="Enter Color Impression"></div>
                <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_black_imp[]" placeholder="Enter Black Impression"></div>
                <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_color_large_imp[]" placeholder="Enter Color Large Impression"></div>
              </div>
            </div>
          </div>
          <button type="button" class="btn-add no-margin" onclick="addInput('pullout')">➕ Add Another Serial (Max 2)</button>
        </div>
      </div>

      <!-- Replacement Only Section -->
      <div id="replacementOnlyContainerMain" class="machine-section">
        <div id="replacementOnlyContainer">
          <div class="machine-model-group">
            <div class="machine-model-header">
              <div class="form-control">
                <label>Machine Model</label>
                <input type="text" name="replace_only_machines[0][model]" required placeholder="Enter Machine Model">
              </div>
              <button type="button" class="btn-add add-serial-btn" onclick="addSerialToModel(this)">➕ Add Serial</button>
            </div>
            <div class="serials-container">
              <div class="serial-group">
                <div class="flex-row-serial">
                  <div class="form-control"><label>Serial No.</label><input type="text" name="replace_only_machines[0][serials][0][serial]" placeholder="Enter Serial Number"></div>
                  <div class="form-control"><label>MR Start</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[0][serials][0][mr_start]" placeholder="Enter MR Start"></div>
                  <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[0][serials][0][color_imp]" placeholder="Enter Color Impression"></div>
                  <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[0][serials][0][black_imp]" placeholder="Enter Black Impression"></div>
                  <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[0][serials][0][color_large_imp]" placeholder="Enter Color Large Impression"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button type="button" class="btn-add no-margin" onclick="addMachineModel('replacementOnlyContainer', 'replace_only_machines')">➕ Add Another Machine Model</button>
      </div>

      <!-- Pullout Only Section -->
      <div id="pulloutOnlyContainerMain" class="machine-section">
        <div id="pulloutOnlyContainer">
          <div class="machine-model-group">
            <div class="machine-model-header">
              <div class="form-control">
                <label>Machine Model</label>
                <input type="text" name="pullout_machines[0][model]" required placeholder="Enter Machine Model">
              </div>
              <button type="button" class="btn-add add-serial-btn" onclick="addSerialToModel(this)">➕ Add Serial</button>
            </div>
            <div class="serials-container">
              <div class="serial-group">
                <div class="flex-row-serial">
                  <div class="form-control"><label>Serial No.</label><input type="text" name="pullout_machines[0][serials][0][serial]" placeholder="Enter Serial Number"></div>
                  <div class="form-control"><label>MR End</label><input type="text" oninput="formatPrice(this)" name="pullout_machines[0][serials][0][mr_end]" placeholder="Enter MR End"></div>
                  <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_machines[0][serials][0][color_imp]" placeholder="Enter Color Impression"></div>
                  <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_machines[0][serials][0][black_imp]" placeholder="Enter Black Impression"></div>
                  <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_machines[0][serials][0][color_large_imp]" placeholder="Enter Color Large Impression"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button type="button" class="btn-add no-margin" onclick="addMachineModel('pulloutOnlyContainer', 'pullout_machines')">➕ Add Another Machine Model</button>
      </div>
    </div>

    <!-- DR for Complete Delivery -->
    <div id="drWithInvoiceField" class="machine-section">
      <div id="drWithInvoiceContainer">
        <div class="input-group-invoice">
          <div class="flex-row">
            <div class="form-control"><label>Machine Model</label><input type="text" name="model[]" required placeholder="Enter Machine Model"></div>
            <div class="form-control"><label>Under PO No.</label><input type="text" name="po_number[]" required placeholder="Enter P.O No."></div>
            <div class="form-control"><label>Under Invoice No.</label><input type="text" name="invoice_number[]" placeholder="Enter Invoice No."></div>
            <div class="form-control"><label>Note</label><input type="text" name="note[]" placeholder="Enter Note"></div>
          </div>
        </div>
      </div>
      <button type="button" class="btn-add" onclick="addInput('invoice')">➕ Add Another Item (Max 4)</button>
    </div>

    <!-- DR with Prices -->
    <div id="drWithPriceField" class="machine-section">
      <div id="drWithPriceContainer">
        <div class="input-group-price">
          <div class="flex-row">
            <div class="form-control"><label>Machine Model</label><input type="text" name="model[]" required placeholder="Enter Machine Model"></div>
            <div class="form-control"><label>Quantity</label><input type="text" oninput="formatPrice(this)" name="quantity[]" required placeholder="Enter Quantity"></div>
            <div class="form-control"><label>Price</label><input oninput="formatPrice(this)" type="text" name="price[]" required placeholder="Enter Price"></div>
            <div class="form-control"><label>Unit Type</label><input type="text" name="unit_type[]" required placeholder="Enter Unit Type"></div>
            <div class="form-control"><label>Item Description</label><input type="text" name="item_desc[]" required placeholder="Enter Item Description"></div>
          </div>
        </div>
      </div>
      <button type="button" class="btn-add" onclick="addInput('dr-price')">➕ Add Another Item (Max 5)</button>
    </div>

    <!-- Used Dr -->
    <div id="usedDrField" class="machine-section">
      <div id="usedDrContainer">
        <div class="input-group-used-dr">
          <div class="flex-row">
            <div class="form-control"><label>Machine Model</label><input type="text" name="model[]" required placeholder="Enter Machine Model"></div>
            <div class="form-control"><label>Serial No.</label><input type="text" name="serial[]" required placeholder="Enter Serial Number"></div>
            <div class="form-control"><label>MR Start</label><input type="text" oninput="formatPrice(this)" name="mr_start[]" placeholder="Enter MR Start"></div>
            <div class="form-control"><label>Technician Name</label><input type="text" name="tech_name[]" placeholder="Enter Technician Name"></div>
            <div class="form-control"><label>PR No.</label><input type="text" name="pr_number[]" placeholder="Enter PR Number"></div>
          </div>
        </div>
      </div>
      <button type="button" class="btn-add" onclick="addInput('used-dr')">➕ Add Another Item (Max 4)</button>
    </div>

    <button type="submit" class="btn-submit">Save & Generate</button>
  </form>

  <script src="./DR_Form_Script.js"></script>
</body>

</html>