document.getElementById("booking_button").addEventListener("click", function() {
    window.location.href = "./booking.html";
}); 


document.querySelectorAll(".dropdown").forEach(dropdown => {
    const header = dropdown.querySelector(".dropdown-header");
    const toggleBtn = dropdown.querySelector(".toggle-btn");
        
    header.addEventListener("click", () => {
        dropdown.classList.toggle("active");

        toggleBtn.textContent = dropdown.classList.contains("active") ? "x" : "+";
    });
});
