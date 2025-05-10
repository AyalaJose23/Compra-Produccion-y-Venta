<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LP3</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php
    session_start();
    require 'menu/css_lte.ctp';
    ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php require 'menu/header_lte.ctp'; ?>
    <?php require 'menu/toolbar_lte.ctp'; ?>

    <div class="content-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-lg-6">
                    <!-- Box Izquierda -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Proceso y Filtros</h3>
                        </div>
                        <div class="box-body">
                            <form action="informe_compras_print.php" method="get" accept-charset="utf-8" class="form-horizontal" target="print">
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Proceso:</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" name="proceso" id="proceso" required="">
                                            <option value="">Seleccione un proceso</option>
                                            <option value="pedido">Pedido Venta</option>
                                            <option value="presupuesto">Presupuesto Producción</option>
                                            <option value="orden">Factura de Ventas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Filtrar por:</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" name="filterType" id="filterType" required="">
                                            <option value="">Seleccione un tipo de filtro</option>
                                            <option value="fecha">Fecha</option>
                                            <option value="insumo">Insumo</option>
                                            <option value="cliente">Cliente</option>
                                            <option value="empleado">Empleado</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <!-- Box Derecha -->
                    <div class="box box-primary" id="filtroSeleccionadoBox">
                        <div class="box-header">
                            <h3 class="box-title">Opciones de Filtro Seleccionado</h3>
                        </div>
                        <div class="box-body" id="specificFilters">
                            <!-- Aquí se cargará dinámicamente el contenido del filtro específico -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">
                    <i class="fa fa-print"></i> Listar
                </button>
            </div>
        </div>
    </div>

    <?php require 'menu/footer_lte.ctp'; ?>
</div>
<?php require 'menu/js_lte.ctp'; ?>

<script>
$(document).ready(function() {
    $('#proceso').change(function() {
        $('#specificFilters').html(''); // Limpiar filtros previos
    });

    $('#filterType').change(function() {
        var filterType = $(this).val();
        var specificFiltersHtml = '';

        if (filterType === 'fecha') {
            specificFiltersHtml = `
                <div class="form-group">
                    <label>Desde:</label>
                    <input type="date" name="vdesde" class="form-control"/>
                </div>
                <div class="form-group">
                    <label>Hasta:</label>
                    <input type="date" name="vhasta" class="form-control"/>
                </div>`;
        } else if (filterType === 'insumo') {
            specificFiltersHtml = `
                <div class="form-group">
                    <label>Insumo:</label>
                    <select class="form-control" name="vinsumo" id="vinsumoSelect" required="">
                    </select>
                </div>`;
            cargarOpciones('insumo', '#vinsumoSelect');
            
        } else if (filterType === 'cliente') {
            specificFiltersHtml = `
                <div class="form-group">
                    <label>Cliente:</label>
                    <select class="form-control" name="vcliente" id="vclienteSelect" required="">
                    </select>
                </div>`;
            cargarOpciones('cliente', '#vclienteSelect');

        } else if (filterType === 'empleado') {
            specificFiltersHtml = `
                <div class="form-group">
                    <label>Empleado:</label>
                    <select class="form-control" name="vempleado" id="vempleadoSelect" required="">
                    </select>
                </div>`;
            cargarOpciones('empleado', '#vempleadoSelect');
        }

        $('#specificFilters').html(specificFiltersHtml);
    });

    function cargarOpciones(tipo, selectId) {
        $.ajax({
            url: 'informe_compras_control.php',
            type: 'GET',
            data: { tipo: tipo },
            dataType: 'json',
            success: function(response) {
                var options = '<option value="">Seleccione una opción</option>';
                $.each(response, function(index, item) {
                    options += `<option value="${item.value}">${item.text}</option>`;
                });
                $(selectId).html(options);
            }
        });
    }
});
</script>
</body>
</html>
