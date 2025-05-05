<?php
$pageTitle = "Servicii Medicale";
include("includes/config.php");
include("includes/header.php");

$medicsResult = mysqli_query($connection, "
    SELECT medics.*, specializations.specialization_name 
    FROM medics 
    JOIN specializations ON medics.specialization_id = specializations.id
");
?>

    <main>
        <ol style="list-style:none">
            <?php while ($row = mysqli_fetch_assoc($medicsResult)): ?>
                <li>
                    <section>
                        <h2>
                            Dr. <?php echo htmlspecialchars($row['first_name']);
                            echo " ";
                            echo htmlspecialchars($row['last_name']); ?>
                        </h2>
                        <p><?php echo htmlspecialchars($row['specialization_name']); ?></p>
                    </section>
                </li>
            <?php endwhile; ?>
        </ol>
    </main>

<?php include("includes/footer.php"); ?>