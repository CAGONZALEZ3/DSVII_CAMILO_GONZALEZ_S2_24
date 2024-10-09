<?php


interface Detalle {
    public function obtenerDetallesEspecificos(): string;
}


abstract class Entrada implements Detalle {
    public $id;
    public $fecha_creacion;
    public $tipo;

    public function __construct($id, $fecha_creacion, $tipo) {
        $this->id = $id;
        $this->fecha_creacion = $fecha_creacion;
        $this->tipo = $tipo;
    }

    
    abstract public function obtenerDetallesEspecificos(): string;
}


class EntradaUnaColumna extends Entrada {
    public $titulo;
    public $descripcion;

    public function __construct($id, $fecha_creacion, $tipo, $titulo, $descripcion) {
        parent::__construct($id, $fecha_creacion, $tipo);
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
    }

    public function obtenerDetallesEspecificos(): string {
        return "Título: $this->titulo, Descripción: $this->descripcion";
    }
}


class EntradaDosColumnas extends Entrada {
    public $titulo1;
    public $descripcion1;
    public $titulo2;
    public $descripcion2;

    public function __construct($id, $fecha_creacion, $tipo, $titulo1, $descripcion1, $titulo2, $descripcion2) {
        parent::__construct($id, $fecha_creacion, $tipo);
        $this->titulo1 = $titulo1;
        $this->descripcion1 = $descripcion1;
        $this->titulo2 = $titulo2;
        $this->descripcion2 = $descripcion2;
    }


    public function obtenerDetallesEspecificos(): string {
        return "Columna 1 - Título: $this->titulo1, Descripción: $this->descripcion1; Columna 2 - Título: $this->titulo2, Descripción: $this->descripcion2";
    }
}


class EntradaTresColumnas extends Entrada {
    public $titulo1;
    public $descripcion1;
    public $titulo2;
    public $descripcion2;
    public $titulo3;
    public $descripcion3;

    public function __construct($id, $fecha_creacion, $tipo, $titulo1, $descripcion1, $titulo2, $descripcion2, $titulo3, $descripcion3) {
        parent::__construct($id, $fecha_creacion, $tipo);
        $this->titulo1 = $titulo1;
        $this->descripcion1 = $descripcion1;
        $this->titulo2 = $titulo2;
        $this->descripcion2 = $descripcion2;
        $this->titulo3 = $titulo3;
        $this->descripcion3 = $descripcion3;
    }

    public function obtenerDetallesEspecificos(): string {
        return "Columna 1 - Título: $this->titulo1, Descripción: $this->descripcion1; Columna 2 - Título: $this->titulo2, Descripción: $this->descripcion2; Columna 3 - Título: $this->titulo3, Descripción: $this->descripcion3";
    }
}


class GestorBlog {
    private $entradas = [];


    public function cargarTareas() {
        $json = file_get_contents('entradas.json');
        $data = json_decode($json, true);

        foreach ($data as $entradaData) {
            switch ($entradaData['tipo']) {
                case 1:
                    $entrada = new EntradaUnaColumna(
                        $entradaData['id'],
                        $entradaData['fecha_creacion'],
                        $entradaData['tipo'],
                        $entradaData['titulo'],
                        $entradaData['descripcion']
                    );
                    break;
                case 2:
                    $entrada = new EntradaDosColumnas(
                        $entradaData['id'],
                        $entradaData['fecha_creacion'],
                        $entradaData['tipo'],
                        $entradaData['titulo1'],
                        $entradaData['descripcion1'],
                        $entradaData['titulo2'],
                        $entradaData['descripcion2']
                    );
                    break;
                case 3:
                    $entrada = new EntradaTresColumnas(
                        $entradaData['id'],
                        $entradaData['fecha_creacion'],
                        $entradaData['tipo'],
                        $entradaData['titulo1'],
                        $entradaData['descripcion1'],
                        $entradaData['titulo2'],
                        $entradaData['descripcion2'],
                        $entradaData['titulo3'],
                        $entradaData['descripcion3']
                    );
                    break;
                default:
                    throw new Exception("Tipo de entrada desconocido");
            }
            $this->entradas[] = $entrada;
        }
        
        return $this->entradas;
    }

    public function agregarEntrada(Entrada $entrada) {
        $this->entradas[] = $entrada;
    }

    public function editarEntrada(Entrada $entrada) {
        foreach ($this->entradas as $key => $e) {
            if ($e->id == $entrada->id) {
                $this->entradas[$key] = $entrada;
                break;
            }
        }
    }

    public function eliminarEntrada($id) {
        $this->entradas = array_filter($this->entradas, function ($entrada) use ($id) {
            return $entrada->id != $id;
        });
    }

    public function obtenerEntrada($id) {
        foreach ($this->entradas as $entrada) {
            if ($entrada->id == $id) {
                return $entrada;
            }
        }
        return null;
    }

    public function moverEntrada($id, $direccion) {
        $index = null;
        foreach ($this->entradas as $key => $entrada) {
            if ($entrada->id == $id) {
                $index = $key;
                break;
            }
        }

        if ($index !== null) {
            if ($direccion === 'arriba' && $index > 0) {
                $temp = $this->entradas[$index];
                $this->entradas[$index] = $this->entradas[$index - 1];
                $this->entradas[$index - 1] = $temp;
            } elseif ($direccion === 'abajo' && $index < count($this->entradas) - 1) {
                $temp = $this->entradas[$index];
                $this->entradas[$index] = $this->entradas[$index + 1];
                $this->entradas[$index + 1] = $temp;
            }
        }
    }
}



?>
