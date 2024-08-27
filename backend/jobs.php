<?php

// Configuración de la base de datos
$servername = "localhost"; // Cambia esto si tu servidor es diferente
$username = "root"; // Cambia esto si tu usuario es diferente
$password = ""; // Cambia esto por tu contraseña
$dbname = "job_board";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para registrar un nuevo usuario
function registerUser($conn, $user) {
    $stmt = $conn->prepare("INSERT INTO usuarios (nombres, apellidos, dni, ruc, correo, celular, rol, user, password, archivo_cv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssisss", $user['nombres'], $user['apellidos'], $user['dni'], $user['ruc'], $user['correo'], $user['celular'], $user['rol'], $user['user'], $user['password'], $user['archivo_cv']);
    $stmt->execute();
    $stmt->close();
}

// Manejo de la solicitud POST para registrar un nuevo usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $ruc = $_POST['ruc'];
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    $rol = $_POST['rol'];
    $user = $_POST['user'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashear la contraseña
    $archivo_cv = $_FILES['archivo_cv']['name'];

    // Mover el archivo CV a una carpeta del servidor
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($archivo_cv);
    move_uploaded_file($_FILES['archivo_cv']['tmp_name'], $target_file);

    $new_user = [
        'nombres' => $nombres,
        'apellidos' => $apellidos,
        'dni' => $dni,
        'ruc' => $ruc,
        'correo' => $correo,
        'celular' => $celular,
        'rol' => $rol,
        'user' => $user,
        'password' => $password,
        'archivo_cv' => $target_file
    ];

    registerUser($conn, $new_user);
    header('Location: ../index.php');
    exit();
}

// Cerrar la conexión
$conn->close();
?>
