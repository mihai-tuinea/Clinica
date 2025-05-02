<?php
$pageTitle = "Admin Page";
include("includes/header.php");
include("includes/config.php");

// Fetch data
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

<main>
    <!-- Specializari -->
    <section>
        <div style="display:flex; gap:20px; align-items: center">
            <h2>Specializari</h2>
            <button onclick="location.href='crud/add-specializare.php'">Adauga Specializare</button>
        </div>
        <table border="1" cellpadding="8" cellspacing="0">
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
                        <button>Edit</button>
                        <button>Delete</button>
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
            <button onclick="location.href='crud/add-serviciu.php'">Adauga Serviciu</button>
        </div>
        <table border="1" cellpadding="8" cellspacing="0">
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
                        <button>Edit</button>
                        <button>Delete</button>
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
            <button onclick="location.href='crud/add-medic.php'">Adauga Medic</button>
        </div>
        <table border="1" cellpadding="8" cellspacing="0">
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
                        <?php echo $row['specialization_name'] ? htmlspecialchars($row['specialization_name']) : 'Fara'; ?>
                    </td>
                    <td>
                        <button>Edit</button>
                        <button>Delete</button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </section>
</main>
