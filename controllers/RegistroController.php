<?php

namespace Controllers;

use Model\Registro;
use Model\Usuario;
use Model\Paquete;
use Model\Ponente;
use Model\Categoria;
use Model\Hora;
use Model\Dia;
use Model\Regalo;
use MVC\Router;
use Model\Evento;
use Model\EventosRegistros;

//para subir las imagenes

class RegistroController {
    
    public static function crear(Router $router){

        if(!is_auth()){
            //sino existe validación
            header('location: /login');
            return;
        }
        //Verificar si el usuario ya tiene un plan
        $registro = Registro::where('usuario_id', $_SESSION['id']);

        //redirecciona a la entrada
        if(isset($registro) && ($registro->paquete_id === "3" || $registro->paquete_id === "2")){
            header('Location: /entrada?id='. urlencode($registro->token));
            return;
        }
        //si el usuario ha pagado ir a su ticket
        if(isset($registro) && $registro->paquete_id === "1"){
            header('location: /finalizar-registro/conferencias');
            return;
        }

        $router->render('registro/crear', [
            'titulo' => 'Finalizar Registro'
        ]);
    }

    public static function gratis(Router $router){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!is_auth()){
                //sino existe validación
                header('location: /login');
                return;
            }
            //Verificar si el usuario ya tiene un plan
            $registro = Registro::where('usuario_id', $_SESSION['id']);

            if(isset($registro) && $registro->paquete_id === "3"){
                header('Location: /entrada?id='. urlencode($registro->token));
                return;
            }
            //si existe
            $token =substr(md5(uniqid(rand(), true)), 0, 8);
            //Crear Registro
            $datos = [
                'paquete_id' => 3,
                'pago_id' => '1',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            ];

            $registro = new Registro($datos);
            $resultado = $registro->guardar();
            if($resultado){
                header('Location: /entrada?id='. urlencode($registro->token));
                return;
            }
        }
    }

    public static function pagar(Router $router){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!is_auth()){
                //sino existe validación
                header('location: /login');
                return;
            }
            //validar que post no venga vacío
            if(empty($_POST)){
                echo json_encode([]);
                return;
            }

            //si existe
            //Crear Registro
            $datos = $_POST;
            $datos['token'] = substr(md5(uniqid(rand(), true)), 0, 8);
            //instanciamos el registro
            $datos['usuario_id'] = $_SESSION['id'];


            try{
                //si funciona
                //lo almacenamos
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                //lo q se retorna a crear.php
                echo json_encode($resultado);

            } catch (\Throwable $th) {
                //retornamos ante el error
                echo json_encode([
                    'resultado' => 'error'
                ]);
                return;
            }
        }
    }

    public static function entrada(Router $router){
        //validar la url
        $id = $_GET['id'];
        if(!$id || !strlen($id) === 8){
            header('location: /');
            return;
        }

        //buscarlo en la BD
        $registro = Registro::where('token', $id);
        if(!$registro){
            header('location: /');
            return;
        }
        //llenar las tablas de referencia
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);

        $router->render('registro/entrada', [
            'titulo' => 'Entrada a DevWebCamp',
            'registro' => $registro
        ]);
    }

    public static function conferencias(Router $router){

        if(!is_auth()){
            //sino existe validación
            header('location: /login');
            return;
        }

        // Validar que el usuario tenga el plan presencial
        $usuario_id = $_SESSION['id'];
        $registro = Registro::where('usuario_id', $usuario_id);
        $recordFinished = EventosRegistros::where('registro_id', $registro->id);

        //redireccion entrada virtual
        if(isset($registro) && $registro->paquete_id === "2" ){
            header('Location: /entrada?id='. urlencode($registro->token));
            return;
        } 
        if(isset($recordFinished)){
            header('Location: /entrada?id='. urlencode($registro->token));
            return;
        }

        if($registro->paquete_id !== "1"){
            header( 'Location: /');
            return;
        }

        //redireccionar a entrada en virtual en caso de haber finalizado el registro 


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

        $regalos = Regalo::all('ASC');

        //manejando el registro mediante post
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            //Revisar que el usuario esta autentificado
            if(!is_auth()){
                //sino existe validación
                header('location: /login');
                return;
            }

            $eventos = explode(',', $_POST['eventos']);

            //si esta vacío retornamos una respuesta como false
            if(empty($eventos)){
                echo json_encode(['resultado' => false]);
                return;
            }

            //obtener el registro del usuario
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            if(!isset($registro) || $registro->paquete_id !== "1"){
                echo json_encode(['resultado' => false]);    
                return;
            }
        
            // debuguear($registro); comprobamos si se ha pagado 
            //validar la disponibilidad de los eventos seleccionados
            $eventos_array = [];
            foreach ($eventos as $evento_id) {
                $evento = Evento::find($evento_id);

                //comprbar que el evento exista
                if(!isset($evento) || $evento->disponibles === "0"){
                    echo json_encode(['resultado' => false]);
                    return;
                }
                $eventos_array[] = $evento;
            }
            foreach ($eventos_array as $evento) {
                $evento->disponibles -= 1;
                $evento->guardar();

                //almacenar el registro
                $datos = [
                    'evento_id' => (int) $evento->id,
                    'registro_id' => (int) $registro->id
                ];

                //almacenar el regalo
                $registro->sincronizar(['regalo_id' => $_POST['regalo_id']]);
                $resultado = $registro->guardar();

                if($resultado){
                    echo json_encode([
                        'resultado' => $resultado,
                    'token' => $registro->token,
                    ]); 
                } else {
                    echo json_encode(['resultado' => false]);
                }
            return;
            }
        }
        $router->render('registro/conferencias', [
            'titulo' => 'Elige Workshops y Conferencias',
            'eventos' => $eventos_formateados,
            'regalos' => $regalos
        ]);
        $registro_usuario = new EventosRegistros($datos);
        $registro_usuario->guardar();

    }

}