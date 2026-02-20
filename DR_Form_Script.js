const BASE_MAX_SERIALS = 21;
const maxLimitAll = 7;
let currentMaxSerials = BASE_MAX_SERIALS;
const maxGroupsUsed = 7;
// const maxGroupsBnew = 2;
const maxMachineModels = 5;
const maxSerialsPerModel = 7;

// ===== AJAX DUPLICATE DR NUMBER CHECK =====
let isDRNumberValid = true;
let drCheckTimeout;

function checkDRNumberDuplicate(drNumber) {
    // Clear previous timeout
    clearTimeout(drCheckTimeout);
    
    const drInput = document.querySelector('input[name="dr_number"]');
    const statusElement = document.getElementById('dr-check-status');
    
    // Remove old status message if exists
    if (statusElement) {
        statusElement.remove();
    }
    
    // Create status message container
    const status = document.createElement('div');
    status.id = 'dr-check-status';
    status.style.cssText = 'margin-top: 8px; padding: 10px 15px; border-radius: 4px; font-size: 11.5px; font-weight: 500; display: inline-block;';
    
    // Validate input
    if (!drNumber || drNumber.trim() === '') {
        isDRNumberValid = true;
        drInput.style.borderColor = '#ddd';
        drInput.style.boxShadow = 'none';
        return;
    }
    
    // Show loading state
    status.textContent = 'Checking DR Number...';
    status.style.backgroundColor = '#e3f2fd';
    status.style.color = '#1976d2';
    status.style.border = '1px solid #90caf9';
    drInput.parentElement.appendChild(status);
    
    // Debounce the AJAX call (wait 500ms after user stops typing)
    drCheckTimeout = setTimeout(() => {
        fetch('check_dr_duplicate.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'dr_number=' + encodeURIComponent(drNumber)
        })
        .then(response => response.json())
        .then(data => {
            const status = document.getElementById('dr-check-status');
            
            if (data.exists) {
                // Duplicate found
                isDRNumberValid = false;
                drInput.style.borderColor = '#e74c3c';
                drInput.style.boxShadow = '0 0 0 3px rgba(231, 76, 60, 0.1)';
                
                status.innerHTML = `<h5><strong>⚠ Duplicate DR Number!</strong><br>This DR Number (${data.dr_number}) already exists in the database.</h5>`;
                status.style.backgroundColor = '#ffe6e6';
                status.style.color = '#c53030';
                status.style.border = '1px solid #e74c3c';
            } else {
                // No duplicate
                isDRNumberValid = true;
                drInput.style.borderColor = '#27ae60';
                drInput.style.boxShadow = '0 0 0 3px rgba(39, 174, 96, 0.1)';
                
                
                status.innerHTML = '<h5>✓ DR Number is available</h5>';
                status.style.backgroundColor = '#e8f5e9';
                status.style.color = '#27ae60';
                status.style.border = '1px solid #27ae60';
            }
        })
        .catch(error => {
            console.error('Error checking DR Number:', error);
            const status = document.getElementById('dr-check-status');
            status.textContent = 'Error checking DR Number. Please try again.';
            status.style.backgroundColor = '#fff3cd';
            status.style.color = '#856404';
            status.style.border = '1px solid #ffc107';
            isDRNumberValid = false;
        });
    }, 500); // Wait 500ms after user stops typing
}

function validateDRNumberOnSubmit() {
    const drNumber = document.querySelector('input[name="dr_number"]').value;
    
    if (!drNumber || drNumber.trim() === '') {
        alert('Please enter a DR Number.');
        return false;
    }
    
    if (!isDRNumberValid) {
        alert('Cannot submit: Duplicate DR Number found! Please use a different DR Number.');
        document.querySelector('input[name="dr_number"]').focus();
        return false;
    }
    
    return true;
}

// ===== END AJAX DUPLICATE DR NUMBER CHECK =====

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

// Function to count how many machine models are currently in the bnew section
function countMachineModels() {
    const container = document.getElementById('bnewContainer');
    if (!container) return 0;
    return container.getElementsByClassName('input-group-bnew').length;
}

// Update the max serials based on machine models count
function updateMaxSerials() {
    const machineModelCount = countMachineModels();
    // Each machine model reduces max serials by 3
    currentMaxSerials = BASE_MAX_SERIALS - (machineModelCount * 3);
    
    // Ensure it doesn't go below 0
    if (currentMaxSerials < 0) {
        currentMaxSerials = 0;
    }
    
    // Update the display
    updateSerialCountDisplay();
    
    return currentMaxSerials;
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
        counter.textContent = `Total Serials: ${total} / ${currentMaxSerials}`;
        counter.style.color = total >= currentMaxSerials ? '#e74c3c' : '#2c3e50';
        
        // Add a warning when approaching the limit
        if (total >= currentMaxSerials) {
            counter.style.backgroundColor = '#ffe6e6';
            counter.style.border = '1px solid #ff9999';
        } else if (total >= currentMaxSerials - 3) {
            counter.style.backgroundColor = '#fff3cd';
            counter.style.border = '1px solid #ffc107';
        } else {
            counter.style.backgroundColor = '#f8f9fa';
            counter.style.border = '1px solid #dee2e6';
        }
    }
}

