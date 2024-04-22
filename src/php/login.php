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

    if (isset($data['username']) && isset($data['password'])) {
        $username = $data['username'];
        $password = $data['password'];

        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $username;
                $res['error'] = false;
                $res['message'] = "Login Successful";
                $res['user_id'] = $row['id'];
            } else {
                $res['error'] = true;
                $res['message'] = "Invalid Username or Password";
            }
        } else {
            $res['error'] = true;
            $res['message'] = "Invalid Username or Password";
        }
    } else {
        $res['error'] = true;
        $res['message'] = "Username or password not provided";
    }
}

$conn->close();
header("Content-type: application/json");
echo json_encode($res);
?>
