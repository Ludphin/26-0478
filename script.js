// Automatically show the premium pop-up when the website finishes loading
window.addEventListener('DOMContentLoaded', () => {
    const popup = document.getElementById('premiumPopup');
    if (popup) {
        popup.classList.add('active');
    }
});

// Completely hide and remove the pop-up overlay out of the way
function closePopup() {
    const popup = document.getElementById('premiumPopup');
    if (popup) {
        popup.classList.remove('active');
    }
}