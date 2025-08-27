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
    day = '0' + day
}

if (month < 10) {
    month = '0' + month
}

today = year + '-' + month + '-' + day
document.getElementById("date").setAttribute("min", today)

var time = new Date().getTime()
var hours = new Date(time).getHours()
var minutes = new Date(time).getMinutes()

if (minutes < 10) {
    minutes = '0' + minutes
}

if (hours < 10) {
    hours = '0' + hours
}

today = hours + ':' + minutes
document.getElementById("time").setAttribute("min", today)
