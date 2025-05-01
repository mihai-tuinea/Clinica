<!doctype html>
<html lang="en">
<meta charset="UTF-8">
<link rel="stylesheet" href="/src/css/styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<!--for social media icons-->
<title><?php echo isset($pageTitle) ? $pageTitle : "pageTitle is undefined" ?></title>
<body>
<header>
    <h1><?php echo isset($pageTitle) ? $pageTitle : "pageTitle is undefined" ?></h1>
    <nav class="navbar">
        <ul>
            <li>
                <a href="index.php">Home</a>
            </li>
            <li>
                <a href="servicii-medicale.php">Servicii Medicale</a>
            </li>
            <li>
                <a href="medici.php">Medici</a>
            </li>
            <li>
                <a href="galerie.php">Galerie</a>
            </li>
            <li>
                <a href="contact.php">Contact</a>
            </li>
        </ul>
    </nav>
</header>