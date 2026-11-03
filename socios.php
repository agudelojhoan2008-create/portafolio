<?php
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: index.php"); exit(); }
require_once __DIR__ . "/conexion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socios — Biblioteca</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="page-wrapper">
    <div class="page-header">
        <h1>🪪 Socios</h1>
        <a href="menu.php" class="back-link">← Volver al menú</a>
    </div>
    <div class="card">
        <h2>Agregar socio</h2>
        <form action="guardar.php" method="POST">
            <input type="hidden" name="tabla" value="socios">
            <div class="form-grid">
                <input type="text"  name="nombre"   placeholder="Nombre"    required>
                <input type="email" name="correo"   placeholder="Correo electrónico">
                <input type="text"  name="telefono" placeholder="Teléfono">
                <button type="submit" class="btn btn-primary">＋ Guardar</button>
            </div>
        </form>
    </div>
    <div class="table-wrapper">
        <table>
            <thead><tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Teléfono</th><th>Acciones</th></tr></thead>
            <tbody>
            <?php
            $res = $conn->query("SELECT * FROM socios ORDER BY id_socio DESC");
            if ($res && $res->num_rows > 0):
                while ($r = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= $r['id_socio'] ?></td>
                    <td><?= htmlspecialchars($r['nombre']) ?></td>
                    <td><?= htmlspecialchars($r['correo']   ?? '—') ?></td>
                    <td><?= htmlspecialchars($r['telefono'] ?? '—') ?></td>
                    <td><a href="eliminar.php?tabla=socios&id=<?= $r['id_socio'] ?>" class="btn btn-danger" onclick="return confirm('¿Eliminar?')">🗑 Eliminar</a></td>
                </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="5" style="text-align:center;padding:28px;color:var(--text-light)">No hay socios registrados aún.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>