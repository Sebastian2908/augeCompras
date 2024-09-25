<?php 
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header("Location: index.php");
        exit();
    }

    include("conexion.php");

    // Consulta para obtener productos y sus proveedores
    $query = "SELECT productos.id, productos.nombre_producto, productos.imagen, productos.precio_unitario, proveedores.nombre AS proveedor 
              FROM productos 
              JOIN proveedores ON productos.id_proveedor = proveedores.id";
    $result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Mi Carrito</title>
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img id="logo-img" src="img/auge.jpg" alt="logo">
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
                        <a href="inicio.php">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Inicio</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="carrito.php">
                            <i class='bx bxs-cart icon'></i>
                            <span class="text nav-text">Mi Carrito</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="bottom-content">
                <li class="">
                    <a href="cerrar.php" onclick="return confirm('¿Deseas Cerrar Sesión?');">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Cerrar Sesion</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>

    <div class="home_">
        <div id="main-container">
        <div class="productos">
        <?php
        // Verificar si hay productos disponibles
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="producto">
                <img src="<?= $row['imagen']; ?>" alt="<?= $row['nombre_producto']; ?>" class="imagen-producto">
                <h3><?= $row['nombre_producto']; ?></h3>
                <p>Proveedor: <?= $row['proveedor']; ?></p>
                <p>Precio: $<?= $row['precio_unitario']; ?></p>
                <form action="agregar_al_carrito.php" method="POST">
                    <input type="hidden" name="id_producto" value="<?= $row['id']; ?>">
                    <input type="number" name="cantidad" min="1" value="1" required>
                    <input type="submit" value="Agregar al carrito"> 
                </form>
            </div>
        <?php
            }
        } else {
        ?>
            <p>No hay productos disponibles.</p>
        <?php
        }
        ?>
    </div>
        </div>
    </div>

    <script src="js/script.js"></script>
    <script src="js/script1.js"></script>
</body>
</html>
