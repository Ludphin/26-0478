// Show welcome popup when page loads
window.addEventListener('DOMContentLoaded', function () {
    var popup = document.getElementById('welcomePopup');
    if (popup) {
        popup.classList.add('active');
    }
});

function closePopup() {
    var popup = document.getElementById('welcomePopup');
    if (popup) {
        popup.classList.remove('active');
    }
}

// Close popup when clicking outside the box
window.addEventListener('click', function (event) {
    var popup = document.getElementById('welcomePopup');
    if (popup && event.target === popup) {
        closePopup();
    }
});

// Handle registration form submission
function handleRegistration(event) {
    event.preventDefault();

    var name = document.getElementById('regName').value.trim();
    var email = document.getElementById('regEmail').value.trim();
    var phone = document.getElementById('regPhone').value.trim();
    var genderInput = document.querySelector('input[name="gender"]:checked');
    var gender = genderInput ? genderInput.value : '';

    if (!name || !email || !phone || !gender) {
        alert('Please fill in all fields, including gender, before submitting.');
        return false;
    }

    alert('Thank you, ' + name + '! Your registration has been received.');
    document.getElementById('registrationForm').reset();
    return false;
}
