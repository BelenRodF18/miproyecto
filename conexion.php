<?php
// Conexión a MariaDB/MySQL usando PDO.
// Los datos de acceso se leen de config.php (no se publica en GitHub).
if (!file_exists(__DIR__ . '/config.php')) {
    die('Falta config.php. Copiá config.example.php como config.php y completá los datos.');
}
require __DIR__ . '/config.php';

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log('Error de conexión: ' . $e->getMessage()); // queda en /var/log/apache2/error.log
    die('No se pudo conectar a la base de datos.');
}

// Listas usadas en los formularios
$TIPOS   = ['PC de escritorio', 'Notebook', 'Servidor', 'Impresora', 'Router / Switch', 'Otro'];
$ESTADOS = ['Operativo', 'En reparación', 'Dado de baja'];

function e($texto) {
    return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8');
}
