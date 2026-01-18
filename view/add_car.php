<?php require __DIR__ . '/layout/header.php'; ?>

<h1>Nieuwe Auto Toevoegen</h1>

<p>
    <a href="index.php?page=cars" class="btn-primary" style="margin-bottom:15px; display:inline-block;">
        Terug naar auto’s
    </a>
</p>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="make" placeholder="Merk" required>
    <input type="text" name="model" placeholder="Model" required>
    <input type="number" name="year" placeholder="Jaar" required>
    <input type="number" name="mileage" placeholder="Kilometerstand" required>
    <input type="number" step="0.01" name="price" placeholder="Prijs" required>

    <label>Brandstof:</label>
    <select name="fuel_id">
        <option value="">-- Kies brandstof --</option>
        <?php
        foreach ($fuelTypes as $fuel) {
            ?>
            <option value="<?= $fuel['id'] ?>"><?= htmlspecialchars($fuel['name']) ?></option>
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
                <input type="checkbox" name="features[]" value="<?= $feature['id'] ?>">
                <?= htmlspecialchars($feature['name']) ?>
            </label>
            <?php
        }
        ?>
    </div>

    <label>Auto Afbeelding (optioneel):</label>
    <input type="file" name="image" accept="image/*" id="imageInput">
    <div id="imagePreview" style="margin-top:10px;"></div>

    <button type="submit">Toevoegen</button>
</form>

<script>
const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');

imageInput.addEventListener('change', function() {
    imagePreview.innerHTML = '';
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
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
