<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="img/mueble.png"/>
    <title>Todo Muebles</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php require 'menu/css_lte.ctp'; ?><!-- ARCHIVOS CSS -->
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <?php require 'menu/header_lte.ctp'; ?>
        <?php require 'menu/toolbar_lte.ctp'; ?>

        <div class="content-wrapper">
            <div class="text-left">
                <h3><b>System Todo Muebles</b></h3>

                <!-- Mostrar el Mensaje de Bienvenida si existe -->
                <?php if (!empty($_SESSION['mensaje_bienvenida'])) { ?>
                    <div class="alert alert-primary" role="alert" id="mensaje_bienvenida">
                        <?php echo $_SESSION['mensaje_bienvenida']; ?>
                    </div>
                    <?php unset($_SESSION['mensaje_bienvenida']); // Elimina el mensaje después de mostrarlo ?>
                <?php } ?>

                <img src="img/m4.jpg" width="1290" height="570">
            </div>

            <?php require 'menu/footer_lte.ctp'; ?>
        </div>

        <?php require 'menu/js_lte.ctp'; ?>

        <!-- Script para ocultar el mensaje después de unos segundos -->
        <script>
            setTimeout(function() {
                var mensaje = document.getElementById('mensaje_bienvenida');
                if (mensaje) {
                    mensaje.style.display = 'none';
                }
            }, 4000); // El mensaje desaparece después de 4 segundos
        </script>
    </div>
</body>
</html>
