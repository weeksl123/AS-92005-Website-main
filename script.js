document.getElementById("booking_button").addEventListener("click", function() {
    window.location.href = "./booking.html";
}); 

// document.getElementById("booking_form").addEventListener("submit", async function(e) {
//     e.preventDefault();

//     const formData = new FormData(this);

//    try {
//        const response = await fetch('save_booking.php', {
//            method: "POST",
//            body: formData
//        });

//        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

//        const result = await response.json();
//        alert(result.message || "Booked successfully!");
//    } catch (error) {
//        console.error("Error during booking:", error);
//        alert("Error during booking:", error);
//    }
// });
