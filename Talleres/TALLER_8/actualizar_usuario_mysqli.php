<?php
require_once "config_mysqli.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $id = intval( $_POST['id']);
    
    $sql = "UPDATE  usuarios set nombre = ?, email = ? where id = ?";
    
    try {
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "ssi", $nombre, $email, $id);
            
            if(mysqli_stmt_execute($stmt)){
                echo "Usuario Actualizado con exito.";
            } else{
                echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($conn);
            }
        }
    } catch (mysqli_sql_exception  $e) {
        // Capturar error de duplicado de entrada (código de error 1062)
        if ($e->getCode() == 1062) {
            echo "ERROR: El correo electrónico ya está registrado para otro usuario.";
        }
    }
    
    
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <div><label>id</label><input type="number" name="id" required></div>
    <input type="submit" value="Actualizar Usuario">
</form>