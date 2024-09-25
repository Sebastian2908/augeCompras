<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location:../login.html");
    exit();
}

include('conexion.php');

$id_usuario = $_SESSION['usuario_id'];

// Verificar si el carrito tiene productos en estado 'En proceso'
$sql_check = "SELECT COUNT(*) AS total_productos FROM carrito_compras WHERE id_usuario = ? AND estado = 'En proceso'";
$stmt_check = $conexion->prepare($sql_check);
$stmt_check->bind_param("i", $id_usuario);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$row_check = $result_check->fetch_assoc();

// Si el carrito está vacío, redirigir de nuevo al carrito con un mensaje
if ($row_check['total_productos'] == 0) {
    $_SESSION['mensaje_error'] = "El carrito está vacío. No puedes finalizar la compra.";
    header("Location: carrito.php");
    exit();
}

// Actualizar el estado de los productos en el carrito a 'Finalizado'
$sql_update = "UPDATE carrito_compras SET estado = 'Finalizado' WHERE id_usuario = ? AND estado = 'En proceso'";
$stmt = $conexion->prepare($sql_update);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();

$conexion->close();


echo "<script>
        alert('Compra realizada con exito');
        setTimeout(function() {
        window.location.href = 'inicio.php';
        }, 500); 
    </script>";
exit();
?>


