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
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Retrieve DELETE data
    $profileId = $_GET['id'];

    // Delete profile from database
    $sql = "DELETE FROM profiles WHERE id='$profileId'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Profile deleted successfully"));
    } else {
        echo json_encode(array("error" => "Error deleting profile: " . $conn->error));
    }
} elseif ($_POST["action"] == "add") {
    // Retrieve POST data for adding new profile
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $phoneNumber = $_POST['phone_number'];
    $email = $_POST['email'];

    // Validate input data
    if (empty($firstName) || empty($lastName) || empty($phoneNumber) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array("error" => "Invalid input data"));
        exit;
    }

    // Insert new profile into database
    $sql = "INSERT INTO profiles (first_name, last_name, phone_number, email) VALUES ('$firstName', '$lastName', '$phoneNumber', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "New profile added successfully"));
    } else {
        echo json_encode(array("error" => "Error adding profile: " . $conn->error));
    }
} elseif ($_POST["action"] == "edit") {
    // Check if all required fields are provided
    if (!isset($_POST['id']) || !isset($_POST['first_name']) || !isset($_POST['last_name']) || !isset($_POST['phone_number']) || !isset($_POST['email'])) {
        echo json_encode(array("error" => "Missing required fields"));
        exit;
    }

    // Sanitize input data
    $profileId = intval($_POST['id']);
    $firstName = htmlspecialchars($_POST['first_name']);
    $lastName = htmlspecialchars($_POST['last_name']);
    $phoneNumber = htmlspecialchars($_POST['phone_number']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Validate input data
    if (empty($firstName) || empty($lastName) || empty($phoneNumber) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array("error" => "Invalid input data"));
        exit;
    }

    // Update profile in database using prepared statement
    $sql = "UPDATE profiles SET first_name=?, last_name=?, phone_number=?, email=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $firstName, $lastName, $phoneNumber, $email, $profileId);

    if ($stmt->execute()) {
        // Fetch updated profile data from the database
        $updatedProfile = array();
        $selectSql = "SELECT * FROM profiles WHERE id='$profileId'";
        $result = $conn->query($selectSql);
        if ($result->num_rows > 0) {
            $updatedProfile = $result->fetch_assoc();
        }

        echo json_encode(array("message" => "Profile updated successfully", "profile" => $updatedProfile));
    } else {
        echo json_encode(array("error" => "Error updating profile"));
    }
} else {
    echo json_encode(array("error" => "Invalid request method"));
}

$conn->close();
?>
