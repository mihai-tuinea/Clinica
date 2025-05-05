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

<style>
    .specialization-toggle {
        cursor: pointer;
        font-size: 1.1rem;
        font-weight: bold;
        background-color: #f0f0f0;
        padding: 0.5rem;
        border: none;
        width: 100%;
        text-align: left;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .specialization-toggle:hover {
        background-color: #e0e0e0;
    }

    .toggle-icon {
        display: inline-block;
        transition: transform 0.3s ease;
    }

    .toggle-icon.rotate {
        transform: rotate(180deg);
    }

    .services-list {
        padding-left: 1rem;
        display: none;
        margin-bottom: 1rem;
    }
</style>

<main>
    <ol style="list-style: none; padding: 0;">
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
