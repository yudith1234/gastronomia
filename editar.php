
<!--///////////////////////////////////////// -->
<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$dbname = 'apprestaurant1';
$username = 'root';
$password = '';
if (isset($_GET['logout'])) {
    // Cerrar sesión y redirigir al inicio de sesión
    session_destroy();
    header("Location: login.php");
    exit();
}
try {
    // Crear conexión a la base de datos
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener el ID del registro a editar
    $id = $_GET['id'];

    // Obtener el registro de la base de datos
    $query = "SELECT * FROM menu WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $registro = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se ha enviado el formulario de edición
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
        // Obtener los datos del formulario
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $tipo = $_POST['estado'];

        // Actualizar el registro en la base de datos
        $query = "UPDATE menu SET codigo = :codigo, nombre = :nombre, descripcion = :descripcion, precio = :precio, estado= :estado WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':estado', $tipo);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $message = "Registro actualizado exitosamente.";
        } else {
            $message = "Error al actualizar el registro.";
        }
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Editar Registro</title>
</head>
<body>
    <h1>Editar Registro</h1>

    <?php if (!empty($message)) { ?>
        <p><?php echo $message; ?></p>
    <?php } ?>

    <form method="POST" action="">
        <label for="codigo">Código:</label>
        <input type="text" name="codigo" id="codigo" value="<?php echo $registro['codigo']; ?>" required>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $registro['nombre']; ?>" required>

        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" id="descripcion" value="<?php echo $registro['descripcion']; ?>" required>

        <label for="precio">Precio:</label>
        <input type="string" name="precio" id="precio" value="<?php echo $registro['precio']; ?>" required>

        <label for="estado">Tipo:</label>
        <input type="text" name="estado" id="estado" value="<?php echo $registro['estado']; ?>" required>

        <input type="submit" name="editar" value="Guardar cambios">
    </form>
    <a href="?logout=true">Cerrar sesión</a>
</body>
</html>

