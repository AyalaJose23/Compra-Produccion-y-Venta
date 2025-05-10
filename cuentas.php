<?php

session_start(); /* Reanudar sesión */

require 'clases/conexion.php';
//
$ctas = consultas::get_datos("select * from v_ctas_cobrar_2 where cli_cod = " . $_REQUEST['vcli_cod']);
if($ctas){
foreach ($ctas as $cuota) {?>
    <option value="<?php echo $cuota['cta_id'] . '_' . $cuota['cta_importe'] . '_' . $cuota['cta_vto'] . '_'. $cuota['descripcion'] .'_'.$cuota['cta_cuo_nro'] ; ?>"><?= $cuota['descripcion']." | "." Monto: ".  $cuota['cta_importe'] ?></option>
<?php } 
}else{?>
 <option value="0">No existen cuentas</option>
<?php }?>

