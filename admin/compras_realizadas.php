<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location:../index.php");
    exit();
}

include('../conexion.php');

// Consultar todas las compras finalizadas por los usuarios
$sql = "SELECT c.nombre_producto, c.cantidad, c.precio_unitario, (c.cantidad * c.precio_unitario) AS subtotal, 
               p.nombre AS proveedor, c.fecha_compra, u.nombre AS usuario
        FROM carrito_compras c
        JOIN proveedores p ON c.id_proveedor = p.id
        JOIN usuarios u ON c.id_usuario = u.id
        WHERE c.estado = 'Finalizado'
        ORDER BY c.fecha_compra DESC";

$stmt = $conexion->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Compras Realizadas por los Usuarios</title>
</head>
<body>
    <nav class="sidebar close">
         <header class="header-nav">
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
            <h2>Compras Realizadas por los Usuarios</h2>

            <table class="tablaUsuarios">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Proveedor</th>
                        <th>Subtotal</th>
                        <th>Fecha de Compra</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_compras = 0;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $subtotal = $row['subtotal'];
                            $total_compras += $subtotal; // Sumar cada subtotal al total general

                            echo "<tr>";
                            echo "<td>" . $row['usuario'] . "</td>"; // Mostrar el nombre del usuario
                            echo "<td>" . $row['nombre_producto'] . "</td>";
                            echo "<td>" . $row['cantidad'] . "</td>";
                            echo "<td>$" . number_format($row['precio_unitario'], 2) . "</td>";
                            echo "<td>" . $row['proveedor'] . "</td>";
                            echo "<td>$" . number_format($subtotal, 2) . "</td>";
                            echo "<td>" . $row['fecha_compra'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No se han realizado compras.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <h3>Total de Compras: $<?php echo number_format($total_compras, 2); ?></h3> <!-- Mostrar el total de todas las compras -->
        </div>
    </div>

    <script src="../js/script.js"></script>
    <script src="../js/script1.js"></script>
</body>
</html>

<?php
$conexion->close();
?>
