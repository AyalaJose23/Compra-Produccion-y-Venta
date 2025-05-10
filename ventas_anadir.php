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
    <body class="hold-transition skin-green sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp'; ?><!--MENU PRINCIPAL-->
            <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="content-wrapper">
                <div class="content">
                <div class="row">
            <!--impresion del titulo de la pagina-->
            <div class="col-lg-12">
                        <h3 class="page-header text-center alert-success"> <strong>AÑADIR FACTURA VENTA</strong>
                            <a href="ventas_index.php" 
                               class="btn btn-success  pull-right" 
                               rel='tooltip' title="Atras">
                                <i class="glyphicon glyphicon-arrow-left"></i>
                            </a> 

                        </h3>
                    </div>   
                </div>
                
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <strong>Agregar Factura de Venta</strong>
                            </div>
                            
                                <form action="ventas_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vid_venta" value="0"/>                                    
                                    
                                    <div class="box-body">
                                        
                                        
                                            <div class="form-group">
                                            <label class="col-lg-2 control-label">Factura N°</label>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                                <input type="text" name="vven_nrofactura" placeholder="002-001-5387653" class="form-control" required="" disabled=""/>
                                            </div>

                                            <div class="form-group">
                                            <label class="col-lg-2 control-label">Timbrado N°</label>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                                <input type="text" name="vtimb_cod" placeholder=" 002 -003-1234567" class="form-control" required="" disabled=""/>
                                            </div>
                                            </div>
                                            </div>

                                        
                                            <div class="form-group has-feedback">
                                            <?php $fecha = consultas::get_datos("select current_date as fecha");?>
                                            <label class="control-label col-lg-2 col-md-2"> Fecha:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="date" class="form-control" value="<?php echo $fecha[0]['fecha'];?>" id="fechaInspeccion" onblur="fechaac()"/>
                                                <i class="fa fa-calendar form-control-feedback"></i>
                                            </div>
                                            </div>

                                            <div class="form-group">
  <label class="control-label col-lg-2 col-md-2">Tipo de venta:</label>
  <div class="col-lg-3 col-md-3">
    <select class="form-control select2" id="tipo-venta" onchange="cambiarFormulario()">
      <option value="">Seleccione una opción</option>
      <option value="pedido">POR PEDIDO</option>
      <option value="presupuesto">POR PRESUPUESTO</option>
    </select>
  </div>

