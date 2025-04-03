<?php
session_start();
include 'db.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM clientes WHERE usuario=?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $cliente = $result->fetch_assoc();

    // Verificar si el usuario existe y la contraseña es correcta
    if ($cliente && password_verify($password, $cliente['password'])) {
        $_SESSION['cliente'] = $cliente['id']; // Guardar ID del cliente en la sesión
        header("Location: inicio.html"); // Redirigir al dashboard del cliente
        exit();
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Cliente</title>
    <link rel="stylesheet" href="assets/form.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
        <p>¿No tienes cuenta? <a href="registro_usuario.php">Regístrate</a></p>
    </div>
</body>
</html>
