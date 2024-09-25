<?php
// Archivo: clases.php
require_once 'Detalles.php';

class Tarea  {
    public $id;
    public $titulo;
    public $descripcion;
    public $estado;
    public $prioridad;
    public $fechaCreacion;
    public $tipo;

    public function __construct($datos) {
        foreach ($datos as $key => $value) {
            $this->$key = $value;
        }
    }
}


class GestorTareas
{
    private $tareas = [];

    public function cargarTareas() {
        $json = file_get_contents('tareas.json');
        $data = json_decode($json, true);
        foreach ($data as $tareaData) {
            /* $tarea = new Tarea($tareaData);
            $this->tareas[] = $tarea; */
            switch ($tareaData['tipo']) {
                case 'desarrollo':
                    $tarea = new TareaDesarrollo($tareaData, $tareaData['lenguajeProgramacion']);
                    break;
                case 'diseno':
                    $tarea = new TareaDiseno($tareaData, $tareaData['herramientaDiseno']);
                    break;
                case 'testing':
                    $tarea = new TareaTesting($tareaData, $tareaData['tipoTest']);
                    break;
            }
            $this->tareas[] = $tarea;
        }
        
        return $this->tareas;
    }
    function nuevaTarea($titulo, $descripcion, $estado, $prioridad, $tipo, $tipoTest)
    {
        $this->cargarTareas();
        $last_task = end($this->tareas);
        $id = $last_task->id;
        $new_id = $id + 1;
        $nueva_tarea = [
            "id" => $new_id,
            "titulo" => $titulo,
            "descripcion" => $descripcion,
            "estado" => $estado,
            "prioridad" => $prioridad,
            "fechaCreacion" => date('Y-m-d H:i:s'),
            "tipo" => $tipo,
            "tipoTest" => $tipoTest
        ];
        return $nueva_tarea;
    }
    function agregarTarea($tarea)
    {
        $this->tareas[] = $tarea;

        file_put_contents("tareas.json", json_encode($this->tareas));
    }
    function eliminarTarea($id)
    {
        $this->cargarTareas();
        $this->tareas = array_filter($this->tareas, function ($tarea) use ($id) {
            return $tarea->id != $id;
        });
        $this->tareas = array_values($this->tareas);
        $this->agregarTarea($this->tareas);
        // for ($i = 0; $i < count($this->tareas); $i++) {
        // print_r($this->tareas[$i]);
        // echo "<br>";
        // }
    }
    function actualizarTarea($tarea) {}
    function actualizarEstadoTarea($id, $nuevoEstado) {}
    function buscarTareasPorEstado($estado) {}
    function listarTareas($filtroEstado = '') {}
}

$gestor = new GestorTareas();
$test = [];
// $tarea = $gestor->nuevaTarea("test", "tarea de testing", "nueva", "1", "programacion", "test programatico");
// $gestor->agregarTarea($tarea);
$gestor->eliminarTarea(4);

class TareaDesarrollo extends Tarea implements Detalles{ 
    public $lenguajeProgramacion;

    public function __construct($datos,$lenguajeProgramacion){
        parent::__construct($datos);
        $this->setlenguajeProgramacion($lenguajeProgramacion);
    }

    public function getlenguajeProgramacion(){
        return $this->lenguajeProgramacion;
    }

    public function setlenguajeProgramacion($lenguajeProgramacion){
        $this->lenguajeProgramacion= trim($lenguajeProgramacion);
    }

    public function obtenerDetallesEspecificos(): string{
        return $this->getlenguajeProgramacion();
    }

}

class TareaDiseno extends Tarea implements Detalles{
    public $herramientaDiseno;

    public function __construct($datos,$herramientaDiseno){
        parent::__construct($datos);
        $this->setherramientaDiseno($herramientaDiseno);
    }

    public function getherramientaDiseno(){
        return $this->herramientaDiseno;
    }

    public function setherramientaDiseno($herramientaDiseno){
        $this->herramientaDiseno= trim($herramientaDiseno);
    }

    public function obtenerDetallesEspecificos(): string{
        return $this->getherramientaDiseno();
    }
}

class TareaTesting extends tarea implements Detalles{
    public $tipoTest;

    public function __construct($datos,$tipoTest){
        parent::__construct($datos);
        $this->settipoTest($tipoTest);
    }

    public function gettipoTest(){
        return $this->tipoTest;
    }

    public function settipoTest($tipoTest){
        $this->tipoTest= trim($tipoTest);
    }

    public function obtenerDetallesEspecificos(): string{
        return $this->gettipoTest();
    }
}

// Implementar:
// 1. La interfaz Detalle
// 2. Modificar la clase Tarea para implementar la interfaz Detalle
// 3. Las clases TareaDesarrollo, TareaDiseno y TareaTesting que hereden de Tarea

?>