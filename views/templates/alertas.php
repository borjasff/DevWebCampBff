<?php 
foreach($alertas as $key => $alerta) {
    foreach($alerta as $mensaje) {
?>
    <div class="alerta alerta__<?php echo $key; ?>">
        <!--vemos errores por pantalla-->
    <?php echo $mensaje; ?>
    </div>
<?php 
        }
    }
?>