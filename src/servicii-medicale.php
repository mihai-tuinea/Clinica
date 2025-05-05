<?php
$pageTitle = "Servicii Medicale";
include("includes/config.php");
include("includes/header.php");

$query = "
    SELECT s.specialization_name, s.id AS specialization_id, sv.service_name
    FROM specializations s
    LEFT JOIN services sv ON s.id = sv.specialization_id
    ORDER BY s.specialization_name, sv.service_name
";

$result = mysqli_query($connection, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($connection));
}

$specializationsArray = [];
while ($row = mysqli_fetch_assoc($result)) {
    $specializationId = $row['specialization_id'];
    if (!isset($specializationsArray[$specializationId])) {
        $specializationsArray[$specializationId] = [
            'name' => $row['specialization_name'],
            'services' => [],
        ];
    }

    if ($row['service_name']) {
        $specializationsArray[$specializationId]['services'][] = $row['service_name'];
    }
}
?>

<main>
    <ol class="services-container">
        <?php foreach ($specializationsArray as $specializationId => $specialization): ?>
            <li>
                <section>
                    <button class="specialization-toggle">
                        <?php echo htmlspecialchars($specialization['name']); ?>
                        <span class="toggle-icon">˅</span>
                    </button>
                    <div class="services-list">
                        <?php if (!empty($specialization['services'])): ?>
                            <ul>
                                <?php foreach ($specialization['services'] as $service): ?>
                                    <li><?php echo htmlspecialchars($service); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p><em>Nu exista servicii disponibile.</em></p>
                        <?php endif; ?>
                    </div>
                </section>
            </li>
        <?php endforeach; ?>
    </ol>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const specializationToggles = document.querySelectorAll(".specialization-toggle");

        specializationToggles.forEach(toggleButton => {
            const toggleIcon = toggleButton.querySelector(".toggle-icon");
            toggleButton.addEventListener("click", () => {
                const servicesList = toggleButton.nextElementSibling;
                const isOpen = servicesList.style.display === "block";

                servicesList.style.display = isOpen ? "none" : "block";
                toggleIcon.classList.toggle("rotate", !isOpen);
            });
        });
    });
</script>

<?php include("includes/footer.php"); ?>
