<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUGE Compras</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="nav">
            <a href="#" class="nav_logo">
                <img src="img/auge.jpg" alt="" class="logo_image">
            </a>
    
            <ul class="nav_items">
                <li class="nav_item">
                    <a href="" class="nav_link">Inicio</a>
                    <a href="" class="nav_link">Servicios</a>
                    <a href="" class="nav_link">Contacto</a>
                </li>
            </ul>

            <button class="button" id="form-open">Iniciar Sesion</button>
         </nav>
     </header>

     <!-- Inicio -->
     <section class="home">
        <img src="img/compras.jpg" class="home">
        <div class="form_container">
            <i class="uil uil-times form_close"></i>
            <!-- Login -->
            <div class="form login_form">
                <form action="login.php" id="formularioLogin" method="post">
                    <h2>Iniciar Sesion</h2>

                    <div class="input_box">
                        <input type="email" name="email" id="email" placeholder="Ingrese su correo" required>
                        <i class="uil uil-envelope-alt email"></i>
                    </div>
                    <div class="input_box">
                        <input type="password" name="password" id="password" placeholder="Ingrese su contraseña" required>
                        <i class="uil uil-lock password"></i>
                        <i class="uil uil-eye-slash pw_hide"></i>
                    </div>

                    <div class="option_field">
                        <span class="checkbox">
                            <input type="checkbox" id="check">
                            <label for="check">Recuerda me</label>
                        </span>
                        <a href="#" class="forgot_pw">¿Olvidaste tu contraseña?</a>
                    </div>

                    <button class="button">Iniciar Sesion</button>
                    
                    <div class="login_signup">¿No tienes una cuenta? <a href="#" id="signup">Registrarse</a></div>
                </form>
            </div>

            <!-- Signup Form -->

            <div class="form signup_form">
                <form action="registro.php" id="formularioDeRegistro" method="post">
                    <h2>Registrarse</h2>

                    <div class="input_box">
                        <input type="text" name="name" id="name" placeholder="Ingrese su Nombre" required>
                        <i class="uil uil-user email"></i>
                    </div>
                    <div class="input_box">
                        <input type="text" name="lastname" id="lastname" placeholder="Ingrese su Apellido" required>
                        <i class="uil uil-user email"></i>
                    </div>
                    <div class="input_box">
                        <input type="email" name="email" id="email" placeholder="Ingrese su correo" required>
                        <i class="uil uil-envelope-alt email"></i>
                    </div>
                    <div class="input_box">
                        <input type="password" name="password" id="password" placeholder="Ingrese su contraseña" required>
                        <i class="uil uil-lock password"></i>
                        <i class="uil uil-eye-slash pw_hide"></i>
                    </div>
                    <div class="input_box">
                        <input type="password" name="confirmarPassword" id="confirmarPassword" placeholder="Confirmar contraseña" required>
                        <i class="uil uil-lock password"></i>
                        <i class="uil uil-eye-slash pw_hide"></i>
                    </div>

                    <button class="button">Registrarse</button>
                    
                    <div class="login_signup">¿Ya tienes una cuenta? <a href="#" id="login">Iniciar Sesion</a></div>
                </form>
            </div>
        </div>
     </section>
     <script src="js/script.js"></script>
</body>
</html>