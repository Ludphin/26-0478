// Automatically trigger the premium alert modal window on page load
window.addEventListener('DOMContentLoaded', () => {
    const popup = document.getElementById('premiumPopup');
    if (popup) {
        popup.classList.add('active');
    }
});

// Remove the pop-up display clear out of the way
function closePopup() {
    const popup = document.getElementById('premiumPopup');
    if (popup) {
        popup.classList.remove('active');
    }
}