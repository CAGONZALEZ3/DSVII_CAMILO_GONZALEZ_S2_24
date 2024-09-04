<?php
include 'funciones_tienda.php';
include 'includes/header.php';

$productos = ['sueters' => 80,
             'pantalon' => 100,
             'zapatos' => 150, 
             'calcetines' => 20, 
             'gorras' => 30];

$carrito = ['sueters'=>3,
            'pantalon'=>2,
            'zapatos'=>1,
            'calcetines'=>4,
            'gorras'=>2];
?>

<div class="container">
    <h3>Carrito de compras</h3>
    <h3>Carrito:</h3>
    <p>
    <?php
        $valorPro =0;
        $subtotal =0;
        $descuento =0;
        $impuesto = 0;
        foreach ($carrito as $producto => $cantidad) {
            if (isset($productos[$producto])) {
                $valorPro += $productos[$producto] * $cantidad;
                echo "$producto:$valorPro.<br>";
                $subtotal += $valorPro; 
            }
        }
        $descuento = calcular_descuento($subtotal);
        $impuesto = aplicar_impuesto($subtotal);
        $total = calcular_total($subtotal, $descuento, $impuesto);
        echo "<h4>Subtotal: $$subtotal</h4>";
        echo "<h5>Descuento:$descuento% </h5>";
        echo "<h5>Impuesto:$$impuesto</h5>";
        echo "<h4> Total:$$total </h4>";

    ?></p>
</div>


<?php include 'includes/footer.php'; ?>