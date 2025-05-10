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
                <div class="col-lg-12">
                    <h3 class="page-header text-center alert-info">
                        <strong>AÑADIR NOTA DE REMISIÓN DE COMPRA</strong>
                        <a href="nota_remision.index.php" class="btn btn-primary pull-right" rel="tooltip" title="Atrás">
                            <i class="glyphicon glyphicon-arrow-left"></i>
                        </a>
                    </h3>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <strong>Agregar Nota de Remisión</strong>
                        </div>
                        <?php $fecha = consultas::get_datos("select current_date as remi_fecha");?>
                        <form action="nota_remision.control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                            <input type="hidden" name="accion" value="1"/>
                            <input type="hidden" name="vcod_nota" value="0"/>
                            
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">Fecha:</label>
                                    <div class="col-lg-2">
                                        <input type="date" name="fecha" class="form-control" min="<?php echo date("Y-m-d");?>" value="<?php echo date("Y-m-d");?>"/>
                                    </div>

                                    <label class="col-lg-1 control-label">Vigencia:</label>
                                    <div class="col-lg-2">
                                        <input type="date" name="vremi_vigen" class="form-control" min="<?php echo date("Y-m-d");?>" value="<?php echo date("Y-m-d");?>"/>
                                    </div>

                                    <label class="col-lg-2 control-label">N° Remision:</label>
                                    <div class="col-lg-2">
                                        <input type="text" name="vnro_remi" placeholder="002-001-5387653" class="form-control" required="" onchange="solo_remision()" onkeyup="solo_remision()" pattern="[0-9-]{15,15}" title="SOLO SE PERMITEN 15 DIGITOS"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-1 control-label">Timbrado N°:</label>
                                    <div class="col-lg-2">
                                        <input type="text" name="vtimbrado" placeholder="12345678" class="form-control" required=""/>
                                    </div>

                                    <?php $proveedores = consultas::get_datos("SELECT * FROM proveedor WHERE prv_estado = 'ACTIVO' ORDER BY prv_razonsocial");?>
                                    <label class="col-lg-1 control-label">Proveedor:</label>
                                    <div class="col-lg-3">
                                        <select class="form-control select2" name="vprv_cod" required="" id="proveedor" onchange="compras()">
                                            <option value="">Seleccione un proveedor</option>
                                            <?php foreach ($proveedores as $proveedor) { ?>
                                            <option value="<?php echo $proveedor['prv_cod'];?>"><?php echo "(".$proveedor['prv_ruc'].") ".$proveedor['prv_razonsocial'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div id="lista_compras"></div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-1 control-label">Motivo:</label>
                                    <div class="col-lg-2">
                                        <input type="text" id="descrip" onkeyup="sololetras()" onchange="sololetras()" placeholder="Ingrese descripcion" class="form-control" name="vmotivo" pattern="[A-Za-z ]{4,30}"/>
                                    </div>

                                    <label class="col-lg-1 control-label">Empleado:</label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" value="<?php echo $_SESSION['nombres'];?>" readonly=""/>
                                    </div>
                                </div>

                                <hr>

                                <div class="form-group">
                                    <label class="col-lg-1 control-label">Conductor:</label>
                                    <div class="col-lg-2">
                                        <input type="text" required="" id="conduc" placeholder="Ingrese descripcion" class="form-control" onchange="solo_conduc()" onkeyup="solo_conduc()" name="vconductor"/>
                                    </div>

                                    <label class="col-lg-1 control-label">CI:</label>
                                    <div class="col-lg-2">
                                        <input type="text" placeholder="Especifique CI" class="form-control" name="vci" id="cii" onchange="solo_cii()" onkeyup="solo_cii()" pattern="[0-9]{7}" title="SOLO SE PERMITEN 7 DIGITOS"/>
                                    </div>

                                    <label class="col-lg-1 control-label">Telefono:</label>
                                    <div class="col-lg-2">
                                        <input type="text" placeholder="Especifique telefono" class="form-control" name="vtelef" id="tel" onchange="solo_telefo()" onkeyup="solo_telefo()" pattern="[0-9]{9,10}" title="SOLO SE PERMITEN 10 DIGITOS"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-1 control-label">Matricula:</label>
                                    <div class="col-lg-2">
                                        <input type="text" required="" id="chap" placeholder="Ingrese numero de chapa" class="form-control" onchange="solo_chapa()" onkeyup="solo_chapa()" name="vchapa"/>
                                    </div>

                                    <?php $marcas = consultas::get_datos("select * from marca_vehiculo order by cod_mar_vehi"); ?>
                                    <label class="col-lg-1 control-label">Vehiculo:</label>
                                    <div class="col-lg-3">
                                        <select class="form-control select2" name="vmarca" required="">
                                            <option value="">Seleccione una marca de vehiculo</option>
                                            <?php if (!empty($marcas)) {
                                                foreach ($marcas as $marca) { ?>
                                                <option value="<?php echo $marca['cod_mar_vehi']; ?>"><?php echo $marca['descrip_mar_vehi']; ?></option>
                                            <?php }
                                            } else { ?>
                                                <option value="">Debe insertar una marca de vehiculo</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <hr>

                                <div class="form-group has-feedback">
                                    <label class="control-label col-lg-1">Salida:</label>
                                    <div class="col-lg-2">
                                        <input type="date" name="vsalida" class="form-control" min="<?php echo date("Y-m-d");?>" value="<?php echo date("Y-m-d");?>"/>
                                    </div>

                                    <label class="control-label col-lg-1">Llegada:</label>
                                    <div class="col-lg-2">
                                        <input type="date" name="vllegada" class="form-control" min="<?php echo date("Y-m-d");?>" value="<?php echo date("Y-m-d");?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="box-footer">
                                <a href="nota_remision.index.php" class="btn btn-default">
                                    <i class="fa fa-remove"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary pull-right" data-title="Guardar datos" rel="tooltip">
                                    <i class="fa fa-floppy-o"></i> Registrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require 'menu/footer_lte.ctp'; ?>
</div>
<?php require 'menu/js_lte.ctp'; ?>
<script>
    function compras() {
        $.ajax({
            type: "GET",
            url: "/tdp/compras.remi.php?vprv_cod=" + $('#proveedor').val(),
            cache: false,
            beforeSend: function() {
                $('#lista_compras').html('<img src="img/loader.gif" /><strong>Cargando...</strong>');
            },
            success: function(msg) {
                $('#lista_compras').html(msg);
            }
        });
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

function solo_cii() {
    var numero = document.getElementById("cii").value;
        if (numero.match(/^-?[0-9]+(\.[0-9](1,2))?$/))
            {

            } else {
                notificacion('Atencion', 'No se permiten letras o espacios ', 'window.alert(message);');
                //notificacion("Solo numeros");
                document.getElementById("cii").value = "";

            }
}
function solo_telefo() {
    var numero = document.getElementById("tel").value;
        if (numero.match(/^-?[0-9]+(\.[0-9](1,2))?$/))
            {

            } else {
                notificacion('Atencion', 'No se permiten letras o espacios ', 'window.alert(message);');
                //notificacion("Solo numeros");
                document.getElementById("tel").value = "";

                }
}
 function solo_chapa() {
                //var numero = trim(numero);
    var numero = document.getElementById("chap").value;
        if (numero.length === 0 || numero === " ") {
                notificacion('Atencion', 'No se permiten campos vacios', 'window.alert(message);');
                   
                document.getElementById("chap").value = "Sin Chapa";
                    
                    
            } else {

            }
}
function solo_conduc() {
            //var numero = trim(numero);
                var numero = document.getElementById("conduc").value;
                if (numero.length === 0 || numero === " ") {
                    notificacion('Atencion', 'No se permiten campos vacios', 'window.alert(message);');
                   
                    document.getElementById("conduc").value = "Sin Nombre";
                    
                    
                } else {

                }
}
function solo_remision() {
var numero = document.getElementById("remisi").value;
    if (numero.match(/^-?[0-9--]+(\.[0-9--](1,2))?$/))
        {

        } else {
        notificacion('Atencion', 'No se permiten letras o espacios ', 'window.alert(message);');
        //notificacion("Solo numeros");
        document.getElementById("remisi").value = "";

         }
}
function sololetras() {
//                      var numero = trim(numero);
                var numero = document.getElementById("descrip").value;
                if (numero.length === 0 || numero === " ") {
                    notificacion('Atencion', 'No se permiten campos vacios', 'window.alert(message);');
                    document.getElementById("descrip").value = "";
                    
                    
                } else {

                }
}
$("#check").click(function () {
            $("#oculdescuento").css("display", "none");
            $("#descrip").val('');

        });


        $("#check_1").click(function () {
            $("#oculdescuento").css("display", "block");
});
</script>
</body>
</html>


