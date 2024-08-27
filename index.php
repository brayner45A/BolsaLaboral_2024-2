<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolsa Laboral - Registro de Usuarios</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header>
        <h1>Registro de Usuarios</h1>
    </header>

    <main>
        <section id="user-form">
            <h2>Registrar Nuevo Usuario</h2>
            <form action="backend/register.php" method="POST" enctype="multipart/form-data">
                <label for="nombres">Nombres:</label>
                <input type="text" id="nombres" name="nombres" required>

                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" required>

                <label for="dni">DNI:</label>
                <input type="text" id="dni" name="dni" required>

                <label for="ruc">RUC:</label>
                <input type="text" id="ruc" name="ruc">

                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" required>

                <label for="celular">Celular:</label>
                <input type="text" id="celular" name="celular">

                <label for="rol">Rol:</label>
                <select id="rol" name="rol" required>
                    <option value="1">Admin</option>
                    <option value="2">Empresa</option>
                    <option value="3">Postulante</option>
                    <option value="4">Supervisor</option>
                </select>

                <label for="user">Nombre de Usuario:</label>
                <input type="text" id="user" name="user" required>

                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>

                <label for="archivo_cv">Archivo CV:</label>
                <input type="file" id="archivo_cv" name="archivo_cv">

                <button type="submit">Registrar Usuario</button>
            </form>
        </section>

        <section id="user-list">
            <h2>Lista de Usuarios Registrados</h2>
            <?php
            // Configuración de la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "job_board";

            // Crear la conexión
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar la conexión
            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Obtener todos los usuarios registrados
            $sql = "SELECT * FROM usuarios";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<ul>';
                while ($row = $result->fetch_assoc()) {
                    echo '<li>';
                    echo '<h3>' . htmlspecialchars($row['nombres']) . ' ' . htmlspecialchars($row['apellidos']) . '</h3>';
                    echo '<p><strong>DNI:</strong> ' . htmlspecialchars($row['dni']) . '</p>';
                    echo '<p><strong>RUC:</strong> ' . htmlspecialchars($row['ruc']) . '</p>';
                    echo '<p><strong>Correo:</strong> ' . htmlspecialchars($row['correo']) . '</p>';
                    echo '<p><strong>Celular:</strong> ' . htmlspecialchars($row['celular']) . '</p>';
                    echo '<p><strong>Rol:</strong> ' . ($row['rol'] == 1 ? 'Admin' : ($row['rol'] == 2 ? 'Empresa' : ($row['rol'] == 3 ? 'Postulante' : 'Supervisor'))) . '</p>';
                    echo '<p><strong>Usuario:</strong> ' . htmlspecialchars($row['user']) . '</p>';
                    echo '<p><strong>Archivo CV:</strong> ' . htmlspecialchars($row['archivo_cv']) . '</p>';
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>No hay usuarios registrados en este momento.</p>';
            }

            // Cerrar la conexión
            $conn->close();
            ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Bolsa Laboral</p>
    </footer>

    <script src="scripts/script.js"></script>
</body>
</html>
