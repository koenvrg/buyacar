<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>RentMyCar</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
<header class="site-header">
    <div class="container">
        <div class="header-inner">
            
            <a href="index.php" class="site-logo"><img src="assets/img/text.png" alt="RentMyCar Banner"></a>
            <nav>
                <?php if(isset($_SESSION['username'])){ ?>
                    <a href="index.php?page=cars">All cars</a>
                    <a href="index.php?page=logout">Logout</a>
                <?php } else {?>
                    <a href="index.php?page=login">Login</a>
                <?php }; ?>
            </nav>
        </div>
    </div>
</header>
<main>
<div class="container">

