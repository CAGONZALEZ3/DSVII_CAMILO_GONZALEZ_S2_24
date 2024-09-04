<?php
function calcular_descuento($total_compra){
    $descuento = 0;
    if ($total_compra >= 100 && $total_compra <= 500) {
        # code...
        $descuento = 5;
    } elseif ($total_compra > 500 && $total_compra <= 1000) {
        # code...
        $descuento = 10;
    }elseif ($total_compra > 1000) {
        # code...
        $descuento = 15;
    }else {
        # code...
        $descuento = 0;
    }
    return $descuento;
    
}
/*• Si la compra es menor a $100, no hay descuento.
• Si la compra es de $100 a $500, aplica un 5% de descuento.
• Si la compra es de $501 a $1000, aplica un 10% de descuento.
• Si la compra es mayor a $1000, aplica un 15% de descuento. La función 
debe devolver el monto del descuento.*/
function aplicar_impuesto($subtotal){
    $impuesto = $subtotal * (7 / 100);
    return $impuesto;
}
/*• Aplica un impuesto del 7% al subtotal.
• Devuelve el monto del impuesto.*/
function calcular_total($subtotal, $descuento, $impuesto){
    $total_des = $subtotal - ($subtotal * ($descuento / 100));
    $total = $total_des + $impuesto;
    return $total;

}//Calcula y devuelve el total a pagar (subtotal - descuento + impuesto)
?>