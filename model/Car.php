<?php
// models/Car.php
class Car {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllCars() {
        $stmt = $this->pdo->query("
            SELECT cars.*, fuel_types.name AS fuel_type
            FROM cars
            LEFT JOIN car_fuel ON cars.id = car_fuel.car_id
            LEFT JOIN fuel_types ON car_fuel.fuel_id = fuel_types.id
            ORDER BY cars.id DESC
        ");
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($cars as &$car) {
            $stmtFeatures = $this->pdo->prepare("
                SELECT f.name 
                FROM features f
                INNER JOIN car_feature cf ON f.id = cf.feature_id
                WHERE cf.car_id = ?
            ");
            $stmtFeatures->execute([$car['id']]);
            $car['features'] = $stmtFeatures->fetchAll(PDO::FETCH_COLUMN);
        }
        return $cars;
    }

    public function getCarById($id) {
        $stmt = $this->pdo->prepare("
            SELECT cars.*, fuel_types.name AS fuel_type
            FROM cars
            LEFT JOIN car_fuel ON cars.id = car_fuel.car_id
            LEFT JOIN fuel_types ON car_fuel.fuel_id = fuel_types.id
            WHERE cars.id = ?
        ");
        $stmt->execute([$id]);
        $car = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($car) {
            $stmtFeatures = $this->pdo->prepare("
                SELECT f.name 
                FROM features f
                INNER JOIN car_feature cf ON f.id = cf.feature_id
                WHERE cf.car_id = ?
            ");
            $stmtFeatures->execute([$id]);
            $car['features'] = $stmtFeatures->fetchAll(PDO::FETCH_COLUMN);
        }
        return $car;
    }

    public function addCar($make, $model, $year, $mileage, $price, $imageBase64 = null, $fuelId = null, $featureIds = []) {
        $stmt = $this->pdo->prepare("
            INSERT INTO cars (make, model, year, mileage, price, image)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$make, $model, $year, $mileage, $price, $imageBase64]);
        $carId = $this->pdo->lastInsertId();

        if ($fuelId) {
            $this->pdo->prepare("INSERT INTO car_fuel (car_id, fuel_id) VALUES (?, ?)")->execute([$carId, $fuelId]);
        }

        foreach($featureIds as $featureId) {
            $this->pdo->prepare("INSERT INTO car_feature (car_id, feature_id) VALUES (?, ?)")->execute([$carId, $featureId]);
        }

        return $carId;
    }

    public function updateCar($id, $make, $model, $year, $mileage, $price, $imageBase64 = null, $fuelId = null, $featureIds = []) {
        $sql = "UPDATE cars SET make=?, model=?, year=?, mileage=?, price=?";
        $params = [$make, $model, $year, $mileage, $price];

        if ($imageBase64 !== null) {
            $sql .= ", image=?";
            $params[] = $imageBase64;
        }

        $sql .= " WHERE id=?";
        $params[] = $id;

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        if ($fuelId !== null) {
            $this->pdo->prepare("DELETE FROM car_fuel WHERE car_id=?")->execute([$id]);
            $this->pdo->prepare("INSERT INTO car_fuel (car_id, fuel_id) VALUES (?, ?)")->execute([$id, $fuelId]);
        }

        if (!empty($featureIds)) {
            $this->pdo->prepare("DELETE FROM car_feature WHERE car_id=?")->execute([$id]);
            foreach($featureIds as $featureId) {
                $this->pdo->prepare("INSERT INTO car_feature (car_id, feature_id) VALUES (?, ?)")->execute([$id, $featureId]);
            }
        }
    }

    public function deleteCar($id) {
        $this->pdo->prepare("DELETE FROM cars WHERE id=?")->execute([$id]);
    }

    public function getFuelTypes() {
        $stmt = $this->pdo->query("SELECT * FROM fuel_types ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeatures() {
        $stmt = $this->pdo->query("SELECT * FROM features ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
