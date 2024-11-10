<?php
require_once "config_mysqli.php";

function mostrarResumenCategorias($conn) {
    $sql = "SELECT * FROM vista_resumen_categorias";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Resumen por Categorías:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Categoría</th>
            <th>Total Productos</th>
            <th>Stock Total</th>
            <th>Precio Promedio</th>
            <th>Precio Mínimo</th>
            <th>Precio Máximo</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['categoria']}</td>";
        echo "<td>{$row['total_productos']}</td>";
        echo "<td>{$row['total_stock']}</td>";
        echo "<td>{$row['precio_promedio']}</td>";
        echo "<td>{$row['precio_minimo']}</td>";
        echo "<td>{$row['precio_maximo']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}

function mostrarProductosPopulares($conn) {
    $sql = "SELECT * FROM vista_productos_populares LIMIT 5";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Top 5 Productos Más Vendidos:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Producto</th>
            <th>Categoría</th>
            <th>Total Vendido</th>
            <th>Ingresos Totales</th>
            <th>Compradores Únicos</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['producto']}</td>";
        echo "<td>{$row['categoria']}</td>";
        echo "<td>{$row['total_vendido']}</td>";
        echo "<td>{$row['ingresos_totales']}</td>";
        echo "<td>{$row['compradores_unicos']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($result);
}

//1
function mostrarProductosBajoStock($conn) {
    $sql = "SELECT * FROM vista_bajo_stock";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Productos con Bajo Stock:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Producto</th>
            <th>Stock</th>
            <th>Cantidad Vendida</th>
            <th>Ingresos Totales</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['producto']}</td>";
        echo "<td>{$row['stock']}</td>";
        echo "<td>{$row['cantidad_vendida']}</td>";
        echo "<td>{$row['ingresos_totales']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

//2
function mostrarHistorialClientes($conn) {
    $sql = "SELECT * FROM vista_historial_clientes";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Historial de Clientes:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Cliente</th>
            <th>Producto</th>
            <th>Cantidad Total</th>
            <th>Precio Unitario Promedio</th>
            <th>Subtotal</th>
            <th>Fecha Venta</th>
            <th>Total Gastado</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['cliente']}</td>";
        echo "<td>{$row['producto']}</td>";
        echo "<td>{$row['cantidad_total']}</td>";
        echo "<td>{$row['precio_unitario_promedio']}</td>";
        echo "<td>{$row['subtotal']}</td>";
        echo "<td>{$row['fecha_venta']}</td>";
        echo "<td>{$row['total_gastado']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

//3
function mostrarRendimientoCategoria($conn) {
    $sql = "SELECT * FROM vista_rendimiento_categoria";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Rendimiento por Categoría:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Categoría</th>
            <th>Total Productos</th>
            <th>Ventas Totales</th>
            <th>Producto Más Vendido</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['categoria']}</td>";
        echo "<td>{$row['total_productos']}</td>";
        echo "<td>{$row['ventas_totales']}</td>";
        echo "<td>{$row['producto_mas_vendido']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

//4
function mostrarTendenciasVentas($conn) {
    $sql = "SELECT * FROM vista_tendencias_ventas";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Tendencias de Ventas por Mes:</h3>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Mes</th>
            <th>Ventas Totales</th>
            <th>Ventas Mes Anterior</th>
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['mes']}</td>";
        echo "<td>{$row['ventas_totales']}</td>";
        echo "<td>{$row['ventas_mes_anterior']}</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Mostrar los resultados
mostrarResumenCategorias($conn);
mostrarProductosPopulares($conn);
//1.
mostrarProductosBajoStock($conn);
//2.
mostrarHistorialClientes($conn);
//3.
mostrarRendimientoCategoria($conn);
//4.
mostrarTendenciasVentas($conn);

mysqli_close($conn);
?>