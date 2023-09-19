<?php

namespace Controllers;

use MVC\Router;
use Classes\Paginacion;
use Model\Paquete;
use Model\Registro;
use Model\Usuario;

class RegistradosController {
    
    public static function index(Router $router){
        if(!is_admin()){
            header('Location: /login');
        }
            //validamos la página en la que estamos
            $pagina_actual = $_GET['page'];
            $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
            
            //si no tiene valor o es menor a uno llevamos a la primera página
            if(!$pagina_actual || $pagina_actual < 1) {
                header ('Location: /admin/registrados?page=1');
            }
            //para la paginación
            $registros_por_pagina = 8;
            $total = Registro::total();
            //pasamos las variables para hacerlas dinámicas
            $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
    
            if($paginacion->total_paginas() < $paginacion->pagina_actual  ){
                header ('Location: /admin/registrados?page=1');
            }
            //traemos todos los ponentes de la bd respecto a la paginación en la que se encuentra
            $registros = Registro::paginar($registros_por_pagina, $paginacion->offset());


            foreach($registros as $registro){
                $registro->usuario = Usuario::find($registro->usuario_id);
                $registro->paquete = Paquete::find($registro->paquete_id);
                
            }
    

        $router->render('admin/registrados/index', [
            'titulo' => 'Usuarios Registrados',
            'registros' => $registros,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
}