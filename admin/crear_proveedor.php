<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location:../index.php");

    exit();
}

include('../conexion.php');

$sql_categoria = "SELECT id, nombre_categoria FROM categorias";
$query_categoria = mysqli_query($conexion, $sql_categoria);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $id_categoria = $_POST['id_categoria'];

    $sql_insert = "INSERT INTO proveedores (nombre, correo, telefono, id_categoria) VALUES ('$nombre', '$correo', '$telefono', '$id_categoria')";
    $query_insert = mysqli_query($conexion, $sql_insert);

    if ($query_insert) {
        echo "<script>
                alert('Registro exitoso');
                setTimeout(function() {
                    window.location.href = 'proveedor.php';
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
    <form action="crear_proveedor.php" method="POST" class="formulariousuarios">
        <h1>Crear Proveedor</h1>
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <input type="email" name="correo" placeholder="Correo" required><br>
        <input type="text" name="telefono" placeholder="Telefono" required><br>

        <label for="id_categoria">Categoria:</label>
        <select name="id_categoria">
            <?php while ($row_categoria = mysqli_fetch_array($query_categoria)): ?>
                <option value="<?= $row_categoria['id'] ?>">
                    <?= $row_categoria['nombre_categoria'] ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <input type="submit" value="Crear Proveedor">
        <br>
        <br>
        <a href="proveedor.php" class="volver_usuarios">Atras</a>
    </form>
</div>
</body>
</html>
