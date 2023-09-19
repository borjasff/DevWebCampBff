<main class="paquetes">
    <h2 class="paquetes__heading"><?php echo $titulo; ?></h2>

    <p class="paquetes__descripcion">Diferentes paquetes para tu Experiencia DevWebCamp</p>

    <div class="paquetes__grid">

    <!--Pase gratis-->
        <div <?php aos_animacion();?> class="paquete">
            <h3 class="paquete__nombre">Pase Gratis</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual a DevWebCamp</li>
            </ul>

            <p class="paquete__precio">0$</p>
        </div>

    <!--Pase Presencial-->
        <div <?php aos_animacion();?> class="paquete">
            <h3 class="paquete__nombre">Pase Presencial</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Presencial a DevWebCamp</li>
                <li class="paquete__elemento">Pase por 2 días</li>
                <li class="paquete__elemento">Acceso a talleres y conferencias</li>
                <li class="paquete__elemento">Acceso a las grabaciones</li>
                <li class="paquete__elemento">Camiseta del Evento</li>
                <li class="paquete__elemento">Comida y Bebida</li>

            </ul>

            <p class="paquete__precio">199$</p>
        </div>

    <!--Pase Virtual-->
        <div <?php aos_animacion();?> class="paquete">
            <h3 class="paquete__nombre">Pase Virtual</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento">Acceso Virtual a DevWebCamp</li>
                <li class="paquete__elemento">Pase por 2 días</li>
                <li class="paquete__elemento">Enlace talleres y conferencias</li>
                <li class="paquete__elemento">Acceso a las grabaciones</li>

            </ul>

            <p class="paquete__precio">49$</p>
        </div>
    </div>


</main>