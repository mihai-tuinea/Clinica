<?php
include("../includes/config.php");

$type = $_GET["type"];
$id = $_GET["id"];

$specializationsResult = null;

if ($type == "service" || $type == "medic") {
    $specializationsResult = mysqli_query($connection, "SELECT id, specialization_name FROM specializations");
}


$fetchQuery = "";

switch ($type) {
    case 'specialization':
        $fetchQuery = "SELECT * FROM specializations WHERE id = $id";
        break;
    case 'service':
        $fetchQuery = "SELECT * FROM services WHERE id = $id";
        break;
    case 'medic':
        $fetchQuery = "SELECT * FROM medics WHERE id = $id";
        break;
    default:
        die("Invalid Type!");
}

$data = mysqli_fetch_assoc(mysqli_query($connection, $fetchQuery));

$updateQuery = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($type) {
        case 'specialization':
            $name = trim($_POST['specialization_name']);
            $updateQuery = "UPDATE specializations SET specialization_name = '$name' WHERE id = $id";
            break;

        case 'service':
            $name = trim($_POST['service_name']);
            $specId = intval($_POST['specialization_id']);
            $updateQuery = "UPDATE services SET service_name = '$name', specialization_id = $specId WHERE id = $id";
            break;

        case 'medic':
            $firstName = trim($_POST['first_name']);
            $lastName = trim($_POST['last_name']);
            $specId = $_POST['specialization_id'] !== '' ? intval($_POST['specialization_id']) : 'NULL';
            $updateQuery = "UPDATE medics SET first_name = '$firstName', last_name = '$lastName', specialization_id = $specId WHERE id = $id";
            break;
    }

    $result = mysqli_query($connection, $updateQuery);
    if ($result) {
        header("Location: ../admin-page.php?feedback=Editarea a avut succes!");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Pagina de Editare</title>
</head>
<body>
<header>
    <h1>Pagina de Editare</h1>
</header>
<main>
    <section>
        <form method="POST">
            <?php if ($type == "specialization"): ?>
                <label>
                    Nume Specializare:
                    <input type="text" name="specialization_name"
                           value="<?php echo htmlspecialchars($data['specialization_name']); ?>" required>
                </label>

            <?php elseif ($type == "service"): ?>
                <label>
                    Nume Serviciu:
                    <input type="text" name="service_name"
                           value="<?php echo htmlspecialchars($data['service_name']); ?>" required>
                </label>
                <label>
                    Specializare:
                    <select name="specialization_id" required>
                        <?php while ($row = mysqli_fetch_assoc($specializationsResult)): ?>
                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $data['specialization_id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($row['specialization_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </label>

            <?php elseif ($type == "medic"): ?>
                <label>Prenume:
                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($data['first_name']); ?>"
                           required>
                </label>
                <label>Nume:
                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($data['last_name']); ?>"
                           required>
                </label>
                <label>Specializare (optional):
                    <select name="specialization_id">
                        <option value="">-- Fara specializare --</option>
                        <?php while ($row = mysqli_fetch_assoc($specializationsResult)): ?>
                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $data['specialization_id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($row['specialization_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </label>

            <?php else: ?>
                <p>EROARE: TIP INVALID SAU LIPSA</p>
            <?php endif; ?>

            <button type="submit">Salveaza</button>
            <button type="button" onclick="location.href='../admin-page.php'">Renunta</button>
        </form>
    </section>
</main>
</body>
</html>
