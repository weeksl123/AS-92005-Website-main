<!DOCTYPE html>
<html lang="en"> 
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Chewbacca's Kitchen</title>
		<link rel="icon" type="image/jpg" href="./chewbaccas-kitchen.jpg">
		<link rel="stylesheet" href="./styles.css">
		<script src="./script.js" defer></script>
	</head>
	<body>
		<main>
			<header id="home">
				<div id="header_container">
					<div id="header_text" class="header_column">
						<h1 id="header_h1">Welcome to Chewbacca's Kitchen</h1>
						<h3 id="header_h3">May the flavor be with you</h3>
					</div>
					<div id="header_img" class="header_column">
						<img id="header_logo" src="./chewbaccas-kitchen.png" alt="Chewbacca's Kitchen Logo">
					</div>
				</div>
			</header>
			<div class="topnav">
				<a href="./index.html">Home</a>
				<a href="./menu.html">Menu</a>
				<a href="./contact.html">Contact</a>
				<a href="./about.html">About</a>
				<button id="booking_button">Book a Table</button>
			</div>
            <h1>Thanks for your booking!</h1>
			<h2>We have received your booking and will be awaiting you when you arrive.</h2>
        </main>
        <footer>
			<div class="footer-column" id="footer-links">
				<a class="footer-link" href="./policies.html">Privacy Policy</a><br>
				<a class="footer-link" href="./policies.html">Cookie Policy</a><br>
				<a class="footer-link" href="./policies.html">Terms of Service</a>
			</div>
			<div class="footer-column" id="footer-main">
				<p class="footer_txt">Chewbacca's Kitchen Ltd, PO Box 1234, Cherrywood, Tauranga, NZ | Phone: 0800123456 <br> 
				© ChewBaccas 2025. All rights reserved.</p>
			</div>
		</footer>
    </body>
</html>

<?php
date_default_timezone_set('Pacific/Auckland');

header('content-type: application/json');

//Collect data from the form

// For php 5.4
$name = $_POST['name'] ?: '';
$email = $_POST['email'] ?: '';
$date = $_POST['date'] ?: '';
$time = $_POST['time'] ?: '';
$guests = $_POST['guests'] ?: '';
$requests = $_POST['requests'] ?: '';

//For php 7+
//$name = $_POST['name'] ?? '';
// $email = $_POST['email'] ?? '';
// $date = $_POST['date'] ?? '';
// $time = $_POST['time'] ?? '';
// $guests = $_POST['guests'] ?? '';
// $requests = $_POST['requests'] ?? '';

if (empty($name) || empty($email) || empty($date) || empty($time) || empty($guests)) {
	echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
	exit;
}

// Save the booking to a file
$file = 'data/bookings.txt';
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

$line = str_pad(date('d-m-y H:i'), 20) . 
		str_pad($name, 25) . 
		str_pad($email, 35) . 
		str_pad($date, 12) .
		str_pad($time, 10) .
		str_pad($guests, 8) . 
		$requests . "\n";

file_put_contents($file, $line, FILE_APPEND);

// Get info from dotenv file
function loadEnv($path)
{
	if (!file_exists($path)) {
		return;
	}

	$lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lines as $line) {
		if (strpos(trim($line), '#') === 0) {
			continue; // Skip comments
		}
		list($name, $value) = explode('=', $line, 2);
		$name = trim($name);
		$value = trim($value);
		$_ENV[$name] = $value;
		putenv("$name=$value");
	}
}
// Load environment variables
loadEnv(__DIR__ . '/.env');
