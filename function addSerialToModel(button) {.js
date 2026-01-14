function addSerialToModel(button) {
    const modelGroup = button.closest('.machine-model-group');
    const serialsContainer = modelGroup.querySelector('.serials-container');
    const baseName = button.closest('.machine-model-group').querySelector('input[name*="[model]"]').name;
    
    // Extract the base name and index
    const match = baseName.match(/(.*)\[\d+\]\[model\]/);
    const baseNamePrefix = match ? match[1] : 'replace_only_machines';
    const modelIndexMatch = baseName.match(/\[(\d+)\]\[model\]/);
    const modelIndex = modelIndexMatch ? modelIndexMatch[1] : '0';
    
    const serialGroups = serialsContainer.querySelectorAll('.serial-group');
    const serialIndex = serialGroups.length;
    
    const newSerialGroup = document.createElement('div');
    newSerialGroup.className = 'serial-group';
    newSerialGroup.innerHTML = `
        <div class="flex-row-serial">
            <div class="form-control">
                <label>Serial No.</label>
                <input type="text" name="${baseNamePrefix}[${modelIndex}][serials][${serialIndex}][serial]" placeholder="Enter Serial Number">
            </div>
            <div class="form-control">
                <label>MR Start</label>
                <input type="text" oninput="formatPrice(this)" name="${baseNamePrefix}[${modelIndex}][serials][${serialIndex}][mr_start]" placeholder="Enter MR Start">
            </div>
            <div class="form-control">
                <label>Color Impression</label>
                <input type="text" oninput="formatPrice(this)" name="${baseNamePrefix}[${modelIndex}][serials][${serialIndex}][color_imp]" placeholder="Enter Color Impression">
            </div>
            <div class="form-control">
                <label>Black Impression</label>
                <input type="text" oninput="formatPrice(this)" name="${baseNamePrefix}[${modelIndex}][serials][${serialIndex}][black_imp]" placeholder="Enter Black Impression">
            </div>
            <div class="form-control">
                <label>Color Large Impression</label>
                <input type="text" oninput="formatPrice(this)" name="${baseNamePrefix}[${modelIndex}][serials][${serialIndex}][color_large_imp]" placeholder="Enter Color Large Impression">
            </div>
        </div>
    `;
    
    serialsContainer.appendChild(newSerialGroup);
}