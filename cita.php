<?php
include 'db.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $servicio = $_POST['servicio'];

    // Verificar si el usuario ya existe (por ejemplo, con el nombre)
    $stmt = $conn->prepare("SELECT id FROM clientes WHERE nombre = ?");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si el usuario ya existe
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cliente_id = $row['id']; // Obtener el ID del cliente existente

        // Insertar cita para el usuario existente
        $stmt = $conn->prepare("INSERT INTO citas (cliente_id, fecha, hora, servicio) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $cliente_id, $fecha, $hora, $servicio);
        $stmt->execute();

        // Mostrar alerta y redirigir al inicio
        echo "<script>
                alert('Cita reservada con éxito.');
                window.location.href = 'inicio.html';
              </script>";
        exit();
    } else {
        // Si el usuario no existe, mostrar un mensaje de error o redirigir
        echo "<script>
                alert('El usuario no está registrado. Por favor, regístrate antes de agendar una cita.');
                window.location.href = 'registro.php'; // Redirigir a una página de registro, si es necesario
              </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda tu cita</title>
    <style>
        /* Contenedor del formulario */
        form {
            width: 90%;
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            background-color: #f5f5f5;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        /* Título del formulario */
        form h2 {
            text-align: center;
            font-size: 24px;
            font-family: 'Oswald', sans-serif;
            color: #111111;
            margin-bottom: 30px;
        }

        /* Estilo para los inputs */
        input[type="text"], input[type="email"], input[type="date"], input[type="time"], select {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 15px;
            border: 1px solid #111111;
            background-color: #ffffff;
            border-radius: 5px;
            font-size: 16px;
            color: #111111;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        /* Cambio de estilo al enfocar los campos */
        input[type="text"]:focus, input[type="email"]:focus, input[type="date"]:focus, input[type="time"]:focus, select:focus {
            border-color: #444444;
        }

        /* Estilo del botón de submit */
        button[type="submit"] {
            width: 100%;
            padding: 12px 15px;
            background-color: #111111;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #444444;
        }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Agenda tu cita</h2>
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="telefono" placeholder="Teléfono" required>
        <input type="date" name="fecha" required>
        <input type="time" name="hora" required>
        <select name="servicio">
            <option value="Corte de rizos">Corte de rizos</option>
            <option value="Definición">Definición</option>
            <option value="Tratamiento">Tratamiento</option>
        </select>
        <button type="submit">Reservar</button>
    </form>
</body>
</html>
