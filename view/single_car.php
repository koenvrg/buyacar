<?php require __DIR__ . '/layout/header.php'; ?>

<h1><?= htmlspecialchars($car['make'] . ' ' . $car['model']) ?></h1>

<p>
    <a href="index.php?page=cars" class="btn-primary" style="margin-bottom:15px; display:inline-block;">
        Terug naar auto’s
    </a>
</p>

<div class="single-car-container" style="display:flex; flex-wrap:wrap; gap:20px;">

    <div class="single-car-image" style="flex:1; min-width:250px;">
        <?php
        if (!empty($car['image'])) {
        ?>
            <img src="data:image/jpeg;base64,<?= $car['image'] ?>" style="width:100%; border-radius:8px;">
        <?php
        } else {
        ?>
            <img src="assets/img/car_no_image.png" style="width:100%; border-radius:8px;">
        <?php
        }
        ?>
    </div>

    <div class="single-car-info" style="flex:2; min-width:250px; color:#E5E5E5;">
        <p><strong>Merk:</strong> <?= htmlspecialchars($car['make']) ?></p>
        <p><strong>Model:</strong> <?= htmlspecialchars($car['model']) ?></p>
        <p><strong>Jaar:</strong> <?= $car['year'] ?></p>
        <p><strong>Kilometerstand:</strong> <?= number_format($car['mileage'], 0, ',', '.') ?> km</p>
        <p><strong>Prijs:</strong> € <?= number_format($car['price'], 2) ?></p>
        <p><strong>Brandstof:</strong> <?= htmlspecialchars($car['fuel_type']) ?></p>

        <?php
        if (!empty($car['features'])) {
        ?>
            <p><strong>Features:</strong></p>
            <ul>
                <?php
                foreach ($car['features'] as $feature) {
                ?>
                    <li><?= htmlspecialchars($feature) ?></li>
                <?php
                }
                ?>
            </ul>
        <?php
        }
        ?>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
