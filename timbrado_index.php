<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>SERVITECH SYS</title>

        <?php
        require './ver_sesion.php';
         require './anular_sesion.php'; #este es para bloquear la url
        require 'menu/css.ctp';
        ?>
    </head>
    <body>
        <div id="wrapper">
            <?php require 'menu/navbar.php'; ?><!--BARRA DE HERRAMIENTAS-->
            <div id="page-wrapper">
                <div class="row">
                    <!--impresion del titulo de la pagina-->
                    <div class="col-lg-12">
                        <h3 class="page-header text-center">Listado de Timbrados
                            
                            <a href="imprimir_timbrados.php" 
                               class="btn btn-primary btn-circle pull-right" 
                               rel="tooltip" data-title="Imprimir" target="_blank">
                                <i class="fa fa-print"></i>
                            </a> 
                            <a data-toggle="modal" data-target="#registrar" 
                               class="btn btn-primary btn-circle pull-right" 
                               rel="tooltip" data-title="Registrar Timbrados">
                                <i class="fa fa-plus"></i>
                            </a>                      
                        </h3>
                    </div>     
                    <!--Buscador-->
                    <div class="col-lg-12">
                        <div class="panel-heading">
                            <div class="input-group custom-search-form">
                                <input id="filtrar" type="text" class="form-control" placeholder="Buscar...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" rel="tooltip" title="Buscar">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>                      
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                Datos Sucursales
                            </div>
                            <?php
                            $timbrados = consultas::get_datos("select * from v_timbrado
                                         order by cod_timbrado asc ");
                            if (!empty($timbrados)) {
                                ?>                         
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <div>
                                        <table id="example1" width="100%" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Nro Timbrado</th>
                                                    <th class="text-center">Vigencia Inicio</th>
                                                    <th class="text-center">Vigencia Fin</th>
                                                    <th class="text-center">Desde</th>  
                                                    <th class="text-center">Hasta</th>  
                                                    <th class="text-center">Sucursal</th> 
                                                    <th class="text-center">Tipo Comprobante</th>  
                                                    <th class="text-center">Estado</th> 
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody class="buscar">
                                                <?php foreach ($timbrados as $timbrado) { ?> 
                                                    <tr>
                                                        <td class="text-center"><?php echo $timbrado['cod_timbrado']; ?></td>
                                                        <td class="text-center"><?php echo $timbrado['nro_timbrado']; ?></td>
                                                        <td class="text-center"><?php echo $timbrado['vfecha_ini']; ?></td>
                                                        <td class="text-center"><?php echo $timbrado['vfecha_fin']; ?></td>
                                                        <td class="text-center"><?php echo $timbrado['tim_desde']; ?></td>
                                                        <td class="text-center"><?php echo $timbrado['tim_hasta']; ?></td>
                                                        <td class="text-center"><?php echo $timbrado['suc_descri']; ?></td>
                                                        <td class="text-center"><?php echo $timbrado['comprobante_des']; ?></td>
                                                        <td class="text-center"><?php echo $timbrado['estado']; ?></td>
                                                        <td class="text-center">
                                                            <a onclick="editar(<?php echo "'" . $timbrado['cod_timbrado'] . "_" .
                                                                    $timbrado['fecha_inicio'] . "_" .
                                                                    $timbrado['fecha_fin'] . "_" .
                                                                    $timbrado['nro_timbrado'] . "_" .
                                                                    $timbrado['cod_suc'] . "_" .
                                                                    $timbrado['cod_tipo_comp'] . "_" .
                                                                    $timbrado['tim_desde'] . "_" .
                                                                    $timbrado['tim_hasta'] . "'"; ?>)" 
                                                               class="btn btn-xs btn-info" rel='tooltip' data-title="Editar Timbrado" 
                                                               data-toggle="modal" data-target="#editar">
                                                                <span class="glyphicon glyphicon-pencil"></span></a>
                                                                  
                                                               <a onclick="borrar(<?php echo "'" . $timbrado['cod_timbrado'] . "_" . 
                                                                    $timbrado['cod_usu'] . "_" .
                                                                    $timbrado['fecha_inicio'] . "_" .
                                                                    $timbrado['fecha_fin'] . "_" .
                                                                    $timbrado['nro_timbrado'] . "_" .
                                                                    $timbrado['cod_suc'] . "_" .
                                                                    $timbrado['cod_tipo_comp'] . "_" .
                                                                    $timbrado['tim_desde'] . "_" .
                                                                    $timbrado['tim_hasta'] . "_" .
                                                                    $timbrado['comprobante_des'] . "'"; ?>)" 
                                                               class="btn btn-xs btn-danger" rel='tooltip' data-title="Borrar"
                                                               data-toggle="modal"
                                                               data-target="#delete">
                                                                <span class="glyphicon glyphicon-trash"></span></a>
                                                                
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>                         
                                    </div>
                                <?php } else { ?>
                                    <div class="alert alert-info alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <strong>No se encontraron registro....!</strong>
                                    </div>
                                <?php } ?>  
                                <!-- /.panel-body -->
                            </div>
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <!--registrar-->
                <div id="registrar" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" 
                                        data-dismiss="modal" arial-label="Close">x</button>
                                <h4 class="modal-title"><strong>Registrar Timbrado</strong></h4>
                            </div>
                            <form action="timbrado_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                <div class="panel-body se">
                                    <input type="hidden" name="accion"  value="1">
                                    <input type="hidden" name="vtim" value="0"/>
                                    <input type="hidden" name="vsuc" id="vsuc" value="<?php echo $_SESSION['cod_suc'] ?>">
                                    <input type="hidden" name="vusu" id="vusu" value="<?php echo $_SESSION['cod_usu'] ?>">
                                    <input type="hidden" name="pagina" value="timbrado_index.php">

                                    <!-- INICIO Nro tim-->
                                    <div class="form-group">
                                    <label class="col-md-3 control-label">Nro Timbrado:</label>
                                    <div class="col-md-4">
                                        <input type="text" required="" id="nro_tim" minlength="8" maxlength="8" title="No debe superar 8 digitos"
                                               placeholder="Ingrese Numero de Timbrado con 8 digitos" autocomplete="off"
                                               class="form-control" name="vnro"
                                               onkeyup="nronegativo()"
                                               onchange="nronegativo()"
                                               autofocus="">
                                    </div>
                                </div>
                                 <br>
