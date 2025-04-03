<?php
include '../db.php';
session_start();


if (isset($_GET['estado']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $estado = $_GET['estado'];

    if (in_array($estado, ['pendiente', 'aceptada'])) {
        $stmt = $conn->prepare("UPDATE citas SET estado=? WHERE id=?");
        $stmt->bind_param("si", $estado, $id);
        $stmt->execute();
    }
    header("Location: citas.php");
    exit();
}

$citas = $conn->query("SELECT * FROM citas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas - Administrador</title>
    <link rel="stylesheet" href="citas.css">
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
    height: 100vh;
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

.citas-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.citas-table th, .citas-table td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid #E1DFD7;
}

.citas-table th {
    background: #000000;
    color: white;
}

.citas-table tr:hover {
    background: #F1EDE8;
}

.status-pendiente {
    color: #d9534f;
    font-weight: bold;
}

.status-aceptada {
    color: #5cb85c;
    font-weight: bold;
}

.actions {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.actions a {
    padding: 6px 12px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
    font-weight: bold;
}

.accept-btn {
    background: #5cb85c;
}

.pending-btn {
    background: #f0ad4e;
}

.actions a:hover {
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
        <h1>Citas Agendadas</h1>
        <table class="citas-table">
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Servicio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            <?php while ($cita = $citas->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $cita['fecha']; ?></td>
                    <td><?php echo $cita['hora']; ?></td>
                    <td><?php echo $cita['servicio']; ?></td>
                    <td class="status-<?php echo $cita['estado']; ?>">
                        <?php echo ucfirst($cita['estado']); ?>
                    </td>
                    <td class="actions">
                        <a href="citas.php?estado=aceptada&id=<?php echo $cita['id']; ?>" class="accept-btn">Aceptar</a>
                        <a href="citas.php?estado=pendiente&id=<?php echo $cita['id']; ?>" class="pending-btn">Pendiente</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
