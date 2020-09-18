<?php

/**
 *
 * Index de prueba
 *
 * @category Vista
 * @package Prueba para Jorge emilio Morales
 * @version 1.0
 * @author Hernan Castro <alberto87.cr@gmail.com>
 * @copyright Copyright (c) 2020, Hernan Alberto Castro Paniagua <alberto87.cr@gmail.com>
 *
 */
require_once('api.php');
$api = new api();
?>
<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba Hernan Alberto Castro Paniagua</title>
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-secondary">
            <a class="navbar-brand" href="http://acastro.crdevelopers.com/">Hernán Castro</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Productos <span class="sr-only">(actual)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="consulta.php">API</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main role="main" class="flex-shrink-0 mt-5">
        <div class="container-xl">
            <h1 class="mt-5">Listado de productos</h1>
            <p>Si desea editar un producto, puede dar clic en la fila respectiva.</p>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Naturaleza</th>
                        <th scope="col">Código comercial</th>
                        <th scope="col">Unidad</th>
                        <th scope="col">Unidad comercial</th>
                        <th scope="col">Detalle</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Impuesto</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $api->get_products_rows(); ?>
                </tbody>
            </table>
        </div>
    </main>
    <div class="modal fade" id="modal_edit" tabindex="-1" aria-labelledby="product_name" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="product_name"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="prod-id">
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="prod-nat" class="col-form-label">Naturaleza del producto:</label>
                                    <select class="form-control" id="prod-nat">
                                        <option value="0">Bien</option>
                                        <option value="1">Servicio</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="prod-uni" class="col-form-label">Unidad Medida:</label>
                                    <select class="form-control" id="prod-uni">
                                        <?= $api->get_products_units(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-8">
                                <div class="form-group">
                                    <label for="prod-det" class="col-form-label">Detalle:</label>
                                    <input type="text" class="form-control" id="prod-det">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4">
                                <div class="form-group">
                                    <label for="prod-amount" class="col-form-label">Precio unitario:</label>
                                    <input type="number" class="form-control" id="prod-amount">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" data-save class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer mt-auto py-3 bg-secondary" style="background: #2d3246;">
        <div class="container">
            <span class="text-white">Hernán Alberto Castro Paniagua, más info en <a target="blank" href="http://acastro.crdevelopers.com/" class="text-warning">Mi CV en Línea</a>.</span>
        </div>
    </footer>
</body>
<script src="assets/js/jquery.3.5.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script>
    $('[data-row_product]').off('click');
    $('[data-row_product]').on('click', function() {
        let row = $(this);
        $('#prod-id').val(row.data('row_product'));
        $('#modal_edit #product_name').text(row.find('.detail').text());
        $('#prod-nat').val(row.find('[data-nat]').data('nat'));
        $('#prod-uni').val(row.find('.uni').text());
        $('#prod-det').val(row.find('.detail').text());
        $('#prod-amount').val(row.find('.amount').text());
        $('#modal_edit').modal('show');
    });
    $('[data-save]').off('click');
    $('[data-save]').on('click', function(e) {
        e.preventDefault();
        $.post(
            'api.php', {
                action: 'save_prod',
                id: $('#prod-id').val(),
                nat: $('#prod-nat').val(),
                uni: $('#prod-uni').val(),
                det: $('#prod-det').val(),
                amo: $('#prod-amount').val(),
            },
            function(data) {
                console.log(data);
                if (data.status == 1) {
                    location.reload();
                }
            });
    });
</script>
</html>