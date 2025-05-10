<!DOCTYPE html>
<?php
session_start();
if ($_SESSION) {
    session_destroy();
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Acceso</title>
         <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
        <style>
            body{
                padding-top: 40px;
                padding-bottom: 40px;
            }
            body, html {
                 background: url(img/m1.jpg) no-repeat center center fixed; 
              -webkit-background-size: cover;
              -moz-background-size: cover;
              -o-background-size: cover;
              background-size: cover;
            }    
            .login{
                max-width: 330px;
                padding: 15px;
                margin: 0 auto;
            }
            #sha{
                max-width: 340px;
                -webkit-box-shadow: 0px 0px 18px 0px rgba(48,50,50,0.48);
                -moz-box-shadow: 0px 0px 18px 0px rgba(48,50,50,0.48);
                box-shadow: 0px 0px 18px 0px rgba(48,50,50,0.48);
                border-radius: 10%;
            }
            #avatar{
                width: 96px;
                height: 96px;
                margin: 0px auto 10px;
                display: block;
                border-radius: 50%;
            }
        </style>
    </head>
    <body>
        <div class="container well" id="sha">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <img src="img/m6.png" class="img-responsive" id="avatar"/>
                </div>
            </div>
            <form class="login" action="acceso.php" method="post" accept-charset="utf-8">
                <div class="form-group has-feedback">
                    <input type="text" name="usuario" class="form-control" required="" autofocus=""
                           placeholder="Ingrese su usuario"/>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="clave" class="form-control" required="" autofocus=""
                           placeholder="Ingrese su clave"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <button class="btn btn-primary btn-block" type="submit">Iniciar Sesión</button>
                
                
                <?php if (!empty($_SESSION['error'])) { ?>
                    <div class="alert alert-danger" role='alert'>
                        <span class="glyphicon glyphicon-exclamation-sign"></span>
                        <?php echo $_SESSION['error'];?>
                    </div>                    
                <?php } ?>
            </form>
        </div>
    <script src="js/jquery-1.12.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    </body>   
</html>
