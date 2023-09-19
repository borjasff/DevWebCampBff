<?php

namespace Controllers;
use MVC\Router;
use Model\Categoria;
use Model\Dia;
use Model\Hora;
use Model\Evento;
use Model\Ponente;

class PaginasController {
    public static function index(Router $router) {

        $eventos = Evento::ordenar('hora_id', 'ASC');

        $eventos_formateados = [];
        foreach ($eventos as $evento){
            //iteramos cada evento para extraer la información de la categoria
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);

            //conferencias por días
            //lunes
            if($evento->dia_id === "1" && $evento->categoria_id === "1"){
                $eventos_formateados['conferencias_l'][] = $evento;
        }
            //martes
            if($evento->dia_id === "2" && $evento->categoria_id === "1"){
                $eventos_formateados['conferencias_m'][] = $evento;
        }
            //miercoles
            if($evento->dia_id === "3" && $evento->categoria_id === "1"){
                $eventos_formateados['conferencias_x'][] = $evento;
        }
            //viernes
            if($evento->dia_id === "4" && $evento->categoria_id === "1"){
                $eventos_formateados['conferencias_v'][] = $evento;
        }
            //sabado
            if($evento->dia_id === "5" && $evento->categoria_id === "1"){
                $eventos_formateados['conferencias_s'][] = $evento;
        }
        //Workshops por días
            //lunes
            if($evento->dia_id === "1" && $evento->categoria_id === "2"){
                $eventos_formateados['workshops_l'][] = $evento;
        }
            //martes
            if($evento->dia_id === "2" && $evento->categoria_id === "2"){
                $eventos_formateados['workshops_m'][] = $evento;
        }
            //miercoles
            if($evento->dia_id === "3" && $evento->categoria_id === "2"){
                $eventos_formateados['workshops_x'][] = $evento;
        }
            //viernes
            if($evento->dia_id === "4" && $evento->categoria_id === "2"){
                $eventos_formateados['workshops_v'][] = $evento;
        }
            //sabado
            if($evento->dia_id === "5" && $evento->categoria_id === "2"){
                $eventos_formateados['workshops_s'][] = $evento;
        }
    }

    //obtener el total de cada bloque
    $ponentes_total = Ponente::total();
    $conferencias_total = Evento::total('categoria_id', 1 );
    $workshops_total = Evento::total('categoria_id', 2 );

    //obtener todos los ponentes
    $ponentes = Ponente::all();



        $router->render('paginas/index', [
            'titulo' => 'Inicio',
            'eventos' => $eventos_formateados,
            'ponentes_total' => $ponentes_total,
            'conferencias_total' => $conferencias_total,
            'workshops_total' => $workshops_total,
            'ponentes' => $ponentes
        ]);
    }

    public static function evento(Router $router) {


        $router->render('paginas/devwebcamp', [
            'titulo' => 'Sobre WebDewCamp'
        ]);
    }

    public static function paquetes(Router $router) {

        
        $router->render('paginas/paquetes', [
            'titulo' => 'Paquetes DewWebCamp'
        ]);
    }

    public static function conferencias(Router $router) {

        $eventos = Evento::ordenar('hora_id', 'ASC');

        $eventos_formateados = [];
        foreach ($eventos as $evento){
            //iteramos cada evento para extraer la información de la categoria
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);

            //conferencias por días
            //lunes
            if($evento->dia_id === "1" && $evento->categoria_id === "1"){
                $eventos_formateados['conferencias_l'][] = $evento;
        }
            //martes
            if($evento->dia_id === "2" && $evento->categoria_id === "1"){
                $eventos_formateados['conferencias_m'][] = $evento;
        }
            //miercoles
            if($evento->dia_id === "3" && $evento->categoria_id === "1"){
                $eventos_formateados['conferencias_x'][] = $evento;
        }
            //viernes
            if($evento->dia_id === "4" && $evento->categoria_id === "1"){
                $eventos_formateados['conferencias_v'][] = $evento;
        }
            //sabado
            if($evento->dia_id === "5" && $evento->categoria_id === "1"){
                $eventos_formateados['conferencias_s'][] = $evento;
        }
        //Workshops por días
            //lunes
            if($evento->dia_id === "1" && $evento->categoria_id === "2"){
                $eventos_formateados['workshops_l'][] = $evento;
        }
            //martes
            if($evento->dia_id === "2" && $evento->categoria_id === "2"){
                $eventos_formateados['workshops_m'][] = $evento;
        }
            //miercoles
            if($evento->dia_id === "3" && $evento->categoria_id === "2"){
                $eventos_formateados['workshops_x'][] = $evento;
        }
            //viernes
            if($evento->dia_id === "4" && $evento->categoria_id === "2"){
                $eventos_formateados['workshops_v'][] = $evento;
        }
            //sabado
            if($evento->dia_id === "5" && $evento->categoria_id === "2"){
                $eventos_formateados['workshops_s'][] = $evento;
        }
    }
        // para ver los datos que extraemos debuguear($eventos_formateados);

        $router->render('paginas/conferencias', [
            'titulo' => 'Conferencias & Workshops',
            'eventos' => $eventos_formateados
        ]);
    

    }
    public static function error(Router $router) {

        
        $router->render('paginas/error', [
            'titulo' => 'Página no encontrada'
        ]);
    }
}