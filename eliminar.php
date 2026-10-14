<?php
require 'conexion.php';

// Solo se elimina por POST (desde el botón del listado)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $pdo->prepare('DELETE FROM equipos WHERE id = ?')->execute([$id]);
    header('Location: index.php?ok=eliminado');
    exit;
}
header('Location: index.php');
