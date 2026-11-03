<?php
require_once __DIR__ . "/conexion.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") { header("Location: index.php"); exit(); }

$tablas_permitidas = [
    'libros'    => ['titulo', 'autor', 'genero', 'disponible'],
    'socios'    => ['nombre', 'correo', 'telefono'],
    'empleados' => ['nombre', 'cargo'],
    'prestamos' => ['id_libro', 'id_socio', 'id_empleado', 'fecha_prestamo', 'fecha_devolucion'],
    'usuarios'  => ['usuario', 'password'],
];

$tabla = trim($_POST['tabla'] ?? '');
if (!array_key_exists($tabla, $tablas_permitidas)) { die("Tabla no permitida."); }
unset($_POST['tabla']);

$datos = [];
foreach ($tablas_permitidas[$tabla] as $col) {
    if (isset($_POST[$col]) && $_POST[$col] !== '') {
        $valor = $_POST[$col];
        if ($tabla === 'usuarios' && $col === 'password') {
            $valor = password_hash($valor, PASSWORD_DEFAULT);
        }
        $datos[$col] = $valor;
    }
}

if (empty($datos)) { header("Location: $tabla.php"); exit(); }

$columnas     = implode(", ", array_keys($datos));
$placeholders = implode(", ", array_fill(0, count($datos), "?"));
$tipos        = str_repeat("s", count($datos));
$stmt = $conn->prepare("INSERT INTO $tabla ($columnas) VALUES ($placeholders)");
if (!$stmt) { die("Error: " . $conn->error); }
$valores = array_values($datos);
$stmt->bind_param($tipos, ...$valores);
$stmt->execute();
$stmt->close();
header("Location: $tabla.php"); exit();
?>