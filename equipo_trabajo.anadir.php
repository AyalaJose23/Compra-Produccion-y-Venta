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
    <body class="hold-transition skin-black sidebar-mini">
        <div class="wrapper">
            <?php require 'menu/header_lte.ctp'; ?><!--CABECERA PRINCIPAL-->
            <?php require 'menu/toolbar_lte.ctp'; ?><!--MENU PRINCIPAL-->
            <div class="content-wrapper">
                <div class="content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <i class="ion ion-plus"></i>
                                    <h3 class="box-title">Agregar Nuevo Equipo</h3>
                                    <div class="box-tools">
                                        <a href="equipo_trabajo.index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i> VOLVER</a>
                                    </div>
                                </div>
                                <form action="equipo_trabajo.control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vcod_fromula" value="0"/>                                    
                                    <div class="box-body">
                                    
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                    <label>Equipo:</label>
                                                <input type="text" class="form-control" name="vnombre_equipo"/>
                                            </div>
                                            

                                        <div class="form-group">
                                            <div class="col-lg-3 col-md-6 col-sm-6">
                                                <?php $fecha = consultas::get_datos("select current_date as fecha");?>
                                                <label>Fecha:</label>
                                                <input type="date" name="vfecha_creacion" class="form-control" value="<?php echo $fecha[0]['fecha'];?>" readonly="">
                                            </div>
                                            </div>
                                    <div class="box-footer">
                                        <button type="reset" class="btn btn-default" data-title="Cancelar" rel="tooltip">
                                            <i class="fa fa-remove"></i> Cancelar</button>                                        
                                        <button type="submit" class="btn btn-primary pull-right" data-title="Guardar datos" rel="tooltip">
                                            <i class="fa fa-floppy-o"></i> Registrar</button>
                                    </div>
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


