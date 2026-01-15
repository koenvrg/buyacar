<?php
// Database connectie
try {
    $pdo = new PDO('mysql:host=localhost;dbname=rentmycar', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database fout: " . $e->getMessage());
}

// Auto-login admin (tijdelijk, voor testen)
if(!isset($_SESSION['user_id'])){
    $_SESSION['user_id'] = 1;
    $_SESSION['username'] = 'admin';
    $_SESSION['role'] = 'admin';
}
