<?php
include 'db.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Verificar si el usuario ya existe
    $stmt = $conn->prepare("SELECT id FROM clientes WHERE usuario=?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "El usuario ya está registrado.";
    } else {
        // Hash de la contraseña antes de guardarla
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar nuevo usuario
        $stmt = $conn->prepare("INSERT INTO clientes (nombre, usuario, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $usuario, $hashed_password);
        
        if ($stmt->execute()) {
            header("Location: login_usuario.php"); // Redirige al login después de registrarse
            exit();
        } else {
            $error = "Error al registrarse. Intenta de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Cliente</title>
    <link rel="stylesheet" href="assets/form.css">
</head>
<body>
    <div class="register-container">
        <h2>Regístrate</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre Completo" required>
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="login_usuario.php">Inicia sesión</a></p>
    </div>
</body>
</html>
