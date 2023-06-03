<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$dbname = 'apprestaurant1';
$username = 'root';
$password = '';

// Variable para almacenar mensajes de éxito o error
$message = '';
if (isset($_GET['logout'])) {
    // Cerrar sesión y redirigir al inicio de sesión
    session_destroy();
    header("Location: login.php");
    exit();
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $tipo = $_POST['tipo'];
    
    // Validar los campos (ejemplo de validación simple)
    if (empty($nombre) || empty($email) || empty($contrasena)||empty($tipo)) {
        $message = "Por favor, complete todos los campos.";
    } else {
        // Intentar realizar la conexión a la base de datos
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Insertar los datos en la base de datos
            $query = "INSERT INTO usuario (nombre, email, contrasena,tipo) VALUES (:nombre, :email, :contrasena,:tipo)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->execute();
            
            $message = "Registro creado exitosamente.";
            
            // Cerrar la conexión
            $conn = null;
        } catch (PDOException $e) {
            // Capturar el error de conexión a la base de datos
            $message = "Error de conexión: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Registro</title>
</head>
<body>
    <h1>Formulario de Registro</h1>
    
    <?php if (!empty($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre">
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
        
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" id="contrasena">

        <label for="tipo">Estado:</label>
        <input type="number" name="tipo" id="tipo">
        
        <input type="submit" value="Registrarse">
    </form>
    <a href="?logout=true">Cerrar sesión</a>
</body>
</html>


