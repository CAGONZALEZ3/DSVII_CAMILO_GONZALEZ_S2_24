<?php
require_once "config_mysqli.php";

// 1. Mostrar todos los usuarios junto con el número de publicaciones que han hecho
$sql = "SELECT u.id, u.nombre, COUNT(p.id) as num_publicaciones 
        FROM usuarios u 
        LEFT JOIN publicaciones p ON u.id = p.usuario_id 
        GROUP BY u.id";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Usuarios y número de publicaciones:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Usuario: " . $row['nombre'] . ", Publicaciones: " . $row['num_publicaciones'] . "<br>";
    }
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($conn);
}

// 2. Listar todas las publicaciones con el nombre del autor
$sql = "SELECT p.titulo, u.nombre as autor, p.fecha_publicacion 
        FROM publicaciones p 
        INNER JOIN usuarios u ON p.usuario_id = u.id 
        ORDER BY p.fecha_publicacion DESC";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Publicaciones con nombre del autor:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Título: " . $row['titulo'] . ", Autor: " . $row['autor'] . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
    }
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($conn);
}

// 3. Encontrar el usuario con más publicaciones
$sql = "SELECT u.nombre, COUNT(p.id) as num_publicaciones 
        FROM usuarios u 
        LEFT JOIN publicaciones p ON u.id = p.usuario_id 
        GROUP BY u.id 
        ORDER BY num_publicaciones DESC 
        LIMIT 1";

$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo "<h3>Usuario con más publicaciones:</h3>";
    echo "Nombre: " . $row['nombre'] . ", Número de publicaciones: " . $row['num_publicaciones'];
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($conn);
}
//tarea
echo "<h3>Tarea 1</h3>";
$sql = "SELECT p.titulo, u.nombre as autor, p.fecha_publicacion 
        FROM publicaciones p 
        INNER JOIN usuarios u ON p.usuario_id = u.id 
        ORDER BY p.fecha_publicacion DESC
        LIMIT 5";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Ultimas 5 publicaciones con nombre de autor y fecha de publicacionr:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Título: " . $row['titulo'] . ", Autor: " . $row['autor'] . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
    }
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($conn);
}

echo "<h3>Tarea 2</h3>";
$sql = "SELECT nombre, email
        FROM USUARIOS
        where id not in (select usuario_id from publicaciones)";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Usuarios que no tienen publicaciones:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Nombre: " . $row['nombre'] . ", Autor: " . $row['email']."<br>";
    }
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($conn);
}

echo "<h3>Tarea 3</h3>";
$sql = "SELECT count(*) cuantas,COUNT(p.id) / COUNT(DISTINCT u.id) promedio
        FROM USUARIOS u
        LEFT JOIN PUBLICACIONES p ON u.id = p.usuario_id";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Promedio de publicaciones de usuario:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Total Publicaciones: " . $row['cuantas'] . ", Promedio por Usuario: " . $row['promedio']."<br>";
    }
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($conn);
}

echo "<h3>Tarea 4</h3>";
$sql = "SELECT 
            u.id AS usuario_id, 
            u.nombre, 
            MAX(p.fecha_publicacion) AS ultima_fecha_publicacion
        FROM usuarios u
        JOIN publicaciones p ON u.id = p.usuario_id
        GROUP BY u.id";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Ultima Publicacion por Usuario:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Usuario: " . $row['nombre'] . ", Ultima Fecha de publicacion: " . $row['ultima_fecha_publicacion']."<br>";
    }
    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>