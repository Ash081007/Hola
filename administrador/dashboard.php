<?php
include '../db.php';
session_start();


// Contar registros
$usuariosTotal = $conn->query("SELECT COUNT(*) AS total FROM clientes")->fetch_assoc()['total'];
$citasTotal = $conn->query("SELECT COUNT(*) AS total FROM citas")->fetch_assoc()['total'];
$citasPendientes = $conn->query("SELECT COUNT(*) AS total FROM citas WHERE estado='pendiente'")->fetch_assoc()['total'];
$citasAceptadas = $conn->query("SELECT COUNT(*) AS total FROM citas WHERE estado='aceptada'")->fetch_assoc()['total'];

// Obtener citas en espera (las más próximas)
$citasEnEspera = $conn->query("SELECT fecha, hora FROM citas WHERE estado='pendiente' ORDER BY fecha, hora LIMIT 5");

// Obtener citas por fecha
$citasPorFecha = $conn->query("SELECT DATE(fecha) AS fecha, COUNT(*) AS total FROM citas GROUP BY DATE(fecha) ORDER BY DATE(fecha) DESC LIMIT 7");

$fechas = [];
$citasPorDia = [];
while ($row = $citasPorFecha->fetch_assoc()) {
    $fechas[] = $row['fecha'];
    $citasPorDia[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrador</title>
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Estilos generales */
/* Estilos generales */
<style>
    /* Estilos generales */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background: #F1EDE8;
        display: flex;
    }

    /* Sidebar */
    .sidebar {
        width: 250px;
        background: #000000;
        color: white;
        padding: 20px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
    }

    .sidebar h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
    }

    .sidebar ul li {
        margin: 20px 0;
    }

    .sidebar ul li a {
        color: white;
        text-decoration: none;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        border-radius: 5px;
        transition: background 0.3s;
    }

    .sidebar ul li a:hover {
        background: #000000;
    }

    /* Contenido principal */
    .main-content {
        margin-left: 270px;
        padding: 20px;
        width: calc(100% - 270px);
    }

    h1 {
        text-align: center;
        color: #000000;
        margin-bottom: 20px;
    }

    /* Tarjetas de estadísticas (ahora incluye Citas Pendientes) */
    .stats {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 20px;
    }

    .card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 180px;
        font-size: 18px;
    }

    .card h3 {
        color: #000000;
        margin-bottom: 10px;
    }

    .card p {
        font-size: 22px;
        font-weight: bold;
    }

    /* Contenedor del dashboard */
    .dashboard-grid {
        display: flex;
        justify-content: center;
        gap: 20px;
        align-items: flex-start;
        width: 100%;
    }

    /* Gráfico de citas */
    .chart-container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 450px;
        text-align: center;
    }

    /* Contenedor de las citas (Citas en Espera y Citas Aceptadas) */
    .citas-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        width: 260px; /* Asegura que tengan el mismo ancho */
    }

    /* Tarjetas de citas */
    .citas-card.citas-en-espera {
        height: 350px; /* Asegura la misma altura que el gráfico */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);

    }

    .citas-card h2 {
        color: #000000;
        margin-top:2em;
        margin-left:1em;
    }

    /* Lista de citas */
    .citas-card ul {
        list-style: none;
        padding: 0;
        margin-bottom:3em;
    }

    .citas-card li {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        font-size: 16px;
        margin-left:1em;
       
    }

    /* Responsividad */
    @media screen and (max-width: 768px) {
        .dashboard-grid {
            flex-direction: column;
            align-items: center;
        }

        .chart-container {
            width: 100%;
        }

        .citas-container {
            width: 100%;
        }
    }
</style>





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
        <h1>Panel de Administración</h1>
        <div class="stats">
            <div class="card">
                <h3><i class="fa-solid fa-users"></i> Clientes</h3>
                <p><?php echo $usuariosTotal; ?></p>
            </div>
            <div class="card">
                <h3><i class="fa-solid fa-calendar-check"></i> Citas</h3>
                <p><?php echo $citasTotal; ?></p>
            </div>
            <div class="card">
                <h3><i class="fa-solid fa-clock"></i> Citas Pendientes</h3>
                <p><?php echo $citasPendientes; ?></p>
            </div>

        
    </div>
    <div class="dashboard-grid">
    <!-- Sección del Gráfico -->
    <div class="chart-container">
        <h2>Citas por Día</h2>
        <canvas id="citasChart"></canvas>
    </div>

    <div class="citas-container">
    <!-- Citas en Espera -->
    <div class="citas-card citas-en-espera" style="height: 330px;">
        <h2>Citas en Espera</h2>
        <ul>
            <?php while ($cita = $citasEnEspera->fetch_assoc()) { ?>
                <li><?php echo date("d/m/Y", strtotime($cita['fecha'])) . " - " . $cita['hora']; ?></li>
            <?php } ?>
        </ul>
    </div>
</div>


    </div>
</div>


    <script>
        const ctx = document.getElementById('citasChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($fechas); ?>,
                datasets: [{
                    label: 'Citas por Día',
                    data: <?php echo json_encode($citasPorDia); ?>,
                    backgroundColor: '#000000',
                    borderColor: '#000000',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: { beginAtZero: true, maxTicksLimit: 7 },
                    y: { beginAtZero: true }
                },
                plugins: { legend: { display: false } }
            }
        });
    </script>
</body>
</html>
