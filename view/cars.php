<?php 
require __DIR__ . '/layout/header.php'; 
?>

<h1>Beschikbare Auto’s</h1>

<?php
$view = $_GET['view'] ?? 'cards';
?>

<?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
<div class="admin-controls" style="display:flex; align-items:center; margin-bottom:15px;">
    <div class="view-switch-container" style="display:flex; align-items:center; gap:10px;">
        <strong>Weergave:</strong>

        <a href="index.php?page=cars&view=table" class="view-switch <?= $view==='table'?'active':'' ?>" title="Lijstweergave">
            <div class="hamburger-icon">
                <span></span><span></span><span></span>
            </div>
        </a>

        <a href="index.php?page=cars&view=cards" class="view-switch <?= $view==='cards'?'active':'' ?>" title="Kaartenweergave">
            <div class="grid-icon">
                <span></span><span></span>
                <span></span><span></span>
            </div>
        </a>
    </div>

    <a href="index.php?page=add_car" class="btn-primary" style="margin-left:auto;">Auto toevoegen</a>
</div>
<?php endif; ?>

<?php if($view === 'table') { ?>
<!-- Lijstweergave -->
<div class="cars-list">
<?php foreach($cars as $car) { ?>
    <div class="car-line" style="display:flex; gap:15px; padding:10px; border-bottom:1px solid #333745; align-items:flex-start; flex-wrap:wrap;">

        <!-- Image links -->
        <div class="car-image" style="flex:0 0 150px;">
            <img src="<?= !empty($car['image']) ? 'data:image/jpeg;base64,' . $car['image'] : 'assets/img/car_no_image.png' ?>" 
                 alt="<?= htmlspecialchars($car['make'].' '.$car['model']) ?>" 
                 style="width:150px; height:100px; object-fit:cover; border-radius:5px;">
        </div>

        <!-- Info + features rechts -->
        <div class="car-info" style="flex:1; display:flex; flex-direction:column; gap:5px;">
            <div class="car-make" style="font-size:1.2rem; font-weight:bold;"><?= htmlspecialchars($car['make']) ?></div>
            <div class="car-model" style="font-size:1rem; color:#ccc;"><?= htmlspecialchars($car['model']) ?></div>
            <div class="car-price" style="font-size:1.1rem; font-weight:bold;">€ <?= number_format($car['price'],2) ?></div>

            <!-- Extra eigenschappen als badges -->
            <div class="car-features" style="display:flex; gap:10px; margin-top:5px;">
                <span class="feature-badge" style="background:#1B1D2B; border-radius:15px; padding:5px 15px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:0.85rem; font-weight:bold; min-width:50px; text-align:center;"><?= $car['year'] ?></span>
                <span class="feature-badge" style="background:#1B1D2B; border-radius:15px; padding:5px 15px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:0.85rem; font-weight:bold; min-width:80px; text-align:center;"><?= number_format($car['mileage'],0,',','.') ?> km</span>
                <span class="feature-badge" style="background:#1B1D2B; border-radius:15px; padding:5px 15px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:0.85rem; font-weight:bold; min-width:70px; text-align:center;"><?= htmlspecialchars($car['fuel_type']) ?></span>
            </div>

            <!-- Features tags (volledige breedte) -->
            <?php if(!empty($car['features'])) { ?>
                <div class="car-features-tags" style="display:flex; flex-wrap:wrap; gap:5px; margin-top:5px; width:100%;">
                    <?php foreach($car['features'] as $feature) { ?>
                        <span style="background:#1B1D2B; color:#fff; padding:5px 12px; border-radius:12px; font-size:0.75rem; font-weight:bold; white-space:nowrap;">
                            <?= htmlspecialchars($feature) ?>
                        </span>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <!-- Acties -->
        <div class="car-actions" style="display:flex; flex-direction:column; gap:5px;">
            <a class="table-btn" href="index.php?page=edit_car&id=<?= $car['id'] ?>">Bewerken</a>
            <a class="table-btn" href="index.php?page=delete_car&id=<?= $car['id'] ?>" onclick="return confirm('Weet je het zeker?')">Verwijderen</a>
        </div>
    </div>
<?php } ?>
</div>
<?php } else { ?>
<!-- Kaartenweergave -->
<div class="cars-grid">
<?php foreach($cars as $car) { ?>
    <a href="index.php?page=edit_car&id=<?= $car['id'] ?>" class="car-card">
        <img src="<?= !empty($car['image']) ? 'data:image/jpeg;base64,' . $car['image'] : 'assets/img/car_no_image.png' ?>" 
             alt="<?= htmlspecialchars($car['make'].' '.$car['model']) ?>" 
             style="width:100%;height:150px;border-radius:5px;margin-bottom:10px;">
        <h3><?= htmlspecialchars($car['make']) ?> <?= htmlspecialchars($car['model']) ?></h3>
        <p>Jaar: <?= $car['year'] ?></p>
        <p>Prijs: € <?= number_format($car['price'], 2) ?></p>
        <p style="font-size:0.9rem; color:#ccc;">
            <?= number_format($car['mileage'],0,',','.') ?> km | <?= htmlspecialchars($car['fuel_type']) ?>
        </p>
    </a>
<?php } ?>
</div>
<?php } ?>


<?php require __DIR__ . '/layout/footer.php'; ?>
