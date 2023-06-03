<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$dbname = 'apprestaurant1';
$username = 'root';
$password = '';

// Variable para almacenar mensajes de error o éxito
$message = '';
if (isset($_GET['logout'])) {
    // Cerrar sesión y redirigir al inicio de sesión
    session_destroy();
    header("Location: login.php");
    exit();
}

// Verificar si se ha enviado el formulario de creación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    // Obtener los datos del formulario
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $imagen = $_FILES['foto']['name'];
    $imagen_tmp = $_FILES['foto']['tmp_name'];
    $estado = $_POST['estado'];
    
    // Validar los campos (ejemplo de validación simple)
    if (empty($nombre) || empty($precio) || empty($imagen)|| empty($descripcion)||empty($estado)||empty($codigo)) {
        $message = "Por favor, complete todos los campos.";
    } else {
        // Verificar si se seleccionó un archivo de imagen
        if (!empty($imagen_tmp)) {
            // Ruta de destino para almacenar la imagen
            $ruta_imagen = 'C:\Users\Evelyn Mercedes\Downloads/';
            $rutaDestinoCompleta=$ruta_imagen.$imagen;
            // Mover la imagen al directorio de destino
            if (move_uploaded_file($imagen_tmp, $rutaDestinoCompleta)) {
                // Intentar realizar la conexión a la base de datos
                try {
                    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // Insertar los datos en la base de datos
                    $query = "INSERT INTO menu (codigo,nombre, precio, foto,descripcion,estado) VALUES (:codigo,:nombre, :precio, :foto,:descripcion,:estado)";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':codigo', $codigo);
                    $stmt->bindParam(':nombre', $nombre);
                    $stmt->bindParam(':precio', $precio);
                    $stmt->bindParam(':foto', $ruta_imagen);
                    $stmt->bindParam(':descripcion', $descripcion);
                    $stmt->bindParam(':estado', $estado);
                    $stmt->execute();
                    
                    $message = "Producto creado exitosamente.";
                    
                    // Cerrar la conexión
                    $conn = null;
                } catch (PDOException $e) {
                    // Capturar el error de conexión a la base de datos
                    $message = "Error de conexión: " . $e->getMessage();
                }
            } else {
                $message = "Error al subir la imagen.";
            }
        } else {
            $message = "Por favor, seleccione una imagen.";
        }
    }
}

// Verificar si se ha enviado el formulario de eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    // Obtener el ID del producto a eliminar
    $id = $_POST['id'];
    
    // Verificar si se proporcionó un ID válido
    if (!empty($id)) {
        // Intentar realizar la conexión a la base de datos
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Obtener la ruta de la imagen antes de eliminar el registro
            $query = "SELECT id FROM menu WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $imagen = $stmt->fetchColumn();
            
            // Eliminar el registro de la base de datos
            $query = "DELETE FROM menu WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            // Eliminar la imagen del directorio
         /*   if (!empty($imagen)) {
                unlink($imagen);
            }*/
            
            $message = "Producto eliminado exitosamente.";
            
            // Cerrar la conexión
            $conn = null;
        } catch (PDOException $e) {
            // Capturar el error de conexión a la base de datos
            $message = "Error de conexión: " . $e->getMessage();
        }
    } else {
        $message = "ID de producto inválido.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD de Platos</title>
</head>
<body>
    <h1>CRUD de Platos</h1>
    
    <?php if (!empty($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    
    <h2>Crear Plato</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="codigo">Codigo:</label>
        <input type="string" name="codigo" id="codigo"><br>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre"><br>
        
        <label for="precio">Precio:</label>
        <input type="string" name="precio" id="precio"><br>

        <label for="descripcion">Descripcion:</label>
        <input type="text" name="descripcion" id="descripcion"><br>
        
        <label for="foto">Imagen:</label>
        <input type="file" name="foto" id="foto"><br>

        <label for="estado">Tipo:</label>
        <input type="text" name="estado" id="estado"><br>
        
        <input type="submit" name="crear" value="Crear"><br>
    </form>
    
    <h2>Eliminar Plato</h2>
    <form method="POST" action="">
        <label for="id">ID del Plato:</label>
        <input type="number" name="id" id="id">
        
        <input type="submit" name="eliminar" value="Eliminar">
    </form>
    <a href="?logout=true">Cerrar sesión</a>
    <a href="listar.php">Ver lista</a>
</body>
</html>

