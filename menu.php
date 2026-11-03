<?php
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú — Biblioteca</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="menu-wrapper">
    <div class="menu-box">
        <div class="welcome">Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?></div>
        <p class="subtitle">¿Qué sección deseas gestionar hoy?</p>
        <nav class="menu-nav">
            <a href="libros.php"><span class="icon">📖</span> Libros</a>
            <a href="socios.php"><span class="icon">🪪</span> Socios</a>
            <a href="empleados.php"><span class="icon">👤</span> Empleados</a>
            <a href="prestamos.php"><span class="icon">🔄</span> Préstamos</a>
            <a href="usuarios.php"><span class="icon">🔐</span> Usuarios</a>
            <a href="biblioteca.php"><span class="icon">✏️</span> Editar libro</a>
        </nav>
        <a href="logout.php" class="logout-link">↩ Cerrar sesión</a>
    </div>
</div>
</body>
</html>