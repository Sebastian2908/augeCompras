<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.html");
    exit();
}

include('conexion.php');

$id_usuario = $_SESSION['usuario_id'];
$id_producto = $_GET['id'];

// Obtener la cantidad actual del producto en el carrito
$sql = "SELECT cantidad FROM carrito_compras WHERE id = ? AND id_usuario = ? AND estado = 'En proceso'";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ii", $id_producto, $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cantidad_actual = $row['cantidad'];
} else {
    $_SESSION['mensaje_error'] = "No se encontró el producto en el carrito.";
    header("Location: carrito.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva_cantidad = $_POST['cantidad'];

    $sql_update = "UPDATE carrito_compras SET cantidad = ? WHERE id = ? AND id_usuario = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("iii", $nueva_cantidad, $id_producto, $id_usuario);
    $stmt_update->execute();

    header("Location: carrito.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Editar Carrito</title>
</head>
<body>
    <div id="main-container">
        <h2>Editar Cantidad del Producto</h2>

        <form action="" method="POST">
            <label for="cantidad">Nueva Cantidad:</label>
            <input type="number" name="cantidad" id="cantidad" value="<?php echo $cantidad_actual; ?>" min="1" required>
            <input type="submit" value="Actualizar">
        </form>

        <a href="carrito.php">Volver al Carrito</a>
    </div>
</body>
</html>

<?php
$conexion->close();
?>
