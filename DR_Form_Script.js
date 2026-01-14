// const maxGroupsUsed = 7;
//     const maxGroupsBnew = 2;
//     const maxSerials = 15;
//     const maxMachineModels = 5; // Maximum number of machine models
//     const maxSerialsPerModel = 7; // Maximum serials per machine model

//     function formatPrice(input) {
//       // Remove any non-digit characters (except temporary commas)
//       let value = input.value.replace(/[^0-9]/g, '');

//       // Convert to number (avoid NaN for empty input)
//       if (value === '') {
//         input.value = '';
//         return;
//       }

//       // Format with comma separators every 3 digits
//       input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
//     }
    
//     function inputOnlyNumber(input) {
//       // Remove any non-digit characters (except temporary commas)
//       let value = input.value.replace(/[^0-9]/g, '');

//       // Convert to number (avoid NaN for empty input)
//       if (value === '') {
//         input.value = '';
//         return;
//       }

//       // Format with dash after every 4 digits
//       input.value = value.replace(/[^0-9]/g, '');
//     }

//     // --- COUNT TOTAL SERIALS FOR BRANDNEW MACHINE ---
//     function countTotalSerials() {
//       const inputs = document.querySelectorAll('#bnewMachineFields .serialInput');
//       let total = 0;
//       inputs.forEach(input => {
//         const serials = input.value
//           .split(',')
//           .map(s => s.trim())
//           .filter(s => s !== '');
//         total += serials.length;
//       });
//       return total;
//     }

//     // --- UPDATE COUNTER DISPLAY FOR BRANDNEW MACHINE ---
//     function updateSerialCountDisplay() {
//       const total = countTotalSerials();
//       const counter = document.getElementById('totalSerialCount');
//       if (counter) counter.textContent = `Total Serials: ${total} / ${maxSerials}`;
//     }

//     document.addEventListener('input', function(e) {
//       if (e.target.classList.contains('serialInput')) {
//         // --- Format serials: every 6 digits separated by comma and space ---
//         let raw = e.target.value.replace(/[^0-9]/g, ''); // Remove non-digits
//         let formatted = raw.match(/.{1,6}/g)?.join(', ') || '';
//         if (e.target.value !== formatted) {
//           e.target.value = formatted;
//         }

//         const totalSerials = countTotalSerials();
//         updateSerialCountDisplay();

//         const currentSerials = e.target.value
//           .split(',')
//           .map(s => s.trim())
//           .filter(s => s !== '');

//         if (totalSerials > maxSerials) {
//           e.target.style.border = '2px solid red';
//           alert(`Total of ${maxSerials} serial numbers reached for all Brand New Machines.`);

//           const excess = totalSerials - maxSerials;
//           const allowedCount = currentSerials.length - excess;
//           e.target.value = currentSerials.slice(0, allowedCount).join(', ');
//           updateSerialCountDisplay();
//         } else {
//           e.target.style.border = '1px solid #ccc';
//         }
//       }
//     });

//     // --- TOGGLE INPUT SECTIONS ---
//     function toggleInputs(selected, secondarySelected) {
//       const usedSection = document.getElementById('usedMachineFields');
//       const bnewSection = document.getElementById('bnewMachineFields');
//       const pulloutReplaceSection = document.getElementById('pulloutReplaceField');
//       const drWithInvoiceSection = document.getElementById('drWithInvoiceField');
//       const drWithPriceSection = document.getElementById('drWithPriceField');
//       const usedDrSection = document.getElementById('usedDrField')

//       const pulloutOnlyContainer = document.getElementById('pulloutOnlyContainerMain');
//       const replacementOnlyContainer = document.getElementById('replacementOnlyContainerMain');

//       const basedUnitInput = document.getElementById('basedUnit');
//       const pulloutReplacementSelect = document.getElementById('pullout-replacement-group');

//       // --- Reset visibility ---
//       const allSections = [
//         usedSection,
//         bnewSection,
//         pulloutReplaceSection,
//         drWithInvoiceSection,
//         pulloutOnlyContainer,
//         replacementOnlyContainer,
//         drWithPriceSection,
//         usedDrSection
//       ];

//       allSections.forEach(sec => {
//         sec.classList.remove('visible');
//         sec.style.display = 'none';
//         // Only disable inputs, not buttons
//         sec.querySelectorAll('input:not([type="button"]):not([type="submit"])').forEach(i => (i.disabled = true));
//       });

//       // Hide and disable pullout replacement select
//       pulloutReplacementSelect.style.display = 'none';
//       pulloutReplacementSelect.querySelector('select').disabled = true;
//       pulloutReplacementSelect.querySelector('label').disabled = true;

//       // Hide and disable based unit field
//       basedUnitInput.style.display = 'none';
//       basedUnitInput.querySelector('label').disabled = true;
//       basedUnitInput.querySelector('input').disabled = true;

//       // --- MAIN LOGIC ---
//       if (selected === 'used') {
//         usedSection.classList.add('visible');
//         usedSection.style.display = 'block';
//         usedSection.querySelectorAll('input').forEach(i => (i.disabled = false));

//         basedUnitInput.style.display = 'flex';
//         basedUnitInput.querySelector('label').disabled = false;
//         basedUnitInput.querySelector('input').disabled = false;

//       } else if (selected === 'bnew') {
//         bnewSection.classList.add('visible');
//         bnewSection.style.display = 'block';
//         bnewSection.querySelectorAll('input').forEach(i => (i.disabled = false));

//         basedUnitInput.style.display = 'flex';
//         basedUnitInput.querySelector('label').disabled = false;
//         basedUnitInput.querySelector('input').disabled = false;

//       } else if (selected === 'drWithInvoice') {
//         drWithInvoiceSection.classList.add('visible');
//         drWithInvoiceSection.style.display = 'block';
//         drWithInvoiceSection.querySelectorAll('input').forEach(i => (i.disabled = false));

//         basedUnitInput.style.display = 'none';
//         basedUnitInput.querySelector('label').disabled = true;
//         basedUnitInput.querySelector('input').disabled = true;

//       } else if (selected === 'drWithPrice') {
//         drWithPriceSection.classList.add('visible');
//         drWithPriceSection.style.display = 'block';

//         // Enable all inputs inside this section
//         drWithPriceSection.querySelectorAll('input').forEach(i => (i.disabled = false));
//         drWithPriceSection.querySelectorAll('label').forEach(l => (l.disabled = false));

//         basedUnitInput.style.display = 'none';
//         basedUnitInput.querySelector('label').disabled = true;
//         basedUnitInput.querySelector('input').disabled = true;
//       } else if (selected === 'pullout-delivery') {
//         // Always show dropdown for pullout type
//         pulloutReplacementSelect.style.display = 'flex';
//         pulloutReplacementSelect.querySelector('select').disabled = false;
//         pulloutReplacementSelect.querySelector('label').disabled = false;

//         basedUnitInput.style.display = 'flex';
//         basedUnitInput.querySelector('label').disabled = false;
//         basedUnitInput.querySelector('input').disabled = false;

