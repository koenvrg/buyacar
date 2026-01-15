<?php require __DIR__ . '/layout/header.php'; ?>

<h1>Login</h1>

<?php if(!empty($error)) echo "<p class='error'>$error</p>"; ?>

<form method="post">
    <input type="text" name="username" placeholder="Gebruikersnaam" required>
    <input type="password" name="password" placeholder="Wachtwoord" required>
    <button type="submit">Inloggen</button>
</form>

<?php require __DIR__ . '/layout/footer.php'; ?>
