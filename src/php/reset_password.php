<?php
session_start();
include "db.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$res = array('error'=> false);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!empty($data['username']) && !empty($data['password'])) {
        $username = $data['username'];
        $password = $data['password'];

        // Password validation
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/', $password)) {
            $res['error'] = true;
            $res['message'] = "Password must be at least 8 characters long and contain at least one letter, one number, and one special character.";
            echo json_encode($res);
            exit();
        }

        // Check if username exists
        $checkQuery = "SELECT * FROM user WHERE username = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $res['error'] = true;
            $res['message'] = "Username does not exist";
            echo json_encode($res);
            exit(); // Exit script if username doesn't exist
        }

        // Hash the new password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $updateQuery = "UPDATE user SET password = ? WHERE username = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ss", $hashed_password, $username);

        if ($stmt->execute()) {
            $res['error'] = false;
            $res['message'] = "Password reset successful";
        } else {
            $res['error'] = true;
            $res['message'] = "Password reset failed";
        }
    } else {
        $res['error'] = true;
        $res['message'] = "Please provide both username and new password";
    }
}

$conn->close();
header("Content-type: application/json");
echo json_encode($res);
?>
