<?php
include("../includes/config.php");

$type = $_GET["type"];
$specializationsResult = null;

if ($type == "service" || $type == "medic") {
    $specializationsResult = mysqli_query($connection, "SELECT id, specialization_name FROM specializations");
}

function validText($text)
{
    return preg_match("/^[a-zA-Z ]*$/", $text);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = '';
    switch ($type) {

        case 'specialization':
            $name = trim($_POST['specialization_name']);
            if (!validText($name)) {
                $error = "Numele specializarii trebuie sa contina doar litere.";
                break;
            }
            $query = "INSERT INTO specializations (specialization_name) VALUES ('$name')";
            break;

        case 'service':
            $name = trim($_POST['service_name']);
            if (!validText($name)) {
                $error = "Numele serviciului trebuie sa contina doar litere.";
                break;
            }
            $specialization_id = intval($_POST['specialization_id']);
            $query = "INSERT INTO services(service_name,specialization_id) VALUES ('$name','$specialization_id')";
            break;

        case 'medic':
            $first_name = trim($_POST['first_name']);
            $last_name = trim($_POST['last_name']);
            if (!validText($first_name) || !validText($last_name)) {
                $error = "Numele si prenumele trebuie sa contina doar litere.";
                break;
            }
            $specialization_id = $_POST['specialization_id'] != '' ? intval($_POST['specialization_id']) : 'NULL';
            $query = "INSERT INTO medics (first_name, last_name, specialization_id) 
                      VALUES ('$first_name', '$last_name', $specialization_id)";
            break;

        default:
            die("Invalid Type!");
    }
    if (!isset($error)) {
        try {
            $result = mysqli_query($connection, $query);
            if ($result) {
                header("Location: ../admin-page.php?feedback=Crearea a avut succes!");
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                $error = "Aceasta intrare exista deja.";
            } else {
                $error = "A aparut o eroare: " . $e->getMessage();
            }
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Pagina de Creare</title>
    <!-- client side validation -->
    <script>
        function validateForm(event) {
            const onlyLettersRegex = /^[a-zA-Z ]*$/;

            const type = "<?php echo $type; ?>";

            if (type === "specialization") {
                const name = document.forms[0]["specialization_name"].value.trim();
                if (!onlyLettersRegex.test(name)) {
                    alert("Numele specializarii trebuie sa contina doar litere.");
                    event.preventDefault();
                    return false;
                }
            }

            if (type === "service") {
                const name = document.forms[0]["service_name"].value.trim();
                if (!onlyLettersRegex.test(name)) {
                    alert("Numele serviciului trebuie sa contina doar litere.");
                    event.preventDefault();
                    return false;
                }
            }

            if (type === "medic") {
                const first = document.forms[0]["first_name"].value.trim();
                const last = document.forms[0]["last_name"].value.trim();
                if (!onlyLettersRegex.test(first) || !onlyLettersRegex.test(last)) {
                    alert("Numele si prenumele trebuie sa contina doar litere.");
                    event.preventDefault();
                    return false;
                }
            }

            return true;
        }
    </script>
<body>
<header>
    <h1>Pagina de Creare</h1>
    <h2 style="color:red"><?php echo isset($error) ? $error : "" ?></h2>
</header>
<main>
    <section>
        <form method="POST" onsubmit="validateForm(event)">
            <?php if ($type == "specialization"): ?>
                <label>
                    Nume Specializare:
                    <input type="text" name="specialization_name" required>
                </label>

            <?php elseif ($type == "service"): ?>
                <label>
                    Nume Serviciu:
                    <input type="text" name="service_name" required>
                </label>
                <label>
                    Specializare:
                    <select name="specialization_id" required>
                        <option value="" disabled selected>-- Selecteaza o specializare --</option>
                        <?php while ($row = mysqli_fetch_assoc($specializationsResult)): ?>
                            <option value="<?php echo $row['id']; ?>">
                                <?php echo htmlspecialchars($row['specialization_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </label>

            <?php elseif ($type == "medic"): ?>
                <label>
                    Prenume:
                    <input type="text" name="first_name" required>
                </label>
                <label>
                    Nume:
                    <input type="text" name="last_name" required>
                </label>
                <label>
                    Specializare (optional):
                    <select name="specialization_id">
                        <option value="">-- Fara specializare --</option>
                        <?php while ($row = mysqli_fetch_assoc($specializationsResult)): ?>
                            <option value="<?php echo $row['id']; ?>">
                                <?php echo htmlspecialchars($row['specialization_name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </label>

            <?php else: ?>
                <p>EROARE: TIP INVALID SAU LIPSA</p>
            <?php endif; ?>

            <button type="submit">Adauga</button>
            <button type="button" onclick="location.href='../admin-page.php'">Renunta</button>
        </form>
    </section>
</main>
</body>
</html>
