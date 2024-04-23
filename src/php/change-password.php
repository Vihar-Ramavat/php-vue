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

    if (isset($data['currentPassword']) && isset($data['newPassword']) && isset($data['confirmNewPassword']) && isset($data['username'])) { 
        $currentPassword = $data['currentPassword'];
        $newPassword = $data['newPassword'];
        $confirmNewPassword = $data['confirmNewPassword'];
        $username = $data['username']; 

        // Retrieve user data from database
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            // Verify current password
            if (password_verify($currentPassword, $hashed_password)) {
                // Check if new password meets complexity requirements
                if (strlen($newPassword) >= 8 && preg_match('/[A-Za-z]/', $newPassword) && preg_match('/\d/', $newPassword) && preg_match('/[^A-Za-z\d]/', $newPassword)) {
                    // Ensure new password is different from current password
                    if ($newPassword !== $currentPassword) {
                        // Check if new password matches confirm new password
                        if ($newPassword === $confirmNewPassword) {
                            // Hash the new password
                            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                            
                            // Update password in the database
                            $updateQuery = "UPDATE user SET password = ? WHERE username = ?";
                            $stmt = $conn->prepare($updateQuery);
                            $stmt->bind_param("ss", $newHashedPassword, $username);
                            
                            if ($stmt->execute()) {
                                $res['error'] = false;
                                $res['message'] = "Password changed successfully";
                            } else {
                                $res['error'] = true;
                                $res['message'] = "Failed to change password";
                            }
                        } else {
                            $res['error'] = true;
                            $res['message'] = "New password and confirm new password does not match";
                        }
                    } else {
                        $res['error'] = true;
                        $res['message'] = "New password must be different from the current password";
                    }
                } else {
                    $res['error'] = true;
                    $res['message'] = "New password must be at least 8 characters long and contain at least one alphabet, one number, and one special character";
                }
            } else {
                $res['error'] = true;
                $res['message'] = "Incorrect current password";
            }
        } else {
            $res['error'] = true;
            $res['message'] = "User not found";
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