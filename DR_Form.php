<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Delivery for Mono and Colored Machine</title>
  <link rel="stylesheet" href="DRStyle.css" />
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
          <input type="text" name="terms" placeholder="Enter Terms">
        </div>
        <div class="form-control">
          <label>Particulars</label>
          <input type="text" name="particulars" placeholder="Enter Particulars">
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

    <!-- NOTE SECTION -->
    <div id="note-main-used-machine" class="note-main-used-machine visible">
      <h3>Note:</h3>
      <div class="note-container">
        <li>Please fill in the details of the machines below based on the selected DR format.</li>
        <li>To indentify if the machine is <strong>Colored</strong> or <strong>Mono</strong> type:</li>
        <ul>
          <li>If the machine is <strong>Colored type</strong>, please input <strong>"Color Impression"</strong> and <strong>"Color Large Impression"</strong> fields.</li>
          <li>If the machine is <strong>Mono type</strong>, please input only the <strong>"Black Impression"</strong> field only.</li>
        </ul>
      </div>
    </div>

    <div id="note-main-invoice" class="note-main-invoice visible">
      <h3>Note:</h3>
      <div class="note-container">
        <li>Please fill in the details of the machines below based on the selected DR format.</li>
        <li>To Identify if the record is <strong>Partial</strong> or <strong>Complete</strong></li>
        <ul>
          <li>If the machine is for Partial delivery please input only the <strong>Under PO No.</strong></li>
          <li>If the machine is for Complete delivery please input the <strong>Under PO No.</strong> and <strong>Under Invoice No.</strong></li>
        </ul>
      </div>
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
      <button type="button" class="btn-add" onclick="addInput('bnew')">➕ Add Another Model and Serials</button>
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