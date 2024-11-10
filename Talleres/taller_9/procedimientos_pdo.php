<?php
require_once "config_pdo.php";

// Función para registrar una venta
function registrarVenta($pdo, $cliente_id, $producto_id, $cantidad) {
    try {
        $stmt = $pdo->prepare("CALL sp_registrar_venta(:cliente_id, :producto_id, :cantidad, @venta_id)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->execute();
        
        // Obtener el ID de la venta
        $result = $pdo->query("SELECT @venta_id as venta_id")->fetch(PDO::FETCH_ASSOC);
        
        echo "Venta registrada con éxito. ID de venta: " . $result['venta_id'];
    } catch (PDOException $e) {
        echo "Error al registrar la venta: " . $e->getMessage();
    }
}

// Función para obtener estadísticas de cliente
function obtenerEstadisticasCliente($pdo, $cliente_id) {
    try {
        $stmt = $pdo->prepare("CALL sp_estadisticas_cliente(:cliente_id)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $estadisticas = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Estadísticas del Cliente</h3>";
        echo "Nombre: " . $estadisticas['nombre'] . "<br>";
        echo "Membresía: " . $estadisticas['nivel_membresia'] . "<br>";
        echo "Total compras: " . $estadisticas['total_compras'] . "<br>";
        echo "Total gastado: $" . $estadisticas['total_gastado'] . "<br>";
        echo "Promedio de compra: $" . $estadisticas['promedio_compra'] . "<br>";
        echo "Últimos productos: " . $estadisticas['ultimos_productos'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

//1
function procesarDevolucionPDO($pdo, $venta_id, $producto_id, $cantidad) {
    $stmt = $pdo->prepare("CALL sp_procesar_devolucion(:venta_id, :producto_id, :cantidad, @mensaje)");
    $stmt->bindParam(':venta_id', $venta_id);
    $stmt->bindParam(':producto_id', $producto_id);
    $stmt->bindParam(':cantidad', $cantidad);

    $stmt->execute();

    $result = $pdo->query("SELECT @mensaje as mensaje")->fetch();
    echo $result['mensaje'];
}

//2
function aplicarDescuentoPDO($pdo, $cliente_id) {
    $stmt = $pdo->prepare("CALL sp_aplicar_descuento(:cliente_id, @descuento)");
    $stmt->bindParam(':cliente_id', $cliente_id);
    
    $stmt->execute();

    $result = $pdo->query("SELECT @descuento as descuento")->fetch();
    echo "Descuento aplicado: " . $result['descuento'] . "%";
}

//3
function reporteBajoStockPDO($pdo) {
    $stmt = $pdo->query("CALL sp_reporte_bajo_stock()");
    
    echo "<h3>Productos con Bajo Stock</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Producto: " . $row['nombre'] . " - Stock: " . $row['stock'] . " - Sugerencia de Reposición: " . $row['sugerencia_reposicion'] . "<br>";
    }
}

//
function calcularComisionPDO($pdo, $vendedor_id) {
    $stmt = $pdo->prepare("CALL sp_calcular_comisiones(:vendedor_id, @comision)");
    $stmt->bindParam(':vendedor_id', $vendedor_id);
    
    $stmt->execute();

    $result = $pdo->query("SELECT @comision as comision")->fetch();
    echo "Comisión calculada: $" . $result['comision'];
}

// Ejemplos de uso
registrarVenta($pdo, 1, 1, 2);
obtenerEstadisticasCliente($pdo, 1);

//1
$venta_id = 1;
$producto_id = 2;
$cantidad = 1;
procesarDevolucion($pdo, $venta_id, $producto_id, $cantidad);

//2
$cliente_id = 1;
aplicarDescuento($pdo, $cliente_id);
//3
reporteBajoStock($pdo);
//4
$vendedor_id = 1;
calcularComision($pdo, $vendedor_id);

$pdo = null;
?>