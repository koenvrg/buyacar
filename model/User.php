<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Haal gebruiker op via username
    public function getUserByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Controleer login
    public function checkLogin($username, $password) {
        $user = $this->getUserByUsername($username);
        if($user && password_verify($password, $user['password'])) {
            return $user; 
        }
        return false;
    }
}
