<?php require __DIR__ . '/layout/header.php'; ?>

<h1>Auto Bewerken</h1>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="make" value="<?= htmlspecialchars($car['make']) ?>" placeholder="Merk" required>
    <input type="text" name="model" value="<?= htmlspecialchars($car['model']) ?>" placeholder="Model" required>
    <input type="number" name="year" value="<?= htmlspecialchars($car['year']) ?>" placeholder="Jaar" required>
    <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($car['price']) ?>" placeholder="Prijs" required>

    <label>Auto Afbeelding (optioneel):</label>
    <input type="file" name="image" accept="image/*" id="imageInput">
    <div id="imagePreview" style="margin-top:10px;">
        <?php if(!empty($car['image'])): ?>
            <img src="data:image/jpeg;base64,<?= $car['image'] ?>" style="max-width:200px;border-radius:5px;">
        <?php endif; ?>
    </div>

    <button type="submit">Opslaan</button>
</form>

<p><a href="index.php?page=cars">Terug naar auto’s</a></p>

<script>
const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');

imageInput.addEventListener('change', function(){
    imagePreview.innerHTML = '';
    const file = this.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxWidth = '200px';
            img.style.borderRadius = '5px';
            imagePreview.appendChild(img);
        }
        reader.readAsDataURL(file);
    }
});
</script>

<?php require __DIR__ . '/layout/footer.php'; ?>
