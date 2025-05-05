<?php

session_start();

// redirects to login page if the current session didn't login
if (!isset($_SESSION['user_id'])) {
    header('Location: includes/login.php');
    exit();
}

$pageTitle = "Admin Page";
include("includes/header.php");
include("includes/config.php");

$specializationsResult = mysqli_query($connection, "SELECT * FROM specializations");
$servicesResult = mysqli_query($connection, "
    SELECT services.id, service_name, specialization_name 
    FROM services 
    JOIN specializations ON services.specialization_id = specializations.id
");
$medicsResult = mysqli_query($connection, "
    SELECT medics.id, first_name, last_name, specialization_name 
    FROM medics 
    LEFT JOIN specializations ON medics.specialization_id = specializations.id
");
?>
<header>
    <form action="includes/logout.php" method="post">
        <button class="admin-button" type="submit">
            Logout
        </button>
    </form>
</header>
<main>
    <?php $feedback = isset($_GET["feedback"]) ? $_GET["feedback"] : ""; ?>
    <?php if ($feedback): ?>
        <section id="feedback-message">
            <h2 style="color:green; margin:0;"><?php echo htmlspecialchars($feedback); ?></h2>
            <button onclick="document.getElementById('feedback-message').style.display='none';"
                    style="background:none; border:none; font-size:30px;">&times;
            </button>
        </section>
    <?php endif; ?>

    <!-- Specializari -->
    <section>
        <div class="admin-section-header">
            <h2>Specializari</h2>
            <button onclick="location.href='crud/create.php?type=specialization'">Adauga Specializare</button>
        </div>
        <table class="data-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nume</th>
                <th>Actiuni</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($specializationsResult)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['specialization_name']); ?></td>
                    <td>
                        <button onclick="location.href='crud/update.php?type=specialization&id=<?php echo $row['id']; ?>'">
                            Edit
                        </button>
                        <button onclick="confirmDelete('specialization', <?php echo $row['id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </section>

    <!-- Servicii -->
    <section>
        <div style="display:flex; gap:20px; align-items: center">
            <h2>Servicii</h2>
            <button onclick="location.href='crud/create.php?type=service'">Adauga Serviciu</button>
        </div>
        <table class="data-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nume</th>
                <th>Specializare</th>
                <th>Actiuni</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($servicesResult)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['specialization_name']); ?></td>
                    <td>
                        <button onclick="location.href='crud/update.php?type=service&id=<?php echo $row['id']; ?>'">Edit
                        </button>
                        <button onclick="confirmDelete('service', <?php echo $row['id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </section>

    <!-- Medici -->
    <section>
        <div style="display:flex; gap:20px; align-items: center">
            <h2>Medici</h2>
            <button onclick="location.href='crud/create.php?type=medic'">Adauga Medic</button>
        </div>
        <table class="data-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Prenume</th>
                <th>Nume</th>
                <th>Specializare</th>
                <th>Actiuni</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($medicsResult)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                    <td>
                        <?php echo $row['specialization_name'] ? htmlspecialchars($row['specialization_name']) : '-'; ?>
                    </td>
                    <td>
                        <button onclick="location.href='crud/update.php?type=medic&id=<?php echo $row['id']; ?>'">
                            Edit
                        </button>
                        <button onclick="confirmDelete('medic', <?php echo $row['id']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </section>
</main>

<script>
    function confirmDelete(type, id) {
        if (confirm("Sigur vrei sa stergi acest element?")) {
            window.location.href = 'crud/delete.php?type=' + type + '&id=' + id;
        }
    }
</script>