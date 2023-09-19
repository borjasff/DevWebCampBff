<main class="devwebcamp">
    <h2 class="devwebcamp__heading"><?php echo $titulo; ?></h2>

    <p class="devwebcamp__descripcion">Conoce la conferencia más importante para los Devs</p>

    <div class="devwebcamp__grid">
        <div <?php aos_animacion();?> class="devwebcamp__imagen">
            <picture>
                <source srcset="build/img/sobre_devwebcamp.avif" type="image/avif">
                <source srcset="build/img/sobre_devwebcamp.webp" type="image/webp">
                <img loading="lazy" width="200" height="300" src="build/img/sobre_devwebcamp.jpg" ALT="imagen DewVewCamp"/>
            </picture>
        </div>
        <div class="devwebcamp__contenido">
            <p <?php aos_animacion();?> class="devwebcamp__texto">Pellentesque ipsum erat, cursus et augue in, posuere pulvinar urna. Suspendisse viverra pretium nibh, a laoreet enim pulvinar quis. Sed a nulla porta, accumsan risus ut, posuere leo. Curabitur sit amet nisl aliquet, condimentum eros quis, vestibulum erat. Quisque libero ante, laoreet eget tortor sed, tincidunt tristique metus. Sed lacinia massa placerat neque eleifend, sed dignissim mauris viverra. Vestibulum scelerisque erat consectetur, convallis lorem a, sollicitudin nulla. Maecenas gravida lobortis eros eget rutrum. Integer quis interdum nibh.</p>
            <p <?php aos_animacion();?> class="devwebcamp__texto">Duis finibus mauris mauris, sit amet congue nulla suscipit sed. Donec tellus libero, cursus sed egestas vitae, egestas non sem. Vestibulum volutpat porttitor justo. Nunc risus urna, tristique sed auctor id, dapibus id nibh. Nulla ac erat vestibulum metus mollis commodo. 
            <p <?php aos_animacion();?> class="devwebcamp__texto">Vestibulum feugiat, metus in convallis dapibus, felis elit fringilla purus, porta pellentesque arcu odio sed ante. Nullam sed dui sem. Phasellus scelerisque tempus lorem, eu gravida urna mattis id. Fusce eu leo tincidunt, interdum tortor sed, sagittis diam. Sed molestie elit magna, in imperdiet libero aliquet ut. Proin porttitor augue efficitur lacinia ullamcorper. </p>
             
        </div>   
    </div>
</main>