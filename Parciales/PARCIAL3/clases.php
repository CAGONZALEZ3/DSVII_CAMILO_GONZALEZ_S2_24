<?php

    class Notas {
        public $id;
        public $usuario;
        public $nota;

        public function __construct($id, $usuario, $nota) {
            $this->id = $id;
            $this->usuario = $usuario;
            $this->nota = $nota;
        }

        
    }

    class Principal {
        private $validarLogin = [];
        private $entradas = [];

        public function cargarTablas(){
            $json = file_get_contents('blog.json');
            $data = json_decode($json, true);

            foreach ($data as $entradaData) {
                $entrada = new Notas(
                    $entradaData['id'],
                    $entradaData['usuario'],
                    $entradaData['nota']
                );
            
            $this->entradas[] = $entrada;
        }
        
        return $this->entradas;
        }

        public function logins($usuarioL, $contraseñaL){
            $json = file_get_contents('usuarios.json');
            $data = json_decode($json, true);
            $valida = false;
            $rol = null;
            $id = null;

            foreach ($data as $entradaData) {
        
                // Access properties using array notation
                if ($entradaData['usuario'] === $usuarioL && $entradaData['password'] === $contraseñaL) {
                    $id = $entradaData['id'];
                    $rol = $entradaData['rol'];
                    $valida = true;
                    break;
                }            
            }
        
        return [$valida,$rol,$id];
        }



    }

?>