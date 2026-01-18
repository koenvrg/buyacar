<?php
$page = $_GET['page'] ?? 'home';

switch($page){
    case 'cars':
        require __DIR__ . '/../controller/CarController.php';
        $carController = new CarController($pdo);
        $carController->index();
        break;

    case 'add_car':
        require __DIR__ . '/../controller/CarController.php';
        $carController = new CarController($pdo);
        $carController->add();
        break;

    case 'edit_car':
        require __DIR__ . '/../controller/CarController.php';
        $carController = new CarController($pdo);
        $carController->edit();
        break;

    case 'delete_car':
        require __DIR__ . '/../controller/CarController.php';
        $carController = new CarController($pdo);
        $carController->delete();
        break;

    case 'single_car':
        require __DIR__ . '/../controller/CarController.php';
        $carController = new CarController($pdo);
        $carController->single();
        break;

    case 'login':
    require __DIR__ . '/../controller/AuthController.php';
    $authController = new AuthController($pdo);
    $authController->login();
    break;


    case 'logout':
        session_destroy();
        header('Location: index.php?page=home');
        exit;

    default:
        require __DIR__ . '/../view/home.php';
        break;
}
