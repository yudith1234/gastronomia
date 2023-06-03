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

// Conexión a la base de datos
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Función para validar una imagen subida
/*function validarImagen($imagen)
{
    $permitidos = array('jpg', 'jpeg', 'png', 'gif');
    $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);
    
    if (in_array($extension, $permitidos) && $imagen['size'] < 5000000) {
        return true;
    } else {
        return false;
    }
}*/

// Verificar si se ha enviado el formulario de creación
 /*if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    // Obtener los datos del formulario
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
  //  $imagen = $_FILES['imagen'];
    
    // Validar la imagen subida
   /* if (validarImagen($imagen)) {
        $rutaImagen = 'ruta/directorio/imagenes/' . $imagen['name'];
        
        // Mover la imagen al directorio de destino
        if (move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
            // Insertar el nuevo registro en la base de datos
            $query = "INSERT INTO menu (codigo, nombre, imagen, descripcion, estado) VALUES (:codigo, :nombre, :imagen, :descripcion, :estado)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':imagen', $rutaImagen);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':estado', $estado);
            
            if ($stmt->execute()) {
                $message = "Nuevo elemento creado exitosamente.";
            } else {
                $message = "Error al crear el elemento.";
            }
        } else {
            $message = "Error al mover la imagen.";
        }
    } else {
        $message = "La imagen no cumple con los requisitos de formato o tamaño.";
    }
}*/

// Verificar si se ha enviado el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    
    // Actualizar el registro en la base de datos
    $query = "UPDATE menu SET codigo = :codigo, nombre = :nombre, descripcion = :descripcion, estado = :estado WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':id', $id);
    
    if ($stmt->execute()) {
        $message = "Elemento modificado exitosamente.";
    } else {
        $message = "Error al modificar el elemento.";
    }
}

// Verificar si se ha enviado el formulario de eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar'])) {
    // Obtener el ID del elemento a eliminar
    $id = $_POST['id'];
    
    // Eliminar el registro de la base de datos
    $query = "DELETE FROM menu WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    
    if ($stmt->execute()) {
        $message = "Elemento eliminado exitosamente.";
    } else {
        $message = "Error al eliminar el elemento.";
    }
}

// Obtener la lista de elementos de la tabla "menu"
$query = "SELECT * FROM menu";
$stmt = $conn->prepare($query);
$stmt->execute();
$elementos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD de Menú</title>
</head>
<body>
    <h1>CRUD de Menú</h1>
    
    <?php if (!empty($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>
    
    <h2>Listado de Elementos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Código</th>
            <th>Nombre</th>
      <!--      <th>Imagen</th> -->
            <th>Descripción</th>
            <th>Estado</th>
      <!--      <th>Acciones</th>  -->
        </tr>
        <?php foreach ($elementos as $elemento) { ?>
            <tr>
                <td><?php echo $elemento['id']; ?></td>
                <td><?php echo $elemento['codigo']; ?></td>
                <td><?php echo $elemento['nombre']; ?></td>
          <!--      <td><img src="<?php echo $elemento['imagen']; ?>" width="100" height="100" alt=""></td>-->
                <td><?php echo $elemento['descripcion']; ?></td>
                <td><?php echo $elemento['estado']; ?></td>
        
                    <td>
                    <a href="editar.php?id=<?php echo $elemento['id']; ?>">Editar</a>
                    <form method="POST" action="">
                        <input type="hidden" name="id" value="<?php echo $elemento['id']; ?>">
                    <!--    <input type="submit" name="eliminar" value="Eliminar"> -->
                    </form>

                </td>
            </tr>
        <?php } ?>
    </table>

        <a href="?logout=true">Cerrar sesión</a>  
</body>
</html>

