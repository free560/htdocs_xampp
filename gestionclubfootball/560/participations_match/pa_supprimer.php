<?php
include '../config/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: pa_lister.php');
    exit;
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT id FROM participations_match WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    header('Location: pa_lister.php?erreur=introuvable');
    exit;
}
$stmt->close();

$stmt = $conn->prepare("DELETE FROM participations_match WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: pa_lister.php?success=suppression');
} else {
    header('Location: pa_lister.php?erreur=suppression');
}

$stmt->close();
$conn->close();
exit;
?>