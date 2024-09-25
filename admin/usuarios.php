<?php 
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header("Location:../index.php");

        exit();
    }

    include('../conexion.php');
    $query = mysqli_query($conexion, "SELECT id, nombre, apellido, correo, id_rol FROM usuarios");
    if (!$query) {
        die('Error en la consulta: ' . mysqli_error($conexion));
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Document</title>
</head>
    <body>
        <nav class="sidebar close">
            <header>
                <div class="image-text">
                        <span class="image">
                            <img id="logo-img" src="../img/auge.jpg" alt="logo">
                        </span>

                        <div class="text header-text">
                            <span class="name"><span class="au">AU</span><span class="p">GE</span> Compras</span>
                            <span class="user">Bienvenid@ <?php echo $_SESSION['usuario_nombre']; ?></span>
                        </div>
                    </div>

                    <i class='bx bx-chevron-right toggle'></i>
            </header>

            <div class="menu-bar">
                <div class="menu">
                    <ul class="menu-links">
                        <li class="nav-link">
                            <a href="compras_realizadas.php">
                                <i class='bx bx-cart icon'></i>
                                <span class="text nav-text">Compras</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="#">
                                <i class='bx bx-comment-add icon' ></i>
                                <span class="text nav-text">Productos</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="proveedor.php">
                                <i class='bx bxs-user icon'></i>
                                <span class="text nav-text">Proveedores</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="usuarios.php">
                                <i class='bx bx-user icon'></i>
                                <span class="text nav-text">Usuarios</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <br>
                <br>
                <div class="bottom-content">
                    <li class="">
                        <a href="admin_cerrar.php" onclick="return confirm('¿Deseas Cerrar Sesión?');">
                            <i class='bx bx-log-out icon'></i>
                            <span class="text nav-text">Cerrar Sesion</span>
                        </a>
                    </li>
                </div>
            </div>
        </nav>

        <div class="home_">
            <div id="main-container">
                <div class="text">Usuarios</div>
                <br>
                <a href="crear_usuarios.php" class="nuevoUsuario">Nuevo Usuario</a>
                <br>
                <br>
                    <table class="tablaUsuarios">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Email</th>
                                <th>Acciones</th>
                                <th></th>   
                            </tr>
                        </thead>
                        <tbody>
                            <?Php while($row = mysqli_fetch_array($query)): ?>
                            <tr>
                                <th><?= $row['id']?></th>
                                <th><?= $row['nombre']?></th>
                                <th><?= $row['apellido']?></th>
                                <th><?= $row['correo']?></th>    

                                <th><a href="editar_usuarios.php?id=<?= $row['id'] ?>" class="btn-editar">Editar</a></th>
                                <td><a href="eliminar_usuarios.php?id=<?= $row['id'] ?>" class="btn-eliminar" onclick="return confirm('¿Quieres ELIMINAR este registro?');">Eliminar</a></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
            </div>
        </div>
        <script src="../js/script.js"></script>
        <script src="../js/script1.js"></script>
    </body>
</html>