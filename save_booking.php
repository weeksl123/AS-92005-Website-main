<?php
date_default_timezone_set('Pacific/Auckland');

header('content-type: application/json');

//Collect data from the form
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$date = $_POST['date'] ?? '';
$time = $_POST['time'] ?? '';
$guests = $_POST['guests'] ?? '';
$requests = $_POST['special_requests'] ?? '';

if (empty($name) || empty($email) || empty($date) || empty($time) || empty($guests)) {
	echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
	exit;
}

// Save the booking to a file
$file = 'bookings.txt';
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
