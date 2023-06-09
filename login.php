<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$dbname = 'apprestaurant1';
$username = 'root';
$password = '';

// Variable para almacenar mensajes de error o éxito
$message = '';

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    
    // Validar los campos (ejemplo de validación simple)
    if (empty($email) || empty($contrasena)) {
        $message = "Por favor, complete todos los campos.";
    } else {
        // Intentar realizar la conexión a la base de datos
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Verificar si el email y la contraseña coinciden en la base de datos
            $query = "SELECT * FROM usuario WHERE email = :email AND contrasena = :contrasena";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->execute();
            
            // Verificar si se encontraron registros
            if ($stmt->rowCount() > 0) {
                // Las credenciales son correctas
               // $message = "Las credenciales son correctas.";
               header("Location: cuenta.php");
            } else {
                // Las credenciales son incorrectas
                $message = "Las credenciales son incorrectas.";
            }
            
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
    <title>Iniciar sesion</title>
</head>
<body>
    <h1 style="text-align: center;">Iniciar sesion</h1>
    
    <?php if (!empty($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    
    <form method="POST" action="">
        <label  for="email">Email:</label>
        <input   type="email" name="email" id="email">
        
        <label for="contrasena">Contraseña:</label>
        <input  type="password" name="contrasena" id="contrasena"><br>
        
        <input  type="submit" value="Verificar">
        <a href="registro.php">Registrarse</a>

    </form>
</body>
</html>

