// Automatically show the premium pop-up modal when the website loads
window.addEventListener('DOMContentLoaded', () => {
    const popup = document.getElementById('premiumPopup');
    if (popup) {
        popup.classList.add('active');
    }
});

// Hide the pop-up overlay and smooth scroll to the registration form
function closePopup() {
    const popup = document.getElementById('premiumPopup');
    if (popup) {
        popup.classList.remove('active');
    }
    
    // Smoothly jump down to the updated registration form
    const registerSection = document.getElementById('register');
    if (registerSection) {
        registerSection.scrollIntoView({ behavior: 'smooth' });
    }
}