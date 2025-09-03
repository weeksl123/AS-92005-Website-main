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

var today = new Date()
var day = today.getDate()
var month = today.getMonth() + 1
var year = today.getFullYear()

if (day < 10) {
    day = '0' + (day + 1)
}

if (month < 10) {
    month = '0' + month
}

today = year + '-' + month + '-' + day
document.getElementById("date").setAttribute("min", today)
