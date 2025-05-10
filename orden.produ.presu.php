<?php
session_start();

require './clases/conexion.php';

$clientes= consultas::get_datos("select * from v_presu_prod where cod_preprod = " . $_REQUEST['vcod_preprod']."order by cod_preprod ");
?>

<select class="form-control"  required="" >
   
    <?php
    if (!empty($clientes)) {
        foreach ($clientes as $cliente) {
            ?>
            <option value="<?php echo $cliente['cli_cod'];?>">
                <?php echo $cliente['clientes'];?></option>
               

            <?php
        }
    } else {
        ?>
          
<?php }; ?>
</select>
