<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="js/bootstrap.bundle.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="vendor/metisMenu/metisMenu.min.js"></script>

<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>

<!-- FastClick -->
<script src="plugins/fastclick/fastclick.min.js"></script>

<!-- AdminLTE App -->
<script src="js/adminlte/js/app.min.js"></script>

<!-- SlimScroll 1.3.0 -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>

<script src="plugins/iCheck/icheck.min.js"></script>

<!-- DataTables JavaScript -->
<!--script src="js/jquery.dataTables.js"></script-->
<!--script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script-->
<!--script src="vendor/datatables-responsive/dataTables.responsive.js"></script-->
<script src="js/bootstrap-notify.js"></script>
<script src="js/select2.js"></script> 
<script src="js/bootstrap-formhelpers-number.js"></script> 
<script src="js/bootstrap-formhelpers.min.js"></script> 
<script src="js/typeahead.js"></script> 

<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>


<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="/sicoe/js/adminlte/js/pages/dashboard2.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="vendor/pnotify/pnotify.custom.min.js"></script>
<script src="js/chosenselect.js"></script>
<script>
//Initialize Select2 Elements
    $(".select2").select2();
</script>

<script>
    $(function() {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>

<script>
    $(function() {
        $("[rel='tooltip']").tooltip();
    });
</script>

<script>
    $(function() {
        $("[data-toggle='popover']").popover();
    });
</script>

<script type='text/javascript'>
    // Botón para ir al tope de la pagina
    $(document).ready(function() {
        $("#IrArriba").hide();
        $(function() {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 80) {
                    $('#IrArriba').fadeIn();
                } else {
                    $('#IrArriba').fadeOut();
                }
            });
        });
        $('#arriba').click(function() {
            $('html,body').animate({scrollTop: '0px'}, 500);
            return false;
        });
    });
</script>

<script>
    function format(input)
    {
        var num = input.value.replace(/\./g, '');
        if (!isNaN(num)) {
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/, '');
            input.value = num;
        } else {
            alert('Sólo se permiten numeros');
            input.value = input.value.replace(/[^\d\.]*/g, '');
        }
    }
</script>
<script>
    $(document).ready(function() {
        $('[id^=detail-]').hide();
        $('.toggle').click(function() {
            $input = $(this);
            $target = $('#' + $input.attr('data-toggle'));
            $target.slideToggle();
        });
    });
</script>

<script>
    function currency(value, decimals, separators) {
        decimals = decimals >= 0 ? parseInt(decimals, 0) : 2;
        separators = separators || ['.', "'", ','];
        var number = (parseFloat(value) || 0).toFixed(decimals);
        if (number.length <= (4 + decimals))
            return number.replace('.', separators[separators.length - 1]);
        var parts = number.split(/[-.]/);
        value = parts[parts.length > 1 ? parts.length - 2 : 0];
        var result = value.substr(value.length - 3, 3) + (parts.length > 1 ?
                separators[separators.length - 1] + parts[parts.length - 1] : '');
        var start = value.length - 6;
        var idx = 0;
        while (start > -3) {
            result = (start > 0 ? value.substr(start, 3) : value.substr(0, 3 + start))
                    + separators[idx] + result;
            idx = (++idx) % 2;
            start -= 3;
        }
        return (parts.length === 3 ? '-' : '') + result;
    }
</script>
<!--captura los mensajes desde la base de datos-->
<script>
    $("document").ready(function () {
        var mensaje = '<?php echo $_SESSION['mensaje']?>'.split("_");
        var tipo;
        var icono;
        switch (mensaje[1]) {
            case '1':
                tipo = 'success';
                icono = 'glyphicon glyphicon-ok';
                break;
            case '2':
                tipo = 'warning';
                icono = 'glyphicon glyphicon-pencil';
                break;
            case '3':
                tipo = 'danger';
                icono = 'glyphicon glyphicon-trash';
                break;
            case '4':
                tipo = 'info';
                icono = 'glyphicon glyphicon-ok';
                break;  
            case '5':
                tipo = 'danger';
                icono = 'glyphicon glyphicon-remove';
                break; 
            default:
                tipo = 'info';
                icono = 'glyphicon glyphicon-exclamation-sign';
        }
        if (mensaje[0] !== '') {
            $.notifyDefaults({
                type: tipo,
                delay: '3000',
                dismiss: false
            });
            $.notify(
                    {
                        icon: icono,
                        message: mensaje[0]
                    }
            , {
                animate: {
                    enter: 'animated lightSpeedIn',
                    exit: 'animated lightSpeedOut'
                }
            });
        }
    });
    "<?php $_SESSION['mensaje'] = null; ?>";
</script>
<!--fin-->
<!--para colocar un tooltip a los elementos-->
<script>
    $(function () {
        $("[rel='tooltip']").tooltip();
    });
</script>
<!--fin-->

<!--enviar foco al elemento input-->
<script>
    $('.modal').on('shown.bs.modal', function () {
        $(this).find('input:text:visible:first').focus();
    });
</script>
<!--fin-->
<!--para el buscador y filtrar-->
<script type="text/javascript">
    $(document).ready(function () {
        (function ($) {
            $('#filtrar').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.buscar tr').hide();
                $('.buscar tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })

        }(jQuery));
    });
</script> 
<!--lista desplegable buscar-->
<script>
    $(document).ready(function () {
        $(".select2").select2();
        $(".chosen-select2").chosen({width: "100%"});
    });
</script>
<!--fin-->
<!--Paginación-->
<!--script type="text/javascript">
    $(document).ready(function() {
         $('#example1').DataTable({
            "responsive": true,
            "language": {
               "url": 'vendor/Plugins/i18n/Spanish.lang'
            }
        });
         var espanol = {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                },
                "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
       };       
    });
</script-->
<script>
    function notificacion(titulo, msg, tipo, time) {
        var option = new Object();
        option.title = titulo;
        option.text = msg;
        option.type = tipo;
        option.delay = time ? time : 2500;
        new PNotify(option);
    }
</script>






