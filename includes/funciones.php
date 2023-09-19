<?php
//comprobación
function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//sanitizar
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//comrprobamos la pagina
function  pagina_actual($path) : bool {
    return str_contains( $_SERVER['PATH_INFO'] ?? '/', $path ) ? true : false;
}

//autentificamos la sesión
function is_auth():bool{
    if(!isset($_SESSION)){
        session_start();
    }
    return isset($_SESSION['nombre']) && !empty($_SESSION);
}
function is_admin():bool{
    if(!isset($_SESSION)){
        session_start();
    }
    return isset($_SESSION['admin']) && !empty($_SESSION['admin']);
}

function aos_animacion():void {
    $efectos = ['data-aos=', 'fade-down', 'fade-up',  'fade-right', 'fade-left','zoom-in-up', 'zoom-in','flip-left', 'zoom-out'];

    $efecto = array_rand($efectos, 1);
    echo ' data-aos="' . $efectos[$efecto] . '" ';
}