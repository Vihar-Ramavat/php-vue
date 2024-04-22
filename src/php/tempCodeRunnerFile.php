<?php
session_start();
include "db.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM profiles";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $profiles = array();
        while ($row = $result->fetch_assoc()) {
            $profiles[] = $row;
        }
        echo json_encode($profiles);
    } else {
        echo json_encode(array("error" => "No profiles found"));
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $phoneNumber = $_POST['phone_number'];
    $email = $_POST['email'];

    // Insert new profile into database
    $sql = "INSERT INTO profiles (first_name, last_name, phone_number, email) VALUES ('$firstName', '$lastName', '$phoneNumber', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "New profile added successfully"));
    } else {
        echo json_encode(array("error" => "Error adding profile: " . $conn->error));
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {
    // Retrieve PUT data
    parse_str(file_get_contents("php://input"), $_PUT);
    $profileId = $_PUT['id'];
    $firstName = $_PUT['first_name'];
    $lastName = $_PUT['last_name'];
    $phoneNumber = $_PUT['phone_number'];
    $email = $_PUT['email'];

    // Update profile in database
    $sql = "UPDATE profiles SET first_name='$firstName', last_name='$lastName', phone_number='$phoneNumber', email='$email' WHERE id='$profileId'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Profile updated successfully"));
    } else {
        echo json_encode(array("error" => "Error updating profile: " . $conn->error));
    }
}elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Retrieve DELETE data
    $profileId = $_GET['id'];

    // Delete profile from database
    $sql = "DELETE FROM profiles WHERE id='$profileId'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Profile deleted successfully"));
    } else {
        echo json_encode(array("error" => "Error deleting profile: " . $conn->error));
    }
} else {
    echo json_encode(array("error" => "Invalid request method"));
}

$conn->close();
?>