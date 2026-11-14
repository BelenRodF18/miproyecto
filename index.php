<?php
require 'conexion.php';

$VERSION = '1.1';
$mensaje = '';

// Registrar un equipo nuevo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campos = ['nombre', 'tipo', 'marca', 'numero_serie', 'ubicacion', 'estado'];
    $datos = [];
    foreach ($campos as $c) {
        $datos[$c] = trim($_POST[$c] ?? '');
    }
    if (in_array('', $datos, true)) {
        $mensaje = 'Todos los campos son obligatorios.';
    } else {
        $sql = 'INSERT INTO equipos (nombre, tipo, marca, numero_serie, ubicacion, estado)
                VALUES (:nombre, :tipo, :marca, :numero_serie, :ubicacion, :estado)';
        $pdo->prepare($sql)->execute($datos);
        header('Location: index.php?ok=creado');
        exit;
    }
}

if (isset($_GET['ok'])) {
    $textos = ['creado' => 'Equipo registrado.', 'editado' => 'Equipo modificado.', 'eliminado' => 'Equipo eliminado.'];
    $mensaje = $textos[$_GET['ok']] ?? '';
}

$equipos = $pdo->query('SELECT * FROM equipos ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Equipos - Centro de Cómputos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<header>
    <h1>Registro de Equipos</h1>
    <p>Centro de Cómputos — inventario de hardware</p>
</header>

<main>
    <?php if ($mensaje): ?>
        <div class="mensaje"><?= e($mensaje) ?></div>
    <?php endif; ?>

    <section class="tarjeta">
        <h2>Registrar equipo</h2>
        <form method="post" action="index.php">
            <label>Nombre <input type="text" name="nombre" maxlength="100" required></label>
            <label>Tipo
                <select name="tipo">
                    <?php foreach ($TIPOS as $t): ?><option><?= e($t) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label>Marca <input type="text" name="marca" maxlength="60" required></label>
            <label>N° de serie <input type="text" name="numero_serie" maxlength="60" required></label>
            <label>Ubicación <input type="text" name="ubicacion" maxlength="100" required></label>
            <label>Estado
                <select name="estado">
                    <?php foreach ($ESTADOS as $s): ?><option><?= e($s) ?></option><?php endforeach; ?>
                </select>
            </label>
            <button type="submit">Guardar</button>
        </form>
    </section>

    <section class="tarjeta">
        <h2>Equipos registrados (<?= count($equipos) ?>)</h2>
        <?php if (!$equipos): ?>
            <p>Todavía no hay equipos registrados.</p>
        <?php else: ?>
        <div class="tabla">
        <table>
            <tr>
                <th>ID</th><th>Nombre</th><th>Tipo</th><th>Marca</th><th>N° serie</th>
                <th>Ubicación</th><th>Estado</th><th>Alta</th><th>Acciones</th>
            </tr>
            <?php foreach ($equipos as $eq): ?>
            <tr>
                <td><?= e($eq['id']) ?></td>
                <td><?= e($eq['nombre']) ?></td>
                <td><?= e($eq['tipo']) ?></td>
                <td><?= e($eq['marca']) ?></td>
                <td><?= e($eq['numero_serie']) ?></td>
                <td><?= e($eq['ubicacion']) ?></td>
                <td><?= e($eq['estado']) ?></td>
                <td><?= e($eq['fecha_alta']) ?></td>
                <td class="acciones">
                    <a class="boton" href="editar.php?id=<?= e($eq['id']) ?>">Modificar</a>
                    <form method="post" action="eliminar.php" onsubmit="return confirm('¿Eliminar este equipo?');">
                        <input type="hidden" name="id" value="<?= e($eq['id']) ?>">
                        <button type="submit" class="peligro">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div>
        <?php endif; ?>
    </section>
</main>

<footer>Servidor: <?= e(gethostname()) ?> · Versión <?= e($VERSION) ?></footer>
</body>
</html>
