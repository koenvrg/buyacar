<?php require __DIR__ . '/layout/header.php'; ?>

<h1>Auto Bewerken</h1>

<p>
    <a href="index.php?page=cars" class="btn-primary" style="margin-bottom:15px; display:inline-block;">
        Terug naar auto’s
    </a>
</p>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="make" value="<?= htmlspecialchars($car['make']) ?>" placeholder="Merk" required>
    <input type="text" name="model" value="<?= htmlspecialchars($car['model']) ?>" placeholder="Model" required>
    <input type="number" name="year" value="<?= htmlspecialchars($car['year']) ?>" placeholder="Jaar" required>
    <input type="number" name="mileage" value="<?= htmlspecialchars($car['mileage']) ?>" placeholder="Kilometerstand" required>
    <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($car['price']) ?>" placeholder="Prijs" required>

    <label>Brandstof:</label>
    <select name="fuel_id">
        <option value="">-- Kies brandstof --</option>
        <?php
        foreach ($fuelTypes as $fuel) {
            ?>
            <option
                value="<?= $fuel['id'] ?>"
                <?= ($car['fuel_type'] === $fuel['name']) ? 'selected' : '' ?>
            >
                <?= htmlspecialchars($fuel['name']) ?>
            </option>
            <?php
        }
        ?>
    </select>

    <label>Features:</label>
    <div>
        <?php
        foreach ($features as $feature) {
            ?>
            <label>
                <input
                    type="checkbox"
                    name="feature_ids[]"
                    value="<?= $feature['id'] ?>"
                    <?= in_array($feature['name'], $car['features']) ? 'checked' : '' ?>
                >
                <?= htmlspecialchars($feature['name']) ?>
            </label>
            <?php
        }
        ?>
    </div>

    <label>Auto Afbeelding (optioneel):</label>
    <input type="file" name="image" accept="image/*" id="imageInput">

    <div id="imagePreview" style="margin-top:10px;">
        <?php
        if (!empty($car['image'])) {
            ?>
            <img
                src="data:image/jpeg;base64,<?= $car['image'] ?>"
                style="max-width:200px;border-radius:5px;"
            >
            <?php
        }
        ?>
    </div>

    <button type="submit">Opslaan</button>
</form>

<script>
const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');

imageInput.addEventListener('change', function () {
    imagePreview.innerHTML = '';
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '200px';
            img.style.borderRadius = '5px';
            imagePreview.appendChild(img);
        };
        reader.readAsDataURL(file);
    }
});
</script>

<?php require __DIR__ . '/layout/footer.php'; ?>