<!--                                Fin Numero tim-->

                                      <!--Inicio Comprobante-->
                                    <div class="form-group">
                                    <label class="col-lg-3 control-label">Tipo Comprobante:</label>
                                    <?php $tipo_comprobantes = consultas::get_datos("select * from tipo_comprobante order by cod_tipo_comp"); ?>
                                    <div class="col-lg-4">
                                        <select name="vtipo_comp" required="" class="form-control select" >
                                            <?php
                                            if (!empty($tipo_comprobantes)) {
                                                foreach ($tipo_comprobantes as $tipo_comprobante) {
                                                    ?>
                                                    <option value="<?php echo $tipo_comprobante['cod_tipo_comp']; ?>">
                                                        <?php echo $tipo_comprobante['comprobante_des']; ?></option>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <option value="0">Debe insertar un Tipo de Comprobante</option>
                                            <?php } ?>    
                                        </select>
                                    </div>
                                </div>
                                 <br>
                                 <!--Fin Ciudad-->
                                <!--Inicio Fecha-->
                                    <div class="form-group">
                                    <label class="col-md-3 control-label">Vigencia Inicio:</label>
                                    <div class="col-md-4">
                                        <input type="date" required="" id="desde"
                                               placeholder="Especifique Inicio de Vigencia" title="Especifique Inicio de Vigencia del Timbrado"
                                               class="form-control"
                                               value="<?php echo date("Y-m-d") ?>" name="vfecha_ini"
                                               onchange="validar_vigen_timbrado()"
                                               onkeyup="validar_vigen_timbrado()"
                                               onchange="validar_vigen_timbrado()"
                                               onclick="validar_vigen_timbrado()"
                                               onkeypress="validar_vigen_timbrado()">
                                    </div>
                                </div>
                                <br>
                                 <!--Fin Fecha Inicio-->
                                 
                                 <!--Inicio Desde-->
                                    <div class="form-group">
                                    <label class="col-md-3 control-label">Vigencia Fin:</label>
                                    <div class="col-md-4">
                                        <input type="date" required="" id="hasta"
                                               placeholder="Especifique Vigencia Fin" title="Especifique Fin de Vigencia del Timbrado"
                                               class="form-control"
                                               value="<?php echo date("Y-m-d") ?>" name="vfecha_fin" 
                                               onchange="validar_vigen_timbrado()"
                                               onkeyup="validar_vigen_timbrado()"
                                               onchange="validar_vigen_timbrado()"
                                               onclick="validar_vigen_timbrado()"
                                               onkeypress="validar_vigen_timbrado()"
                                               >
                                    </div>
                                </div>
                                <br>
                                 <!--Fin Hasta-->
                                 
                                 <!-- INICIO Hasta-->
                                    <div class="form-group">
                                    <label class="col-md-3 control-label">Timbrado Desde:</label>
                                    <div class="col-md-4">
                                        <input type="text"  required="" id="tim_desde" minlength="7" maxlength="7" title="Desde que numero de pagina inicia desde"
                                               placeholder="Ingrese Numero Desde"  autocomplete="off"
                                               class="form-control" name="vdesde"
                                               value="0000001"
                                               onkeyup="nronegativo_desde();"
                                               onchange="nronegativo_desde();  validar_numero_hasta()"
                                               autofocus="">
                                    </div>
                                </div>
                                 <br>
<!--                                Fin Hasta-->
                                   
                                
                                    <!-- INICIO direccion-->
                                    <div class="form-group">
                                    <label class="col-md-3 control-label">Timbrado Hasta:</label>
                                    <div class="col-md-4">
                                        <input type="text" required="" id="tim_hasta" minlength="7" maxlength="7" title="Hasta que numero de pagina tendria hasta"
                                               placeholder="Ingrese Numero Hasta" autocomplete="off"
                                               class="form-control" name="vhasta"
                                               value="0000100"
                                               onkeyup="nronegativo_hasta();"
                                               onchange="nronegativo_hasta(); validar_numero_hasta()"
                                               autofocus="">
                                    </div>
                                </div>
                                    <br>
<!--                                Fin Sucursal direccion-->
                               
<!--                                 Inicio Sucursal-->
                                 <div class="form-group">
                                        <label class="col-md-3 control-label">Sucursal:</label>
                                        <div class="col-md-4">
                                            <?php $sucursales = consultas::get_datos("select * from v_sucursal where cod_suc=".$_SESSION['cod_suc']. " order by cod_suc"); ?>
                                            <select name="vsuc" class="form-control">
                                                <?php
                                                if (!empty($sucursales)) {
                                                    foreach ($sucursales as $sucursal) {
                                                        ?>
                                                        <option value="<?php echo $sucursal['cod_suc']; ?>">
                                                            <?php echo $sucursal['suc_descri']; ?></option>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <option value="0">Debe ingresar una Sucursal</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
<!--                                 Fin sucursal-->
                                <br>
                                </div>
                                <br>
                                <div class="modal-footer">
                                    <button type="reset" data-dismiss="modal" class="btn btn-default pull-left">
                                        <i class="fa fa-close"></i> Cerrar</button>
                                    <button type="submit" class="btn btn-primary pull-right">
                                        <i class="fa fa-floppy-o"></i> Registrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--fin-->
            <!--editar-->
            <div id="editar" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" 
                                    data-dismiss="modal" arial-label="Close">x</button>
                            <h4 class="modal-title"><strong>Editar Timbrado</strong></h4>
                        </div>
                        <form action="timbrado_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                            <div class="panel-body">
                                <input name="accion" value="2" type="hidden"/>
                                <input type="hidden" name="pagina" value="timbrado_index.php">
                                <input id="cod" type="hidden" name="vtim"/>
                                <input id="tipo_comp_oculto" type="hidden" name="vtipo_comp"/>
                                <input type="hidden" name="vusu" id="vusu" value="<?php echo $_SESSION['cod_usu'] ?>">
                                <input id="estado" type="hidden" name="vestado" value="ACTIVO"/>
                                
                                 <!-- INICIO Nro tim-->
                                    <div class="form-group">
                                    <label class="col-md-3 control-label">Nro Timbrado:</label>
                                    <div class="col-md-4">
                                        <input type="text" required="" id="nro_timbra" minlength="8" maxlength="8" title="No debe superar 8 digitos"
                                               placeholder="Ingrese Numero de Timbrado con 8 digitos"  autocomplete="off"
                                               class="form-control" name="vnro" readonly=""
                                               onkeyup="nronegativo2()"
                                               onchange="nronegativo2()"
                                               value="<?php echo $timbrados[0]['nro_timbrado']; ?>"
                                               autofocus="">
                                    </div>
                                </div>
                                 <br>
<!--                                Fin Numero tim-->

                               <!--Inicio Comprobante-->
                                    <div class="form-group">
                                    <label class="col-lg-3 control-label">Tipo Comprobante:</label>
                                    <?php $tipo_comprobantes = consultas::get_datos("select * from tipo_comprobante order by cod_tipo_comp"); ?>
                                    <div class="col-lg-4">
                                        <select id="tipo_comp" required="" class="form-control select" disabled="">
                                            <?php
                                            if (!empty($tipo_comprobantes)) {
                                                foreach ($tipo_comprobantes as $tipo_comprobante) {
                                                    ?>
                                                    <option value="<?php echo $tipo_comprobante['cod_tipo_comp']; ?>">
                                                        <?php echo $tipo_comprobante['comprobante_des']; ?></option>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <option value="0">Debe insertar un Tipo de Comprobante</option>
                                            <?php } ?>    
                                        </select>
                                    </div>
                                </div>
                                 <br>
                                 <!--Fin Ciudad-->
                                <!--Inicio Fecha-->
                                    <div class="form-group">
                                    <label class="col-md-3 control-label">Vigencia Inicio:</label>
                                    <div class="col-md-4">
                                        <input type="date" required="" id="desde_tim"
                                               placeholder="Especifique Inicio de Vigencia" title="Especifique Inicio de Vigencia del Timbrado"
                                               class="form-control" name="vfecha_ini"
                                               onchange="validar_vigen_timbrado2()"
                                               onkeyup="validar_vigen_timbrado2()"
                                               onchange="validar_vigen_timbrado2()"
                                               onclick="validar_vigen_timbrado2()"
                                               onkeypress="validar_vigen_timbrado2()"
                                               value="<?php echo $timbrados[0]['fecha_inicio']; ?>">
                                    </div>
                                </div>
                                <br>
                                 <!--Fin Fecha Inicio-->
                                 
                                 <!--Inicio Desde-->
                                    <div class="form-group">
                                    <label class="col-md-3 control-label">Vigencia Fin:</label>
                                    <div class="col-md-4">
                                        <input type="date" required="" id="hasta_tim"
                                               placeholder="Especifique Vigencia Fin" title="Especifique Fin de Vigencia del Timbrado"
                                               class="form-control" name="vfecha_fin" 
                                               onchange="validar_vigen_timbrado2()"
                                               onkeyup="validar_vigen_timbrado2()"
                                               onchange="validar_vigen_timbrado2()"
                                               onclick="validar_vigen_timbrado2()"
                                               onkeypress="validar_vigen_timbrado2()"
                                                value="<?php echo $timbrados[0]['fecha_fin']; ?>"
                                               >
                                    </div>
                                </div>
                                <br>
                                 <!--Fin Hasta-->
                                 
                                 <!-- INICIO Hasta-->
                                    <div class="form-group">
                                    <label class="col-md-3 control-label">Timbrado Desde:</label>
                                    <div class="col-md-4">
                                        <input type="text"  required="" id="timbra_desde" minlength="1" maxlength="7" title="Desde que numero de pagina inicia desde"
                                               placeholder="Ingrese Numero Desde" autocomplete="off"
                                               class="form-control" name="vdesde"
                                               onkeyup="nronegativo_desde2();"
                                               onchange="nronegativo_desde2();  validar_numero_hasta2()"
                                               value="<?php echo $timbrados[0]['tim_desde']; ?>"
                                               autofocus="">
                                    </div>
                                </div>
                                 <br>
<!--                                Fin Hasta-->
                                   
                                
                                    <!-- INICIO direccion-->
                                    <div class="form-group">
                                    <label class="col-md-3 control-label">Timbrado Hasta:</label>
                                    <div class="col-md-4">
                                        <input type="text" required="" id="timbra_hasta" minlength="1" maxlength="7" title="Hasta que numero de pagina tendria hasta"
                                               placeholder="Ingrese Numero Hasta" autocomplete="off"
                                               class="form-control" name="vhasta"
                                               onkeyup="nronegativo_hasta2();"
                                               onchange="nronegativo_hasta2(); validar_numero_hasta2()"
                                               value="<?php echo $timbrados[0]['tim_hasta']; ?>"
                                               autofocus="">
                                    </div>
                                </div>
                                    <br>
<!--                                Fin Sucursal direccion-->
                               
<!--                                 Inicio Sucursal-->
                                 <div class="form-group">
                                        <label class="col-md-3 control-label">Sucursal:</label>
                                        <div class="col-md-4">
                                            <?php $sucursales = consultas::get_datos("select * from v_sucursal where cod_suc=".$_SESSION['cod_suc']. " order by cod_suc"); ?>
                                            <select id="vsucursal" name="vsuc" class="form-control">
                                                <?php
                                                if (!empty($sucursales)) {
                                                    foreach ($sucursales as $sucursal) {
                                                        ?>
                                                        <option value="<?php echo $sucursal['cod_suc']; ?>">
                                                            <?php echo $sucursal['suc_descri']; ?></option>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <option value="0">Debe ingresar una Sucursal</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
<!--                                 Fin sucursal-->
                                <br>
                                
                            </div>
                            <div class="modal-footer">
                                <button type="reset" data-dismiss="modal" class="btn btn-default pull-left">
                                    <i class="fa fa-close"></i> Cerrar</button>
                                <button type="submit" class="btn btn-primary pull-right">
                                    <i class="fa fa-refresh"></i> Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--fin-->

            <!--borrar-->
            <div class="modal fade" id="delete" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title custom_align" id="Heading">Atenci&oacute;n!!!</h4>
                        </div>
                        <div class="modal-body">

                            <div class="alert alert-warning" id="confirmacion"></div>

                        </div>
                        <div class="modal-footer">
                            <a id="si" role="button" class="btn btn-primary" ><span class="glyphicon glyphicon-ok-sign"></span> Si</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
                        </div>
                    </div>
                </div>
            </div> 
            <!--fin-->
        </div> 
        <!--archivos js-->  
        <?php require 'menu/js.ctp'; ?>


        <script>
            function editar(datos) {
                var dat = datos.split("_");
                $('#cod').val(dat[0]);
                $('#desde_tim').val(dat[1]);
                $('#hasta_tim').val(dat[2]);
                $('#nro_timbra').val(dat[3]);
                $('#vsucursal').val(dat[4]);
                $('#tipo_comp').val(dat[5]);
                $('#timbra_desde').val(dat[6]);
                $('#timbra_hasta').val(dat[7]);
                $('#tipo_comp_oculto').val(dat[5]);
            }
            
            function borrar(datos) {
                var dat = datos.split("_");
                $('#si').attr('href'
                , 'timbrado_control.php?vtim=' + dat[0] + 
                        '&vusu=' + dat[1] +
                        '&vfecha_ini=1900-01-01'+
                        '&vfecha_fin=1900-01-01'+
                        '&vnro='+ dat[4] +
                        '&vestado=null'+
                        '&vsuc='+ dat[5] +
                        '&vtipo_comp='+ dat[6] +
                        '&vdesde='+ dat[7] +
                        '&vhasta='+ dat[8] +
                        '&accion=3'+
                        '&pagina=timbrado_index.php');
                $('#confirmacion').html('<span class="glyphicon glyphicon-warning-sign"></span>\n\
            Desea Borrar el Timbrado N° <i><strong>' + dat[4] + ' del Comprobante ' + dat[9] + '</strong></i> ?');
            }
            
            function validar_vigen_timbrado() { //valida la fechas de vigencia
                var hoy = new Date($('#desde').val());
                var fechaFormulario = new Date($('#hasta').val());
                if (fechaFormulario < hoy) {
                    alert('El timbrado ya vencio!!!');
                    $('#desde').val(hoy);
                    $('#hasta').val(fechaFormulario);
                }
                else {
//                    $("#ocultar").css("display", "block");
                }
            }
            
             function validar_vigen_timbrado2() { //valida la fechas de vigencia
                var hoy = new Date($('#desde_tim').val());
                var fechaFormulario = new Date($('#hasta_tim').val());
                if (fechaFormulario < hoy) {
                    alert('El timbrado ya vencio!!!');
                    $('#desde_tim').val(hoy);
                    $('#hasta_tim').val(fechaFormulario);
                }
                else {
//                    $("#ocultar").css("display", "block");
                }
            }
            

            
            function validar_numero_hasta() { //valida los numeros de timbrado desde hasta
                 var timbrado_desde = parseInt($('#tim_desde').val());
                 var timbrado_hasta = parseInt($('#tim_hasta').val());
                 
                if (timbrado_hasta <= timbrado_desde) {
                    alert('El numero de timbrado Hasta debe ser mayor a Desde!!!');
                    $('#tim_desde').val('0000001');
                    $('#tim_hasta').val('0000100');
                }
                else {
//                    $("#ocultar").css("display", "block");
                }
            }
            
            function validar_numero_hasta2() { //valida los numeros de timbrado desde hasta
                 var timbrado_desde = parseInt($('#timbra_desde').val());
                 var timbrado_hasta = parseInt($('#timbra_hasta').val());
                 
                if (timbrado_hasta <= timbrado_desde) {
                    alert('El numero de timbrado Hasta debe ser mayor a Desde!!!');
                    $('#timbra_desde').val('');
                    $('#timbra_hasta').val('');
                }
                else {
//                    $("#ocultar").css("display", "block");
                }
            }
            
                
            //para que no permita numeros negativos ni letras ci
            function nronegativo_desde() {

                var numero = document.getElementById("tim_desde").value;
                if (numero.match(/^-?[0-9]+(\.[0-9]{1,2})?$/))
                {
//                    alert("numero ok");
                }
                else
                {
                    alert("Ingrese su numero sin puntos, letras ni espacios");
                    document.getElementById("tim_desde").value = "";
                }
            }
            function nronegativo_desde2() {

                var numero = document.getElementById("timbra_desde").value;
                if (numero.match(/^-?[0-9]+(\.[0-9]{1,2})?$/))
                {
//                    alert("numero ok");
                }
                else
                {
                    alert("Ingrese su numero sin puntos, letras ni espacios");
                    document.getElementById("timbra_desde").value = "";
                }
            }
            
            function nronegativo_hasta() {

                var numero = document.getElementById("tim_desde").value;
                if (numero.match(/^-?[0-9]+(\.[0-9]{1,2})?$/))
                {
//                    alert("numero ok");
                }
                else
                {
                    alert("Ingrese su numero sin puntos, letras ni espacios");
                    document.getElementById("tim_desde").value = "";
                }
            }
            function nronegativo_hasta2() {

                var numero = document.getElementById("timbra_hasta").value;
                if (numero.match(/^-?[0-9]+(\.[0-9]{1,2})?$/))
                {
//                    alert("numero ok");
                }
                else
                {
                    alert("Ingrese su numero sin puntos, letras ni espacios");
                    document.getElementById("timbra_hasta").value = "";
                }
            }
            function nronegativo() {

                var numero = document.getElementById("nro_tim").value;
                if (numero.match(/^-?[0-9]+(\.[0-9]{1,2})?$/))
                {
//                    alert("numero ok");
                }
                else
                {
                    alert("Ingrese su numero sin puntos, letras ni espacios");
                    document.getElementById("nro_tim").value = "";
                }
            }
            function nronegativo2() {

                var numero = document.getElementById("nro_timbra").value;
                if (numero.match(/^-?[0-9]+(\.[0-9]{1,2})?$/))
                {
//                    alert("numero ok");
                }
                else
                {
                    alert("Ingrese su numero sin puntos, letras ni espacios");
                    document.getElementById("nro_timbra").value = "";
                }
            }
   //hasta aqui
   
        </script>


    </body>
</html>

