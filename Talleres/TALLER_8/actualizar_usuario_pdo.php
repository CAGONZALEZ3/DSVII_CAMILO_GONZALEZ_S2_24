
<?php
require_once "config_pdo.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $id = $_POST['id'];
    
    $sql = "UPDATE  usuarios set nombre = :nombre, email = :email where id = :id";

    try {
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":id", $email, PDO::PARAM_INT);
    
            if($stmt->execute()){
                echo "Usuario actualizado con éxito.";
            } else{
                echo "ERROR: No se pudo ejecutar $sql. " . $stmt->errorInfo()[2];
            }
        }
    } catch (PDOException  $e) {
        if ($e->getCode() == 23000) {
            echo "ERROR: El correo electrónico ya está registrado para otro usuario.";
        }
    }
    
    unset($stmt);
}

unset($pdo);
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <div><label>id</label><input type="number" name="id" required></div>
    <input type="submit" value="Actualizar Usuario">
</form>