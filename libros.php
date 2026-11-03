<?php
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: index.php"); exit(); }
require_once __DIR__ . "/conexion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros — Biblioteca</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="page-wrapper">
    <div class="page-header">
        <h1>📖 Libros</h1>
        <a href="menu.php" class="back-link">← Volver al menú</a>
    </div>
    <div class="card">
        <h2>Agregar libro</h2>
        <form action="guardar.php" method="POST">
            <input type="hidden" name="tabla" value="libros">
            <div class="form-grid">
                <input type="text" name="titulo" placeholder="Título" required>
                <input type="text" name="autor"  placeholder="Autor">
                <input type="text" name="genero" placeholder="Género">
                <select name="disponible">
                    <option value="" disabled selected>Disponibilidad</option>
                    <option value="1">✅ Disponible</option>
                    <option value="0">❌ No disponible</option>
                </select>
                <button type="submit" class="btn btn-primary">＋ Guardar</button>
            </div>
        </form>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr><th>ID</th><th>Título</th><th>Autor</th><th>Género</th><th>Disponible</th><th>Acciones</th></tr>
            </thead>
            <tbody>
            <?php
            $result = $conn->query("SELECT * FROM libros ORDER BY id_libro DESC");
            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id_libro'] ?></td>
                    <td><?= htmlspecialchars($row['titulo']) ?></td>
                    <td><?= htmlspecialchars($row['autor']  ?? '—') ?></td>
                    <td><?= htmlspecialchars($row['genero'] ?? '—') ?></td>
                    <td><?= $row['disponible'] ? '<span class="badge badge-yes">Sí</span>' : '<span class="badge badge-no">No</span>' ?></td>
                    <td>
                        <a href="biblioteca.php?id=<?= $row['id_libro'] ?>" class="btn btn-primary" style="font-size:.78rem;padding:5px 11px;margin-right:4px">✏️ Editar</a>
                        <a href="eliminar.php?tabla=libros&id=<?= $row['id_libro'] ?>" class="btn btn-danger" onclick="return confirm('¿Eliminar este libro?')">🗑 Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; else: ?>
                <tr><td colspan="6" style="text-align:center;padding:28px;color:var(--text-light)">No hay libros registrados aún.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>