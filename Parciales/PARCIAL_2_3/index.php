<?php

require_once 'clases.php';

$gestorBlog = new GestorBlog();
$gestorBlog->cargarEntradas();

$action = $_GET['action'] ?? 'list';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                // Agregar nueva entrada
                $tipo = $_POST['tipo'];
                $entrada = new Entrada();
                $entrada->tipo = $tipo;

                if ($tipo == 1) {
                    $entrada->titulo = $_POST['titulo'];
                    $entrada->descripcion = $_POST['descripcion'];
                } elseif ($tipo == 2) {
                    $entrada->titulo1 = $_POST['titulo1'];
                    $entrada->titulo2 = $_POST['titulo2'];
                    $entrada->descripcion1 = $_POST['descripcion1'];
                    $entrada->descripcion2 = $_POST['descripcion2'];
                } elseif ($tipo == 3) {
                    $entrada->titulo1 = $_POST['titulo1'];
                    $entrada->titulo2 = $_POST['titulo2'];
                    $entrada->titulo3 = $_POST['titulo3'];
                    $entrada->descripcion1 = $_POST['descripcion1'];
                    $entrada->descripcion2 = $_POST['descripcion2'];
                    $entrada->descripcion3 = $_POST['descripcion3'];
                }

                $gestorBlog->agregarEntrada($entrada);
                $mensaje = "Entrada agregada con éxito.";
                $action = "list";
                break;

            case 'edit':
                // Editar una entrada existente
                $id = $_POST['id'];
                $entrada = $gestorBlog->obtenerEntrada($id);
                $tipo = $_POST['tipo'];
                $entrada->tipo = $tipo;

                if ($tipo == 1) {
                    $entrada->titulo = $_POST['titulo'];
                    $entrada->descripcion = $_POST['descripcion'];
                } elseif ($tipo == 2) {
                    $entrada->titulo1 = $_POST['titulo1'];
                    $entrada->titulo2 = $_POST['titulo2'];
                    $entrada->descripcion1 = $_POST['descripcion1'];
                    $entrada->descripcion2 = $_POST['descripcion2'];
                } elseif ($tipo == 3) {
                    $entrada->titulo1 = $_POST['titulo1'];
                    $entrada->titulo2 = $_POST['titulo2'];
                    $entrada->titulo3 = $_POST['titulo3'];
                    $entrada->descripcion1 = $_POST['descripcion1'];
                    $entrada->descripcion2 = $_POST['descripcion2'];
                    $entrada->descripcion3 = $_POST['descripcion3'];
                }

                $gestorBlog->actualizarEntrada($entrada);
                $mensaje = "Entrada actualizada con éxito.";
                $action = "list";
                break;
        }
    }
}

if ($action === 'delete' && isset($_GET['id'])) {
    // Eliminar entrada
    $gestorBlog->eliminarEntrada($_GET['id']);
    $mensaje = "Entrada eliminada con éxito.";
    $action = "list";
}

if (($action === 'move_up' || $action === 'move_down') && isset($_GET['id'])) {
    // Reordenar entradas
    if ($action === 'move_up') {
        $gestorBlog->moverEntradaArriba($_GET['id']);
    } else {
        $gestorBlog->moverEntradaAbajo($_GET['id']);
    }
    $mensaje = "Entrada reordenada con éxito.";
    $action = "list";
}

$entradas = $gestorBlog->obtenerEntradas();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Gestor de Blog</h1>
        
        <?php if ($mensaje): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <nav class="mb-4">
            <a href="index.php?action=list" class="btn btn-primary">Listar Entradas</a>
            <a href="index.php?action=add" class="btn btn-success">Agregar Entrada</a>
            <a href="index.php?action=view" class="btn btn-info">Ver Blog</a>
        </nav>

        <?php if ($action === 'list'): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entradas as $entrada): ?>
                        <tr>
                            <td><?php echo $entrada->id; ?></td>
                            <td><?php echo $entrada->obtenerDetallesEspecificos(); ?></td>
                            <td><?php echo $entrada->tipo; ?> columna(s)</td>
                            <td><?php echo $entrada->fecha_creacion; ?></td>
                            <td>
                                <a href="index.php?action=edit&id=<?php echo $entrada->id; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="index.php?action=delete&id=<?php echo $entrada->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta entrada?')">Eliminar</a>
                                <a href="index.php?action=move_up&id=<?php echo $entrada->id; ?>" class="btn btn-secondary btn-sm">▲</a>
                                <a href="index.php?action=move_down&id=<?php echo $entrada->id; ?>" class="btn btn-secondary btn-sm">▼</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="index.php?action=view" class="btn btn-primary">Ver Blog</a>
        <?php elseif ($action === 'add' || $action === 'edit'): ?>
            <?php
            $entradaEditar = null;
            if ($action === 'edit' && isset($_GET['id'])) {
                $entradaEditar = $gestorBlog->obtenerEntrada($_GET['id']);
            }
            ?>
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="<?php echo $action; ?>">
                <?php if ($entradaEditar): ?>
                    <input type="hidden" name="id" value="<?php echo $entradaEditar->id; ?>">
                <?php endif; ?>
                
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Entrada</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="1" <?php echo $entradaEditar && $entradaEditar->tipo == 1 ? 'selected' : ''; ?>>1 Columna</option>
                        <option value="2" <?php echo $entradaEditar && $entradaEditar->tipo == 2 ? 'selected' : ''; ?>>2 Columnas</option>
                        <option value="3" <?php echo $entradaEditar && $entradaEditar->tipo == 3 ? 'selected' : ''; ?>>3 Columnas</option>
                    </select>
                </div>

                <div id="campos-dinamicos">
                    <!-- Los campos se generarán dinámicamente con JavaScript -->
                </div>

                <button type="submit" class="btn btn-primary"><?php echo $action === 'add' ? 'Agregar' : 'Actualizar'; ?> Entrada</button>
                <a href="index.php?action=list" class="btn btn-secondary">Volver al Listado</a>
            </form>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tipoSelect = document.getElementById('tipo');
                const camposDinamicos = document.getElementById('campos-dinamicos');

                const entradaEditar = <?php echo $entradaEditar ? json_encode($entradaEditar) : 'null'; ?>;

                function generarCampos() {
                    const tipo = parseInt(tipoSelect.value);
                    let campos = '';

                    for (let i = 1; i <= tipo; i++) {
                        const tituloKey = tipo === 1 ? 'titulo' : `titulo${i}`;
                        const descripcionKey = tipo === 1 ? 'descripcion' : `descripcion${i}`;

                        const tituloValue = entradaEditar ? (entradaEditar[tituloKey] || '') : '';
                        const descripcionValue = entradaEditar ? (entradaEditar[descripcionKey] || '') : '';

                        campos += `
                            <div class="mb-3">
                                <label for="${tituloKey}" class="form-label">Título ${i}</label>
                                <input type="text" class="form-control" id="${tituloKey}" name="${tituloKey}" required value="${tituloValue.replace(/"/g, '&quot;')}">
                            </div>
                            <div class="mb-3">
                                <label for="${descripcionKey}" class="form-label">Descripción ${i}</label>
                                <textarea class="form-control" id="${descripcionKey}" name="${descripcionKey}" required>${descripcionValue}</textarea>
                            </div>
                        `;
                    }

                    camposDinamicos.innerHTML = campos;
                }

                tipoSelect.addEventListener('change', generarCampos);

                generarCampos(); // Llamada inicial para cargar los campos al cargar la página
            });
            </script>

        <?php endif; ?>
    </div>
</body>
</html>
