<?php
require_once "config_mysqli.php";

// 1. Productos que tienen un precio mayor al promedio de su categoría
$sql = "SELECT p.nombre, p.precio, c.nombre as categoria,
        (SELECT AVG(precio) FROM productos WHERE categoria_id = p.categoria_id) as promedio_categoria
        FROM productos p
        JOIN categorias c ON p.categoria_id = c.id
        WHERE p.precio > (
            SELECT AVG(precio)
            FROM productos p2
            WHERE p2.categoria_id = p.categoria_id
        )";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Productos con precio mayor al promedio de su categoría:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Producto: {$row['nombre']}, Precio: {$row['precio']}, ";
        echo "Categoría: {$row['categoria']}, Promedio categoría: {$row['promedio_categoria']}<br>";
    }
    mysqli_free_result($result);
}

// 2. Clientes con compras superiores al promedio
$sql = "SELECT c.nombre, c.email,
        (SELECT SUM(total) FROM ventas WHERE cliente_id = c.id) as total_compras,
        (SELECT AVG(total) FROM ventas) as promedio_ventas
        FROM clientes c
        WHERE (
            SELECT SUM(total)
            FROM ventas
            WHERE cliente_id = c.id
        ) > (
            SELECT AVG(total)
            FROM ventas
        )";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Clientes con compras superiores al promedio:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Cliente: {$row['nombre']}, Total compras: {$row['total_compras']}, ";
        echo "Promedio general: {$row['promedio_ventas']}<br>";
    }
    mysqli_free_result($result);
}

    // 1. Productos que nunca se han vendido
        $sql = "SELECT p.nombre, p.precio, c.nombre AS categoria
        FROM productos p
        JOIN categorias c ON p.categoria_id = c.id
        WHERE p.id NOT IN (SELECT producto_id FROM detalles_venta)";

        $result = mysqli_query($conn, $sql);

        if ($result) {
        echo "<h3>Productos que nunca se han vendido:</h3>";
        if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "Producto: {$row['nombre']}, Precio: {$row['precio']}, Categoría: {$row['categoria']}<br>";
        }
        } else {
        echo "No hay productos que no se hayan vendido.<br>";
        }
        mysqli_free_result($result);
        } else {
        echo "Error en la consulta: " . mysqli_error($conn);
        }

    // 2. Listar las categorías con el número de productos y el valor total del inventario
    $sql = "SELECT c.nombre AS categoria,
                COUNT(p.id) AS numero_productos,
                SUM(p.precio * p.stock) AS valor_total_inventario
            FROM categorias c
            LEFT JOIN productos p ON c.id = p.categoria_id
            GROUP BY c.id";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Categorías con el número de productos y el valor total del inventario:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Categoría: {$row['categoria']}, Número de productos: {$row['numero_productos']}, Valor total del inventario: {$row['valor_total_inventario']}<br>";
    }
    mysqli_free_result($result);

    // 3. Encontrar los clientes que han comprado todos los productos de una categoría específica
    $categoria_id = 3; 
    $sql = "SELECT c.nombre AS cliente
            FROM clientes c
            JOIN ventas v ON c.id = v.cliente_id
            JOIN detalles_venta dv ON v.id = dv.venta_id
            JOIN productos p ON dv.producto_id = p.id
            WHERE p.categoria_id = ?
            GROUP BY c.id
            HAVING COUNT(DISTINCT p.id) = (
                SELECT COUNT(*)
                FROM productos
                WHERE categoria_id = ?
            )";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $categoria_id, $categoria_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    echo "<h3>Clientes que han comprado todos los productos de una categoría específica:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Cliente: {$row['cliente']}<br>";
    }
    mysqli_free_result($result);

    // 4. Calcular el porcentaje de ventas de cada producto respecto al total de ventas
    $sql = "SELECT p.nombre AS producto,
                SUM(dv.cantidad * dv.precio_unitario) AS total_ventas_producto,
                (SUM(dv.cantidad * dv.precio_unitario) / (SELECT SUM(cantidad * precio_unitario) FROM detalles_venta) * 100) AS porcentaje_ventas
            FROM productos p
            JOIN detalles_venta dv ON p.id = dv.producto_id
            GROUP BY p.id";

    $result = mysqli_query($conn, $sql);

    echo "<h3>Porcentaje de ventas de cada producto respecto al total de ventas:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Producto: {$row['producto']}, Total ventas: {$row['total_ventas_producto']}, Porcentaje ventas: {$row['porcentaje_ventas']}%<br>";
    }
    mysqli_free_result($result);

mysqli_close($conn);
?>