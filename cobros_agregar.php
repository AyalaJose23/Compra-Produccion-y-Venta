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
                        <h3 class="page-header text-center alert-info"> <strong>AÑADIR COBRO</strong>
                            <a href="cobros.php" 
                               class="btn btn-success  pull-right" 
                               rel='tooltip' title="Atras">
                                <i class="glyphicon glyphicon-arrow-left"></i>
                            </a> 

                        </h3>
                    </div>
                    </div>
                    <div class="box-body" style="border: 2px solid #ccc; border-radius: 8px;">
                        <?php 
                            $aper = consultas::get_datos("SELECT * FROM v_aperturas WHERE estado_aper = 'ACTIVO'"); 
                            $recibo = consultas::get_datos("SELECT * FROM v_nrecibo_siguiemtenumero"); 
                            $fecha = consultas::get_datos("SELECT * FROM v_fecha"); 
                        ?>
                        <form action="cobros_control.php" method="post" id="formRegistroCobros" class="form-horizontal">
                            <input type="hidden" name="accion" value="1">
                            <input type="hidden" name="codigo" value="0">
                            <input type="hidden" name="vape" value="<?php echo $aper[0]['id_apercierre']; ?>">
                            <input type="hidden" name="vemp" value="<?php echo $_SESSION['emp_cod']; ?>">
                            <input type="hidden" name="pagina" value="cobros.php">
                            <input type="hidden" name="estado" value="ACTIVO">
                            <input type="hidden" name="vrecibo" value="<?php echo $recibo[0]['nro_recibo']; ?>">
                            <input type="hidden" name="vrecinume" value="<?php echo $recibo[0]['siguienterecibo']; ?>">
                            
                            <fieldset>
                                <div class="form-group">
                                    <label for="clicod" class="col-md-1 ">Cliente</label>
                                    <div class="col-md-3">
                                        <select name="vcli_cod" id="clicod" class="form-control chosen-select" required onchange="getCuentas();">
                                            <?php 
                                                $clientes = consultas::get_datos("SELECT * FROM v_clientes");
                                                foreach ($clientes as $cliente) {
                                                    echo "<option value='{$cliente['cli_cod']}'>{$cliente['cli_nombre']} {$cliente['cli_apellido']}</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    
                                    
                                    <label for="fecha" class="col-md-2 ">Fecha de Cobro</label>
                                    <div class="col-md-2">
                                        <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo date("Y-m-d"); ?>" disabled>
                                    </div> 
                                    
                                
                                        
                                            <label  class="col-md-1">Funcionario</label>
                                            <div class="col-md-2 " >
                                            <?php $funcionario = consultas::get_datos("SELECT emp_nombre FROM empleado WHERE emp_cod = ".$_SESSION['emp_cod']);
                                            ?>

                                            <input type="text" readonly="" readonly="" class="form-control" 
                                                value="<?php echo $funcionario[0]['emp_nombre']; ?>">
                                        </div>
                                        
                                        
                                    </div>
                                    <input type="hidden" class="form-control" name="detallecobro" id="detallecobro">
                                    <input type="hidden" class="form-control" name="totalcobrar" id="totalcobrar" value="0">                        
                                    <input type="hidden" class="form-control" name="detallecheque" id="detallecheque">
                                    <input type="hidden" class="form-control" name="detalletarjeta" id="detalletarjeta">
                                    <input type="hidden" class="form-control" name="totalcheques" id="totalcheques" value="0"> 
                                    <input type="hidden" class="form-control" name="totaltarjetas" id="totaltarjetas" value="0"> 
                                    <br><br>
                                    <div class="panel panel-success">
                                        <div class="panel-heading"><strong>Detalles</strong></div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <div class="col-sm-1">
                                                    <label for="cuentas" class="control-label">Cuentas</label>
                                                </div>
                                                <div class="col-sm-5">
                                                    <select class="form-control chosen-select2" name="cuentas" id="cuentas" onchange="cuentaselect();" onblur="cuentaselect();" required="">

                                                    </select>
                                                    <div id="prog"></div>
                                                </div>

                                                <div class="col-sm-1">
                                                    <label for="saldo" class="control-label">Saldo</label>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input  readonly=""type="number" class="form-control" min="1" name="saldo" id="saldo" autofocus="">
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table" id="grilladetalle">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">#Cuota</th>
                                                    <th style="text-align: center;">Descripcion</th>
                                                    <th style="text-align: center;">Vencimiento</th>
                                                    <th style="text-align: right;">Monto</th>
                                                    <th style="text-align: right;"></th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>

                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="panel panel-success">
                                        <div class="panel-heading"><strong>Total</strong> <span class="label label-primary right-block" id="lbtotalcobrado" style="padding-left: 5px; padding-right: 5px; font-size: large;">0</span></div>
                                        <div class="panel-body">
                                            <div class="panel-group" id="acordeon">
                                                <div class="panel panel-warning">
                                                    <span class="col-md-1"></span>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <br>
                                                            
                                                            <label class="col-md-2 control-label" >FORMA DE COBRO:</label>
                                                             <div class="col-md-5">
                                                                
                                                                <select name="vformacobro" class="form-control chosen-select2" id="vformacobro" onchange="tiposelect1(),tiposelect2(),tiposelect3(),tiposelect4(),tiposelect5(),tiposelect6(),tiposelect7() ">
                                                                    <option  value="1" id="efec">EFECTIVO</option>
                                                                    <option value="2" id="tar">TARJETA</option>
                                                                    <option value="3" id="che">CHEQUE</option>
                                                                    <option value="4" id="efectarj"> EFECTIVO - TARJETA</option>
                                                                    <option value="5" id="efecheque">EFECTIVO - CHEQUE</option>
                                                                    <option value="6" id="cheqtarj">TARJETA - CHEQUE</option>
                                                                    <option value="7" id="efeccheqtarj">EFECTIVO - TARJETA - CHEQUE</option>
                                                                </select>
                                                            </div>

                                                        </div>                                  
                                                    </div>   
                                                 
                                                    <div class="panel panel-warning"  style="display: none" id="ocultarefectivo">
                                                        <div class="panel-heading" >
                                                            <h4 class="panel-title" >
                                                                <a data-toggle="collapse" data-parent="#acordeon" href="#cobroefectivo">PAGO EN EFECTIVO <span class="label label-success right-block" id="lbmontoefe"   style="background-color: green; color: white; padding-left: 5px; padding-right: 5px; font-size: medium;">0</span></a>
                                                            </h4>
                                                        </div>
                                                        <div id="cobroefectivo" class="panel-collapse collapse" >
                                                            <div class="panel-body">
                                                                <div class="form-group">
                                                                    <div class="col-sm-2">
                                                                        <label for="efectivo" class="control-label">IMPORTE EFECTIVO:</label>
                                                                    </div>
                                                                    <div class="col-sm-3">
                                                                        <input min="1" type="number" class="form-control alert-warning" name="efectivo" id="efectivo" value="0" onkeyup="calcularVuelto(), validar()">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
<!--                                        COBRO TARJETA 1-->
                                                <br>
                                                

                                                <div class="panel panel-danger" style="display: none" id="ocultartarjeta">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#acordeon" href="#cobrotarjeta"> PAGO CON TARJETA  A <span class="label label-success right-block" id="lbmontotarjeta" style="background-color: green; color: white; padding-left: 5px; padding-right: 5px; font-size: medium;">0</span></a>
                                                        </h4>
                                                    </div>
                                                    <div id="cobrotarjeta" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <input type="hidden"  id="codigotarjeta" name="codigotarjeta" value="0">
                                                            <div class="form-group">
                                                                <div class="col-sm-1">
                                                                    <label for="efectivo" class="control-label">ENTIDAD:</label>
                                                                </div>
                                                                <div class="col-sm-3">                    
                                                                    <select class="form-control chosen-select2" name="entidad"  id="entidad" >
                                                                        <?php $entidas = consultas::get_datos("select * from enti_emisora"); ?> 
                                                                        <?php foreach ($entidas as $entida) { ?>
                                                                            <option value="<?php echo $entida['cod_entidad']; ?>"><?php echo $entida['entidad_descri']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <label for="efectivo" class="control-label">IMPORTE TARJETA</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="number" class="form-control alert-warning" name="importarj" id="importarj" value="0" onkeyup="calcularVuelto(), validar();">
                                                                </div>  
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-1">
                                                                    <label for="efectivo" class="control-label">POS:</label>
                                                                </div>
                                                                <div class="col-sm-3">                    
                                                                    <select class="form-control chosen-select2" name="vpost" id="vpost"   >
                                                                        <?php $posts = consultas::get_datos("select * from tipo_pos"); ?> 
                                                                        <?php foreach ($posts as $post) { ?>
                                                                            <option value="<?php echo $post['cod_tipo_pos']; ?>"><?php echo $post['descri_post']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <label for="efectivo" class="control-label">#VOUCHER:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="number" class="form-control" name="voucher" id="voucher"  value="" >
                                                                </div>


                                                                
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-sm-1">
                                                                    <label for="efectivo" class="control-label">TIPO TARJ:</label>
                                                                </div>
                                                                <div class="col-sm-3">                    
                                                                    <select class="form-control chosen-select2" name="vtipotarj" id="vtipotarj"   >
                                                                        <?php $tipostars = consultas::get_datos("select * from v_tipo_tarjetas"); ?> 
                                                                        <?php foreach ($tipostars as $tipostar) { ?>
                                                                            <option value="<?php echo $tipostar['id_tarjeta']; ?>"><?php echo $tipostar['tarj_tipo']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <label for="efectivo" class="control-label">#TARJETA:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="number" class="form-control" name="nrotarj" id="nrotarj" value="" >
                                                                </div>

                                                                
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
<!--                                              COBRO TARJETA 2-->
                                                <div class="panel panel-danger" style="display: none" id="ocultartarjeta2">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#acordeon" href="#cobrotarjeta2">PAGO CON TARJETA B <span class="label label-success right-block" id="lbmontotarjeta2" style="background-color: green; color: white; padding-left: 5px; padding-right: 5px; font-size: medium;">0</span></a>
                                                        </h4>
                                                    </div>
                                                    <div id="cobrotarjeta2" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <input type="hidden"  id="codigotarjeta2" name="codigotarjeta2" value="0">
                                                            <div class="form-group">
                                                                <div class="col-sm-1">
                                                                    <label for="efectivo" class="control-label">ENTIDAD:</label>
                                                                </div>
                                                                <div class="col-sm-3">                    
                                                                    <select class="form-control chosen-select2" name="entidad2"  id="entidad2" >
                                                                        <?php $entidas = consultas::get_datos("select * from enti_emisora"); ?> 
                                                                        <?php foreach ($entidas as $entida) { ?>
                                                                            <option value="<?php echo $entida['cod_entidad']; ?>"><?php echo $entida['entidad_descri']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <label for="efectivo" class="control-label">IMPORTE TARJETA:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="number" class="form-control alert-warning" name="importarj2" id="importarj2" value="0" onkeyup="calcularVuelto(), validar();">
                                                                </div>                                                                                                                                        

                                                                
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-1">
                                                                    <label for="efectivo" class="control-label">POS:</label>
                                                                </div>
                                                                <div class="col-sm-3">                    
                                                                    <select class="form-control chosen-select2" name="vpost2" id="vpost2"   >
                                                                        <?php $posts = consultas::get_datos("select * from tipo_pos"); ?> 
                                                                        <?php foreach ($posts as $post) { ?>
                                                                            <option value="<?php echo $post['cod_tipo_pos']; ?>"><?php echo $post['descri_post']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <label for="efectivo" class="control-label">#VOUCHER:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="number" class="form-control" name="voucher2" id="voucher2"  value="" >
                                                                </div>


                                                                
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-sm-1">
                                                                    <label for="efectivo" class="control-label">TIPO TARJ:</label>
                                                                </div>
                                                                <div class="col-sm-3">                    
                                                                    <select class="form-control chosen-select2" name="vtipotarj2" id="vtipotarj2"   >
                                                                        <?php $tipostars = consultas::get_datos("select * from v_tipo_tarjetas"); ?> 
                                                                        <?php foreach ($tipostars as $tipostar) { ?>
                                                                            <option value="<?php echo $tipostar['id_tarjetas']; ?>"><?php echo $tipostar['tarj_tipo']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <label for="efectivo" class="control-label">#TARJETA:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="number" class="form-control" name="nrotarj2" id="nrotarj2" value="" >
                                                                </div>

                                                                
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
<!--                                                   COBRO TARJETA 3-->
                                                <div class="panel panel-danger" style="display: none" id="ocultartarjeta3">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#acordeon" href="#cobrotarjeta3">PAGO CON TARJETA C <span class="label label-success right-block" id="lbmontotarjeta3" style="background-color: green; color: white; padding-left: 5px; padding-right: 5px; font-size: medium;">0</span></a>
                                                        </h4>
                                                    </div>
                                                    <div id="cobrotarjeta3" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <input type="hidden"  id="codigotarjeta3" name="codigotarjeta3" value="0">
                                                            <div class="form-group">
                                                                 <div class="col-sm-1">
                                                                    <label for="efectivo" class="control-label">ENTIDAD:</label>
                                                                </div>
                                                                <div class="col-sm-3">                    
                                                                    <select class="form-control chosen-select2" name="entidad3"  id="entidad3" >
                                                                        <?php $entidas = consultas::get_datos("select * from enti_emisora"); ?> 
                                                                        <?php foreach ($entidas as $entida) { ?>
                                                                            <option value="<?php echo $entida['cod_entidad']; ?>"><?php echo $entida['entidad_descri']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <label for="efectivo" class="control-label">IMPORTE TARJETA:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="number" class="form-control alert-warning" name="importarj3" id="importarj3" value="0" onkeyup="calcularVuelto(), validar();">
                                                                </div>                                                                                                                                        

                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-1">
                                                                    <label for="efectivo" class="control-label">POS:</label>
                                                                </div>
                                                                <div class="col-sm-3">                    
                                                                    <select class="form-control chosen-select2" name="vpost3" id="vpost3"   >
                                                                        <?php $posts = consultas::get_datos("select * from tipo_pos"); ?> 
                                                                        <?php foreach ($posts as $post) { ?>
                                                                            <option value="<?php echo $post['cod_tipo_pos']; ?>"><?php echo $post['descri_post']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <label for="efectivo" class="control-label">#VOUCHER:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="number" class="form-control" name="voucher3" id="voucher3"  value="" >
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-sm-1">
                                                                    <label for="efectivo" class="control-label">TIPO TARJ:</label>
                                                                </div>
                                                                <div class="col-sm-3">                    
                                                                    <select class="form-control chosen-select2" name="vtipotarj3" id="vtipotarj3"   >
                                                                        <?php $tipostars = consultas::get_datos("select * from v_tipo_tarjetas"); ?> 
                                                                        <?php foreach ($tipostars as $tipostar) { ?>
                                                                            <option value="<?php echo $tipostar['id_tarjetas']; ?>"><?php echo $tipostar['tarj_tipo']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2">
                                                                    <label for="efectivo" class="control-label">#TARJETA:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="number" class="form-control" name="nrotarj3" id="nrotarj3" value="" >
                                                                </div>

                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                
<!--                                                COBRO CHEQUE 1-->
                                                        <div class="panel panel-info"  style="display: none" id="ocultarcheque">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title"  >
                                                            <a data-toggle="collapse" data-parent="#acordeon" href="#cobrocheque">PAGO CON CHEQUE A <span class="label label-success right-block" id="lbmontocheque" style="background-color: green; color: white; padding-left: 5px; padding-right: 5px; font-size: medium;">0</span></a>
                                                        </h4>
                                                    </div>
                                                    <div id="cobrocheque" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <input type="hidden"  id="codigocheque" name="codigocheque" value="0">
                                                            <div class="form-group">
                                                                <div class="col-sm-2">
                                                                    <label for="cheque" class="control-label">IMPORTE CHEQUE:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="number" class="form-control alert-warning" name="importech" id="importech" value="0" onkeyup="calcularVuelto(), validar();">
                                                                </div>
                                                                <div class="col-md-1">           
                                                                    <label for="cheque" control-label>FECHA EMISION:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input type="date"  id="vfechacheque" onchange="validarvigencia()"
                                                                           placeholder="Ingrese fecha"  
                                                                           class="form-control" value="<?php echo $fecha[0]['fecha'] ?>"
                                                                           name="vfechacheque">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-sm-2">
                                                                    <label for="cheque" class="control-label">#CHEQUE:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1"  type="number" class="form-control" name="nrocheq" id="nrocheq" value="">
                                                                </div>

                                                                <div class="col-sm-1">
                                                                    <label for="cheque" class="control-label">TITULAR CUENTA:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="text" class="form-control" name="vtitular"  id="vtitular" value="" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-2">
                                                                    <label for="cheque" class="control-label">TIPO CHEQUE:</label>
                                                                </div>
                                                                <div class="col-sm-3">                    
                                                                    <select class="form-control chosen-select2" name="vtipo"  id="vtipo" >
                                                                        <?php $tipos = consultas::get_datos("select * from tipo_cheque"); ?> 
                                                                        <?php foreach ($tipos as $tipo) { ?>
                                                                            <option value="<?php echo $tipo['cod_tipo_cheque']; ?>"><?php echo $tipo['descri']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-1">
                                                                    <label for="cheque" class="control-label col-md-1">BANCO:</label>
                                                                </div>
                                                                <div class="col-sm-3">                    
                                                                    <select class="form-control chosen-select2" name="banco" id="banco">
                                                                        <?php $bancos = consultas::get_datos("select * from enti_emisora"); ?> 
                                                                        <?php foreach ($bancos as $banco) { ?>
                                                                            <option value="<?php echo $banco['cod_entidad']; ?>"><?php echo $banco['entidad_descri']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!--                                                cobro cheque 2-->
                                                <div class="panel panel-info" style="display: none" id="ocultarcheque2">
                                                    <div class="panel-heading" >
                                                        <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#acordeon" href="#cobrocheque2">PAGO CON CHEQUE B <span class="label label-success right-block" id="lbmontocheque2" style="background-color: green; color: white; padding-left: 5px; padding-right: 5px; font-size: medium;">0</span></a>
                                                        </h4>
                                                    </div>
                                                    <div id="cobrocheque2" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <input type="hidden"  id="codigocheque2" name="codigocheque2" value="0">
                                                            <div class="form-group">
                                                                <div class="col-sm-2">
                                                                    <label for="cheque" class="control-label">IMPORTE CHEQUE:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="number" class="form-control alert-warning" name="importech2" id="importech2" value="0" onkeyup="calcularVuelto(), validar();">
                                                                </div>
                                                                <div class="col-md-1">           
                                                                    <label for="cheque" control-label>FECHA EMISION:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input type="date" id="vfechacheque2" onchange="validarvigencia2()"
                                                                           placeholder="Ingrese fecha "  
                                                                           class="form-control" value="<?php echo $fecha[0]['fecha'] ?>"
                                                                           name="vfechacheque2">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-sm-2">
                                                                    <label for="cheque" class="control-label">#CHEQUE:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="number" class="form-control" name="nrocheq2" id="nrocheq2" value="" >
                                                                </div>

                                                                <div class="col-sm-1">
                                                                    <label for="cheque" class="control-label">TITULAR CUENTA:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="text" class="form-control" name="vtitular2"  id="vtitular2" value="" >
                                                                </div>
                                                            </div>
                                                            
                                                             <div class="form-group">
                                                                <div class="col-sm-2">
                                                                    <label for="cheque" class="control-label">TIPO CHEQUE:</label>
                                                                </div>
                                                                <div class="col-sm-3">                    
                                                                    <select class="form-control chosen-select2" name="vtipo2" id="vtipo2" >
                                                                        <?php $tipos = consultas::get_datos("select * from tipo_cheque"); ?> 
                                                                        <?php foreach ($tipos as $tipo) { ?>
                                                                            <option value="<?php echo $tipo['cod_tipo_cheque']; ?>"><?php echo $tipo['descri']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-1">
                                                                    <label for="cheque" class="control-label col-md-1">BANCO:</label>
                                                                </div>
                                                                <div class="col-sm-3">                    
                                                                    <select class="form-control chosen-select2" name="banco2"  id="banco2" >
                                                                        <?php $bancos = consultas::get_datos("select * from enti_emisora"); ?> 
                                                                        <?php foreach ($bancos as $banco) { ?>
                                                                            <option value="<?php echo $banco['cod_entidad']; ?>"><?php echo $banco['entidad_descri']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!--cobro monto cheque 3-->
                                                <div class="panel panel-info" style="display: none" id="ocultarcheque3">
                                                    <div class="panel-heading" >
                                                        <h4 class="panel-title">
                                                            <a data-toggle="collapse" data-parent="#acordeon" href="#cobrocheque3">PAGO CON CHEQUE C <span class="label label-success right-block" id="lbmontocheque3" style="background-color: green; color: white; padding-left: 5px; padding-right: 5px; font-size: medium;">0</span></a>
                                                        </h4>
                                                    </div>
                                                    <div id="cobrocheque3" class="panel-collapse collapse">
                                                        <div class="panel-body">
                                                            <input type="hidden"  id="codigocheque3" name="codigocheque3" value="0">
                                                            <div class="form-group">
                                                                <div class="col-sm-2">
                                                                    <label for="cheque" class="control-label">IMPORTE CHEQUE:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="number" class="form-control alert-warning" name="importech3" id="importech3" value="0" onkeyup="calcularVuelto(), validar();">
                                                                </div>
                                                                <div class="col-md-1">           
                                                                    <label for="cheque" control-label>FECHA EMISION:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input type="date" id="vfechacheque3" onchange="validarvigencia3()"
                                                                           placeholder="Ingrese fecha "  
                                                                           class="form-control" value="<?php echo $fecha[0]['fecha'] ?>"
                                                                           name="vfechacheque3">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-sm-2">
                                                                    <label for="cheque" class="control-label">#CHEQUE:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="number" class="form-control" name="nrocheq3" id="nrocheq3" value="" >
                                                                </div>

                                                                <div class="col-sm-1">
                                                                    <label for="cheque" class="control-label">TITULAR:</label>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input min="1" type="text" class="form-control" name="vtitular3"  id="vtitular3" value="" >
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-2">
                                                                    <label for="cheque" class="control-label">TIPO CHEQUE:</label>
                                                                </div>
                                                                <div class="col-sm-3">                    
                                                                    <select class="form-control chosen-select2" name="vtipo3"  id="vtipo3" >
                                                                        <?php $tipos = consultas::get_datos("select * from tipo_cheque"); ?> 
                                                                        <?php foreach ($tipos as $tipo) { ?>
                                                                            <option value="<?php echo $tipo['cod_tipo_cheque']; ?>"><?php echo $tipo['descri']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-1">
                                                                    <label for="cheque" class="control-label col-md-1">BANCO:</label>
                                                                </div>
                                                                <div class="col-sm-3">                    
                                                                    <select class="form-control chosen-select2" name="banco3"  id="banco3" >
                                                                        <?php $bancos = consultas::get_datos("select * from enti_emisora"); ?> 
                                                                        <?php foreach ($bancos as $banco) { ?>
                                                                            <option value="<?php echo $banco['cod_entidad']; ?>"><?php echo $banco['entidad_descri']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div id='imagenFlotante'  style="text-align: right;">
                                    <div class="panel panel-danger" style="padding-top: 10px; font-size: x-large;">

                                        <p class="label label-success center-block" id="lbvuelto"><strong>Faltan</strong></p>
                                        <p class="label label-danger center-block" id="vuelto"><strong>0</strong></p>

                                    </div>
                                    </fieldset>
                                    <button  class="btn btn-lg btn btn-primary" role="button" data-title="Grabar"  type="submit" 
                                             id="grabar" data-placement="top" rel="tooltip"><span class=" btn-block">Guardar Cobro</span></button>
                                </div>
                           
                        </form>
                    </div>
                </div>
            </section>
        </div>
        
        <?php require 'menu/js_lte.ctp'; ?>
        
        

        <script>
            $(document).ready(function () {
                $('#cuentas').keypress(function (e) {
                    if (e.which === 13) {
                        $('#saldo').select();
                    }
                });
              
               
                 calcularTotales();
                $('#saldo').keypress(function (e) {
                    if (e.which === 13) {
                        var cta = $('#cuentas').val();
                        var cuentas = cta.split('_');
                        var sal = parseInt($('#saldo').val());
                        var repetido = false;
                        var cov = 0;
                        var coc = 0;
                        var contador = 0;
                        if (parseInt(cuentas[1]) < sal) {
                            notificacion('Atención', 'EL MONTO INGRESADO SUPERA EL SALDO DE LA CUENTA', 'error');
                        } else if (sal < 0) {
                            notificacion('Atención', 'INGRESO NUMERO NEGATIVO', 'error');
                        } else {
                            $("#grilladetalle tbody tr").each(function (index) {
                                $(this).children("td").each(function (index2) {
                                    if (index2 === 0) {
                                        cov = $(this).text();
                                    }
                                    if (index2 === 1) {
                                        coc = $(this).text();
                                    }
                                    if (cov === cuentas[0] && coc === cuentas[3]) {
                                        repetido = true;
                                    }

                                });
                            });

                            if (!repetido) {
                                $('#grilladetalle > tbody:last').append('<tr class="ultimo"><td style="text-align: center;">' + cuentas[0] +
                                        '</td><td style="text-align: center;">' + cuentas[3] +
                                        '</td><td style="text-align: center;">' + cuentas[2] +
                                        '</td><td style="text-align: right;">' + sal.toLocaleString() +
                                        '</td><td style="text-align: right;" onclick="eliminarfila($(this).parent(), ' + cuentas[1] + ')">\n\
                                <button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button></td></tr>');
                                contador++;
                            } else {
                                notificacion("Atención", "ESTA CUENTA YA FUE SELECCIONADA", "error");
                            }
                            calcularTotales();
                           calcularVuelto();
                        }
                    }
                });
                getCuentas();
            });
            
               function validarvigencia() {
            
                var hoy1 = $('#fecha2').val();
                var hoy = new Date($('#fecha1').val());
                var fechaFormulario = new Date($('#vfechacheque').val());
                if (fechaFormulario < hoy) {
                    
                     notificacion('Atencion', 'Fecha inferior a la fecha actual!!!', 'window.alert(message);');
                    $('#vfechacheque').val(hoy1);
                    
                }
                else {

                }
            }
               function validarvigencia2() {
            
                var hoy1 = $('#fecha2').val();
                var hoy = new Date($('#fecha1').val());
                var fechaFormulario = new Date($('#vfechacheque2').val());
                if (fechaFormulario < hoy) {
                    
                     notificacion('Atencion', 'La fecha no puede ser inferior a la actual!!!', 'window.alert(message);');
                    $('#vfechacheque2').val(hoy1);
                    
                }
                else {

                }
            }
               function validarvigencia3() {
            
                var hoy1 = $('#fecha2').val();
                var hoy = new Date($('#fecha1').val());
                var fechaFormulario = new Date($('#vfechacheque3').val());
                if (fechaFormulario < hoy) {
                    
                     notificacion('Atencion', 'La fecha no puede ser inferior a la actual!!!', 'window.alert(message);');
                    $('#vfechacheque3').val(hoy1);
                    
                }
                else {

                }
            }
$("#vtitular").keypress(function (key) {
            window.console.log(key.charCode)
            if ((key.charCode < 97 || key.charCode > 122)//letras mayusculas
                && (key.charCode < 65 || key.charCode > 90) //letras minusculas
                && (key.charCode !== 45) //retroceso
                && (key.charCode !== 241) //ñ
                 && (key.charCode !== 209) //Ñ
                 && (key.charCode !== 32) //espacio
                 && (key.charCode !== 225) //á
                 && (key.charCode !== 233) //é
                 && (key.charCode !== 237) //í
                 && (key.charCode !== 243) //ó
                 && (key.charCode !== 250) //ú
                 && (key.charCode !== 193) //Á
                 && (key.charCode !== 201) //É
                 && (key.charCode !== 205) //Í
                 && (key.charCode !== 211) //Ó
                 && (key.charCode !== 218) //Ú
 
                )
                return false;
        });
$("#vtitular2").keypress(function (key) {
            window.console.log(key.charCode)
            if ((key.charCode < 97 || key.charCode > 122)//letras mayusculas
                && (key.charCode < 65 || key.charCode > 90) //letras minusculas
                && (key.charCode !== 45) //retroceso
                && (key.charCode !== 241) //ñ
                 && (key.charCode !== 209) //Ñ
                 && (key.charCode !== 32) //espacio
                 && (key.charCode !== 225) //á
                 && (key.charCode !== 233) //é
                 && (key.charCode !== 237) //í
                 && (key.charCode !== 243) //ó
                 && (key.charCode !== 250) //ú
                 && (key.charCode !== 193) //Á
                 && (key.charCode !== 201) //É
                 && (key.charCode !== 205) //Í
                 && (key.charCode !== 211) //Ó
                 && (key.charCode !== 218) //Ú
 
                )
                return false;
        });
$("#vtitular3").keypress(function (key) {
            window.console.log(key.charCode)
            if ((key.charCode < 97 || key.charCode > 122)//letras mayusculas
                && (key.charCode < 65 || key.charCode > 90) //letras minusculas
                && (key.charCode !== 45) //retroceso
                && (key.charCode !== 241) //ñ
                 && (key.charCode !== 209) //Ñ
                 && (key.charCode !== 32) //espacio
                 && (key.charCode !== 225) //á
                 && (key.charCode !== 233) //é
                 && (key.charCode !== 237) //í
                 && (key.charCode !== 243) //ó
                 && (key.charCode !== 250) //ú
                 && (key.charCode !== 193) //Á
                 && (key.charCode !== 201) //É
                 && (key.charCode !== 205) //Í
                 && (key.charCode !== 211) //Ó
                 && (key.charCode !== 218) //Ú
 
                )
                return false;
        });
            function getCuentas() {
                var cli = $('#clicod').val();
                var ajax_load = "<div class='progress'>" + "<div id='progress_id' class='progress-bar progress-bar-striped active' " +
                        "role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width: 45%'>" +
                        "Cargando...</div></div>";
                $("#prog").html(ajax_load);

                $.post("/tdp/cuentas.php?vcli_cod=" + cli).done(function (data) {
                    var ajax_load = "<div class='progress'>" + "<div id='progress_id' class='progress-bar progress-bar-striped active' " +
                            "role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width: 100%'>" +
                            "Completado</div></div>";
                    $("#prog").html(ajax_load);
                    setTimeout('$("#prog").html("")', 500);
                    $("#cuentas").html(data).trigger('chosen:updated');
                    cuentaselect();
                    $('#saldo').select();
                });
            }
            function cuentaselect() {
                var id = $("#cuentas").val();
                var dat = id.split("_");
                $("#saldo").val(dat[1]);
            }

            function calcularTotales() {
                var total = 0;
                $("#grilladetalle tbody tr").each(function (fila) {
                    $(this).children("td").each(function (col) {
                        if (col === 3) {
                            total += parseInt($(this).text().replace(/\./g, ''));
                        }
                    });
                });

             
                if (total <= 0) {
                    $("#clicod").removeAttr("disabled").trigger("chosen:updated");
                } else {
                    $("#clicod").attr("disabled", "true").trigger("chosen:updated");
                }

                var totales = "<tr>";

                totales += "<tr>";
                totales += "<th class='warning' colspan='3'><h4>TOTAL GENERAL</h4></th>";
                totales += "<th class='warning' style='text-align: right;'><h4>" + total.toLocaleString() + "</h4></th>";
                totales += "<th class='warning'><h4></h4></th>";
                totales += "</tr>";
                $("#totalcobrar").val(total);
                $("#grilladetalle tfoot").html(totales);
                $("#vuelto").html(total.toLocaleString());
            }

            function calcularVuelto() {
                var acobrar = parseInt($("#totalcobrar").val());
                var efe = parseInt($("#efectivo").val());
                var totalch = parseInt($("#importech").val());
                var totalch2 = parseInt($("#importech2").val());
                var totalch3 = parseInt($("#importech3").val());
                var totaltar = parseInt($("#importarj").val());
                var totaltar2 = parseInt($("#importarj2").val());
                var totaltar3 = parseInt($("#importarj3").val());
                var totalcobrado = efe + totalch + totalch2 + totalch3 + totaltar + totaltar2 + totaltar3;

                $("#lbmontoefe").html(efe.toLocaleString());
                $("#lbmontocheque").html(totalch.toLocaleString());
                $("#lbmontocheque2").html(totalch2.toLocaleString());
                $("#lbmontocheque3").html(totalch3.toLocaleString());
                $("#lbmontotarjeta").html(totaltar.toLocaleString());
                $("#lbmontotarjeta2").html(totaltar2.toLocaleString());
                $("#lbmontotarjeta3").html(totaltar3.toLocaleString());
                $("#lbtotalcobrado").html(totalcobrado.toLocaleString());

                var vuelto = acobrar - totalcobrado;

              
                if (vuelto <= 0) {
                    $("#vuelto").attr("class", "label label-success center-block");
                    $("#vuelto").html((vuelto * 1).toLocaleString());
                    $("#lbvuelto").html("Vuelto");
                } else {
                    $("#vuelto").attr("class", "label label-danger center-block");
                    $("#vuelto").html((vuelto).toLocaleString());
                    $("#lbvuelto").html("Faltan");
                }

            }
            function eliminarfila(parent, importe) {
                $(parent).remove();
//                calcularTotalCheque();
//                calcularTotalTarjeta();
                calcularVuelto();
                //cerar los montos
                var nuevoValor = parseInt($("#totalcobrar").val()) - parseInt(importe);
                console.log(nuevoValor);
                $("#lbmontocheque").html(0);
                $("#lbmontocheque2").html(0);
                $("#lbmontocheque3").html(0);
                $("#lbmontoefe").html(0);
                $("#lbmontotarjeta").html(0);
                $("#lbmontotarjeta2").html(0);
                $("#lbmontotarjeta3").html(0);
                $("#lbtotalcobrado").html(0);
                $("#vuelto").html(nuevoValor.toLocaleString());
                calcularTotales();
                
            }

  
           $('#grabar').click(function () {
                var faltante = $.trim($('#lbvuelto').text());
//                var titular = $("#vtitular").val();

                if (faltante === 'Faltan') {
                    notificacion('Atención', 'DEBE COMPLETAR EL MONTO A PAGAR', 'error');
                    
                } else if ((parseInt($('#importarj').val()) > 0) && (($('#nrotarj').val() === "") || ($('#voucher').val() === ""))) {
//          
                    notificacion('Atención', 'DEBE COMPLETAR LOS CAMPOS DE LA TARJETA', 'error');
                    
                    
                } else if ((parseInt($('#importarj').val()) > 0) && (($('#nrotarj').val().length < 6) || ($('#voucher').val().length < 8))) {
//          
                    notificacion('Atención', 'DEBE COMPLETAR LOS PRIMEROS 6 DIGITOS DE LA TARJETA Y 8 DE VOUCHER', 'error');
                    
                    
                } else if ((parseInt($('#importarj').val()) > 0) && (($('#nrotarj').val().length > 6) || ($('#voucher').val().length > 8))) {
//          
                    notificacion('Atención', ' SOLO DEBE COMPLETAR LOS PRIMEROS 6 DIGITOS DE LA TARJETA Y 8 DE VOUCHER', 'error');
                    
                    
                } else if ((parseInt($('#importarj2').val()) > 0) && (($('#voucher2').val() === "") || ($('#nrotarj2').val() === ""))) {
//          
                    notificacion('Atención', 'DEBE COMPLETAR LOS CAMPOS DE LA TARJETA 2', 'error');
          
        } else if ((parseInt($('#importarj2').val()) > 0) && (($('#nrotarj2').val().length < 6) || ($('#voucher2').val().length < 8))) {
//          
                    notificacion('Atención', 'SOLO DEBE COMPLETAR LOS PRIMEROS  6 DIGITOS DE LA TARJETA 2 Y 8 DE VOUCHER 2', 'error');
          
        } else if ((parseInt($('#importarj2').val()) > 0) && (($('#nrotarj2').val().length > 6) || ($('#voucher2').val().length > 8))) {
//          
                    notificacion('Atención', 'DEBE COMPLETAR LOS PRIMEROS  6 DIGITOS DE LA TARJETA 2 Y 8 DE VOUCHER 2', 'error');
          
                } else if ((parseInt($('#importarj3').val()) > 0) && (($('#voucher3').val() === "") || ($('#nrotarj3').val() === ""))) {
//          
                    notificacion('Atención', 'DEBE COMPLETAR LOS CAMPOS DE LA TARJETA 3', 'error');
          
                 } else if ((parseInt($('#importarj3').val()) > 0) && (($('#nrotarj3').val().length < 6) || ($('#voucher3').val().length < 8))) {
//          
                    notificacion('Atención', 'SOLO DEBE COMPLETAR LOS PRIMEROS 6 DIGITOS DE LA TARJETA 3 Y 8 DE VOUCHER 3', 'error');
                
                 } else if ((parseInt($('#importarj3').val()) > 0) && (($('#nrotarj3').val().length > 6) || ($('#voucher3').val().length > 8))) {
//          
                    notificacion('Atención', 'DEBE COMPLETAR LOS PRIMEROS 6 DIGITOS DE LA TARJETA 3 Y 8 DE VOUCHER 3', 'error');
                
                } else if((parseInt($('#importech').val()) > 0) && ($('#nrocheq').val() === ""))  {
//          
                    notificacion('Atención', 'DEBE COMPLETAR LOS CAMPOS DEL CHEQUE 1', 'error');
          
                
                } else if((parseInt($('#importech').val()) > 0) && ($('#nrocheq').val().length < 6))  {
//          
                    notificacion('Atención', ' EL MINIMO DE NUMERO DE CHEQUE 1 ES 6 ', 'error');
          
                
                } else if((parseInt($('#importech').val()) > 0) && ($('#nrocheq').val().length > 8))  {
//          
                    notificacion('Atención', ' EL MAXIMO DE NUMERO DE CHEQUE 1 ES 8 ', 'error');
          
                
                }  else if ((parseInt($('#importech2').val()) > 0) && ($('#nrocheq2').val() === "")){
//          
                    notificacion('Atención', 'DEBE COMPLETAR LOS CAMPOS DEL CHEQUE 2 ', 'error');
                    
              } else if((parseInt($('#importech2').val()) > 0) && ($('#nrocheq2').val().length < 6))  {
//          
                    notificacion('Atención', 'EL MINIMO DE NUMERO DE CHEQUE 2 ES 6', 'error');
          
                
              } else if((parseInt($('#importech2').val()) > 0) && ($('#nrocheq2').val().length > 8))  {
//          
                    notificacion('Atención', ' EL MAXIMO DE NUMERO DE CHEQUE 2 ES 8', 'error');
          
                
                } else if ((parseInt($('#importech3').val()) > 0) && ($('#nrocheq3').val() === ""))  {
//          
                    notificacion('Atención', 'DEBE COMPLETAR LOS CAMPOS DEL CHEQUE 3 ', 'error');
                    
              } else if((parseInt($('#importech3').val()) > 0) && ($('#nrocheq3').val().length < 6))  {
//          
                    notificacion('Atención', 'EL MINIMO DE NUMERO DE CHEQUE 3 ES 6', 'error');
          
              } else if((parseInt($('#importech3').val()) > 0) && ($('#nrocheq3').val().length > 8))  {
//          
                    notificacion('Atención', 'EL MAXIMO DE NUMERO DE CHEQUE 3 ES 8', 'error');
          
                
                }else {
                    grabar();
                }
            });


            function grabar() {
                var parametros = [];
                $('#grilladetalle  tbody tr').each(function (i, e) {
                    var tr = [];
                    $(this).find("td").each(function (index, element) {
                        var valor = $(element).text();
                        console.log(valor);
                        var td = {};
                        if (index !== 4) {
                            td[index] = valor,
                                    tr.push(td);
                        }
                    });
                    parametros.push(tr);
                });
                $.ajax({
                    url: "/tdp/cobros_control.php",
                    data: {"detalle": parametros, "codigo": $("#codigo").val(), "vemp": $("#vemp").val(), "vcli_cod": $("#clicod").val(),
                        "vape": $("#vape").val(), "accion": $("#accion").val(), "pagina": $("#pagina").val(), "vformacobro": $("#efec").val(), "vformacobro": $("#che").val(),
                        "vformacobro": $("#tar").val(),"vformacobro": $("#efecheque").val(),"vformacobro": $("#efectarj").val(),"vformacobro": $("#cheqtarj").val(),"vformacobro": $("#efeccheqtarj").val(),
                        "fecha": $("#fecha").val(), "importe": $("#efectivo").val(), "estado": $("#estado").val(), "vrecibo": $("#vrecibo").val(), "vrecinume": $("#vrecinume").val(),
                        
                        
                        "codigocheque": $("#codigocheque").val(),
                        "vtipo": $("#vtipo").val(), "banco": $("#banco").val(), "nrocheq": $("#nrocheq").val(), "vfechacheque": $("#vfechacheque").val(),
                        "importech": $("#importech").val(), "vtitular": $("#vtitular").val(),

                        "codigocheque2": $("#codigocheque2").val(),
                        "vtipo2": $("#vtipo2").val(), "banco2": $("#banco2").val(), "nrocheq2": $("#nrocheq2").val(), "vfechacheque2": $("#vfechacheque2").val(),
                        "importech2": $("#importech2").val(), "vtitular2": $("#vtitular2").val(),

                        "codigocheque3": $("#codigocheque3").val(),
                        "vtipo3": $("#vtipo3").val(), "banco3": $("#banco3").val(), "nrocheq3": $("#nrocheq3").val(), "vfechacheque3": $("#vfechacheque3").val(),
                        "importech3": $("#importech3").val(), "vtitular3": $("#vtitular3").val(),
                        
                        "codigotarjeta": $("#codigotarjeta").val(),
                        "nrotarj": $("#nrotarj").val(), "importarj": $("#importarj").val(), "voucher": $("#voucher").val(), "entidad": $("#entidad").val(),
                        "vtipotarj": $("#vtipotarj").val(), "vpost": $("#vpost").val(),

                        "codigotarjeta2": $("#codigotarjeta2").val(),
                        "nrotarj2": $("#nrotarj2").val(), "importarj2": $("#importarj2").val(), "voucher2": $("#voucher2").val(), "entidad2": $("#entidad2").val(),
                        "vtipotarj2": $("#vtipotarj2").val(), "vpost2": $("#vpost2").val(),

                        "codigotarjeta3": $("#codigotarjeta3").val(),
                        "nrotarj3": $("#nrotarj3").val(), "importarj3": $("#importarj3").val(), "voucher3": $("#voucher3").val(), "entidad3": $("#entidad3").val(),
                        "vtipotarj3": $("#vtipotarj3").val(), "vpost3": $("#vpost3").val(),
                    },
                    type: "POST",
                    dataType: 'JSON',
                    beforeSend: function (xhr) {
                        $("#grabar").attr("disabled", "disabled");
                    },
                    success: function (data, textStatus, jqXHR) {
                        if (data.success) {
                            setTimeout(function () {
                                window.location.href = "cobros.php";
                            }, 3000);
                            notificacion("Atencion", data.mensaje, "success");
                        } else {
                            notificacion("Atencion", data.mensaje, "error");
                        }
                    },
                });
            }
            function ubicarCheque() {
                var impor = parseInt($('#importech').val());
                if (impor < 0) {
                    notificacion('Atención', 'EL MONTO DEBE SER POSITIVO', 'error');
                } else {
                    calcularTotalCheque();
                    //calcularVuelto();
                }
            }
            function ubicarTarj() {
                var impor = parseInt($('#importarj').val());
                if (impor < 0) {
                    notificacion('Atención', 'EL MONTO DEBE SER POSITIVO', 'error');
                } else {
                    calcularTotalTarjeta();
                    //calcularVuelto();
                }
            }
            function calcularTotalCheque() {
                var acobrar = parseInt($("#totalcobrar").val());
                var efe = parseInt($("#efectivo").val());
                var totalch = parseInt($("#importech").val());
                var totalch2 = parseInt($("#importech2").val());
                var totalch3 = parseInt($("#importech3").val());
                var totaltar = parseInt($("#importarj").val());
                var totaltar2 = parseInt($("#importarj2").val());
                var totaltar3 = parseInt($("#importarj3").val());
                var totalcobrado = efe + totalch + totalch2 + totalch3 + totaltar + totaltar2 + totaltar3;
                $("#lbmontocheque").html(totalch.toLocaleString());
                $("#lbmontocheque2").html(totalch2.toLocaleString());
                $("#lbmontocheque3").html(totalch3.toLocaleString());
                $("#lbtotalcobrado").html(totalcobrado.toLocaleString());
                var vuelto = acobrar - efe - totalcobrado;
                if (vuelto <= 0) {
                    $("#vuelto").attr("class", "label label-success center-block");
                    $("#vuelto").html((vuelto * 1).toLocaleString());
                    $("#lbvuelto").html("Vuelto");
                } else {
                    $("#vuelto").attr("class", "label label-danger center-block");
                    $("#vuelto").html((vuelto).toLocaleString());
                    $("#lbvuelto").html("Faltan");
                }

            }
            function calcularTotalTarjeta() {
                var acobrar = parseInt($("#totalcobrar").val());
                var efe = parseInt($("#efectivo").val());
                var totalch = parseInt($("#importech").val());
                var totalch2 = parseInt($("#importech2").val());
                var totalch3 = parseInt($("#importech3").val());
                var totaltar = parseInt($("#importarj").val());
                var totaltar2 = parseInt($("#importarj2").val());
                var totaltar3 = parseInt($("#importarj3").val());
                var totalcobrado = efe + totalch + totalch2 + totalch3 + totaltar + totaltar2 + totaltar3;
                $("#lbmontotarjeta").html(totaltar.toLocaleString());
                $("#lbmontotarjeta2").html(totaltar2.toLocaleString());
                $("#lbmontotarjeta3").html(totaltar3.toLocaleString());
                $("#lbtotalcobrado").html(totalcobrado.toLocaleString());
                var vuelto = acobrar - efe - totalcobrado;
                if (vuelto <= 0) {
                    $("#vuelto").attr("class", "label label-success center-block");
                    $("#vuelto").html((vuelto * 1).toLocaleString());
                    $("#lbvuelto").html("Vuelto");
                } else {
                    $("#vuelto").attr("class", "label label-danger center-block");
                    $("#vuelto").html((vuelto).toLocaleString());
                    $("#lbvuelto").html("Faltan");
                }
            }

            function validar() {

                var monto = ($("#efectivo").val());
                if (monto === "") {
                    $("#efectivo").val("0");
                    calcularVuelto();
                    
                }

                var monto = ($("#importech").val());
                if (monto === "") {
                    $("#importech").val("0");
                    calcularVuelto();
                }

                var monto = ($("#importarj").val());
                if (monto === "") {
                    $("#importarj").val("0");
                    calcularVuelto();
                }
                var monto = ($("#importech2").val());
                if (monto === "") {
                    $("#importech2").val("0");
                    calcularVuelto();
                }
                var monto = ($("#importarj2").val());
                if (monto === "") {
                    $("#importarj2").val("0");
                    calcularVuelto();
                }
                var monto = ($("#importech3").val());
                if (monto === "") {
                    $("#importech3").val("0");
                    calcularVuelto();
                }
                var monto = ($("#importarj3").val());
                if (monto === "") {
                    $("#importarj3").val("0");
                    calcularVuelto();
                }
            }
            
            function tiposelect1(){
               if (document.getElementById('vformacobro').
                        value === "1") {
                     $("#ocultarefectivo").css("display", "block");

                $("#ocultarcheque").css("display", "none");
                $("#ocultarcheque2").css("display", "none");
                $("#ocultarcheque3").css("display", "none");
                $("#ocultartarjeta").css("display", "none");
                $("#ocultartarjeta2").css("display", "none");
                $("#ocultartarjeta3").css("display", "none");
                $("#importech").val('0');
                $("#importech2").val('0');
                $("#importech3").val('0');
                $("#importarj").val('0');
                $("#importarj2").val('0');
                $("#importarj3").val('0');
               calcularVuelto();
               
                }
            }
            window.onload = tiposelect1();
            
           
                function tiposelect2(){
               if (document.getElementById('vformacobro').
                        value === "2") {
                      $("#ocultarefectivo").css("display", "none");
                $("#ocultarcheque").css("display", "none");
                $("#ocultarcheque2").css("display", "none");
                $("#ocultarcheque3").css("display", "none");
                $("#ocultartarjeta").css("display", "block");
                $("#ocultartarjeta2").css("display", "block");
                $("#ocultartarjeta3").css("display", "block");
                $("#efectivo").val('0');
                $("#importech").val('0');
                $("#importech2").val('0');
                $("#importech3").val('0');
                calcularVuelto();
             
                }
            }
            window.onload = tiposelect2();
            
            function tiposelect3(){
               if (document.getElementById('vformacobro').
                        value === "3") {
                     $("#ocultarefectivo").css("display", "none");
                $("#ocultarcheque").css("display", "block");
                $("#ocultarcheque2").css("display", "block");
                $("#ocultarcheque3").css("display", "block");
                $("#ocultartarjeta").css("display", "none");
                $("#ocultartarjeta2").css("display", "none");
                $("#ocultartarjeta3").css("display", "none");
                $("#efectivo").val('0');
                $("#importarj").val('0');
                $("#importarj2").val('0');
                $("#importarj3").val('0');
                calcularVuelto();
                }
            }
            window.onload = tiposelect3();
            
            function tiposelect4(){
               if (document.getElementById('vformacobro').
                        value === "4") {
                    $("#ocultarefectivo").css("display", "block");
                $("#ocultarcheque").css("display", "none");
                $("#ocultarcheque2").css("display", "none");
                $("#ocultarcheque3").css("display", "none");
                $("#ocultartarjeta").css("display", "block");
                $("#ocultartarjeta2").css("display", "block");
                $("#ocultartarjeta3").css("display", "block");
               
                $("#importech").val('0');
                $("#importech2").val('0');
                $("#importech3").val('0');
                calcularVuelto();
                }
            }
            window.onload = tiposelect4();
            
            function tiposelect5(){
               if (document.getElementById('vformacobro').
                        value === "5") {
                  $("#ocultarefectivo").css("display", "block");
                $("#ocultarcheque").css("display", "block");
                $("#ocultarcheque2").css("display", "block");
                $("#ocultarcheque3").css("display", "block");
                $("#ocultartarjeta").css("display", "none");
                $("#ocultartarjeta2").css("display", "none");
                $("#ocultartarjeta3").css("display", "none");
                $("#importarj").val('0');
                $("#importarj2").val('0');
                $("#importarj3").val('0');
                calcularVuelto();
                }
            }
            window.onload = tiposelect5();
            
            function tiposelect6(){
               if (document.getElementById('vformacobro').
                        value === "6") {
                 $("#ocultarefectivo").css("display", "none");
                $("#ocultarcheque").css("display", "block");
                $("#ocultarcheque2").css("display", "block");
                $("#ocultarcheque3").css("display", "block");
                $("#ocultartarjeta").css("display", "block");
                $("#ocultartarjeta2").css("display", "block");
                $("#ocultartarjeta3").css("display", "block");
               $("#efectivo").val('0');
                calcularVuelto();
                }
            }
            window.onload = tiposelect6();
            
             function tiposelect7(){
               if (document.getElementById('vformacobro').
                        value === "7") {
                 $("#ocultarefectivo").css("display", "block");
                $("#ocultarcheque").css("display", "block");
                $("#ocultarcheque2").css("display", "block");
                $("#ocultarcheque3").css("display", "block");
                $("#ocultartarjeta").css("display", "block");
                $("#ocultartarjeta2").css("display", "block");
                $("#ocultartarjeta3").css("display", "block");
                calcularVuelto();
                }
            }
            window.onload = tiposelect6();
        </script>
    </body>
</html>