//         // Handle secondary selection
//         if (secondarySelected === 'replacementOnly') {
//           replacementOnlyContainer.style.display = 'block';
//           replacementOnlyContainer.querySelectorAll('input').forEach(i => (i.disabled = false));
//           replacementOnlyContainer.querySelectorAll('button').forEach(b => (b.disabled = false));
//         } else if (secondarySelected === 'pulloutOnly') {
//           pulloutOnlyContainer.style.display = 'block';
//           pulloutOnlyContainer.querySelectorAll('input').forEach(i => (i.disabled = false));
//         } else {
//           pulloutReplaceSection.classList.add('visible');
//           pulloutReplaceSection.style.display = 'block';
//           pulloutReplaceSection.querySelectorAll('input').forEach(i => (i.disabled = false));
//         }
//       } else if (selected === 'usedDr') {
//         usedDrSection.style.display = 'block';
//         usedDrSection.querySelectorAll('input').forEach(i => (i.disabled = false));
//       }
//     }

//     // --- ADD & REMOVE INPUTS ---
//     function addInput(type) {
//       let container;

//       // Determine which container to use
//       if (type === 'used') {
//         container = document.getElementById('usedContainer');
//       } else if (type === 'bnew') {
//         container = document.getElementById('bnewContainer');
//       } else if (type === 'invoice') {
//         container = document.getElementById('drWithInvoiceContainer');
//       } else if (type === 'replacement') {
//         container = document.getElementById('replacementContainer');
//       } else if (type === 'pullout') {
//         container = document.getElementById('pulloutContainer');
//       } else if (type === 'pullout-only') {
//         container = document.getElementById('pulloutOnlyContainer');
//       } else if (type === 'dr-price') {
//         container = document.getElementById('drWithPriceContainer');
//       } else if (type === 'used-dr') {
//         container = document.getElementById('usedDrContainer');
//       }

//       const currentGroupsUsed = container.getElementsByClassName('input-group-used').length;
//       const currentGroupsBnew = container.getElementsByClassName('input-group-bnew').length;
//       const currentGroupsInvoice = container.getElementsByClassName('input-group-invoice').length;
//       const currentGroupsReplacement = container.getElementsByClassName('input-group-replacement').length;
//       const currentGroupsPullout = container.getElementsByClassName('input-group-pullout').length;
//       const currentGroupsPulloutOnly = container.getElementsByClassName('input-group-pullout-only').length;
//       const currentGroupWithPrice = container.getElementsByClassName('input-group-price').length;
//       const currentGroupUsedDr = container.getElementsByClassName('input-group-used-dr').length;

//       // Limit per section
//       const maxGroupsUsed = 7;
//       const maxGroupsBnew = 2;
//       const maxGroupsInvoice = 5;
//       const maxGroupsReplacementAndPullout = 2;

//       if (type === 'used' && currentGroupsUsed >= maxGroupsUsed) {
//         alert(`You can only add up to ${maxGroupsUsed} sets.`);
//         return;
//       } else if (type === 'bnew' && currentGroupsBnew >= maxGroupsBnew) {
//         alert(`You can only add up to ${maxGroupsBnew} sets.`);
//         return;
//       } else if (type === 'invoice' && currentGroupsInvoice >= maxGroupsInvoice) {
//         alert(`You can only add up to 4 invoice rows.`);
//         return;
//       } else if (type === 'replacement' && currentGroupsReplacement >= maxGroupsReplacementAndPullout) {
//         alert(`You can only add up to ${maxGroupsReplacementAndPullout} replacement sets.`);
//         return;
//       } else if (type === 'pullout' && currentGroupsPullout >= maxGroupsReplacementAndPullout) {
//         alert(`You can only add up to ${maxGroupsReplacementAndPullout} pullout sets.`);
//         return;
//       } else if (type === 'pullout-only' && currentGroupsPulloutOnly >= maxGroupsUsed) {
//         alert(`You can only add up to ${maxGroupsUsed} sets.`);
//         return;
//       } else if (type === 'dr-price' && currentGroupWithPrice >= 5) {
//         alert('You can only add up to 5 sets.');
//         return;
//       }else if(type === 'used-dr' && currentGroupUsedDr > 4) {
//         alert('You can only add up to 4 sets.');
//         return;
//       }

//       // Create new group container
//       const newGroup = document.createElement('div');
//       newGroup.classList.add(
//         type === 'used' ? 'input-group-used' :
//         type === 'bnew' ? 'input-group-bnew' :
//         type === 'invoice' ? 'input-group-invoice' :
//         type === 'replacement' ? 'input-group-replacement' :
//         type === 'pullout' ? 'input-group-pullout' :
//         type === 'pullout-only' ? 'input-group-pullout-only' :
//         type === 'dr-price' ? 'input-group-price' :
//         type === 'used-dr' ? 'input-group-used-dr' :
//         ''
//       );

