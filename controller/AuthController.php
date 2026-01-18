<?php
class AuthController {
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function login(){
        $error = '';

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username=?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($password, $user['password'])){
                if(session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header('Location: index.php');
                exit;
            } else {
                $error = "Onjuiste gebruikersnaam of wachtwoord.";
            }
        }

        require __DIR__ . '/../view/login.php';
    }

    public function register() {
        $error = '';

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);

            // Validatie
            if(empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
                $error = "Vul alle velden in.";
            } elseif($password !== $confirm_password) {
                $error = "Wachtwoorden komen niet overeen.";
            } else {
                // Check of username al bestaat
                $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username=?");
                $stmt->execute([$username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if($user) {
                    $error = "Deze gebruikersnaam is al in gebruik.";
                } else {
                    // Hash wachtwoord
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Maak gebruiker aan
                    $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
                    $stmt->execute([$username, $email, $hashedPassword]);

                    // Auto login na registratie
                    if(session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    $_SESSION['user_id'] = $this->pdo->lastInsertId();
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = 'user';

                    header('Location: index.php');
                    exit;
                }
            }
        }

        require __DIR__ . '/../view/register.php';
    }
}
