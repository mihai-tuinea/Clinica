<?php
include("../includes/config.php");

if (isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id = intval($_GET['id']);

    switch ($type) {
        case 'specialization':
            $query = "DELETE FROM specializations WHERE id = $id";
            break;
        case 'service':
            $query = "DELETE FROM services WHERE id = $id";
            break;
        case 'medic':
            $query = "DELETE FROM medics WHERE id = $id";
            break;
        default:
            die("Invalid type");
    }

    mysqli_query($connection, $query);
}

header("Location: ../admin-page.php?feedback=Stergerea a avut succes!");
exit;
