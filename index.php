<?php

header("Content-Type: application/json");
require_once "db.php";

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents("php://input"), true);

switch ($method) {
    case 'POST':
        if ($request[0] == 'register') {
            registerUser($input);
        } elseif ($request[0] == 'login') {
            loginUser($input);
        }
        break;
    case 'GET':
        if (isset($request[1])) {
            getUser($request[1]);
        }
        break;
    case 'PUT':
        if (isset($request[1])) {
            updateUser($request[1], $input);
        }
        break;
    case 'DELETE':
        if (isset($request[1])) {
            deleteUser($request[1]);
        }
        break;
    default:
        echo json_encode(["message" => "Method not allowed"]);
        break;
}

function registerUser($data) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $hashed_password = password_hash($data['password'], PASSWORD_BCRYPT);
    if ($stmt->execute([$data['username'], $hashed_password, $data['email']])) {
        echo json_encode(["message" => "User created successfully"]);
    } else {
        echo json_encode(["message" => "Error creating user"]);
    }
}

function loginUser($data) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$data['username']]);
    $user = $stmt->fetch();
    if ($user && password_verify($data['password'], $user['password'])) {
        echo json_encode(["message" => "Login successful", "user" => $user]);
    } else {
        echo json_encode(["message" => "Invalid credentials"]);
    }
}

function getUser($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch();
    if ($user) {
        echo json_encode($user);
    } else {
        echo json_encode(["message" => "User not found"]);
    }
}

function updateUser($id, $data) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    if ($stmt->execute([$data['username'], $data['email'], $id])) {
        echo json_encode(["message" => "User updated successfully"]);
    } else {
        echo json_encode(["message" => "Error updating user"]);
    }
}

function deleteUser($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$id])) {
        echo json_encode(["message" => "User deleted successfully"]);
    } else {
        echo json_encode(["message" => "Error deleting user"]);
    }
}