<?php
include '../db.php';
session_start();

if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conn->prepare("DELETE FROM clientes WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: usuarios.php");
    exit();
}

$usuarios = $conn->query("SELECT * FROM clientes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Administrador</title>
    <link rel="stylesheet" href="usuarios.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: white;
    display: flex;
}

.sidebar {
    width: 250px;
    background: #000000;
    color: white;
    padding: 20px;
    height: 100vh;n
}

.sidebar h2 {
    text-align: center;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    margin: 15px 0;
}

.sidebar ul li a {
    color: white;
    text-decoration: none;
    font-size: 18px;
    display: flex;
    align-items: center;
}

.sidebar ul li i {
    margin-right: 10px;
}

.main-content {
    flex-grow: 1;
    padding: 20px;
}

h1 {
    color: #000000;
    text-align: center;
}

.usuarios-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.usuarios-table th, .usuarios-table td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #E1DFD7;
}

.usuarios-table th {
    background: #000000;
    color: white;
}

.usuarios-table tr:hover {
    background: #F1EDE8;
}

.actions {
    display: flex;
    justify-content: center;
}

.delete-btn {
    background: #d9534f;
    padding: 6px 12px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
    font-weight: bold;
}

.delete-btn:hover {
    opacity: 0.8;
}

    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Encanto Natural</h2>
        <ul>
            <li><a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li><a href="citas.php"><i class="fa-solid fa-calendar-check"></i> Citas</a></li>
            <li><a href="usuarios.php"><i class="fa-solid fa-users"></i> Clientes</a></li>

        </ul>
    </div>

    <div class="main-content">
        <h1>Usuarios Registrados</h1>
        <table class="usuarios-table">
            <tr>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Acciones</th>
            </tr>
            <?php while ($usuario = $usuarios->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['usuario']; ?></td>
                    <td><?php echo $usuario['password']; ?></td>
                    <td class="actions">
                        <a href="usuarios.php?eliminar=<?php echo $usuario['id']; ?>" class="delete-btn" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
