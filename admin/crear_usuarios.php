<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location:../index.php");

    exit();
}

include('../conexion.php');

$sql_roles = "SELECT * FROM roles";
$query_roles = mysqli_query($conexion, $sql_roles);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $id_rol = $_POST['id_rol'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);  

    $sql_insert = "INSERT INTO usuarios (nombre, apellido, correo, contraseña, id_rol) VALUES ('$nombre', '$apellido', '$correo', '$contraseña', '$id_rol')";
    $query_insert = mysqli_query($conexion, $sql_insert);

    if ($query_insert) {
        echo "<script>
                alert('Registro exitoso');
                setTimeout(function() {
                    window.location.href = 'usuarios.php';
                }, 500); 
             </script>";
    } else {
        echo "Error al crear el usuario: " . mysqli_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Crear Usuario</title>
</head>
<body>
<div id="container_formulario_usuarios">
    <form action="crear_usuarios.php" method="POST" class="formulariousuarios">
        <h1>Crear Usuario</h1>
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <input type="text" name="apellido" placeholder="Apellido" required><br>
        <input type="email" name="correo" placeholder="Correo" required><br>
        <input type="password" name="contraseña" placeholder="Contraseña" required><br>

        <label for="id_rol">Rol:</label>
        <select name="id_rol">
            <?php while ($row_roles = mysqli_fetch_array($query_roles)): ?>
                <option value="<?= $row_roles['id'] ?>">
                    <?= $row_roles['descripcion'] ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <input type="submit" value="Crear Usuario">
        <br>
        <br>
        <a href="usuarios.php" class="volver_usuarios">Atras</a>
    </form>
</div>
</body>
</html>
