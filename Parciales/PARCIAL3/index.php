<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();

    require_once 'clases.php';

    $Notas = null;
    // Cargar las tareas si aún no se han cargado
    if ($Notas === null) {
        $gestorNotas = new Principal();
        $Notas = $gestorNotas->cargarTablas();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas</title>
    <link  rel="stylesheet" href="clases.css">
</head>
<body>
    
    <div class="containerG">
    <?php echo "Usuario: ".$_SESSION['usuario']. "<br> rol: ".$_SESSION['rol']."<br>"; ?>
        <div>
            <table >
                <thead>
                <td>id</td>
                <td>Usuario</td>
                <td>Nota</td>
                </thead>
                <tbody>
                    <?php foreach($Notas as $nota): ?>
                        <?php if($_SESSION['usuario'] === $nota->usuario || $_SESSION['rol'] === 'PROFESOR'){ ?>
                        <tr>
                        <td><?php echo $nota->id; ?></td>
                            <td><?php echo $nota->usuario; ?></td>
                            <td><?php echo $nota->nota; ?></td>
                        </tr>
                        <?php }; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="container">
            <a type="button" class="button" href="logout.php">logout</a>
        </div>
    </div>
</body>
</html>
