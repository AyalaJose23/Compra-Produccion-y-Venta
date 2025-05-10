<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon"  href=" img/mueble.png"/>
        <title>Todo Muebles</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php
        session_start(); /* Reanudar sesion */
        require 'menu/css_lte.ctp';
        ?><!--ARCHIVOS CSS-->

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp'; ?><!--MENU PRINCIPAL-->
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-plus"></i><i class="fa fa-money"></i>
                                    <h3 class="box-title">Agregar Ventas</h3>
                                    <div class="box-tools">
                                        <a href="ventas.index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>
                                    </div>
                                </div>
                                <form action="ventas_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vven_cod" value="0"/>                                    
                                    <div class="box-body">
                                        <div class="form-group has-feedback">
                                            <?php $fecha = consultas::get_datos("select current_date as fecha");?>
                                            <label class="control-label col-lg-2 col-md-2">Fecha:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="date" class="form-control" value="<?php echo $fecha[0]['fecha'];?>" readonly=""/>
                                                <i class="fa fa-calendar form-control-feedback"></i>
                                            </div>
                                            <label class="control-label col-lg-2 col-md-2">Condición:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <select class="form-control select2" name="vtipo_venta" required="" id="condicion" onchange="tipoventa()">
                                                    <option value="CONTADO">CONTADO</option>
                                                    <option value="CREDITO">CREDITO</option>
                                                </select>
                                            </div>                                            
                                        </div>
                                        <div class="form-group">
                                            <?php $clientes = consultas::get_datos("select * from clientes order by cli_nombre");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Cliente:</label>
                                            <div class="col-lg-5 col-md-5 col-sm-5">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vcli_cod" required="" id="cliente" onchange="pedidos()">
                                                        <option value="">Seleccione un cliente</option>
                                                        <?php foreach ($clientes as $cliente) { ?>
                                                        <option value="<?php echo $cliente['cli_cod'];?>"><?php echo "(".$cliente['cli_ci'].") ".$cliente['cli_nombre']." ".$cliente['cli_apellido'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="input-group-btn">
                                                        <button type="button" class="btn btn-primary btn-flat" 
                                                                data-toggle="modal" data-target="#registrar">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div id="lista_pedidos"></div>
                                        </div>
                                        <div class="form-group tipo" style="display: none;">
                                            <label class="control-label col-lg-2 col-md-2">Cant. Cuotas:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="number" class="form-control" name="vcan_cuota" id="cuotas" value="1" min="1" max="24" readonly=""/>
                                            </div>
                                            <label class="control-label col-lg-2 col-md-2">Intervalo:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="number" class="form-control" name="vven_plazo" id="intervalo" value="0" min="0" max="90" readonly=""/>
                                            </div>                                            
                                        </div>
*                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2">Empleado:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="text" class="form-control"  value="<?php echo $_SESSION['nombres'];?>" readonly=""/>
                                            </div>
                                                                                       
                                        </div>                                          
                                    </div>  
                                    <div class="box-footer">
                                         <a href="ventas.index.php" class="btn btn-default">
                                            <i class="fa fa-remove"></i> Cancelar
                                        </a>                                       
                                        <button type="submit" class="btn btn-primary pull-right" data-title="Guardar datos" rel="tooltip">
                                            <i class="fa fa-floppy-o"></i> Registrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->  
        </div>                  
<?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
<script>
    function tipoventa(){
        if($('#condicion').val()==='CONTADO'){
            $('.tipo').hide();
            $('#cuotas').val(1);
            $('#cuotas').prop("readonly",true);
            $('#intervalo').val(0);
            $('#intervalo').prop("readonly",true);
        }else{
            $('.tipo').show();
            $('#cuotas').prop("readonly",false);
            $('#intervalo').prop("readonly",false);
        }
    };
    function pedidos(){
        $.ajax({
            type    : "GET",
            url     : "/tdp/ventas.pedidos.php?vcli_cod="+$('#cliente').val(),
            cache   : false,
            beforeSend:function(){
                $('#lista_pedidos').html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
            },
            success:function(data){
                $('#lista_pedidos').html(data);
            }
        })
    }
</script>
    </body>
</html>


