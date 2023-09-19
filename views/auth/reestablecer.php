<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo; ?></h2>
    <p class="auth__texto">Restablecer tu Password de DevWebCamp</p>

    <?php
     require_once __DIR__ . '/../templates/alertas.php' ;
    ?>

    <?php
        if($token_valido) {
    ?>
    <form method="POST" class="formulario">
        <div class="formulario__campo">
            <label class="formulario__label" for="password">Password</label>
            <input type="password" class="formulario__input" placeholder="Tu Nuevo Password" id="password" name="password">
        </div>
        <input type="submit" class="formulario__submit" value="Cambiar Password">
    </form>

    <?php
        }
    ?>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? Iniciar Sesión</a>
        <a href="/olvide" class="acciones__enlace">¿Olvidaste tu Password?</a>
    </div>
</main>