//       // HTML structure based on type
//       if (type === 'used') {
//         newGroup.innerHTML = `
//           <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
//           <div class="flex-row">
//             <div class="form-control"><label>Serial No.</label><input type="text" name="serial[]" placeholder="Enter Serial Number"></div>
//             <div class="form-control"><label>MR Start</label><input type="text" oninput="formatPrice(this)" name="mr_start[]" placeholder="Enter MR Start"></div>
//             <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="color_imp[]" placeholder="Enter Color Impression"></div>
//             <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="black_imp[]" placeholder="Enter Black Impression"></div>
//             <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="color_large_imp[]" placeholder="Enter Color Large Impression"></div>
//           </div>`;
//       } else if (type === 'invoice') {
//         newGroup.innerHTML = `
//           <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
//           <div class="flex-row">
//             <div class="form-control"><label>Quantity</label><input type="text" oninput="formatPrice(this)" name="quantity[]" required placeholder="Enter Quantity"></div>
//             <div class="form-control"><label>Unit Type</label><input type="text" name="unit_type[]" required placeholder="Enter Units"></div>
//             <div class="form-control"><label>Item Description</label><input type="text" name="item_desc[]" required placeholder="Enter Item Description"></div>
//           </div>`;
//       } else if (type === 'pullout') {
//         newGroup.innerHTML = `
//           <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
//           <div class="flex-row">
//             <div class="form-control"><label>Serial No.</label><input type="text" name="pullout_serial[]" placeholder="Enter Serial Number"></div>
//             <div class="form-control"><label>MR End</label><input type="text" oninput="formatPrice(this)" name="pullout_mr_end[]" placeholder="Enter MR End"></div>
//             <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_color_imp[]" placeholder="Enter Color Impression"></div>
//             <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_black_imp[]" placeholder="Enter Black Impression"></div>
//             <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_color_large_imp[]" placeholder="Enter Color Large Impression"></div>
//           </div>`;
//       }
//       else if (type === 'replacement') {
//         newGroup.innerHTML = `
//           <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
//           <div class="flex-row">
//               <div class="form-control"><label>Serial No.</label><input type="text" name="replace_serial[]" placeholder="Enter Serial Number"></div>
//               <div class="form-control"><label>MR Start</label><input type="text" oninput="formatPrice(this)" name="replace_mr_start[]" placeholder="Enter MR Start"></div>
//               <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="replace_color_imp[]" placeholder="Enter Color Impression"></div>
//               <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="replace_black_imp[]" placeholder="Enter Black Impression"></div>
//               <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="replace_color_large_imp[]" placeholder="Enter Color Large Impression"></div>
//           </div>`;
//       } 
//       else if (type === 'dr-price') {
//         newGroup.innerHTML = `
//           <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
//           <div class="flex-row">
//             <div class="form-control"><label>Quantity</label><input type="text" oninput="formatPrice(this)" name="quantity[]" required placeholder="Enter Quantity"></div>
//             <div class="form-control"><label>Price</label><input oninput="formatPrice(this)" type="text" name="price[]" required placeholder="Enter Price"></div>
//             <div class="form-control"><label>Unit Type</label><input type="text" name="unit_type[]" required placeholder="Enter Unit Type"></div>
//             <div class="form-control"><label>Item Description</label><input type="text" name="item_desc[]" required placeholder="Enter Item Description"></div>
//           </div>
//           `;
//       } else if (type === 'used-dr') {
//         newGroup.innerHTML = `
//           <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
//           <div class="flex-row">
//             <div class="form-control"><label>Quantity</label><input type="text" oninput="formatPrice(this)" name="quantity[]" required placeholder="Enter Quantity"></div>
//             <div class="form-control"><label>Unit Type</label><input type="text" name="unit_type[]" required placeholder="Enter Unit Type"></div>
//             <div class="form-control"><label>Item Description</label><input type="text" name="item_desc[]" required placeholder="Enter Item Description"></div>
//           </div>
//         `;
//       } else {
//         newGroup.innerHTML = `
//           <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
//           <div class="flex-row">
//             <div class="form-control"><label>Machine Model</label><input type="text" name="model[]" required placeholder="Enter Machine Model"></div>
//             <div class="form-control"><label>Serial No.</label><input type="text" class="serialInput" name="serial[]" placeholder="Enter Serial Number"></div>
//           </div>`;
//       }

//       // Append the new group to the correct container
//       container.appendChild(newGroup);
//     }

//     // --- NEW FUNCTIONS FOR REPLACEMENT-ONLY SECTION ---
// let machineModelCount = 0; // Start from 1 since we have one default
// let totalGlobalSerialsCount = 0; // Track total serials globally

// // Function to count ALL serials across ALL models
// function countAllSerials() {
//     const replacementOnlyContainer = document.getElementById('replacementOnlyContainer');
//     const pulloutOnlyContainer = document.getElementById('pulloutOnlyContainer');
//     let totalSerials = 0;

//     // Count serials in replacement-only container
//     if (replacementOnlyContainer) {
//         const allModelGroups = replacementOnlyContainer.getElementsByClassName('machine-model-group');
//         for (let modelGroup of allModelGroups) {
//             const serialsContainer = modelGroup.querySelector('.serials-container');
//             if (serialsContainer) {
//                 const serialGroups = serialsContainer.getElementsByClassName('serial-group');
//                 totalSerials += serialGroups.length;
//             }
//         }
//     }

//     // Count serials in pullout-only container
//     if (pulloutOnlyContainer) {
//         const allModelGroups = pulloutOnlyContainer.getElementsByClassName('machine-model-group');
//         for (let modelGroup of allModelGroups) {
//             const serialsContainer = modelGroup.querySelector('.serials-container');
//             if (serialsContainer) {
//                 const serialGroups = serialsContainer.getElementsByClassName('serial-group');
//                 totalSerials += serialGroups.length;
//             }
//         }
//     }
    
//     totalGlobalSerialsCount = totalSerials; // Update global counter
//     return totalSerials;
// }

// // Function to count total models
// function countAllModels() {
//     let totalModels = 0;
//     const containers = ['replacementOnlyContainer', 'pulloutOnlyContainer'];
    
//     containers.forEach(containerId => {
//         const container = document.getElementById(containerId);
//         if (container) {
//             totalModels += container.getElementsByClassName('machine-model-group').length;
//         }
//     });
    
//     return totalModels;
// }

// // Add a new machine model
// function addMachineModel(type, array_name = null) {
//     if (type === 'replacementOnlyContainer') {
//         const container = document.getElementById('replacementOnlyContainer');
//         const currentModels = container.getElementsByClassName('machine-model-group').length;

//         if (currentModels >= maxMachineModels) {
//             alert(`You can only add up to ${maxMachineModels} machine models.`);
//             return;
//         }
        
//         // Use provided array name or default
//         const arrayName = array_name || 'replace_machines';

//         const newModelGroup = document.createElement('div');
//         newModelGroup.className = 'machine-model-group';
//         newModelGroup.innerHTML = `
//             <button type="button" class="machine-model-remove" onclick="removeMachineModel(this)">✖ Remove Model</button>
//             <div class="machine-model-header">
//                 <div class="form-control">
//                     <label>Machine Model</label>
//                     <input type="text" name="${arrayName}[${machineModelCount}][model]" required placeholder="Enter Machine Model">
//                 </div>
//                 <button type="button" class="btn-add add-serial-btn" onclick="addSerialToModel(this)">➕ Add Serial</button>
//             </div>
//             <div class="serials-container">
//                 <!-- Serial numbers will be added here -->
//             </div>
//         `;

//         container.appendChild(newModelGroup);
//         machineModelCount++;

//     } else if (type === 'pulloutOnlyContainer') {
//         const container = document.getElementById('pulloutOnlyContainer');
//         const currentModels = container.getElementsByClassName('machine-model-group').length;

//         if (currentModels >= maxMachineModels) {
//             alert(`You can only add up to ${maxMachineModels} machine models.`);
//             return;
//         }

//         // Use provided array name or default
//         const arrayName = array_name || 'pullout_machines';

//         const newModelGroup = document.createElement('div');
//         newModelGroup.className = 'machine-model-group';
//         newModelGroup.innerHTML = `
//             <button type="button" class="machine-model-remove" onclick="removeMachineModel(this)">✖ Remove Model</button>
//             <div class="machine-model-header">
//                 <div class="form-control">
//                     <label>Machine Model</label>
//                     <input type="text" name="${arrayName}[${machineModelCount}][model]" required placeholder="Enter Machine Model">
//                 </div>
//                 <button type="button" class="btn-add add-serial-btn" onclick="addSerialToModel(this)">➕ Add Serial</button>
//             </div>
//             <div class="serials-container">
//                 <!-- Serial numbers will be added here -->
//             </div>
//         `;

//         container.appendChild(newModelGroup);
//         machineModelCount++;
//     }
// }

