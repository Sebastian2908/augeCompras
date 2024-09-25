<?php
include('../conexion.php');

$id = $_GET['id'];

$sql_usuario = "SELECT * FROM usuarios WHERE id='$id'";
$query_usuario = mysqli_query($conexion, $sql_usuario);
$row_usuario = mysqli_fetch_array($query_usuario);

$sql_roles = "SELECT * FROM roles";
$query_roles = mysqli_query($conexion, $sql_roles);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $id_rol = $_POST['id_rol'];

    $sql_update = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', correo='$correo', id_rol='$id_rol' WHERE id='$id'";
    $query_update = mysqli_query($conexion, $sql_update);

    if ($query_update) {
        echo "<script>
                alert('Registro actualizado');
                setTimeout(function() {
                    window.location.href = 'usuarios.php';
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
        <form action="editar_usuarios.php?id=<?= $id ?>" method="POST" class="formulariousuarios">
            <h1>Editar Usuario</h1>

            <input type="hidden" name="id" value="<?= $row_usuario['id'] ?>">
            <input type="text" name="nombre" placeholder="Nombre" value="<?= $row_usuario['nombre'] ?>" require>
            <input type="text" name="apellido" placeholder="Apellido" value="<?= $row_usuario['apellido'] ?>" require>
            <input type="email" name="correo" placeholder="Correo" value="<?= $row_usuario['correo'] ?>" require>
            
            <label for="id_rol">Rol:</label>
            <select name="id_rol">
                <?php while ($row_roles = mysqli_fetch_array($query_roles)): ?>
                    <option value="<?= $row_roles['id'] ?>" <?= ($row_roles['id'] == $row_usuario['id_rol']) ? 'selected' : '' ?>>
                        <?= $row_roles['descripcion'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <input type="submit" value="Actualizar Información">
            <br>
            <br>
            <a href="usuarios.php" class="volver_usuarios">Atras</a>
        </form>
    </div>
</body>
</html>
