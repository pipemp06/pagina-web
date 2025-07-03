<?php
// Mostrar errores (solo para desarrollo)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "login");

// Verificar conexión
if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}

// Verificar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Consulta para verificar si el usuario existe
    $sql = "SELECT * FROM `iniciar_sesion` WHERE usuario = ? AND contraseña = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $usuario, $contraseña);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            echo "✅ Inicio de sesión exitoso. ¡Bienvenido $usuario!";
        } else {
            echo "❌ Usuario o contraseña incorrectos.";
        }

        $stmt->close();
    } else {
        echo "❌ Error en la preparación de la consulta: " . $conexion->error;
    }

    $conexion->close();
}
?>

