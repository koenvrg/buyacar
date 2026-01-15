<?php
require_once __DIR__ . '/../model/Car.php';

class CarController {
    private $carModel;

    public function __construct($pdo) {
        $this->carModel = new Car($pdo);
    }

    public function index() {
        $cars = $this->carModel->getAllCars();
        $view = $_GET['view'] ?? 'cards';
        require __DIR__ . '/../view/cars.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['tmp_name'] !== '') {
                $imageData = file_get_contents($_FILES['image']['tmp_name']);
                $image = base64_encode($imageData);
            }

            $make = $_POST['make'];
            $model = $_POST['model'];
            $year = $_POST['year'];
            $mileage = $_POST['mileage'];
            $price = $_POST['price'];
            $fuelId = $_POST['fuel_id'] ?? null;
            $featureIds = $_POST['feature_ids'] ?? [];

            $this->carModel->addCar(
                $make,
                $model,
                $year,
                $mileage,
                $price,
                $image,
                $fuelId,
                $featureIds
            );

            header('Location: index.php?page=cars');
            exit;
        }

        require __DIR__ . '/../view/add_car.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php?page=cars');
            exit;
        }

        $car = $this->carModel->getCarById($id);
        if (!$car) {
            header('Location: index.php?page=cars');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $image = $car['image'];
            if (isset($_FILES['image']) && $_FILES['image']['tmp_name'] !== '') {
                $imageData = file_get_contents($_FILES['image']['tmp_name']);
                $image = base64_encode($imageData);
            }

            $make = $_POST['make'];
            $model = $_POST['model'];
            $year = $_POST['year'];
            $mileage = $_POST['mileage'];
            $price = $_POST['price'];
            $fuelId = $_POST['fuel_id'] ?? null;
            $featureIds = $_POST['feature_ids'] ?? [];

            $this->carModel->updateCar(
                $id,
                $make,
                $model,
                $year,
                $mileage,
                $price,
                $image,
                $fuelId,
                $featureIds
            );

            header('Location: index.php?page=cars');
            exit;
        }

        require __DIR__ . '/../view/edit_car.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->carModel->deleteCar($id);
        }
        header('Location: index.php?page=cars');
        exit;
    }
}
