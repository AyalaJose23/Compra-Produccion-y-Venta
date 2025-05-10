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
                        <!-- Impresión del título de la página -->
                        <div class="col-lg-12">
                            <h3 class="page-header text-center alert-info">
                                <strong>AÑADIR ORDEN DE COMPRA</strong>
                                
                                <a href="orden.index.php" class="btn btn-primary pull-right" rel="tooltip" title="Atrás">
                                    <i class="glyphicon glyphicon-arrow-left"></i>
                                </a> 
                            </h3>
                        </div>
                    </div>

                    <!-- Buscador -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <strong>Agregar Orden de Compra</strong>
                                </div>
                                <form action="orden_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vorden_cod" value="0"/>                                    
                                    <div class="box-body">
                                        <div class="form-group has-feedback">
                                            
                                            <?php $fecha = consultas::get_datos("select current_date as fecha");?>
                                            <label class="control-label col-lg-2 col-md-2">Fecha:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="date" class="form-control" value="<?php echo $fecha[0]['fecha'];?>" id="fechaInspeccion" onblur="fechaac()"/>
                                                <i class="fa fa-calendar form-control-feedback"></i>
                                            </div>
                                            
                                                                                      
                                        </div>
                                        <div class="form-group">
                                        <?php  $proveedores = consultas::get_datos("SELECT * FROM proveedor WHERE prv_estado = 'ACTIVO' ORDER BY prv_razonsocial");?>
                                            <label class="control-label col-lg-2 col-md-2 col-sm-2">Proveedor:</label>
                                            <div class="col-lg-5 col-md-5 col-sm-5">
                                                <div class="input-group">
                                                    <select class="form-control select2" name="vprv_cod" required="" id="proveedor" onchange="pedidos()">
                                                        <option value="">Seleccione un proveedor</option>
                                                        <?php foreach ($proveedores as $proveedor) { ?>
                                                        <option value="<?php echo $proveedor['prv_cod'];?>"><?php echo "(".$proveedor['prv_ruc'].") ".$proveedor['prv_razonsocial'];?></option>
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
                                            <div id="lista_presu"></div>
                                        </div>
                                        <!--<div class="form-group tipo" style="display: none;">
                                            <label class="control-label col-lg-2 col-md-2">Cant. Cuotas:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="number" class="form-control" name="vcan_cuota" id="cuotas" value="1" min="1" max="24" readonly=""/>
                                            </div>
                                            <label class="control-label col-lg-2 col-md-2">Intervalo:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="number" class="form-control" name="vcom_plazo" id="intervalo" value="0" min="0" max="90" readonly=""/>
                                            </div>                                            
                                        </div>-->
                                       <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2">Empleado:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="text" class="form-control"  value="<?php echo $_SESSION['nombres'];?>" readonly=""/>
                                            </div>
                                                                                        
                                        </div>                                          
                                    </div>  
                                    <div class="box-footer">
                                        <button type="reset" class="btn btn-default" data-title="Cancelar" rel="tooltip">
                                            <i class="fa fa-remove"></i> Cancelar</button>                                        
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
   /* function tipocompra(){
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
    };*/
    function pedidos(){
        $.ajax({
            type    : "GET",
            url     : "/tdp/orden.pedidos.php?vprv_cod="+$('#proveedor').val(),
            cache   : false,
            beforeSend:function(){
                $('#lista_presu').html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
            },
            success:function(data){
                $('#lista_presu').html(data);
            }
        })
    };
var myDate = $('#fechaInspeccion');
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1;
var yyyy = today.getFullYear();
if(dd < 10)
  dd = '0' + dd;

if(mm < 10)
  mm = '0' + mm;

today = yyyy + '-' + mm + '-' + dd;
myDate.attr("max", today);

function fechaac(){
  var date = myDate.val();
  if(Date.parse(date)){
    if(date > today){
      alert('La fecha no puede ser mayor a la actual');
      myDate.val("");
    }
  }
}
</script>
    </body>
</html>


