<?php

/**
 *
 * Consulta de prueba
 *
 * @category Vista
 * @package Prueba para Jorge emilio Morales
 * @version 1.0
 * @author Hernan Castro <alberto87.cr@gmail.com>
 * @copyright Copyright (c) 2020, Hernan Alberto Castro Paniagua <alberto87.cr@gmail.com>
 *
 */
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
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Productos</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="#">API <span class="sr-only">(actual)</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main role="main" class="flex-shrink-0 mt-5">
        <div class="container-xl">
            <h1 class="mt-5">Listado de productos</h1>
            <p>Si desea editar un producto, puede dar clic en la fila respectiva.</p>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="numeroDocumento" class="col-form-label">N° de autorización:</label>
                        <input type="text" class="form-control" id="numeroDocumento">
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="identificacion" class="col-form-label">Identificación:</label>
                        <input type="text" class="form-control" id="identificacion" disabled>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="fechaEmision" class="col-form-label">Fecha de emisión:</label>
                        <input type="text" class="form-control" id="fechaEmision" disabled>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="fechaVencimiento" class="col-form-label">Fecha de vencimiento:</label>
                        <input type="text" class="form-control" id="fechaVencimiento" disabled>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="porcentajeExoneracion" class="col-form-label">Porcentaje de exoneración:</label>
                        <input type="text" class="form-control" id="porcentajeExoneracion" disabled>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="tipoDocumento" class="col-form-label">Tipo documento (número):</label>
                        <input type="text" class="form-control" id="tipoDocumento" disabled>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="nombreInstitucion" class="col-form-label">Institución:</label>
                        <input type="text" class="form-control" id="nombreInstitucion" disabled>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <button type="button" data-clear class="btn btn-secondary mr-2">Limpiar</button>
                    <button type="button" data-get_api class="btn btn-primary">Consultar</button>
                </div>
            </div>
        </div>
    </main>
    <footer class="footer mt-auto py-3 bg-secondary" style="background: #2d3246;">
        <div class="container">
            <span class="text-white">Hernán Alberto Castro Paniagua, más info en <a target="blank" href="http://acastro.crdevelopers.com/" class="text-warning">Mi CV en Línea</a>.</span>
        </div>
    </footer>
</body>
<script src="assets/js/jquery.3.5.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script>
    $('[data-clear]').off('click');
    $('[data-clear]').on('click', function() {
        $('#numeroDocumento').val('');
        $('#identificacion').val('');
        $('#fechaEmision').val('');
        $('#fechaVencimiento').val('');
        $('#porcentajeExoneracion').val('');
        $('#tipoDocumento').val('');
        $('#nombreInstitucion').val('');
    });
    $('[data-get_api]').off('click');
    $('[data-get_api]').on('click', function(e) {
        e.preventDefault();
        $.get(
            'https://api.hacienda.go.cr/fe/ex', {
                autorizacion: $('#numeroDocumento').val()
            },
            function(data) {
                console.log(data);
                $('#numeroDocumento').val(data.numeroDocumento);
                $('#identificacion').val(data.identificacion);
                $('#fechaEmision').val(data.fechaEmision);
                $('#fechaVencimiento').val(data.fechaVencimiento);
                $('#porcentajeExoneracion').val(data.porcentajeExoneracion);
                $('#tipoDocumento').val(data.tipoDocumento.descripcion + ' ( código: ' + data.tipoDocumento.codigo + ' )');
                $('#nombreInstitucion').val(data.nombreInstitucion);
            });
    });
</script>
</html>