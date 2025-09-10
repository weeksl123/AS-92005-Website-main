<!DOCTYPE html>
	<html lang="en"> 
		<head>
			<!-- Metadata about the document -->
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Chewbacca's Kitchen</title>
			<link rel="icon" type="image/jpg" href="./images/chewbaccas-kitchen.jpg">
			<link rel="stylesheet" href="./styles.css">
			<script src="./script.js" defer></script>
		</head>
		<body>
			<main>
				<!--Header container to hold header text and logo-->
				<header id="home">
					<div id="header_container">
						<div id="header_text" class="header_column">
							<h1 id="header_h1">Welcome to Chewbacca's Kitchen</h1>
							<h3 id="header_h3">May the flavor be with you</h3>
						</div>
						<div id="header_img" class="header_column">
							<a href="./index.html"><img id="header_logo" src="./images/chewbaccas-kitchen.png" alt="Chewbacca's Kitchen Logo"></a>
						</div>
					</div>
				</header>
				<!--Navigation bar-->
				<div class="topnav">
					<a href="./index.html">Home</a>
					<a href="./menu.html">Menu</a>
					<a href="./contact.html">Contact</a>
					<a href="./about.html">About</a>
					<button id="booking_button">Book a Table</button>
				</div>
<?php
// Set the timezone
date_default_timezone_set('Pacific/Auckland');

//Collect data from the form

// For php 5.4
$name = $_POST['name'] ?: '';
$email = $_POST['email'] ?: '';
$date = $_POST['date'] ?: '';
$time = $_POST['time'] ?: '';
$guests = $_POST['guests'] ?: '';
$requests = $_POST['special_requests'] ?: '';

//For php 7+
//$name = $_POST['name'] ?? '';
// $email = $_POST['email'] ?? '';
// $date = $_POST['date'] ?? '';
// $time = $_POST['time'] ?? '';
// $guests = $_POST['guests'] ?? '';
// $requests = $_POST['special_requests'] ?? '';

$success = false;

// Validate and save the booking
if (!empty($name) && !empty($email) && !empty($date) && !empty($time) && !empty($guests)) {
	$file = 'data/bookings.txt';
	// Create the file with headings if it doesn't exist
	if (!file_exists($file)) {
		$heading =  str_pad("Date/Time Booked", 20) . 
					str_pad("Name", 25) . 
					str_pad("Email", 35) . 
					str_pad("Date", 12) . 
					str_pad("Time", 10) .
					str_pad("Guests", 8) . 
					"Special Requests\n";
		file_put_contents($file, $heading);
		file_put_contents($file, str_repeat("-", 130) . "\n", FILE_APPEND);
	}

	// Format the date to dd-mm-yyyy
	$date = date('d-m-Y', strtotime($date));

	// Prepare the line to be saved
	$line = str_pad(date('d-m-y H:i'), 20) . 
			str_pad($name, 25) . 
			str_pad($email, 35) . 
			str_pad($date, 12) .
			str_pad($time, 10) .
			str_pad($guests, 8) . 
			$requests . "\n";

	// Append the line to the file
	file_put_contents($file, $line, FILE_APPEND);

	$success = true;
} else {
	echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
	exit;
}
// Only display success message if booking was saved successfully otherwise display error message
if ($success) { 
	?>
		<h1>Thanks for your booking!</h1>
		<h2>We have received your booking and will be awaiting you when you arrive.</h2>
	<?php
} else {
	?>
		<h1>Oops! Something went wrong.</h1>
		<h2>Very sorry about that! Please try again later.</h2>
<?php
}
?>
			</main>
			<footer>
				<!--Add links to policies page in footer-->
				<div class="footer-column" id="footer-links">
					<a class="footer-link" href="./policies.html">Privacy Policy</a><br>
					<a class="footer-link" href="./policies.html">Cookie Policy</a><br>
					<a class="footer-link" href="./policies.html">Terms of Service</a>
				</div>
				<!--Add main footer content-->
				<div class="footer-column" id="footer-main">
					<p class="footer_txt">Chewbacca's Kitchen Ltd, PO Box 1234, Cherrywood, Tauranga, NZ | Phone: 0800123456 <br> 
					&copy; ChewBaccas 2025. All rights reserved.</p>
				</div>
			</footer>
		</body>
	</html>