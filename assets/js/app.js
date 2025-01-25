// Simple login check for demonstration (replace with actual logic later)
document.getElementById("login-form")?.addEventListener("submit", function(event) {
    event.preventDefault();
    localStorage.setItem("sign-in", true);
    window.location.href = "index.html";
});

document.getElementById("logout")?.addEventListener("click", function() {
    localStorage.removeItem("sign-in");
    window.location.href = "sign-in.html";
});

document.addEventListener("DOMContentLoaded", function() {
    if (!localStorage.getItem("sign-in")) {
        window.location.href = "sign-in.html";
    }
});
