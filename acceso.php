<?php
require 'clases/conexion.php';

$sql = "select * from v_usuarios where usu_nick = '".$_REQUEST['usuario']."' and usu_clave = md5('".$_REQUEST['clave']."')";
$resultado = consultas::get_datos($sql);

session_start();

if ($resultado[0]['usu_cod'] == null) {
    $_SESSION['error'] = "Usuario o contraseña incorrecto";
    header("location:index.php");
} else {
    // Guardar datos del usuario en sesión
    $_SESSION['usu_cod'] = $resultado[0]['usu_cod'];
    $_SESSION['usu_nick'] = $resultado[0]['usu_nick'];
    $_SESSION['usu_foto'] = '';
    $_SESSION['emp_cod'] = $resultado[0]['emp_cod'];
    $_SESSION['nombres'] = $resultado[0]['empleado'];
    $_SESSION['cargo'] = $resultado[0]['car_descri'];
    $_SESSION['gru_cod'] = $resultado[0]['gru_cod'];
    $_SESSION['grupo'] = $resultado[0]['gru_nombre'];

    // Establecer mensaje de bienvenida
    $_SESSION['mensaje_bienvenida'] = "¡Bienvenido, " . $resultado[0]['empleado'] . "!";

    // Redirigir al menú principal
    header("location:menu.php");
}
?>
