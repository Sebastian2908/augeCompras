<?php
$contraseña1 = $nombre = $apellido = $correo = $conexion = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("conexion.php"); 

    $nombre = isset($_POST['name']) ? $_POST['name'] : null;
    $apellido = isset($_POST['lastname']) ? $_POST['lastname'] : null;
    $correo = isset($_POST['email']) ? $_POST['email'] : null;
    $contraseña1 = isset($_POST['password']) ? $_POST['password'] : null;
    $confirmarContraseña = isset($_POST['confirmarPassword']) ? $_POST['confirmarPassword'] : null;

    if ($contraseña1 !== $confirmarContraseña) {
        echo "<script>
                alert('Las contraseñas no coinciden.');
                setTimeout(function() {
                    window.location.href = 'index.html';
                }, 500); 
            </script>";
        exit();
    }

    $hashedContraseña = password_hash($contraseña1, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, apellido, correo, contraseña, id_rol) 
            VALUES ('$nombre', '$apellido', '$correo', '$hashedContraseña', 2)";

    if ($conexion->query($sql) === TRUE) {
        echo "<script>
                alert('Registro exitoso');
                setTimeout(function() {
                    window.location.href = 'index.html';
                }, 500); 
            </script>";
    } else {
        echo "Error al registrar usuario: " . $conexion->error;
    }

    $conexion->close();
}
?>