// Updated serial input handler
function handleSerialInput(e) {
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

        if (totalSerials > currentMaxSerials) {
            e.target.style.border = '2px solid #e74c3c';
            e.target.style.boxShadow = '0 0 0 3px rgba(231, 76, 60, 0.1)';
            
            const excess = totalSerials - currentMaxSerials;
            const allowedCount = currentSerials.length - excess;
            e.target.value = currentSerials.slice(0, allowedCount).join(', ');
            updateSerialCountDisplay();
        } else {
            e.target.style.border = '1px solid #ddd';
            e.target.style.boxShadow = 'none';
        }
    }
}

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

    const usedMachineNote = document.getElementById('note-main-used-machine');
    const invoiceNote = document.getElementById('note-main-invoice');

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

    usedMachineNote.classList.remove('visible');
    usedMachineNote.style.display = 'none';

    invoiceNote.classList.remove('visible');
    invoiceNote.style.display = 'none';

    if (selected === 'used') {
        usedSection.classList.add('visible');
        usedSection.style.display = 'block';
        usedSection.querySelectorAll('input').forEach(i => (i.disabled = false));
        
        basedUnitInput.style.display = 'flex';
        basedUnitInput.querySelector('label').style.opacity = '1';
        basedUnitInput.querySelector('input').disabled = false;

        usedMachineNote.classList.add('visible');
        usedMachineNote.style.display = 'block';

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

        invoiceNote.classList.add('visible');
        invoiceNote.style.display = 'block';
        
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

            usedMachineNote.classList.add('visible');
            usedMachineNote.style.display = 'block';

        } else if (secondarySelected === 'pulloutOnly') {
            pulloutOnlyContainer.style.display = 'block';
            pulloutOnlyContainer.querySelectorAll('input').forEach(i => (i.disabled = false));
            
            usedMachineNote.classList.add('visible');
            usedMachineNote.style.display = 'block';
        } else {
            pulloutReplaceSection.classList.add('visible');
            pulloutReplaceSection.style.display = 'block';
            pulloutReplaceSection.querySelectorAll('input').forEach(i => (i.disabled = false));

            usedMachineNote.classList.add('visible');
            usedMachineNote.style.display = 'block';

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
        'invoice': 4,
        'replacement': 2,
        'pullout': 2,
        'dr-price': 5,
        'used-dr': 4
    };

    if (type === 'bnew') {

        if(updateMaxSerials() <= 0) {
            alert(`You can only add up to ${maxGroupsBnew} machine models.`);
            return;
        }

    } else if (currentGroups > maxLimits[type]) {
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
        // Update max serials after adding machine model
        updateMaxSerials();
        updateSerialCountDisplay();
        
        // Add event listener to the new serial input
        const newSerialInput = newGroup.querySelector('.serialInput');
        newSerialInput.addEventListener('input', handleSerialInput);
    }
}

let machineModelCount = 1; // Start from 1 since we have one model input by default 
let totalGlobalSerialsCount = 1; // Start from 1 since we have one serial input by default in the first model

// Update the countAllSerials function to properly count
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

function addMachineModel(containerId, arrayName) {
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
    const group = button.closest('[class*="input-group-"]');
    const isBnew = group.classList.contains('input-group-bnew');
    
    if (isBnew) {
        group.remove();
        // Update max serials after removing machine model
        updateMaxSerials();
        updateSerialCountDisplay();
    } else {
        button.parentNode.remove();
        // For bnew, we need to update the count
        if (group.closest('#bnewMachineFields')) {
            updateSerialCountDisplay();
        }
    }
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
    
    // Add event listeners to existing serial inputs
    document.querySelectorAll('#bnewMachineFields .serialInput').forEach(input => {
        input.addEventListener('input', handleSerialInput);
    });
    
    // ===== DR NUMBER DUPLICATE CHECK =====
    const drInput = document.querySelector('input[name="dr_number"]');
    if (drInput) {
        // Check for duplicate when user types in DR Number field
        drInput.addEventListener('input', function() {
            checkDRNumberDuplicate(this.value);
        });
        
        // Optional: Check on blur as well
        drInput.addEventListener('blur', function() {
            if (this.value.trim() !== '') {
                checkDRNumberDuplicate(this.value);
            }
        });
    }
    
    // Validate DR Number on form submission
    const form = document.getElementById('myForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateDRNumberOnSubmit()) {
                e.preventDefault();
                return false;
            }
        });
    }
    // ===== END DR NUMBER DUPLICATE CHECK =====
    
    // Initial update of max serials
    updateMaxSerials();
});