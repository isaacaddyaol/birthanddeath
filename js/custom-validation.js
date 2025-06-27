// Function to validate text-only input
function validateTextOnly(event) {
    // Allow backspace, delete, arrow keys, home, end
    if (event.keyCode === 8 || event.keyCode === 46 || (event.keyCode >= 35 && event.keyCode <= 40)) {
        return true;
    }
    
    // Allow space
    if (event.keyCode === 32) {
        return true;
    }

    // Block any non-letter character
    if (event.key.length === 1 && !/^[A-Za-z\s]$/.test(event.key)) {
        event.preventDefault();
        return false;
    }
    
    return true;
}

// Function to clean existing text (remove numbers and special characters)
function cleanTextInput(input) {
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
}

// Function to initialize text-only fields
function initializeTextOnlyFields() {
    // Get all input fields with the text-only class
    const textOnlyFields = document.querySelectorAll('.text-only');
    
    textOnlyFields.forEach(field => {
        // Clean existing value
        cleanTextInput(field);
        
        // Add event listeners
        field.addEventListener('keydown', validateTextOnly);
        field.addEventListener('paste', function(e) {
            e.preventDefault();
            // Get pasted text and clean it
            const pastedText = (e.clipboardData || window.clipboardData).getData('text');
            const cleanedText = pastedText.replace(/[^A-Za-z\s]/g, '');
            // Insert cleaned text
            document.execCommand('insertText', false, cleanedText);
        });
        
        // Add blur event to clean any invalid characters that might have slipped through
        field.addEventListener('blur', function() {
            cleanTextInput(this);
        });
    });
} 