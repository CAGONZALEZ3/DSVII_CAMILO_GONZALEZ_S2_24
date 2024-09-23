<?php

// Definimos un arreglo para almacenar estudiantes
$estudiantes = [];

// Función para agregar un estudiante
function agregarEstudiante($id, $nombre, $edad, $carrera) {
    global $estudiantes; // Usamos el arreglo global
    $estudiantes[$id] = [
        'nombre' => $nombre,
        'edad' => $edad,
        'carrera' => $carrera,
        'materias' => []
    ];
}

// Función para agregar materia y calificación
function agregarMateria($id, $materia, $calificacion) {
    global $estudiantes;
    if (isset($estudiantes[$id])) {
        $estudiantes[$id]['materias'][$materia] = $calificacion;
    }
}

// Función para calcular el promedio de un estudiante
function calcularPromedio($id) {
    global $estudiantes;
    if (isset($estudiantes[$id])) {
        $materias = $estudiantes[$id]['materias'];
        $total = 0;
        $cantidad = count($materias);
        foreach ($materias as $calificacion) {
            $total += $calificacion;
        }
        return $cantidad ? $total / $cantidad : 0;
    }
    return 0;
}

// Agregar estudiantes
agregarEstudiante(1, "Ana López", 20, "Ingeniería");
agregarEstudiante(2, "Carlos Gómez", 22, "Medicina");

// Agregar materias
agregarMateria(1, "Matemáticas", 85);
agregarMateria(1, "Física", 90);
agregarMateria(2, "Anatomía", 95);

// Imprimir lista de estudiantes y sus promedios
echo "Lista de estudiantes:\n";
foreach ($estudiantes as $id => $estudiante) {
    $promedio = calcularPromedio($id);
    echo "{$estudiante['nombre']} (ID: $id, Carrera: {$estudiante['carrera']}, Promedio: " . number_format($promedio, 2) . ")\n";
}

// Calcular y mostrar promedio general
$totalPromedio = 0;
$cantidadEstudiantes = count($estudiantes);
foreach ($estudiantes as $id => $estudiante) {
    $totalPromedio += calcularPromedio($id);
}
$promedioGeneral = $cantidadEstudiantes ? $totalPromedio / $cantidadEstudiantes : 0;
echo "Promedio general: " . number_format($promedioGeneral, 2) . "\n";

?>
