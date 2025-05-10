<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="img/mueble.png" />
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
                                    <h3 class="box-title">Agregar Compras</h3>
                                    <div class="box-tools">
                                        <a href="notacredito_c.index.php" class="btn btn-primary btn-sm" data-title="Volver" rel="tooltip">
                                            <i class="fa fa-arrow-left"></i> VOLVER
                                        </a>
                                    </div>
                                </div>
                                <form action="nota_credito_control.php" method="post" accept-charset="utf-8" class="form-horizontal">
                                    <input type="hidden" name="accion" value="1"/>
                                    <input type="hidden" name="vcom_cod" value="0"/>
                                    <div class="box-body">
                                        <div class="form-group has-feedback">
                                            <?php $fecha = consultas::get_datos("select current_date as fecha");?>
                                            <div class="col-md-3">
                                            <label class="control-label"> Fecha:</label>
                                                <input type="date" class="form-control" value="<?php echo $fecha[0]['fecha'];?>" id="fechaInspeccion" onblur="fechaac()"/>
                                                <i class="fa fa-calendar form-control-feedback"></i>
                                            </div>
                                            <div class="form-group has-feedback">
                                            <div class="col-md-3">
                                            <label class="control-label">Vigencia:</label>
                                                    <input type="date" name="vvigen" class="form-control" min="<?php echo date("Y-m-d");?>" value="<?php echo date("Y-m-d");?>"/>
                                                    <i class="fa fa-calendar form-control-feedback"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                        <div class="col-md-4" >
                                        <label class="control-label">Compra:</label>
                                            <select  required="" class="form-control"   name="vcod_compra" id="compra" 
                                                     onchange="proveedor(), costo()"
                                                     onkeyup="proveedor(), costo()"> 
                                                <!--                                                <option  value="0">Seleccione una compra</option>-->

                                                <?php
                                                $compras = consultas::get_datos("SELECT * FROM v_compras WHERE com_cod NOT IN (SELECT com_cod FROM nota_credi_comp WHERE nota_cred_estado != 'ANULADO') "
                                                //. "AND com_cod NOT IN (SELECT com_cod FROM nota_debi_compra WHERE debi_estado != 'ANULADO') "
                                                . "AND com_estado = 'CONFIRMADO' "
                                                . "ORDER BY com_cod"
                                                );
                                                ?> 
                                                <?php
                                                if (!empty($compras)) {
                                                    foreach ($compras as $compra) {
                                                        ?>
                                                        <option  value="<?php echo $compra['com_cod']; ?>">
                                                            <?php echo $compra['com_cod'] . " - " . $compra['nro_com'] . " - " . $compra['com_total']; ?></option>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <option value="0">No hay facturas compras confirmadas</option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Tipo:</label>
                                            <select required class="form-control" name="vcodtipocomprobante" readonly>
                                                <?php
                                                $tipocomprobantess = consultas::get_datos("SELECT * FROM tipo_comrprobante WHERE cod_tipo_comprobante = 3 ORDER BY descrip_tip_com");
                                                if (!empty($tipocomprobantess)) {
                                                    foreach ($tipocomprobantess as $tipocomprobantes) {
                                                        echo "<option value='{$tipocomprobantes['cod_tipo_comprobante']}'>{$tipocomprobantes['descrip_tip_com']}</option>";
                                                    }
                                                } else {
                                                    echo "<option value=''>Debe insertar un tipo de comprobante</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label">Proveedor:</label>
                                            <select required class="form-control" name="vprv_cod" id="detalles">
                                                <option value="0">Seleccione un proveedor</option>
                                                <?php
                                                $proveedors = consultas::get_datos("SELECT * FROM proveedor");
                                                foreach ($proveedors as $proveedor) {
                                                    echo "<option value='{$proveedor['prv_cod']}'>{$proveedor['prv_razonsocial']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label class="control-label">Timbrado: </label>
                                            <input type="text" required class="form-control" name="vtimbnro" id="timbrad" value="Ej. 001-002-1234567" maxlength="15" minlength="15" title="SOLO SE PERMITEN 13 DÍGITOS SIN INCLUIR LOS GUIONES (-)">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label">Crédito:</label>
                                            <input type="text" required class="form-control" name="vnronotacred" id="credi" value="000-000-0000000" pattern="[0-9--]{15,15}" title="SOLO SE PERMITEN 15 DÍGITOS">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">Motivo:</label>
                                        <input type="radio" name="vmotiv" value="DEVOLUCION" checked> DEVOLUCION
                                        <input type="radio" name="vmotiv" value="DESCUENTO"> DESCUENTO
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label class="control-label">Motivo Descripción:</label>
                                            <input type="text" required class="form-control" name="vdescrip">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="box-footer">
                                        <a href="compras.index.php" class="btn btn-default">
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
            <?php require 'menu/footer_lte.ctp'; ?><!--ARCHIVOS JS-->
        </div>
        <?php require 'menu/js_lte.ctp'; ?><!--ARCHIVOS JS-->
        <script>
            
            
            var myDate = $('#fechaInspeccion');
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();
            if(dd < 10) dd = '0' + dd;
            if(mm < 10) mm = '0' + mm;
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