// // Add a serial number to a machine model
// // function addSerialToModel(button) {
// //     const machineModelGroup = button.closest('.machine-model-group');
// //     const serialsContainer = machineModelGroup.querySelector('.serials-container');
// //     const currentSerials = serialsContainer.getElementsByClassName('serial-group').length;

// //     // Find the model index from the model input name
// //     const modelInput = machineModelGroup.querySelector('input[name*="[model]"]');
// //     const modelName = modelInput.name;
// //     const modelIndex = modelName.match(/\[(\d+)\]/)[1];

// //     // Extract array name from the model input name
// //     const arrayNameMatch = modelName.match(/^([^\[]+)\[(\d+)\]\[model\]$/);
// //     if (!arrayNameMatch) {
// //         console.error('Could not parse model input name:', modelName);
// //         return;
// //     }
// //     const arrayName = arrayNameMatch[1];

// //     // Get current total serials
// //     const totalSerials = countAllSerials();

// //     if (currentSerials >= maxSerialsPerModel) {
// //         alert(`You can only add up to ${maxSerialsPerModel} serial numbers per machine model.`);
// //         return;
// //     }

// //     if (totalSerials >= maxSerialsPerModel) {
// //         alert(`You can only add up to ${maxSerialsPerModel} serial numbers per machine model.`);
// //         return;
// //     }

// //     const newSerialGroup = document.createElement('div');
// //     newSerialGroup.className = 'serial-group';

// //     // Determine which fields to add based on array name
// //     if (arrayName === 'replace_only_machines') {
// //         newSerialGroup.innerHTML = `
// //             <button type="button" class="btn-remove" onclick="removeSerialGroup(this)">✖</button>
// //             <div class="flex-row-serial">
// //                 <div class="form-control"><label>Serial No.</label><input type="text" name="replace_only_machines[${modelIndex}][serials][${currentSerials}][serial]" placeholder="Enter Serial Number"></div>
// //                 <div class="form-control"><label>MR Start</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[${modelIndex}][serials][${currentSerials}][mr_start]" placeholder="Enter MR Start"></div>
// //                 <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[${modelIndex}][serials][${currentSerials}][color_imp]" placeholder="Enter Color Impression"></div>
// //                 <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[${modelIndex}][serials][${currentSerials}][black_imp]" placeholder="Enter Black Impression"></div>
// //                 <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[${modelIndex}][serials][${currentSerials}][color_large_imp]" placeholder="Enter Color Large Impression"></div>
// //             </div>
// //         `;
// //     } else if (arrayName === 'pullout_machines') {
// //         newSerialGroup.innerHTML = `
// //             <button type="button" class="btn-remove" onclick="removeSerialGroup(this)">✖</button>
// //             <div class="flex-row-serial">
// //                 <div class="form-control"><label>Serial No.</label><input type="text" name="pullout_only_machines[${modelIndex}][serials][${currentSerials}][serial]" placeholder="Enter Serial Number"></div>
// //                 <div class="form-control"><label>MR End</label><input type="text" oninput="formatPrice(this)" name="pullout_only_machines[${modelIndex}][serials][${currentSerials}][mr_end]" placeholder="Enter MR End"></div>
// //                 <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_only_machines[${modelIndex}][serials][${currentSerials}][color_imp]" placeholder="Enter Color Impression"></div>
// //                 <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_only_machines[${modelIndex}][serials][${currentSerials}][black_imp]" placeholder="Enter Black Impression"></div>
// //                 <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_only_machines[${modelIndex}][serials][${currentSerials}][color_large_imp]" placeholder="Enter Color Large Impression"></div>
// //             </div>
// //         `;
// //     } else {
// //         console.warn('Unknown array name:', arrayName);
// //         return;
// //     }

// //     serialsContainer.appendChild(newSerialGroup);
    
// //     // Update global serial count
// //     totalGlobalSerialsCount++;
// // }

// // Add a serial number to a machine model
// function addSerialToModel(button) {
//     const machineModelGroup = button.closest('.machine-model-group');
//     const serialsContainer = machineModelGroup.querySelector('.serials-container');
//     const currentSerials = serialsContainer.getElementsByClassName('serial-group').length;

//     // Find the model index from the model input name
//     const modelInput = machineModelGroup.querySelector('input[name*="[model]"]');
//     const modelName = modelInput.name;
//     const modelIndex = modelName.match(/\[(\d+)\]/)[1];

//     // Extract array name from the model input name
//     const arrayNameMatch = modelName.match(/^([^\[]+)\[(\d+)\]\[model\]$/);
//     if (!arrayNameMatch) {
//         console.error('Could not parse model input name:', modelName);
//         return;
//     }
//     const arrayName = arrayNameMatch[1];

//     // Get current total serials
//     const totalSerials = countAllSerials();

//     if (currentSerials >= maxSerialsPerModel) {
//         alert(`You can only add up to ${maxSerialsPerModel} serial numbers per machine model.`);
//         return;
//     }

//     if (totalSerials >= maxSerialsPerModel) {
//         alert(`You can only add up to ${maxSerialsPerModel} serial numbers per machine model.`);
//         return;
//     }

//     const newSerialGroup = document.createElement('div');
//     newSerialGroup.className = 'serial-group';

//     // Determine which fields to add based on array name
//     if (arrayName === 'replace_only_machines') {
//         newSerialGroup.innerHTML = `
//             <button type="button" class="btn-remove" onclick="removeSerialGroup(this)">✖</button>
//             <div class="flex-row-serial">
//                 <div class="form-control"><label>Serial No.</label><input type="text" name="replace_only_machines[${modelIndex}][serials][${currentSerials}][serial]" placeholder="Enter Serial Number"></div>
//                 <div class="form-control"><label>MR Start</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[${modelIndex}][serials][${currentSerials}][mr_start]" placeholder="Enter MR Start"></div>
//                 <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[${modelIndex}][serials][${currentSerials}][color_imp]" placeholder="Enter Color Impression"></div>
//                 <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[${modelIndex}][serials][${currentSerials}][black_imp]" placeholder="Enter Black Impression"></div>
//                 <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[${modelIndex}][serials][${currentSerials}][color_large_imp]" placeholder="Enter Color Large Impression"></div>
//             </div>
//         `;
//     } else if (arrayName === 'pullout_machines') {
//         // FIXED: Changed from 'pullout_only_machines' to 'pullout_machines' to match the array name check
//         newSerialGroup.innerHTML = `
//             <button type="button" class="btn-remove" onclick="removeSerialGroup(this)">✖</button>
//             <div class="flex-row-serial">
//                 <div class="form-control"><label>Serial No.</label><input type="text" name="pullout_machines[${modelIndex}][serials][${currentSerials}][serial]" placeholder="Enter Serial Number"></div>
//                 <div class="form-control"><label>MR End</label><input type="text" oninput="formatPrice(this)" name="pullout_machines[${modelIndex}][serials][${currentSerials}][mr_end]" placeholder="Enter MR End"></div>
//                 <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_machines[${modelIndex}][serials][${currentSerials}][color_imp]" placeholder="Enter Color Impression"></div>
//                 <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_machines[${modelIndex}][serials][${currentSerials}][black_imp]" placeholder="Enter Black Impression"></div>
//                 <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_machines[${modelIndex}][serials][${currentSerials}][color_large_imp]" placeholder="Enter Color Large Impression"></div>
//             </div>
//         `;
//     } else {
//         console.warn('Unknown array name:', arrayName);
//         return;
//     }

