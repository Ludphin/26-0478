/*=========================================
    TURBO COMPANY - JAVASCRIPT
    Student Assignment
=========================================*/

// =========================
// Welcome Popup
// =========================
window.addEventListener("load", function () {
    alert("🚗 Welcome to Turbo Company!\n\nWe supply genuine Japanese spare parts.\n\nEnjoy browsing our products!");
});

// =========================
// Registration Form
// =========================
const form = document.querySelector("form");

if (form) {

    form.addEventListener("submit", function (event) {

        event.preventDefault();

        alert("✅ Thank you for registering!\n\nOur team will contact you shortly.");

        form.reset();

    });

}

// =========================
// Smooth Navigation
// =========================
document.querySelectorAll('nav a').forEach(link => {

    link.addEventListener('click', function(e){

        e.preventDefault();

        const target = document.querySelector(this.getAttribute('href'));

        if(target){

            target.scrollIntoView({

                behavior:'smooth'

            });

        }

    });

});

// =========================
// Footer Year
// =========================
const footer = document.querySelector("footer p");

if(footer){

    footer.innerHTML = "&copy; " + new Date().getFullYear() + " Turbo Company. All Rights Reserved.";

}

// =========================
// Console Message
// =========================
console.log("Turbo Company website loaded successfully.");