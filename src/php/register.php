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

    if (!empty($data['username']) && !empty($data['password']) && !empty($data['cpassword'])) {
        $username = $data['username'];
        $password = $data['password'];
        $cpassword = $data['cpassword'];

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $checkQuery = "SELECT * FROM user WHERE username = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $res['error'] = true;
            $res['message'] = "Username already exists";
        } else {
            if(strlen($password) < 8) {
                $res['error'] = true;
                $res['message'] = "Password must be at least 8 characters long";
            } elseif (!preg_match("/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9]).{8,}$/", $password)) {
                $res['error'] = true;
                $res['message'] = "Password must contain at least one number, one alphabet, and one special character";
            } elseif ($password !== $cpassword) {
                $res['error'] = true;
                $res['message'] = "Passwords do not match";
            } else {
                $insertQuery = "INSERT INTO user (username, password) VALUES (?, ?)";
                $stmt = $conn->prepare($insertQuery);
                $stmt->bind_param("ss", $username, $hashed_password);
                if ($stmt->execute()) {
                    $res['error'] = false;
                    $res['message'] = "Registration successful";
                } else {
                    $res['error'] = true;
                    $res['message'] = "Registration failed";
                }
            }
        }
    } else {
        $res['error'] = true;
        $res['message'] = "Please provide all required fields";
    }
}

$conn->close();
header("Content-type: application/json");
echo json_encode($res);
?>
