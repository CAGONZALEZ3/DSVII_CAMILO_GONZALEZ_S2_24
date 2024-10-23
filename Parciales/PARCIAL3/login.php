<?php
    require_once 'clases.php';
    session_start();
    // Si ya hay una sesión activa, redirigir al panel
    if(isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit();
        }
    
    $validar = new Principal();
    $validacion = [];

    // Procesar el formulario cuando se envía
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario_logib'];
    $contrasena = $_POST['password_login'];
    $validacion = $validar->logins($usuario,$contrasena);

    $isValid = $validacion[0];
    $rol = $validacion[1];
    echo strlen($usuario);
    // En un caso real, verificaríamos contra una base de datos
    if(strlen($usuario) > 3 && strlen($contrasena) > 5){
        if($isValid){
            $_SESSION['usuario'] = $usuario;
            $_SESSION['rol'] = $rol;
            header("Location: index.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    }
    elseif (strlen($usuario) < 3) {
        $error = "El tamaño del usuario es menor a 3 caracteres";
    }elseif (strlen($contrasena) < 5) {
        $error = "El tamaño del contraseña es menor a 5 caracteres";
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link  rel="stylesheet" href="clases.css">
</head>
<body>
    <form action="" method="post">
        <div class="containerG">
            <h2>Login</h2>
            <?php
                if (isset($error)) {
                    echo "<p style='color: red;'>$error</p>";
                }
            ?>
            <div class="container">
                <input type="usuario" name="usuario_logib" id="usuario_logib" require>
            </div>
            <div class="container">
                <input type="password" name="password_login" id="password_login" require>
            </div>
            <button class="button" type="submit">Iniciar Sesion</button>
        </div>
    </form>
</body>
</html>