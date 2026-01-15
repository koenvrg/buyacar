<?php
// Controller: AuthController.php
class AuthController {
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    // Pagina: index.php?page=login
    public function login(){
        $error = '';
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username=?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header('Location: index.php?page=cars');
                exit;
            } else {
                $error = "Onjuiste gebruikersnaam of wachtwoord.";
            }
        }

        require __DIR__ . '/../view/login.php';
    }
}
