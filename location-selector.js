// Function to load districts based on selected region
function loadDistricts(regionSelect, districtSelect) {
    const region = regionSelect.value;
    districtSelect.innerHTML = '<option value="">Select District</option>';
    
    if (!region) return;

    fetch('get_locations.php?type=districts&region=' + encodeURIComponent(region))
        .then(response => response.json())
        .then(districts => {
            districts.forEach(district => {
                const option = document.createElement('option');
                option.value = district;
                option.textContent = district;
                districtSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading districts:', error));
}

// Function to load towns based on selected region and district
function loadTowns(regionSelect, districtSelect, townSelect) {
    const region = regionSelect.value;
    const district = districtSelect.value;
    townSelect.innerHTML = '<option value="">Select Town</option>';
    
    if (!region || !district) return;

    fetch('get_locations.php?type=towns&region=' + encodeURIComponent(region) + '&district=' + encodeURIComponent(district))
        .then(response => response.json())
        .then(towns => {
            towns.forEach(town => {
                const option = document.createElement('option');
                option.value = town;
                option.textContent = town;
                townSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading towns:', error));
}

// Initialize location selectors
document.addEventListener('DOMContentLoaded', function() {
    const regionSelects = document.querySelectorAll('.region-select');
    const districtSelects = document.querySelectorAll('.district-select');
    const townSelects = document.querySelectorAll('.town-select');

    regionSelects.forEach((regionSelect, index) => {
        // Load initial districts if region is pre-selected
        if (regionSelect.value) {
            loadDistricts(regionSelect, districtSelects[index]);
        }

        // Add change event listener for region
        regionSelect.addEventListener('change', function() {
            loadDistricts(this, districtSelects[index]);
            townSelects[index].innerHTML = '<option value="">Select Town</option>';
        });

        // Add change event listener for district
        districtSelects[index].addEventListener('change', function() {
            loadTowns(regionSelect, this, townSelects[index]);
        });
    });
}); 