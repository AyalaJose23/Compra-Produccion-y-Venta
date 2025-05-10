<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="img/mueble.png"/>
        <title>Todo Muebles</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php 
        session_start();
        require 'menu/css_lte.ctp'; ?><!--ARCHIVOS CSS-->
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
                                <strong>AÑADIR FACTURA DE COMPRA</strong>
                                
                                <a href="compras.index.php" class="btn btn-primary pull-right" rel="tooltip" title="Atrás">
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
                                    <strong>Agregar Factura de Compra</strong>
                                </div>
                                <form action="compras_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vcom_cod" value="0"/>                                    
                                    <div class="box-body">
                                        
                                        <div class="form-group has-feedback">
                                            <?php $fecha = consultas::get_datos("select current_date as fecha");?>
                                            <label class="control-label col-lg-2 col-md-2"> Compra:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="date" class="form-control" value="<?php echo $fecha[0]['fecha'];?>" id="fechaInspeccion" onblur="fechaac()"/>
                                                <i class="fa fa-calendar form-control-feedback"></i>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="control-label col-lg-2 col-md-2">Emisión:</label>
                                                <div class="col-lg-3 col-md-3">
                                                    <input type="date" id="vcom_emi" name="vcom_emi" class="form-control" value="<?php echo date('Y-m-d'); ?>"/>
                                                    <i class="fa fa-calendar form-control-feedback"></i>
                                                </div>
                                            </div>




                                            </div>
                                            <div class="form-group has-feedback">
                                            <label class="control-label col-lg-2 col-md-2">Vigencia:</label>
                                            <div class="col-lg-3 col-md-3">
                                            <input type="date" name="vcom_vig" class="form-control" min="<?php echo date("Y-m-d");?>" value="<?php echo date("Y-m-d");?>"/>
                                                <i class="fa fa-calendar form-control-feedback"></i>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Factura N°</label>
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                                    <input type="text" name="vnro_com" placeholder="002-001-5387653" class="form-control" required="" autofocus=""
                                                        minlength="15" maxlength="15"  title="Debe contener exactamente 13 dígitos en el formato 000-000-0000000"/>
                                                </div>
                                            </div>

                                            <label class="control-label col-lg-2 col-md-2">Condición:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <select class="form-control select2" name="vtipo_compra" required="" id="condicion" onchange="tipocompra()">
                                                    <option value="CONTADO">CONTADO</option>
                                                    <option value="CREDITO">CREDITO</option>
                                                </select>
                                            </div>  
                                            
                                            <div class="form-group">
                                                <label class="col-lg-2 control-label">Timbrado N°</label>
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                                    <input type="text" name="vnro_com" placeholder="12345678" class="form-control" required="" autofocus=""
                                                        minlength="8" maxlength="8" pattern="\d{8}" title="Debe contener exactamente 8 dígitos"/>
                                                </div>
                                            </div>

                                                                       
                                         
                                        <div class="form-group has-feedback">
                                            <label class="control-label col-lg-2 col-md-2">Validez Timbrado:</label>
                                            <div class="col-lg-3 col-md-3">
                                            <input type="date" name="vtim_vz" class="form-control" min="<?php echo date("Y-m-d");?>" value="<?php echo date("Y-m-d");?>"/>
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
                                            <div id="lista_pedidos"></div>
                                        </div>
                                        
                                        <div class="form-group tipo" style="display: none;">
                                            <label class="control-label col-lg-2 col-md-2">Cant. Cuotas:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="number" class="form-control" name="vcan_cuota" id="cuotas" value="1" min="1" max="24" readonly=""/>
                                            </div>
                                            <label class="control-label col-lg-2 col-md-2">Intervalo:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="number" class="form-control" name="vcom_plazo" id="intervalo" value="0" min="0" max="90" readonly=""/>
                                            </div>                                            
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2">Empleado:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="text" class="form-control"  value="<?php echo $_SESSION['nombres'];?>" readonly=""/>
                                            </div>                                            
                                                                                
                                    
                                    <!--<div class="form-group">
                                                        <label class="control-label col-lg-2 col-sm-3 col-md-2 col-xs-3">Deposito:</label>
                                                        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                                                            <?php $articulos = consultas::get_datos("select * from v_deposito order by dep_cod");?>
                                                            <select class="form-control select2" name="vart_cod" required="" id="articulo" onchange="precio()">
                                                                <option value="">Seleccione un articulo</option>
                                                                <?php foreach ($articulos as $articulo) { ?>
                                                                <option value="<?php echo $articulo['art_cod']."_".$articulo['art_preciov'];?>"><?php echo $articulo['art_descri']." ".$articulo['mar_descri'];?></option>
                                                               <?php }  ?>                                                
                                                            </select>
                                                        </div>-->
                                                    </div> 
                                                    </div> 
                                    <div class="box-footer">
                                        <a href="compras.index.php" class="btn btn-default">
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
document.addEventListener('DOMContentLoaded', function() {
    var dateInput = document.getElementById('vcom_emi');
    var now = new Date();
    var firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
    var lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);

    dateInput.min = firstDay.toISOString().split('T')[0];
    dateInput.max = lastDay.toISOString().split('T')[0];
});
</script>
<script>
    
    function tipocompra(){
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
            url     : "/tdp/compras.pedidos.php?vprv_cod="+$('#proveedor').val(),
            cache   : false,
            beforeSend:function(){
                $('#lista_pedidos').html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
            },
            success:function(data){
                $('#lista_pedidos').html(data);
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


