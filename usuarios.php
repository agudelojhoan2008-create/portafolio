<?php

require_once __DIR__ . "/conexion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios — Biblioteca</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="page-wrapper">
    <div class="page-header">
        <h1>🔐 Usuarios del sistema</h1>
        <a href="menu.php" class="back-link">← Volver al menú</a>
    </div>
    <div class="alert alert-success">🔒 Las contraseñas se guardan cifradas automáticamente con bcrypt.</div>
    <div class="card">
        <h2>Agregar usuario</h2>
        <form action="guardar.php" method="POST">
            <input type="hidden" name="tabla" value="usuarios">
            <div class="form-grid">
                <input type="text"     name="usuario"  placeholder="Nombre de usuario" required autocomplete="off">
                <input type="password" name="password" placeholder="Contraseña"        required autocomplete="new-password">
                <button type="submit" class="btn btn-primary">＋ Guardar</button>
            </div>
        </form>
    </div>
    <div class="table-wrapper">
        <table>
            <thead><tr><th>ID</th><th>Usuario</th><th>Acciones</th></tr></thead>
            <tbody>
            <?php
            $res = $conn->query("SELECT id_usuario, usuario FROM usuarios ORDER BY id_usuario DESC");
            if ($res && $res->num_rows > 0):
                while ($r = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= $r['id_usuario'] ?></td>
                    <td><?= htmlspecialchars($r['usuario']) ?></td>
                    <td><a href="eliminar.php?tabla=usuarios&id=<?= $r['id_usuario'] ?>" class="btn btn-danger" onclick="return confirm('¿Eliminar?')">🗑 Eliminar</a></td>
                </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="3" style="text-align:center;padding:28px;color:var(--text-light)">No hay usuarios registrados aún.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>