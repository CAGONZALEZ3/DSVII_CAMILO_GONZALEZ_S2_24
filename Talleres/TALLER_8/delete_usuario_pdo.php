
<?php
require_once "config_pdo.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    
    $sql = "DELETE FROM   usuarios where email = :email";
    
    try {
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            
            if($stmt->execute()){
                echo "Usuario Eliminado con éxito.";
            } else{
                echo "ERROR: No se pudo ejecutar $sql. " . $stmt->errorInfo()[2];
            }
        }
    } catch (PDOException $e) {
        echo $e;
    }
    
    
    unset($stmt);
}

unset($pdo);
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" value="Eliminar Usuario">
</form>