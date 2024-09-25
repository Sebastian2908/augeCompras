<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.html");
    exit();
}

include('conexion.php');

$id_usuario = $_SESSION['usuario_id'];
$id_producto = $_GET['id'];

// Eliminar el producto del carrito
$sql_delete = "DELETE FROM carrito_compras WHERE id = ? AND id_usuario = ? AND estado = 'En proceso'";
$stmt_delete = $conexion->prepare($sql_delete);
$stmt_delete->bind_param("ii", $id_producto, $id_usuario);
$stmt_delete->execute();

header("Location: carrito.php");
exit();
?>
