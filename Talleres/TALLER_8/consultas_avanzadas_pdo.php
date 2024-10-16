<?php
require_once "config_pdo.php";

try {
    // 1. Mostrar todos los usuarios junto con el número de publicaciones que han hecho
    $sql = "SELECT u.id, u.nombre, COUNT(p.id) as num_publicaciones 
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            GROUP BY u.id";

    $stmt = $pdo->query($sql);

    echo "<h3>Usuarios y número de publicaciones:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Usuario: " . $row['nombre'] . ", Publicaciones: " . $row['num_publicaciones'] . "<br>";
    }

    // 2. Listar todas las publicaciones con el nombre del autor
    $sql = "SELECT p.titulo, u.nombre as autor, p.fecha_publicacion 
            FROM publicaciones p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            ORDER BY p.fecha_publicacion DESC";

    $stmt = $pdo->query($sql);

    echo "<h3>Publicaciones con nombre del autor:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Título: " . $row['titulo'] . ", Autor: " . $row['autor'] . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
    }

    // 3. Encontrar el usuario con más publicaciones
    $sql = "SELECT u.nombre, COUNT(p.id) as num_publicaciones 
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            GROUP BY u.id 
            ORDER BY num_publicaciones DESC 
            LIMIT 1";

    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<h3>Usuario con más publicaciones:</h3>";
    echo "Nombre: " . $row['nombre'] . ", Número de publicaciones: " . $row['num_publicaciones'];

    // Tarea 1
    echo "<h1>Tarea 1</h1>";
    $sql = "SELECT p.titulo, u.nombre as autor, p.fecha_publicacion 
            FROM publicaciones p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            ORDER BY p.fecha_publicacion DESC
            LIMIT 5";

    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<h3>Ultimas 5 publicaciones con nombre de autor y fecha de publicacion:</h3>";
    if($row){
        do  {
            echo "Título: " . $row['titulo'] . ", Autor: " . $row['autor'] . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
        }while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    }
    

    // tarea 2
    echo "<h1>Tarea 2</h1>";
    $sql = "SELECT nombre, email
        FROM USUARIOS
        where id not in (select usuario_id from publicaciones)";

    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<h3>Usuarios que no tienen publicaciones:</h3>";
    if ($row){
        do {
            echo "Nombre: " . $row['nombre'] . ", Autor: " . $row['email']."<br>";
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    }

    // tarea 3
    echo "<h1>Tarea 3</h1>";
    $sql = "SELECT count(*) cuantas,COUNT(p.id) / COUNT(DISTINCT u.id) promedio
            FROM USUARIOS u
            LEFT JOIN PUBLICACIONES p ON u.id = p.usuario_id";

    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<h3>Promedio de publicaciones de usuario:</h3>";
    echo "Total Publicaciones: " . $row['cuantas'] . ", Promedio por Usuario: " . $row['promedio']."<br>";

    // tarea 4
    echo "<h1>Tarea 4</h1>";
    $sql = "SELECT 
            u.id AS usuario_id, 
            u.nombre, 
            MAX(p.fecha_publicacion) AS ultima_fecha_publicacion
        FROM usuarios u
        JOIN publicaciones p ON u.id = p.usuario_id
        GROUP BY u.id";

    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<h3>Ultima Publicacion por Usuario:</h3>";
    if ($row){
        do {
            echo "Usuario: " . $row['nombre'] . ", Ultima Fecha de publicacion: " . $row['ultima_fecha_publicacion']."<br>";
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>