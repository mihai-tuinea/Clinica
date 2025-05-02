<?php
include("../includes/config.php");

$specializationsQuery = "SELECT id, specialization_name FROM specializations";
$specializationsResult = mysqli_query($connection, $specializationsQuery);

// Handle form submission
if (isset($_POST['submit'])) {
    $serviceName = trim($_POST['serviceName']);
    $specializationId = intval($_POST['specializationId']); // required, so no fallback

    $insertQuery = "INSERT INTO services (service_name, specialization_id) 
                    VALUES ('$serviceName', $specializationId)";

    $result = mysqli_query($connection, $insertQuery);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/src/css/styles.css">
    <title>Adaugare Serviciu</title>
</head>
<body>
<header>
    <h1>Adaugare Serviciu</h1>
</header>
<main>
    <section style="display:flex; justify-content: center">
        <form action="" method="post">
            <label>
                Nume Serviciu:
                <input type="text" name="serviceName" id="serviceName" required>
            </label>
            <label>
                Specializare:
                <select name="specializationId" id="specializationId" required>
                    <option value="">-- Selecteaza specializarea --</option>
                    <?php while ($row = mysqli_fetch_assoc($specializationsResult)) { ?>
                        <option value="<?php echo $row['id']; ?>">
                            <?php echo htmlspecialchars($row['specialization_name']); ?>
                        </option>
                    <?php } ?>
                </select>
            </label>
            <button type="submit" name="submit">Submit</button>
        </form>
    </section>
</main>
</body>
</html>
