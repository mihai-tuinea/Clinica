<?php
include("../includes/config.php");

$specializationsQuery = "SELECT id, specialization_name FROM specializations";
$specializationsResult = mysqli_query($connection, $specializationsQuery);

if (isset($_POST['submit'])) {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $specializationId = $_POST['specializationId'] !== '' ? intval($_POST['specializationId']) : 'NULL';

    $insertQuery = "INSERT INTO medics (first_name, last_name, specialization_id) 
                    VALUES ('$firstName', '$lastName', $specializationId)";

    $result = mysqli_query($connection, $insertQuery);
}
?>

<!doctype html>
<html lang="en">
<meta charset="UTF-8">
<link rel="stylesheet" href="/src/css/styles.css">
<body>
<header>
    <h1>Adaugare Medic</h1>
</header>
<main>
    <section style="display:flex; justify-content: center">
        <form action="" method="post">
            <label>
                Prenume:
                <input type="text" name="firstName" id="firstName" required>
            </label>
            <label>
                Nume:
                <input type="text" name="lastName" id="lastName" required>
            </label>
            <label>
                Specializare (optional):
                <select name="specializationId" id="specializationId">
                    <option value="">-- Fara specializare --</option>
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