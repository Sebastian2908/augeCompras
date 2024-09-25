<?php 
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include("conexion.php");
    $errores=array();

    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    if(empty($email)){
        $errores['correo'] = "El email es obligatorio";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "El email es obligatorio";
    }
    if(empty($password)){
        $errores['contraseña'] = "La contraseña es obligatoria";
    }

    if(empty($errores)){

        try {
    
            $sql = "SELECT * FROM usuarios WHERE correo = ?";
            $sentencia = $conexion->prepare($sql);
            $sentencia->bind_param("s", $email);
            $sentencia->execute();

            
            $result = $sentencia->get_result();

            
            if ($result->num_rows > 0) {
                
                while ($user = $result->fetch_assoc()) {
                    
                    if (password_verify($password, $user["contraseña"])) {
                        $_SESSION['usuario_id']=$user["id"];
                        $_SESSION['usuario_nombre']=$user["nombre"];
                        
                        if ($user["id_rol"] == 1) { 
                            header("Location:admin/admin.php");
                        } else {
                            header("Location:inicio.php");
                        }
                    } else {
                        echo "<script>
                                alert('Contraseña o Correo Incorrecto');
                                setTimeout(function() {
                                    window.location.href = 'index.php';
                                }, 500); 
                            </script>";
                    }
                }
            } else {
                echo "No existe en la base de datos";
            }

            $conexion->close();
        } catch (Exception $e) {
            echo "Hubo un error de conexión: " . $e->getMessage();
        }

    }else{
        foreach($errores as $error){
            echo "<br/>".$error."<br/>";
        }
        echo "<br/><a href='index.php'>Regresar al login</a> ";
    }
}

?>
