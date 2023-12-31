<?php

namespace Controllers;

use Model\Categoria;
use Model\Dia;
use Model\Hora;
use Model\Evento;
use Model\Ponente;
use MVC\Router;
use Classes\Paginacion;

class EventosController {
    
    public static function index(Router $router){

        if(!is_admin()){
            header('Location: /login');
        }

        //validamos la página en la que estamos
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        
        //si no tiene valor o es menor a uno llevamos a la primera página
        if(!$pagina_actual || $pagina_actual < 1) {
            header ('Location: /admin/eventos?page=1');
        }

        //para la paginación
        $por_pagina = 6;
        $total = Evento::total();
        //pasamos las variables para hacerlas dinámicas
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);


        //para la paginación
        $por_pagina = 6;
        $total = Evento::total();
        //pasamos las variables para hacerlas dinámicas
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
        $eventos = Evento::paginar($por_pagina, $paginacion->offset());

        foreach($eventos as $evento){
            //iteramos cada evento para extraer la información de la categoria
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);
        }


        $router->render('admin/eventos/index', [
            'titulo' => 'Conferencias y Workshops',
            'eventos' => $eventos,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router){

        if(!is_admin()){
            header('Location: /login');
        }

        $alertas = [];
        //Mostrar en orden
        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');

        $evento = new Evento;

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!is_admin()){
                header('Location: /login');
            }

            $evento->sincronizar($_POST);

            $alertas = $evento->validar();

            if(empty($alertas)){
                $resultado = $evento->guardar();

                if($resultado){
                    header('Location: /admin/eventos');
                }
            }
        }

        $router->render('admin/eventos/crear', [
            'titulo' => 'Registrar Evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento
        ]);
        
    }

    public static function editar(Router $router){

        if(!is_admin()){
            header('Location: /login');
        }

        $alertas = [];
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if(!$id){
            header('Location: /admin/eventos');
        }

        //Mostrar en orden
        $categorias = Categoria::all('ASC');
        $dias = Dia::all('ASC');
        $horas = Hora::all('ASC');

        $evento = Evento::find($id);
        if(!$evento){
            header('Location: /admin/eventos');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if(!is_admin()){
                header('Location: /login');
            }

            $evento->sincronizar($_POST);

            $alertas = $evento->validar();

            if(empty($alertas)){
                $resultado = $evento->guardar();

                if($resultado){
                    header('Location: /admin/eventos');
                }
            }
        }

        $router->render('admin/eventos/editar', [
            'titulo' => 'Editar Evento',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'dias' => $dias,
            'horas' => $horas,
            'evento' => $evento
        ]);
        
    }

    //renderizar la vista eliminar
    public static function eliminar(){


        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            if(!is_admin()){
                header('Location: /login');
            }

            //recuperamos los id
            $id = $_POST['id'];

            //si el ponente no existe
            $evento = Evento::find($id);
            if(!$evento){
                header('Location: /admin/eventos');
            }
            //si el evento existe y el resultado funciona
            $resultado = $evento->eliminar();
            if($resultado){
                header('Location: /admin/eventos');
            }

        }
    }
}