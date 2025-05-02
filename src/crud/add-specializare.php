<?php
include("../includes/config.php");
if (isset($_POST['submit'])) {
    $specializationName = trim($_POST['specializationInput']);
    $query = "INSERT INTO specializations (specialization_name) VALUES ('$specializationName')";
    // snake_case for sql variable, camelCase for php variables
    $result = mysqli_query($connection, $query);
}
?>

<!doctype html>
<html lang="en">
<meta charset="UTF-8">
<link rel="stylesheet" href="/src/css/styles.css">
<body>
<header>
    <h1>Adaugare Specializare</h1>
</header>
<main>
    <section style="display:flex; justify-content: center">
        <form action="" method="post">
            <label>
                Nume Specializare:
                <input type="text" name="specializationInput" id="specializationInput">
            </label>
            <button type="submit" name="submit">Submit</button>
        </form>
    </section>
</main>
</body>
</html>