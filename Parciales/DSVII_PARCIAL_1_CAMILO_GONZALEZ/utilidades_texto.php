<?php
function contar_palabras($texto){
    return str_word_count($texto);
} //Recibe una cadena de texto y devuelve el número de palabras en el texto.
function contar_vocales($texto){

    preg_match_all('/[aeiouáéíóúüAEIOUÁÉÍÓÚÜ]/', $texto, $matches);
    return count($matches[0]);

}//Recibe una cadena de texto y devuelve el número de vocales (a, e, i, o, u, sin distinguir entre mayúsculas y minúsculas).
function invertir_palabras($texto){
    $palabras = explode(' ', $texto);
    
    // Invierte el orden de las palabras en el array
    $palabrasInvertidas = array_reverse($palabras);
    
    // Une el array de palabras en una cadena de texto
    $textoInvertido = implode(' ', $palabrasInvertidas);
    
    return $textoInvertido;
}//Recibe una cadena de texto y devuelve una nueva cadena con el orden de las palabras invertido
?>