
<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'PoCoYo1-15');
define('DB_NAME', 'SemestraslDSVII');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn === false){
    die("ERROR: No se pudo conectar. " . mysqli_connect_error());
}
?>