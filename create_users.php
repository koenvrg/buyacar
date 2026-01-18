<?php
require 'config.php';

$users = [
    ['admin', 'admin123', 'admin'],
    ['user', 'user123', 'user']
];

foreach ($users as [$username, $password, $role]) {
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare(
        "INSERT INTO users (username, password, role) VALUES (?, ?, ?)"
    );
    $stmt->execute([$username, $hash, $role]);
}

echo "Users aangemaakt";
