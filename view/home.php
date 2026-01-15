<?php require __DIR__ . '/layout/header.php'; ?>

<!-- Banner -->
<div class="homepage-banner">
    <img src="assets/img/banner2.png" alt="RentMyCar Banner">
</div>

<!-- Laatste 5 auto's -->
<h2>Most recent added cars</h2>
<div class="cars-grid">
<?php
$stmt = $pdo->query("SELECT * FROM cars ORDER BY id DESC LIMIT 5");
$recentCars = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($recentCars as $car) {
    ?>
    <a href="index.php?page=cars" class="car-card">
        <?php if(!empty($car['image'])): ?>
            <img src="data:image/jpeg;base64,<?= $car['image'] ?>" alt="<?= htmlspecialchars($car['make']) ?> <?= htmlspecialchars($car['model']) ?>">
        <?php else: ?>
            <img src="assets/img/car_no_image.png" alt="Geen afbeelding beschikbaar" style="width:100%;height:150px;border-radius:5px;margin-bottom:10px;">
        <?php endif; ?>
        <h3><?= htmlspecialchars($car['make']) ?> <?= htmlspecialchars($car['model']) ?></h3>
        <p>Jaar: <?= $car['year'] ?></p>
        <p>Prijs: € <?= number_format($car['price'], 2) ?></p>
    </a>
    <?php
}
?>
</div>

<?php 
if(isset($_SESSION['username'])) {
    echo '<p><a href="index.php?page=cars">Show all our cars</a></p>';
} else {
    echo '<p><a href="index.php?page=login">Inloggen</a></p>';
}
?>

<?php require __DIR__ . '/layout/footer.php'; ?>
