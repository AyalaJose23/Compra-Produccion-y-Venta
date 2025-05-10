<?php
session_start();

require './clases/conexion.php';

$clientes= consultas::get_datos("select * from v_pedido_cabventa where ped_cod = " . $_REQUEST['vped_cod']."order by ped_cod ");
?>

<select class="form-control"  required="" >
   
    <?php
    if (!empty($clientes)) {
        foreach ($clientes as $cliente) {
            ?>
            <option value="<?php echo $cliente['cli_cod'];?>">
                <?php echo $cliente['cliente'];?></option>
               

            <?php
        }
    } else {
        ?>
          
<?php }; ?>
</select>
