/*=========================================
 TURBO COMPANY - JAVASCRIPT
 Student: __________________
=========================================*/

// Popup Message
window.onload = function () {
    alert("🚗 Welcome to Turbo Company!\n\nYour trusted supplier of genuine Japanese spare parts.\n\nBrowse our products and register today!");
};

// Display current year in the footer
const year = new Date().getFullYear();

const footer = document.querySelector("footer p");

if (footer) {
    footer.innerHTML = "&copy; " + year + " Turbo Company. All Rights Reserved.";
}

// Display a message after form submission
const form = document.querySelector("form");

if (form) {

    form.addEventListener("submit", function (event) {

        event.preventDefault();

        alert("✅ Registration Successful!\n\nThank you for registering with Turbo Company.");

        form.reset();

    });

}

// Log a message in the browser console
console.log("Turbo Company Website Loaded Successfully");
