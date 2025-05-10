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
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-success">
                                <div class="box-header">
                                    <i class="ion ion-plus"></i><i class="fa fa-money"></i>
                                    <h3 class="box-title">Agregar Nuevo Cobro</h3>
                                    <div class="box-tools">
                                        <a href="presu.prod.index.php" class="btn btn-success btn-sm" data-title="Volver" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>
                                    </div>
                                </div>
                                <?php $fecha = consultas::get_datos("select current_date as preprod_fecha");?>
                                <form action="presu.prod_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <div class="box-body ">
                                        <input type="hidden" name="accion"  value="1">
                                        <input type="hidden" name="vcod_preprod" value="0"/>
                                        

                                        
                                        <div class="form-group">
                                        
                                            <label class="control-label col-lg-2 col-md-2">Fecha:</label>
                                            <div class="col-lg-3 col-md-3">
                                            <input type="date" name="fecha" class="form-control" min="<?php echo date("Y-m-d");?>" value="<?php echo date("Y-m-d");?>"/>
                                               
                                            </div>
                                            </div>
                                        <div class="form-group">
                                            <label class="col-lg-2 control-label">N° Presupuesto:</label>
                                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4">
                                                <input type="text" name="vpreprod_nro" placeholder="001-001-0001" class="form-control" required="" autofocus=""/>
                                            </div>
                                        </div>
                                        
                                        

                                    <div class="form-group">
                                    <label class="control-label col-lg-2 col-md-2 col-sm-2">Pedido:</label>
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                            <select class="form-control"   required="" name="vped_cod"  id="pedid" 
                                                    onchange="clientes()"
                                                    onkeyup="clientes()">  
                                                <option value="">Seleccione una pedido</option>
                                                <?php
                                                $pedidos = consultas::get_datos("select * from v_pedido_cabventa"
                                                                . " where estado ='PENDIENTE' "
                                                                . "order by ped_cod");
                                                ?> 
                                                <?php foreach ($pedidos as $ped) { ?>
                                                    <option value="<?php echo $ped['ped_cod']; ?>">
                                                        <?php echo $ped['ped_cod'] . " - " . $ped['ped_fecha']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        </div>

                                        <div class="form-group">
                                          <label class="col-lg-2 control-label">Cliente:</label>
                                          <div class="col-lg-5 col-md-5 col-sm-5">
                                            <select class="form-control"   required="" name="vcli_cod" id="detalles" >
                                                <option value="">Seleccione un pedido para obtener un cliente</option>

                                            </select>
                                        </div>
                                    </div>
                                           
                                        <div class="form-group">
                                           
                                          <label class="control-label col-lg-2 col-md-2">Válido hasta:</label>
                                            <div class="col-lg-3 col-md-3">
                                            <input type="date" name="vpreprod_validez" class="form-control" min="<?php echo date("Y-m-d");?>" value="<?php echo date("Y-m-d");?>"/>
                                                  
                                        </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Observación</label>
                                            <div class="col-sm-6 col-lg-6 col-xs-6 col-md-6">
                                                <input type="text" class="form-control" name="vpreprod_obs" value="SIN OBSERVACION"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-2 col-md-2">Empleado:</label>
                                            <div class="col-lg-3 col-md-3">
                                                <input type="text" name="emp_cod" class="form-control"  value="<?php echo $_SESSION['nombres'];?>" readonly=""/>
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
    /*function pedidos(){
        $.ajax({
            type    : "GET",
            url     : "/tdp/presu.prod.pedidos.php?vcli_cod="+$('#cliente').val(),
            cache   : false,
            beforeSend:function(){
                $('#lista_pedidos').html('<img src="img/loader.gif" /><strong>Cargando...</strong>')
            },
            success:function(data){
                $('#lista_pedidos').html(data);
            }
        })
    };*/

    function clientes() {
if ((parseInt($('#pedid').val()) > 0) || ($('#pedid').val() == "") || ($('#pedid').val() !== "")) {
    $.ajax({
        type: "GET",
        url: "presu.prod.pedidos.php?vped_cod=" + $('#pedid').val(),
        cache: false,
        beforeSend: function () {
            $('#detalles').html('<img src="/bulls/img/cargando.GIF">  \n\
      <strong><i>Cargando...</i></strong>');
        },
        success: function (msg) {
            $('#detalles').html(msg);

        }
    });
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


