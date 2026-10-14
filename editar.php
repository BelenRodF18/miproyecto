<?php
require 'conexion.php';

$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campos = ['nombre', 'tipo', 'marca', 'numero_serie', 'ubicacion', 'estado'];
    $datos = [];
    foreach ($campos as $c) {
        $datos[$c] = trim($_POST[$c] ?? '');
    }
    if (in_array('', $datos, true)) {
        $mensaje = 'Todos los campos son obligatorios.';
    } else {
        $datos['id'] = $id;
        $sql = 'UPDATE equipos SET nombre = :nombre, tipo = :tipo, marca = :marca,
                numero_serie = :numero_serie, ubicacion = :ubicacion, estado = :estado
                WHERE id = :id';
        $pdo->prepare($sql)->execute($datos);
        header('Location: index.php?ok=editado');
        exit;
    }
}

$consulta = $pdo->prepare('SELECT * FROM equipos WHERE id = ?');
$consulta->execute([$id]);
$eq = $consulta->fetch(PDO::FETCH_ASSOC);
if (!$eq) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modificar equipo - Centro de Cómputos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<header>
    <h1>Modificar equipo #<?= e($eq['id']) ?></h1>
    <p><a href="index.php">← Volver al listado</a></p>
</header>
<main>
    <?php if ($mensaje): ?>
        <div class="mensaje"><?= e($mensaje) ?></div>
    <?php endif; ?>
    <section class="tarjeta">
        <form method="post" action="editar.php">
            <input type="hidden" name="id" value="<?= e($eq['id']) ?>">
            <label>Nombre <input type="text" name="nombre" maxlength="100" value="<?= e($eq['nombre']) ?>" required></label>
            <label>Tipo
                <select name="tipo">
                    <?php foreach ($TIPOS as $t): ?>
                        <option <?= $t === $eq['tipo'] ? 'selected' : '' ?>><?= e($t) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Marca <input type="text" name="marca" maxlength="60" value="<?= e($eq['marca']) ?>" required></label>
            <label>N° de serie <input type="text" name="numero_serie" maxlength="60" value="<?= e($eq['numero_serie']) ?>" required></label>
            <label>Ubicación <input type="text" name="ubicacion" maxlength="100" value="<?= e($eq['ubicacion']) ?>" required></label>
            <label>Estado
                <select name="estado">
                    <?php foreach ($ESTADOS as $s): ?>
                        <option <?= $s === $eq['estado'] ? 'selected' : '' ?>><?= e($s) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button type="submit">Guardar cambios</button>
        </form>
    </section>
</main>
</body>
</html>
