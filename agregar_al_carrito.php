<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location:../login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("conexion.php");

    // Obtener el ID del usuario desde la sesión
    if (isset($_SESSION['usuario_id'])) {
        $id_usuario = $_SESSION['usuario_id'];  // ID del usuario que está añadiendo productos al carrito
    } else {
        echo "Debes iniciar sesión para agregar productos al carrito.";
        exit();
    }

    $id_producto = $_POST['id_producto'];
    $cantidad = $_POST['cantidad'];

    // Obtener detalles del producto
    $query_producto = "SELECT nombre_producto, precio_unitario, id_proveedor FROM productos WHERE id = '$id_producto'";
    $result_producto = mysqli_query($conexion, $query_producto);
    $producto = mysqli_fetch_assoc($result_producto);

    // Datos del producto
    $nombre_producto = $producto['nombre_producto'];
    $precio_unitario = $producto['precio_unitario'];
    $id_proveedor = $producto['id_proveedor'];

    // Insertar en el carrito con el id_usuario
    $sql = "INSERT INTO carrito_compras (nombre_producto, cantidad, precio_unitario, id_proveedor, id_usuario) 
            VALUES ('$nombre_producto', '$cantidad', '$precio_unitario', '$id_proveedor', '$id_usuario')";

    if (mysqli_query($conexion, $sql)) {
        echo "<script>
                alert('Producto agregado al carrito');
                setTimeout(function() {
                    window.location.href = 'inicio.php';
                }, 500); 
             </script>";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>
