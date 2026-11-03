<?php
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: index.php"); exit(); }
require_once __DIR__ . "/conexion.php";

$tablas_permitidas = [
    'libros'    => 'id_libro',
    'socios'    => 'id_socio',
    'empleados' => 'id_empleado',
    'prestamos' => 'id_prestamo',
    'usuarios'  => 'id_usuario',
];

$tabla = $_GET['tabla'] ?? '';
$id    = intval($_GET['id'] ?? 0);
if (!array_key_exists($tabla, $tablas_permitidas) || $id <= 0) { header("Location: menu.php"); exit(); }

$columna = $tablas_permitidas[$tabla];
$stmt = $conn->prepare("DELETE FROM $tabla WHERE $columna = ?");
if ($stmt) { $stmt->bind_param("i", $id); $stmt->execute(); $stmt->close(); }
header("Location: $tabla.php"); exit();
?>