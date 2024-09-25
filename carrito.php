<?php 
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location:../login.html");
    exit();
}

include('conexion.php');

$id_usuario = $_SESSION['usuario_id'];

// Mostrar solo los productos cuyo estado sea 'En proceso'
$sql = "SELECT c.id, c.nombre_producto, c.cantidad, c.precio_unitario, (c.cantidad * c.precio_unitario) AS subtotal, p.nombre AS proveedor 
        FROM carrito_compras c 
        JOIN proveedores p ON c.id_proveedor = p.id
        WHERE c.id_usuario = ? AND c.estado = 'En proceso'";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
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
        <h2>Mi Carrito</h2>
        
        <?php
        if (isset($_SESSION['mensaje_error'])) {
            echo "<div class='error'>" . $_SESSION['mensaje_error'] . "</div>";
            unset($_SESSION['mensaje_error']);
        }
        ?>

        <table class="tablaUsuarios">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Proveedor</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $subtotal = $row['subtotal'];
                        $total += $subtotal; // Sumar cada subtotal al total general

                        echo "<tr>";
                        echo "<td>" . $row['nombre_producto'] . "</td>";
                        echo "<td>" . $row['cantidad'] . "</td>";
                        echo "<td>$" . number_format($row['precio_unitario'], 2) . "</td>";
                        echo "<td>" . $row['proveedor'] . "</td>";
                        echo "<td>$" . number_format($subtotal, 2) . "</td>";
                        echo "<td>";
                        echo "<a href='editar_carrito.php?id=" . $row['id'] . "' class='btn-editar'>Editar</a> | ";
                        echo "<a href='eliminar_item_carrito.php?id=" . $row['id'] . "' class='btn-eliminar' onclick=\"return confirm('¿Quieres eliminar este producto del carrito?');\">Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No tienes productos en el carrito.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Total a Pagar: $<?php echo number_format($total, 2); ?></h3> <!-- Mostrar el total -->

        <form action="finalizar_carrito.php" method="POST">
            <input type="submit" name="finalizar_compra" value="Finalizar Compra" <?php if ($result->num_rows == 0) echo 'disabled'; ?>>
        </form>
    </div>
</div>

<script src="js/script.js"></script>
<script src="js/script1.js"></script>
</body>
</html>

<?php
$conexion->close();
?>
