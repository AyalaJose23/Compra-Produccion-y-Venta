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
                                <strong>AÑADIR NOTA CRÉDITO/DÉBITO</strong>
                                
                                <a href="notacredito_c.index.php" class="btn btn-primary pull-right" rel="tooltip" title="Atrás">
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
                                    <strong>Agregar Nota Crédio/Débito</strong>
                                </div>
                            <form action="nota_credito_control.php" method="post" class="form-horizontal">
                                <input type="hidden" name="accion" value="1"/>
                                <input type="hidden" name="vcodigo" value="0"/>
                                <div class="box-body">
                                    <div class="form-group">
                                        <?php $fecha = consultas::get_datos("select * from v_fecha"); ?>
                                        <div class="col-md-3">
                                            <label class="control-label">FECHA</label>
                                            <input type="date" required class="form-control" name="vfecha" value="<?php echo $fecha[0]['fecha']; ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label">VIGENCIA</label>
                                            <input type="date" required class="form-control" name="vvigen" value="<?php echo $fecha[0]['fecha']; ?>">
                                        </div>
                                    </div>
                                    
                                        <div class="form-group">
                                        <div class="col-md-4" >
                                        <label class="control-label">COMPRA</label>
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
                                            <label class="control-label">TIPO</label>
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
                                            <label class="control-label">PROVEEDOR</label>
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
                                            <label class="control-label">TIMBRADO</label>
                                            <input type="text" required class="form-control" name="vtimbnro" id="timbrad" value="Ej. 001-002-1234567" maxlength="15" minlength="15" title="SOLO SE PERMITEN 13 DÍGITOS SIN INCLUIR LOS GUIONES (-)">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label">CRÉDITO</label>
                                            <input type="text" required class="form-control" name="vnronotacred" id="credi" value="000-000-0000000" pattern="[0-9--]{15,15}" title="SOLO SE PERMITEN 15 DÍGITOS">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                    <div class="col-md-3">
                                        <label class="control-label">MOTIVO</label>
                                        <input type="radio" name="vmotiv" value="DEVOLUCION" checked> DEVOLUCION
                                        <input type="radio" name="vmotiv" value="DESCUENTO"> DESCUENTO
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4">
                                            <label class="control-label">MOTIVO DESCRIPCIÓN</label>
                                            <input type="text" required class="form-control" name="vdescrip">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" data-dismiss="modal" class="btn btn-default pull-left">
                                            <i class="fa fa-close"></i> Cerrar
                                        </button>
                                        <button type="submit" class="btn btn-primary pull-right">
                                            <i class="fa fa-floppy-o"></i> Registrar
                                        </button>
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
        <?php require 'menu/js.ctp'; ?>
        <!--ARCHIVOS JS-->
    </div>
</body>
</html>