//     serialsContainer.appendChild(newSerialGroup);
    
//     // Update global serial count
//     totalGlobalSerialsCount++;
// }

// // Remove serial group
// function removeSerialGroup(button) {
//     if (confirm('Are you sure you want to remove this serial?')) {
//         const serialGroup = button.closest('.serial-group');
        
//         // Remove from DOM
//         serialGroup.remove();
        
//         // Update global serial count
//         if (totalGlobalSerialsCount > 0) {
//             totalGlobalSerialsCount--;
//         }
        
//         // Reindex serials in the same model (optional)
//         reindexSerialsInModel(serialGroup.closest('.machine-model-group'));
//     }
// }

// // Remove machine model
// function removeMachineModel(button) {
//     if (confirm('Are you sure you want to remove this machine model and all its serials?')) {
//         const machineModelGroup = button.closest('.machine-model-group');
        
//         // Count how many serials are in this model before removing
//         const serialsContainer = machineModelGroup.querySelector('.serials-container');
//         let serialsInThisModel = 0;
//         if (serialsContainer) {
//             serialsInThisModel = serialsContainer.getElementsByClassName('serial-group').length;
//         }
        
//         // Remove from DOM
//         machineModelGroup.remove();
        
//         // Update global counts
//         if (machineModelCount > 0) {
//             machineModelCount--;
//         }
        
//         // Subtract serials from this model from global count
//         if (totalGlobalSerialsCount >= serialsInThisModel) {
//             totalGlobalSerialsCount -= serialsInThisModel;
//         } else {
//             totalGlobalSerialsCount = 0;
//         }
        
//         // Reindex all remaining models (optional)
//         reindexAllModelsAndSerials();
//     }
// }

// // Helper function to reindex serials in a model
// function reindexSerialsInModel(modelGroup) {
//     const serialsContainer = modelGroup.querySelector('.serials-container');
//     if (!serialsContainer) return;
    
//     const serialGroups = serialsContainer.getElementsByClassName('serial-group');
//     const modelInput = modelGroup.querySelector('input[name*="[model]"]');
//     const modelName = modelInput.name;
//     const arrayNameMatch = modelName.match(/^([^\[]+)\[(\d+)\]\[model\]$/);
    
//     if (!arrayNameMatch) return;
    
//     const arrayName = arrayNameMatch[1];
//     const modelIndex = arrayNameMatch[2];
    
//     // Reindex all serial inputs
//     for (let i = 0; i < serialGroups.length; i++) {
//         const serialGroup = serialGroups[i];
//         const inputs = serialGroup.querySelectorAll('input');
        
//         inputs.forEach(input => {
//             const oldName = input.name;
//             const newName = oldName.replace(/serials\[\d+\]/, `serials[${i}]`);
//             input.name = newName;
//         });
//     }
// }

// // Helper function to reindex all models
// function reindexAllModelsAndSerials() {
//     const containers = [
//         { id: 'replacementOnlyContainer', array: 'replace_only_machines' },
//         { id: 'pulloutOnlyContainer', array: 'pullout_only_machines' }
//     ];
    
//     let newModelCount = 0;
    
//     containers.forEach(containerInfo => {
//         const container = document.getElementById(containerInfo.id);
//         if (!container) return;
        
//         const modelGroups = container.getElementsByClassName('machine-model-group');
        
//         for (let i = 0; i < modelGroups.length; i++) {
//             const modelGroup = modelGroups[i];
//             const modelInput = modelGroup.querySelector('input[name*="[model]"]');
            
//             // Update model index
//             if (modelInput) {
//                 modelInput.name = `${containerInfo.array}[${newModelCount}][model]`;
//             }
            
//             // Update serial indices
//             const serialsContainer = modelGroup.querySelector('.serials-container');
//             if (serialsContainer) {
//                 const serialGroups = serialsContainer.getElementsByClassName('serial-group');
//                 for (let j = 0; j < serialGroups.length; j++) {
//                     const serialGroup = serialGroups[j];
//                     const inputs = serialGroup.querySelectorAll('input');
                    
//                     inputs.forEach(input => {
//                         const oldName = input.name;
//                         const newName = oldName
//                             .replace(new RegExp(`${containerInfo.array}\\[\\d+\\]`), `${containerInfo.array}[${newModelCount}]`)
//                             .replace(/serials\[\d+\]/, `serials[${j}]`);
//                         input.name = newName;``
//                     });
//                 }
//             }
            
//             newModelCount++;
//         }
//     });
    
//     // Update global model count
//     machineModelCount = newModelCount;
// }

//     // Remove a machine model
//     function removeMachineModel(button) {
//       button.parentNode.remove();
//     }

//     function removeGroup(button) {
//       button.parentNode.remove();
//       updateSerialCountDisplay();
//     }

//     // Remove a serial group
//     function removeSerialGroup(button) {
//       button.parentNode.remove();
//     }

//     document.addEventListener("DOMContentLoaded", function() {
//       const selectFirst = document.getElementById('machineTypeSelect');
//       const selectSecond = document.getElementById('pulloutReplacementTypeSelect');

//       if (typeof toggleInputs !== 'function' || !selectFirst) return;

//       const firstVal = selectFirst.value || '';
//       const secondVal = selectSecond ? selectSecond.value : '';

//       // initial toggle
//       toggleInputs(firstVal, secondVal);

//       selectFirst.addEventListener('change', function() {
//         toggleInputs(this.value, selectSecond ? selectSecond.value : '');
//       });

//       if (selectSecond) {
//         selectSecond.addEventListener('change', function() {
//           toggleInputs(selectFirst.value, this.value);
//         });
//       }
//     });

const maxGroupsUsed = 7;
const maxGroupsBnew = 2;
const maxSerials = 15;
const maxMachineModels = 5;
const maxSerialsPerModel = 7;

