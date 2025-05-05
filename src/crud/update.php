<?php
include("../includes/config.php");

$error = NULL;
$type = $_GET["type"];
$id = intval($_GET["id"]);
$specializations_result = mysqli_query($connection, "SELECT id, specialization_name FROM specializations");

function valid_text($text)
{
    return preg_match("/^[a-zA-Z ]*$/", $text);
}

$fetch_query = "";
switch ($type) {
    case "specialization":
        $fetch_query = "SELECT * FROM specializations WHERE id = $id";
        break;
    case "service":
        $fetch_query = "SELECT * FROM services WHERE id = $id";
        break;
    case "medic":
        $fetch_query = "SELECT * FROM medics WHERE id = $id";
        break;
    default:
        die("Invalid Type!");
}

$data = mysqli_fetch_assoc(mysqli_query($connection, $fetch_query));

$update_query = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    switch ($type) {
        case "specialization":
            $name = trim($_POST["specialization_name"]);
            if (!valid_text($name)) {
                $error = "Numele specializarii trebuie sa contina doar litere.";
                break;
            }
            $update_query = "UPDATE specializations SET specialization_name = '$name' WHERE id = $id";
            break;

        case "service":
            $name = trim($_POST["service_name"]);
            if (!valid_text($name)) {
                $error = "Numele serviciului trebuie sa contina doar litere.";
                break;
            }
            $specialization_id = intval($_POST["specialization_id"]);
            $update_query = "UPDATE services SET service_name = '$name', specialization_id = $specialization_id WHERE id = $id";
            break;

        case "medic":
            $first_name = trim($_POST["first_name"]);
            $last_name = trim($_POST["last_name"]);
            if (!valid_text($first_name) || !valid_text($last_name)) {
                $error = "Numele si prenumele trebuie sa contina doar litere.";
                break;
            }
            $specialization_id = intval($_POST["specialization_id"]);
            $update_query = "UPDATE medics SET first_name = '$first_name', last_name = '$last_name', specialization_id = $specialization_id WHERE id = $id";
            break;
        default:
            die("Invalid Type!");
    }

    if (!isset($error)) {
        try {
            $result = mysqli_query($connection, $update_query);
            if ($result) {
                header("Location: ../admin-page.php?feedback=Editarea a avut succes!");
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

    $data = mysqli_fetch_assoc(mysqli_query($connection, $fetch_query));
    $specializations_result = mysqli_query($connection, "SELECT id, specialization_name FROM specializations");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Pagina de Editare</title>
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
</head>
<body>
<header>
    <h1>Pagina de Editare</h1>
    <h2 class="error"><?php echo isset($error) ? $error : "" ?></h2>
</header>
<main>
    <section>
        <form method="POST" onsubmit="validateForm(event)">
            <?php if ($type == "specialization"): ?>
                <label>
                    Nume Specializare:
                    <input type="text" name="specialization_name"
                           value="<?php echo htmlspecialchars($data["specialization_name"]); ?>" required>
                </label>

            <?php elseif ($type == "service"): ?>
                <label>
                    Nume Serviciu:
                    <input type="text" name="service_name"
                           value="<?php echo htmlspecialchars($data["service_name"]); ?>" required>
                </label>
                <label>
                    Specializare:
                    <select name="specialization_id" required>
                        <?php while ($row = mysqli_fetch_assoc($specializations_result)): ?>
                            <option value="<?php echo $row["id"]; ?>" <?php if ($row["id"] == $data["specialization_id"]) echo "selected"; ?>>
                                <?php echo htmlspecialchars($row["specialization_name"]); ?>
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
                <label>Specializare:
                    <select name="specialization_id" required>
                        <?php while ($row = mysqli_fetch_assoc($specializations_result)): ?>
                            <option value="<?php echo $row["id"]; ?>" <?php if ($row["id"] == $data["specialization_id"]) echo "selected"; ?>>
                                <?php echo htmlspecialchars($row["specialization_name"]); ?>
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
