<?php
// Datos del formulario
$nombre_de_usuario = $_POST['nombre_de_usuario'];
$Crea_nueva_contraseña = $_POST['Crea_nueva_contraseña'];

// Validar que no esté vacío
if (empty($usuario) || empty($contraseña)) {
    die("Todos los campos son obligatorios.");
}

// Cifrar la contraseña
$hash = password_hash($contrasena, PASSWORD_DEFAULT);

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "nuevo_usuario");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el usuario ya existe
$check = $conn->prepare("SELECT * FROM usuarios_nuevos WHERE nombre_de_usuario = ?");
$check->bind_param("s", $usuario);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    echo "El nombre de usuario ya está registrado.";
} else {
    // Insertar nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios_nuevos (nombre_de_usuario, Crea_nueva_contraseña) VALUES (?, ?)");
    $stmt->bind_param("ss", $usuario, $hash);
    if ($stmt->execute()) {
        echo "Usuario registrado exitosamente.";
    } else {
        echo "Error al registrar usuario.";
    }
}

$conn->close();
?>
