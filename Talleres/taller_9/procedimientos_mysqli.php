<?php
require_once "config_mysqli.php";

// Función para registrar una venta
function registrarVenta($conn, $cliente_id, $producto_id, $cantidad) {
    $query = "CALL sp_registrar_venta(?, ?, ?, @venta_id)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $cliente_id, $producto_id, $cantidad);
    
    try {
        mysqli_stmt_execute($stmt);
        
        // Obtener el ID de la venta
        $result = mysqli_query($conn, "SELECT @venta_id as venta_id");
        $row = mysqli_fetch_assoc($result);
        
        echo "Venta registrada con éxito. ID de venta: " . $row['venta_id'];
    } catch (Exception $e) {
        echo "Error al registrar la venta: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}

// Función para obtener estadísticas de cliente
function obtenerEstadisticasCliente($conn, $cliente_id) {
    $query = "CALL sp_estadisticas_cliente(?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $estadisticas = mysqli_fetch_assoc($result);
        
        echo "<h3>Estadísticas del Cliente</h3>";
        echo "Nombre: " . $estadisticas['nombre'] . "<br>";
        echo "Membresía: " . $estadisticas['nivel_membresia'] . "<br>";
        echo "Total compras: " . $estadisticas['total_compras'] . "<br>";
        echo "Total gastado: $" . $estadisticas['total_gastado'] . "<br>";
        echo "Promedio de compra: $" . $estadisticas['promedio_compra'] . "<br>";
        echo "Últimos productos: " . $estadisticas['ultimos_productos'] . "<br>";
    }
    
    mysqli_stmt_close($stmt);
}

//1
function procesarDevolucion($conn, $venta_id, $producto_id, $cantidad) {
    $query = "CALL sp_procesar_devolucion(?, ?, ?, @mensaje)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $venta_id, $producto_id, $cantidad);
    
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_query($conn, "SELECT @mensaje as mensaje");
    $row = mysqli_fetch_assoc($result);
    echo $row['mensaje'];
    
    mysqli_stmt_close($stmt);
}

//2
function aplicarDescuento($conn, $cliente_id) {
    $query = "CALL sp_aplicar_descuento(?, @descuento)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_query($conn, "SELECT @descuento as descuento");
    $row = mysqli_fetch_assoc($result);
    echo "Descuento aplicado: " . $row['descuento'] . "%";

    mysqli_stmt_close($stmt);
}

//3
function reporteBajoStock($conn) {
    $query = "CALL sp_reporte_bajo_stock()";
    $result = mysqli_query($conn, $query);

    echo "<h3>Productos con Bajo Stock</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Producto: " . $row['nombre'] . " - Stock: " . $row['stock'] . " - Sugerencia de Reposición: " . $row['sugerencia_reposicion'] . "<br>";
    }
}

//4
function calcularComision($conn, $vendedor_id) {
    // Consulta para ejecutar ambas consultas de manera secuencial
    $query = "CALL sp_calcular_comisiones(?, @comision); SELECT @comision as comision";
    
    // Preparar la consulta
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Vincular el parámetro del vendedor_id
        mysqli_stmt_bind_param($stmt, "i", $vendedor_id);

        // Ejecutar la consulta
        if (mysqli_stmt_execute($stmt)) {
            // Procesar el primer resultado (el CALL)
            mysqli_stmt_store_result($stmt);
            
            // Obtener el segundo resultado (SELECT @comision)
            $result = mysqli_query($conn, "SELECT @comision as comision");
            if ($row = mysqli_fetch_assoc($result)) {
                echo "Comisión calculada: $" . $row['comision'];
            }
        } else {
            echo "Error al ejecutar la consulta.";
        }
        
        // Cerrar la declaración
        mysqli_stmt_close($stmt);
    } else {
        echo "Error al preparar la consulta.";
    }
}




// Ejemplos de uso
registrarVenta($conn, 1, 1, 2);
obtenerEstadisticasCliente($conn, 1);

//1
$venta_id = 1;
$producto_id = 2;
$cantidad = 1;
procesarDevolucion($conn, $venta_id, $producto_id, $cantidad);

//2
$cliente_id = 1;
aplicarDescuento($conn, $cliente_id);
//3
reporteBajoStock($conn);
//4
$vendedor_id = 1;
calcularComision($conn, $vendedor_id);


mysqli_close($conn);
?>