<?php
date_default_timezone_set('Pacific/Auckland');

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

// mail("codingpain064@gmail.com", "New Booking Request", "$name has made a booking request.\n\n", "FROM: $email\n\n");

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

// Send a confirmation email
$mail = new PHPMailer(true);

try {
	$mail->isSMTP();
	$mail->Host = $_ENV['SMTP_HOST']; // Set the SMTP server to send through
	$mail->SMTPAuth = true;
	$mail->Username = $_ENV['SMTP_USERNAME']; // SMTP username
	$mail->Password = $_ENV['SMTP_PASSWORD']; // SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	$mail->Port = $_ENV['SMTP_PORT']; // TCP port to connect to

	// From and To
	$mail->setFrom('no-reply@chewieskitchen.com', "Chewbacca's Kitchen");
	$mail->addAddress($email, $name); // Add a recipient

	// Content
	$mail->isHTML(false); // Set email format to plain text
	$mail->Subject = "Thank you for your booking!";
	$mail->Body = "Hello $name,\n\n" .
					"Thank you for booking with us! Here are your booking details:\n" .
					"Date: $date\n" .
					"Time: $time\n" .
					"Guests: $guests\n" .
					"Special Requests: $requests\n\n" .
					"We look forward to seeing you!\n\n" .
					"- Chewbacca's Kitchen";


	$mail->send();
	echo json_encode(['status' => 'success', 'message' => 'Booking saved and confirmation email sent.']);
} catch (Exception $e) {
	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	// echo json_encode([
	// 	'status' => 'error', 
	// 	'message' => $e->getMessage()
	// ]);
} catch (Throwable $e) {
		echo json_encode([
		'status' => 'error',
		'message' => $e->getMessage()
	]);
}
