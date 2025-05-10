<?php
require 'clases/conexion.php';
session_start();
?>
<div class="col-lg-4 col-md-4 col-sm-4">
    <?php
    $articulos = consultas::get_datos("SELECT 
    ar.art_descri,
    t.tmp_descri
   FROM tipo_y_art a
     JOIN articulo ar ON a.art_cod = ar.art_cod
     JOIN tipo_mp t ON a.tmp_cod = t.tmp_cod

      where t.tmp_cod =" . $GET ['vtmp_cod'] ." "
      . "GROUP BY ar.art_descri, t.tmp_descri");

      ?>
      <?php if (!empty($articulos)) { ?>            
          <option value="">FAVOR SELECCIONE EL ARTICULO</option>        
          <?php
          foreach ($articulos as $art) {
              ?>
              <option value="<?php echo $art['art_cod'] ?>"> <?= $art['art_descri'] ?> <?= $art['tmp_descri'] ?></option>            
              <?php
          }
      } else {
          ?>
          <option value="">ESTE TIPO NO TIENE ARTICULO DISPONIBLE</option> 
      <?php } ?>       
    </select>
</div>

