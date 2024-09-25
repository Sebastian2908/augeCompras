<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location:../index.php");

    exit();
}
include('../conexion.php');

$id = $_GET['id'];

$sql_usuario = "SELECT * FROM proveedores WHERE id='$id'";
$query_usuario = mysqli_query($conexion, $sql_usuario);
$row_proveedor = mysqli_fetch_array($query_usuario);

$sql_categoria = "SELECT id, nombre_categoria FROM categorias";
$query_categoria = mysqli_query($conexion, $sql_categoria);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $id_categoria = $_POST['id_categoria'];

    $sql_update = "UPDATE proveedores SET nombre='$nombre', correo='$correo', telefono='$telefono', id_categoria='$id_categoria' WHERE id='$id'";
    $query_update = mysqli_query($conexion, $sql_update);

    if ($query_update) {
        echo "<script>
                alert('Registro actualizado');
                setTimeout(function() {
                    window.location.href = 'proveedor.php';
                }, 500); 
             </script>";
    } else {
        echo "Error al actualizar el usuario: " . mysqli_error($conexion);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Editar Usuario</title>
</head>
<body>
<div id="container_formulario_usuarios">
        <form action="editar_proveedor.php?id=<?= $id ?>" method="POST" class="formulariousuarios">
            <h1>Editar Usuario</h1>

            <input type="hidden" name="id" value="<?= $row_proveedor['id'] ?>">
            <input type="text" name="nombre" placeholder="Nombre" value="<?= $row_proveedor['nombre'] ?>" require>
            <input type="text" name="telefono" placeholder="telefono" value="<?= $row_proveedor['telefono'] ?>" require>
            <input type="email" name="correo" placeholder="Correo" value="<?= $row_proveedor['correo'] ?>" require>
            
            <label for="id_categoria">Categoria:</label>
            <select name="id_categoria">
                <?php while ($row_categoria = mysqli_fetch_array($query_categoria)): ?>
                    <option value="<?= $row_categoria['id'] ?>" <?= ($row_categoria['id'] == $row_proveedor['id_categoria']) ? 'selected' : '' ?>>
                        <?= $row_categoria['nombre_categoria'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <input type="submit" value="Actualizar Información">
            <br>
            <br>
            <a href="proveedor.php" class="volver_usuarios">Atras</a>
        </form>
    </div>
</body>
</html>
