<?php
include 'utilidades_texto.php';
include 'includes/header.php';

$dato1 = "tres tristes tigres comen trigo en un trigal";
$dato2 = "Funcion para contar la cantidad de vocales que hay en un texto";
$dato3 = "Funcion para retornar el orden de palabras invetido";
$dato_array = ["tres tristes tigres comen trigo en un trigal","Funcion para contar la cantidad de vocales que hay en un texto","Funcion para retornar el orden de palabras invetido"];


?>

<div class="container">
    <h3>Funcion para contar palabras</h3>
    <h3>Texto: <?php echo $dato1?></h3>
    <p>
    <?php

    echo "Cantidad de palabras: ".contar_palabras($dato1);
    ?></p>
</div>
<div class="container">
    <h3>Funcion para contar las vocales de un texto</h3>
    <h3>Texto: <?php echo $dato2?></h3>
    <p>
    <?php

    echo "Cantidad de vocales en el texto: ".contar_vocales($dato2);
    ?></p>
</div>
<div class="container">
    <h3>Funcion para invertir el orden del texto</h3>
    <h3>Texto: <?php echo $dato1?></h3>
    <p>
    <?php

    echo "Texto Invertido: ".invertir_palabras($dato1);
    ?></p>
</div>
<div class="container">
    <table border='1'>
        <tr>
            <td><h4>Contar Palabras</h4></td>
            <td><h4>Contar Vocales</h4></td>
            <td><h4>Invertir texto</h4></td>
        </tr>
        <?php
            foreach($dato_array as $texto){
                $cpalabras = contar_palabras($texto);
                $cvocales = contar_vocales($texto);
                $itexto = invertir_palabras($texto);
            echo "<tr>";
                echo "<td><p> $cpalabras </p></td>";
                echo "<td><p> $cvocales </p></td>";
                echo "<td><p> $itexto </p></td>";
            echo "</tr>";
            }
        ?>
    </table>
</div>

<?php include 'includes/footer.php'; ?>