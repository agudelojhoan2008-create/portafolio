<?php
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: index.php"); exit(); }
require_once __DIR__ . "/conexion.php";

$mensaje = ""; $tipo = "";
$pre = ['id' => '', 'titulo' => '', 'autor' => ''];

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    $get_id = intval($_GET['id']);
    $s = $conn->prepare("SELECT id_libro, titulo, autor FROM libros WHERE id_libro = ?");
    if ($s) {
        $s->bind_param("i", $get_id); $s->execute();
        $res = $s->get_result();
        if ($row = $res->fetch_assoc()) { $pre = ['id' => $row['id_libro'], 'titulo' => $row['titulo'], 'autor' => $row['autor'] ?? '']; }
        $s->close();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id'] ?? 0); $titulo = trim($_POST['titulo'] ?? ''); $autor = trim($_POST['autor'] ?? '');
    if ($id > 0 && $titulo !== '') {
        $stmt = $conn->prepare("UPDATE libros SET titulo=?, autor=? WHERE id_libro=?");
        if ($stmt) {
            $stmt->bind_param("ssi", $titulo, $autor, $id);
            $mensaje = $stmt->execute() ? "✅ Libro actualizado correctamente." : "❌ Error al actualizar.";
            $tipo    = $stmt->execute() ? "alert-success" : "alert-error";
            $stmt->close();
        }
    } else { $mensaje = "⚠️ Completa todos los campos requeridos."; $tipo = "alert-error"; }
    $pre = ['id' => $_POST['id'], 'titulo' => $_POST['titulo'], 'autor' => $_POST['autor']];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Libro — Biblioteca</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="page-wrapper">
    <div class="page-header">
        <h1>✏️ Editar libro</h1>
        <a href="libros.php" class="back-link">← Volver a Libros</a>
    </div>
    <?php if ($mensaje): ?>
        <div class="alert <?= $tipo ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <div class="card">
        <h2>Actualizar datos del libro</h2>
        <form method="POST" action="biblioteca.php">
            <div class="form-grid">
                <input type="number" name="id"     placeholder="ID del libro" value="<?= htmlspecialchars($pre['id']) ?>"     required>
                <input type="text"   name="titulo" placeholder="Título"       value="<?= htmlspecialchars($pre['titulo']) ?>" required>
                <input type="text"   name="autor"  placeholder="Autor"        value="<?= htmlspecialchars($pre['autor']) ?>">
                <button type="submit" class="btn btn-primary">💾 Actualizar</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>