<?php require __DIR__ . '/layout/header.php'; ?>

<h1>Registreren</h1>

<?php
if (!empty($error)) {
    echo "<p class='error'>$error</p>";
}
?>

<form method="post">
    <input type="text" name="username" placeholder="Gebruikersnaam" required>
    <input type="email" name="email" placeholder="E-mail" required>
    <input type="password" name="password" placeholder="Wachtwoord" required>
    <input type="password" name="confirm_password" placeholder="Bevestig wachtwoord" required>
    <button type="submit">Registreren</button>
    <p style="text-align:center;">
        Heb je al een account? <a href="index.php?page=login">Inloggen</a>
    </p>
</form>


<?php require __DIR__ . '/layout/footer.php'; ?>