function formatPrice(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    if (value === '') {
        input.value = '';
        return;
    }
    input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

function inputOnlyNumber(input) {
    let value = input.value.replace(/[^0-9]/g, '');
    if (value === '') {
        input.value = '';
        return;
    }
    input.value = value.replace(/[^0-9]/g, '');
}

function countTotalSerials() {
    const inputs = document.querySelectorAll('#bnewMachineFields .serialInput');
    let total = 0;
    inputs.forEach(input => {
        const serials = input.value
            .split(',')
            .map(s => s.trim())
            .filter(s => s !== '');
        total += serials.length;
    });
    return total;
}

function updateSerialCountDisplay() {
    const total = countTotalSerials();
    const counter = document.getElementById('totalSerialCount');
    if (counter) {
        counter.textContent = `Total Serials: ${total} / ${maxSerials}`;
        counter.style.color = total >= maxSerials ? '#e74c3c' : '#2c3e50';
    }
}

document.addEventListener('input', function(e) {
    if (e.target.classList.contains('serialInput')) {
        let raw = e.target.value.replace(/[^0-9]/g, '');
        let formatted = raw.match(/.{1,6}/g)?.join(', ') || '';
        if (e.target.value !== formatted) {
            e.target.value = formatted;
        }

        const totalSerials = countTotalSerials();
        updateSerialCountDisplay();

        const currentSerials = e.target.value
            .split(',')
            .map(s => s.trim())
            .filter(s => s !== '');

        if (totalSerials > maxSerials) {
            e.target.style.border = '2px solid #e74c3c';
            e.target.style.boxShadow = '0 0 0 3px rgba(231, 76, 60, 0.1)';
            
            const excess = totalSerials - maxSerials;
            const allowedCount = currentSerials.length - excess;
            e.target.value = currentSerials.slice(0, allowedCount).join(', ');
            updateSerialCountDisplay();
        } else {
            e.target.style.border = '1px solid #ddd';
            e.target.style.boxShadow = 'none';
        }
    }
});

function toggleInputs(selected, secondarySelected) {
    const usedSection = document.getElementById('usedMachineFields');
    const bnewSection = document.getElementById('bnewMachineFields');
    const pulloutReplaceSection = document.getElementById('pulloutReplaceField');
    const drWithInvoiceSection = document.getElementById('drWithInvoiceField');
    const drWithPriceSection = document.getElementById('drWithPriceField');
    const usedDrSection = document.getElementById('usedDrField');
    const pulloutOnlyContainer = document.getElementById('pulloutOnlyContainerMain');
    const replacementOnlyContainer = document.getElementById('replacementOnlyContainerMain');
    const basedUnitInput = document.getElementById('basedUnit');
    const pulloutReplacementSelect = document.getElementById('pullout-replacement-group');

    const allSections = [
        usedSection,
        bnewSection,
        pulloutReplaceSection,
        drWithInvoiceSection,
        pulloutOnlyContainer,
        replacementOnlyContainer,
        drWithPriceSection,
        usedDrSection
    ];

    allSections.forEach(sec => {
        sec.classList.remove('visible');
        sec.style.display = 'none';
        sec.querySelectorAll('input:not([type="button"]):not([type="submit"])').forEach(i => (i.disabled = true));
    });

    pulloutReplacementSelect.style.display = 'none';
    pulloutReplacementSelect.querySelector('select').disabled = true;
    pulloutReplacementSelect.querySelector('label').style.opacity = '0.5';

    basedUnitInput.style.display = 'none';
    basedUnitInput.querySelector('label').style.opacity = '0.5';
    basedUnitInput.querySelector('input').disabled = true;

    if (selected === 'used') {
        usedSection.classList.add('visible');
        usedSection.style.display = 'block';
        usedSection.querySelectorAll('input').forEach(i => (i.disabled = false));
        
        basedUnitInput.style.display = 'flex';
        basedUnitInput.querySelector('label').style.opacity = '1';
        basedUnitInput.querySelector('input').disabled = false;

    } else if (selected === 'bnew') {
        bnewSection.classList.add('visible');
        bnewSection.style.display = 'block';
        bnewSection.querySelectorAll('input').forEach(i => (i.disabled = false));
        
        basedUnitInput.style.display = 'flex';
        basedUnitInput.querySelector('label').style.opacity = '1';
        basedUnitInput.querySelector('input').disabled = false;

    } else if (selected === 'drWithInvoice') {
        drWithInvoiceSection.classList.add('visible');
        drWithInvoiceSection.style.display = 'block';
        drWithInvoiceSection.querySelectorAll('input').forEach(i => (i.disabled = false));

    } else if (selected === 'drWithPrice') {
        drWithPriceSection.classList.add('visible');
        drWithPriceSection.style.display = 'block';
        drWithPriceSection.querySelectorAll('input').forEach(i => (i.disabled = false));
        drWithPriceSection.querySelectorAll('label').forEach(l => (l.style.opacity = '1'));

    } else if (selected === 'pullout-delivery') {
        pulloutReplacementSelect.style.display = 'flex';
        pulloutReplacementSelect.querySelector('select').disabled = false;
        pulloutReplacementSelect.querySelector('label').style.opacity = '1';
        
        basedUnitInput.style.display = 'flex';
        basedUnitInput.querySelector('label').style.opacity = '1';
        basedUnitInput.querySelector('input').disabled = false;

        if (secondarySelected === 'replacementOnly') {
            replacementOnlyContainer.style.display = 'block';
            replacementOnlyContainer.querySelectorAll('input').forEach(i => (i.disabled = false));
            replacementOnlyContainer.querySelectorAll('button').forEach(b => (b.disabled = false));
        } else if (secondarySelected === 'pulloutOnly') {
            pulloutOnlyContainer.style.display = 'block';
            pulloutOnlyContainer.querySelectorAll('input').forEach(i => (i.disabled = false));
        } else {
            pulloutReplaceSection.classList.add('visible');
            pulloutReplaceSection.style.display = 'block';
            pulloutReplaceSection.querySelectorAll('input').forEach(i => (i.disabled = false));
        }
    } else if (selected === 'usedDr') {
        usedDrSection.style.display = 'block';
        usedDrSection.classList.add('visible');
        usedDrSection.querySelectorAll('input').forEach(i => (i.disabled = false));
        
        basedUnitInput.style.display = 'flex';
        basedUnitInput.querySelector('label').style.opacity = '1';
        basedUnitInput.querySelector('input').disabled = false;
    }
}

function addInput(type) {
    let container;
    let maxGroups;
    let currentGroups;
    
    const containerMap = {
        'used': 'usedContainer',
        'bnew': 'bnewContainer',
        'invoice': 'drWithInvoiceContainer',
        'replacement': 'replacementContainer',
        'pullout': 'pulloutContainer',
        'dr-price': 'drWithPriceContainer',
        'used-dr': 'usedDrContainer'
    };
    
    container = document.getElementById(containerMap[type]);
    
    if (!container) return;
    
    const groupClasses = {
        'used': 'input-group-used',
        'bnew': 'input-group-bnew',
        'invoice': 'input-group-invoice',
        'replacement': 'input-group-replacement',
        'pullout': 'input-group-pullout',
        'dr-price': 'input-group-price',
        'used-dr': 'input-group-used-dr'
    };
    
    currentGroups = container.getElementsByClassName(groupClasses[type]).length;
    
    const maxLimits = {
        'used': 7,
        'bnew': 2,
        'invoice': 4,
        'replacement': 2,
        'pullout': 2,
        'dr-price': 5,
        'used-dr': 4
    };
    
    if (currentGroups >= maxLimits[type]) {
        alert(`You can only add up to ${maxLimits[type]} sets for this section.`);
        return;
    }
    
    const newGroup = document.createElement('div');
    newGroup.classList.add(groupClasses[type]);
    
    const templates = {
        'used': `
            <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
            <div class="flex-row">
                <div class="form-control"><label>Serial No.</label><input type="text" name="serial[]" placeholder="Enter Serial Number"></div>
                <div class="form-control"><label>MR Start</label><input type="text" oninput="formatPrice(this)" name="mr_start[]" placeholder="Enter MR Start"></div>
                <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="color_imp[]" placeholder="Enter Color Impression"></div>
                <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="black_imp[]" placeholder="Enter Black Impression"></div>
                <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="color_large_imp[]" placeholder="Enter Color Large Impression"></div>
            </div>`,
        'invoice': `
            <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
            <div class="flex-row">
                <div class="form-control"><label>Quantity</label><input type="text" oninput="formatPrice(this)" name="quantity[]" required placeholder="Enter Quantity"></div>
                <div class="form-control"><label>Unit Type</label><input type="text" name="unit_type[]" required placeholder="Enter Units"></div>
                <div class="form-control"><label>Item Description</label><input type="text" name="item_desc[]" required placeholder="Enter Item Description"></div>
            </div>`,
        'pullout': `
            <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
            <div class="flex-row">
                <div class="form-control"><label>Serial No.</label><input type="text" name="pullout_serial[]" placeholder="Enter Serial Number"></div>
                <div class="form-control"><label>MR End</label><input type="text" oninput="formatPrice(this)" name="pullout_mr_end[]" placeholder="Enter MR End"></div>
                <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_color_imp[]" placeholder="Enter Color Impression"></div>
                <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_black_imp[]" placeholder="Enter Black Impression"></div>
                <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_color_large_imp[]" placeholder="Enter Color Large Impression"></div>
            </div>`,
        'replacement': `
            <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
            <div class="flex-row">
                <div class="form-control"><label>Serial No.</label><input type="text" name="replace_serial[]" placeholder="Enter Serial Number"></div>
                <div class="form-control"><label>MR Start</label><input type="text" oninput="formatPrice(this)" name="replace_mr_start[]" placeholder="Enter MR Start"></div>
                <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="replace_color_imp[]" placeholder="Enter Color Impression"></div>
                <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="replace_black_imp[]" placeholder="Enter Black Impression"></div>
                <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="replace_color_large_imp[]" placeholder="Enter Color Large Impression"></div>
            </div>`,
        'dr-price': `
            <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
            <div class="flex-row">
                <div class="form-control"><label>Quantity</label><input type="text" oninput="formatPrice(this)" name="quantity[]" required placeholder="Enter Quantity"></div>
                <div class="form-control"><label>Price</label><input oninput="formatPrice(this)" type="text" name="price[]" required placeholder="Enter Price"></div>
                <div class="form-control"><label>Unit Type</label><input type="text" name="unit_type[]" required placeholder="Enter Unit Type"></div>
                <div class="form-control"><label>Item Description</label><input type="text" name="item_desc[]" required placeholder="Enter Item Description"></div>
            </div>`,
        'used-dr': `
            <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
            <div class="flex-row">
                <div class="form-control"><label>Quantity</label><input type="text" oninput="formatPrice(this)" name="quantity[]" required placeholder="Enter Quantity"></div>
                <div class="form-control"><label>Unit Type</label><input type="text" name="unit_type[]" required placeholder="Enter Unit Type"></div>
                <div class="form-control"><label>Item Description</label><input type="text" name="item_desc[]" required placeholder="Enter Item Description"></div>
            </div>`,
        'bnew': `
            <button type="button" class="btn-remove" onclick="removeGroup(this)">✖</button>
            <div class="flex-row">
                <div class="form-control"><label>Machine Model</label><input type="text" name="model[]" required placeholder="Enter Machine Model"></div>
                <div class="form-control"><label>Serial No.</label><input type="text" class="serialInput" name="serial[]" placeholder="Enter Serial Number"></div>
            </div>`
    };
    
    newGroup.innerHTML = templates[type] || '';
    container.appendChild(newGroup);
    
    if (type === 'bnew') {
        updateSerialCountDisplay();
    }
}

let machineModelCount = 0;
let totalGlobalSerialsCount = 0;

function countAllSerials() {
    const replacementOnlyContainer = document.getElementById('replacementOnlyContainer');
    const pulloutOnlyContainer = document.getElementById('pulloutOnlyContainer');
    let totalSerials = 0;

    if (replacementOnlyContainer) {
        const allModelGroups = replacementOnlyContainer.getElementsByClassName('machine-model-group');
        for (let modelGroup of allModelGroups) {
            const serialsContainer = modelGroup.querySelector('.serials-container');
            if (serialsContainer) {
                const serialGroups = serialsContainer.getElementsByClassName('serial-group');
                totalSerials += serialGroups.length;
            }
        }
    }

    if (pulloutOnlyContainer) {
        const allModelGroups = pulloutOnlyContainer.getElementsByClassName('machine-model-group');
        for (let modelGroup of allModelGroups) {
            const serialsContainer = modelGroup.querySelector('.serials-container');
            if (serialsContainer) {
                const serialGroups = serialsContainer.getElementsByClassName('serial-group');
                totalSerials += serialGroups.length;
            }
        }
    }
    
    totalGlobalSerialsCount = totalSerials;
    return totalSerials;
}

function addMachineModel(containerId, arrayName = null) {
    const container = document.getElementById(containerId);
    const currentModels = container.getElementsByClassName('machine-model-group').length;

    if (currentModels >= maxMachineModels) {
        alert(`You can only add up to ${maxMachineModels} machine models.`);
        return;
    }
    
    const arrayNameToUse = arrayName || (containerId === 'replacementOnlyContainer' ? 'replace_only_machines' : 'pullout_machines');

    const newModelGroup = document.createElement('div');
    newModelGroup.className = 'machine-model-group';
    newModelGroup.innerHTML = `
        <button type="button" class="machine-model-remove" onclick="removeMachineModel(this)">✖ Remove Model</button>
        <div class="machine-model-header">
            <div class="form-control">
                <label>Machine Model</label>
                <input type="text" name="${arrayNameToUse}[${machineModelCount}][model]" required placeholder="Enter Machine Model">
            </div>
            <button type="button" class="btn-add add-serial-btn" onclick="addSerialToModel(this)">➕ Add Serial</button>
        </div>
        <div class="serials-container">
        </div>
    `;

    container.appendChild(newModelGroup);
    machineModelCount++;
}

function addSerialToModel(button) {
    const machineModelGroup = button.closest('.machine-model-group');
    const serialsContainer = machineModelGroup.querySelector('.serials-container');
    const currentSerials = serialsContainer.getElementsByClassName('serial-group').length;
    const modelInput = machineModelGroup.querySelector('input[name*="[model]"]');
    const modelName = modelInput.name;
    const modelIndex = modelName.match(/\[(\d+)\]/)[1];
    const arrayNameMatch = modelName.match(/^([^\[]+)\[(\d+)\]\[model\]$/);
    
    if (!arrayNameMatch) return;
    
    const arrayName = arrayNameMatch[1];
    const totalSerials = countAllSerials();

    if (currentSerials >= maxSerialsPerModel) {
        alert(`You can only add up to ${maxSerialsPerModel} serial numbers per machine model.`);
        return;
    }

    if (totalSerials >= maxSerialsPerModel) {
        alert(`You can only add up to ${maxSerialsPerModel} serial numbers per machine model.`);
        return;
    }

    const newSerialGroup = document.createElement('div');
    newSerialGroup.className = 'serial-group';

    if (arrayName === 'replace_only_machines') {
        newSerialGroup.innerHTML = `
            <button type="button" class="btn-remove" onclick="removeSerialGroup(this)">✖</button>
            <div class="flex-row-serial">
                <div class="form-control"><label>Serial No.</label><input type="text" name="replace_only_machines[${modelIndex}][serials][${currentSerials}][serial]" placeholder="Enter Serial Number"></div>
                <div class="form-control"><label>MR Start</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[${modelIndex}][serials][${currentSerials}][mr_start]" placeholder="Enter MR Start"></div>
                <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[${modelIndex}][serials][${currentSerials}][color_imp]" placeholder="Enter Color Impression"></div>
                <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[${modelIndex}][serials][${currentSerials}][black_imp]" placeholder="Enter Black Impression"></div>
                <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="replace_only_machines[${modelIndex}][serials][${currentSerials}][color_large_imp]" placeholder="Enter Color Large Impression"></div>
            </div>
        `;
    } else if (arrayName === 'pullout_machines') {
        newSerialGroup.innerHTML = `
            <button type="button" class="btn-remove" onclick="removeSerialGroup(this)">✖</button>
            <div class="flex-row-serial">
                <div class="form-control"><label>Serial No.</label><input type="text" name="pullout_machines[${modelIndex}][serials][${currentSerials}][serial]" placeholder="Enter Serial Number"></div>
                <div class="form-control"><label>MR End</label><input type="text" oninput="formatPrice(this)" name="pullout_machines[${modelIndex}][serials][${currentSerials}][mr_end]" placeholder="Enter MR End"></div>
                <div class="form-control"><label>Color Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_machines[${modelIndex}][serials][${currentSerials}][color_imp]" placeholder="Enter Color Impression"></div>
                <div class="form-control"><label>Black Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_machines[${modelIndex}][serials][${currentSerials}][black_imp]" placeholder="Enter Black Impression"></div>
                <div class="form-control"><label>Color Large Impression</label><input type="text" oninput="formatPrice(this)" name="pullout_machines[${modelIndex}][serials][${currentSerials}][color_large_imp]" placeholder="Enter Color Large Impression"></div>
            </div>
        `;
    }

    serialsContainer.appendChild(newSerialGroup);
    totalGlobalSerialsCount++;
}

function removeSerialGroup(button) {
    if (confirm('Are you sure you want to remove this serial?')) {
        const serialGroup = button.closest('.serial-group');
        serialGroup.remove();
        if (totalGlobalSerialsCount > 0) {
            totalGlobalSerialsCount--;
        }
        reindexSerialsInModel(serialGroup.closest('.machine-model-group'));
    }
}

function removeMachineModel(button) {
    if (confirm('Are you sure you want to remove this machine model and all its serials?')) {
        const machineModelGroup = button.closest('.machine-model-group');
        const serialsContainer = machineModelGroup.querySelector('.serials-container');
        let serialsInThisModel = 0;
        
        if (serialsContainer) {
            serialsInThisModel = serialsContainer.getElementsByClassName('serial-group').length;
        }
        
        machineModelGroup.remove();
        
        if (machineModelCount > 0) {
            machineModelCount--;
        }
        
        if (totalGlobalSerialsCount >= serialsInThisModel) {
            totalGlobalSerialsCount -= serialsInThisModel;
        } else {
            totalGlobalSerialsCount = 0;
        }
        
        reindexAllModelsAndSerials();
    }
}

function reindexSerialsInModel(modelGroup) {
    const serialsContainer = modelGroup.querySelector('.serials-container');
    if (!serialsContainer) return;
    
    const serialGroups = serialsContainer.getElementsByClassName('serial-group');
    const modelInput = modelGroup.querySelector('input[name*="[model]"]');
    const modelName = modelInput.name;
    const arrayNameMatch = modelName.match(/^([^\[]+)\[(\d+)\]\[model\]$/);
    
    if (!arrayNameMatch) return;
    
    const arrayName = arrayNameMatch[1];
    const modelIndex = arrayNameMatch[2];
    
    for (let i = 0; i < serialGroups.length; i++) {
        const serialGroup = serialGroups[i];
        const inputs = serialGroup.querySelectorAll('input');
        
        inputs.forEach(input => {
            const oldName = input.name;
            const newName = oldName.replace(/serials\[\d+\]/, `serials[${i}]`);
            input.name = newName;
        });
    }
}

function reindexAllModelsAndSerials() {
    const containers = [
        { id: 'replacementOnlyContainer', array: 'replace_only_machines' },
        { id: 'pulloutOnlyContainer', array: 'pullout_machines' }
    ];
    
    let newModelCount = 0;
    
    containers.forEach(containerInfo => {
        const container = document.getElementById(containerInfo.id);
        if (!container) return;
        
        const modelGroups = container.getElementsByClassName('machine-model-group');
        
        for (let i = 0; i < modelGroups.length; i++) {
            const modelGroup = modelGroups[i];
            const modelInput = modelGroup.querySelector('input[name*="[model]"]');
            
            if (modelInput) {
                modelInput.name = `${containerInfo.array}[${newModelCount}][model]`;
            }
            
            const serialsContainer = modelGroup.querySelector('.serials-container');
            if (serialsContainer) {
                const serialGroups = serialsContainer.getElementsByClassName('serial-group');
                for (let j = 0; j < serialGroups.length; j++) {
                    const serialGroup = serialGroups[j];
                    const inputs = serialGroup.querySelectorAll('input');
                    
                    inputs.forEach(input => {
                        const oldName = input.name;
                        const newName = oldName
                            .replace(new RegExp(`${containerInfo.array}\\[\\d+\\]`), `${containerInfo.array}[${newModelCount}]`)
                            .replace(/serials\[\d+\]/, `serials[${j}]`);
                        input.name = newName;
                    });
                }
            }
            
            newModelCount++;
        }
    });
    
    machineModelCount = newModelCount;
}

function removeGroup(button) {
    button.parentNode.remove();
    updateSerialCountDisplay();
}

document.addEventListener("DOMContentLoaded", function() {
    const selectFirst = document.getElementById('machineTypeSelect');
    const selectSecond = document.getElementById('pulloutReplacementTypeSelect');

    const firstVal = selectFirst.value || '';
    const secondVal = selectSecond ? selectSecond.value : '';

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