<!-- Formulario para Pedido -->
<div id="formulario-pedido" style="display: none;">
  <!-- Campos del formulario para Pedido -->
  <div class="form-group">
    <label class="control-label col-lg-2 col-md-2">Pedido:</label>
    <div class="col-lg-3 col-md-3">
      <select class="form-control select2" required="" name="vped_cod" id="pedido"
      onchange="cliente_ped()"
      onkeyup="cliente_ped()">
        <option value="0">Seleccione un pedido</option>
        <?php $pedido = consultas::get_datos("select * from v_pedido_cabventa" . " where estado ='PENDIENTE' " . "order by ped_cod"); ?>
        <?php foreach ($pedido as $ped) { ?>
          <option value="<?php echo $ped['ped_cod']; ?>"> <?php echo $ped['ped_cod'] . " - " . $ped['ped_fecha']; ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <!-- ... -->
</div>

<!-- Formulario para Presupuesto -->
<div id="formulario-presupuesto" style="display: none;">
  <!-- Campos del formulario para Presupuesto -->
  <div class="form-group">
    <label class="control-label col-lg-2 col-md-2">Presupuesto:</label>
    <div class="col-lg-3 col-md-3">
      <select class="form-control select2" required="" name="vcod_preprod" id="presup"
      onchange="clientes_presu()"
      onkeyup="clientes_presu()">
        <option value="0">Seleccione un presupuesto</option>
        <?php $presupuesto = consultas::get_datos("select * from v_presu_prod" . " where preprod_estado ='EN PROCESO' " . "order by cod_preprod"); ?>
        <?php foreach ($presupuesto as $presu) { ?>
          <option value="<?php echo $presu['cod_preprod']; ?>"> <?php echo $presu['cod_preprod'] . " - " . $presu['preprod_fecha']; ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <!-- ... -->
</div>
</div>


                                            

                                                <div class="form-group">
                                          <label class="control-label col-lg-2 col-md-2">Cliente:</label>
                                          <div class="col-lg-3 col-md-3">
                                            <select class="form-control"   required="" name="vcli_cod" id="detalles" >
                                                <option value="">Seleccione un presupuesto para obtener un cliente</option>

                                            </select>
                                        </div>
                                    
                                    
                                                

                                            
                                            
                                            
                                                
                                            <label class="control-label col-lg-2 col-md-2">Condición:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <select class="form-control select2" name="vven_tipo" required="" id="condicion" onchange="tipoventa()">
                                                    <option value="CONTADO">CONTADO</option>
                                                    <option value="CREDITO">CREDITO</option>
                                                </select>
                                            </div>                                            
                                            </div> 

                                            <div class="form-group tipo" style="display: none;">
                                            <label class="control-label col-lg-2 col-md-2">Intervalo:</label>
                                        <div class="col-lg-3 col-md-3">
                                            <select  class="form-control select2" required="" name="vven_intervalo" id="intervalo" name="vinter">
                                                <option  value="0"  >Seleccione intervalo</option>
                                                <option value="5"  >5</option>
                                                <option value="15" >15 </option>
                                                <option value="30" >30</option>
                                                <option value="40" >40</option>
                                            </select>
                                            </div> 

                                        <div class="form-group tipo" style="display: none;">
                                            <label class="control-label col-lg-2 col-md-2">Cant. Cuotas:</label>
                                        <div class="col-lg-3 col-md-3">
                                            <input type="number" class="form-control" name="vven_cantcuotas" id="cuotas" value="1" min="1" max="24" readonly=""/>
                                            </div> 
                                        </div> 
                                        </div> 
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2">Empleado:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="text" class="form-control"  value="<?php echo $_SESSION['nombres'];?>" readonly=""/>
                                            </div> 
                                            </div>
                                                  
                                        
                                        
                                    <div class="form-group">
                                                        <label class="control-label col-lg-2 col-md-2"> Deposito:</label>
                                                        <div class="col-lg-3 col-md-3">
                                                            <?php $deposito = consultas::get_datos("select * from v_deposito order by dep_cod");?>
                                                            <select class="form-control select2" name="vart_cod" required="" id="deposito" onchange="precio()">
                                                                <option value="">Seleccione un deposito</option>
                                                                <?php foreach ($deposito as $dep) { ?>
                                                                    <option value="<?php echo $dep['dep_cod'];?>"><?php echo "(".$dep['dep_descri'].") ";?></option>
                                                        
                                                               <?php }  ?>                                                
                                                            </select>
                                                        </div>
                                                    
                                                    </div> 
                                                    </div> 
                                    <div class="box-footer">
                                        <a href="ventas_index.php" class="btn btn-default">
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
     function clientes_presu() {
        if ((parseInt($('#presup').val()) > 0) || ($('#presup').val() == "") || ($('#presup').val() !== "")) {
            $.ajax({
                type: "GET",
                url: "venta.presu.prod.php?vcod_preprod=" + $('#presup').val(),
                cache: false,
                beforeSend: function () {
                    $('#detalles').html('<img src="/tdp/img/cargando.GIF">  \n\
            <strong><i>Cargando...</i></strong>');
                },
                success: function (msg) {
                    $('#detalles').html(msg);

                }
            });
        }
        }

        function cliente_ped() {
        if ((parseInt($('#pedido').val()) > 0) || ($('#pedido').val() == "") || ($('#pedido').val() !== "")) {
            $.ajax({
                type: "GET",
                url: "venta.pedido.prod.php?vped_cod=" + $('#pedido').val(),
                cache: false,
                beforeSend: function () {
                    $('#detalles').html('<img src="/tdp/img/cargando.GIF">  \n\
            <strong><i>Cargando...</i></strong>');
                },
                success: function (msg) {
                    $('#detalles').html(msg);

                }
            });
        }
        }
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
            url     : "/tdp/compras.pedidos.php?vprv_cod="+$('#cli').val(),
            cache   : false,
            beforeSend:function(){
                $('#lista_pedidos').html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
            },
            success:function(data){
                $('#lista_pedidos').html(data);
            }
        })
    };
function cambiarFormulario() {
  var tipoVenta = document.getElementById("tipo-venta").value;
  if (tipoVenta === "pedido") {
    document.getElementById("formulario-pedido").style.display = "block";
    document.getElementById("formulario-presupuesto").style.display = "none";
  } else if (tipoVenta === "presupuesto") {
    document.getElementById("formulario-pedido").style.display = "none";
    document.getElementById("formulario-presupuesto").style.display = "block";
  } else {
    document.getElementById("formulario-pedido").style.display = "none";
    document.getElementById("formulario-presupuesto").style.display = "none";
  }
}

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


