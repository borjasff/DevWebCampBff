<?php

namespace Controllers;

use Model\Ponente;
use MVC\Router;
//para subir las imagenes
use Intervention\Image\ImageManagerStatic as Image;
use Classes\Paginacion;


class PonentesController {

    public static function index(Router $router){
        
        if(!is_admin()){
            header('Location: /login');
        }
        
        //validamos la página en la que estamos
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        
        //si no tiene valor o es menor a uno llevamos a la primera página
        if(!$pagina_actual || $pagina_actual < 1) {
            header ('Location: /admin/ponentes?page=1');
        }
        //para la paginación
        $registros_por_pagina = 6;
        $total = Ponente::total();
        //pasamos las variables para hacerlas dinámicas
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if($paginacion->total_paginas() < $paginacion->pagina_actual  ){
            header ('Location: /admin/ponentes?page=1');
        }

        
        //traemos todos los ponentes de la bd respecto a la paginación en la que se encuentra
        $ponentes = Ponente::paginar($registros_por_pagina, $paginacion->offset());

        $router->render('admin/ponentes/index', [
            'titulo' => 'Ponentes de la Conferencia',
            'ponentes' => $ponentes,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
    
    //renderizar la vista crear
    public static function crear(Router $router){

        if(!is_admin()){
            header('Location: /login');
        }

        //pasamos las alertas
        $alertas = [];
        $ponente = new Ponente;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            if(!is_admin()){
                header('Location: /login');
            }
            
            //Leer imagen
            if(!empty($_FILES['imagen']['tmp_name'])){
                //generar carpeta de imagenes
                $carpeta_imagenes = '../public/img/speakers';

                //crear la carpeta si no existe
                if(!is_dir($carpeta_imagenes)){
                    mkdir($carpeta_imagenes, 0755, true);
                } 

                //dar formato a las imagenes
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                //para generar un nombre aleatorio
                $nombre_imagen =md5(uniqid(rand(), true));

                //guardar el nombre
                $_POST['imagen'] = $nombre_imagen;

            }

            //Reescribir el apartado redes en formato string
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

            //sincronizamos
            $ponente->sincronizar($_POST);


            //validar
            $alertas = $ponente->validar();

            //guardar el registro
            if(empty($alertas)){
                //guardar las imagenes
                $imagen_png->save($carpeta_imagenes. '/' . $nombre_imagen . '.png');
                $imagen_webp->save($carpeta_imagenes. '/' . $nombre_imagen . '.webp');

                //insertar el registro en la BD
                $resultado = $ponente->guardar();


                if($resultado){
                    header('Location: /admin/ponentes');
                }               
            }
        }


        $router->render('admin/ponentes/crear', [
            'titulo' => 'Registrar Ponente',
            'alertas' => $alertas,
            'ponente' => $ponente,
            'redes' => json_decode($ponente->redes)
        ]);
    }
    

        //renderizar la vista editar
        public static function editar(Router $router){

            if(!is_admin()){
                header('Location: /login');
            }

            $alertas = [];
            //vlidar id
            $id = $_GET['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            //si no existe el id enviar a ponentes
            if(!$id){
                header('Location: /admin/ponentes');
            }

            //obtener ponente a editar por el id
            $ponente = Ponente::find($id);

            //si no existe el ponente enviar a ponentes
            if(!$ponente){
                header('Location: /admin/ponentes');
            }

            //variable temporal para la nueva imagen
            $ponente->imagen_actual = $ponente->imagen;
     
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                if(!is_admin()){
                    header('Location: /login');
                }

                            //Leer imagen
                if(!empty($_FILES['imagen']['tmp_name'])){
                    //generar carpeta de imagenes
                    $carpeta_imagenes = '../public/img/speakers';

                    //crear la carpeta si no existe
                    if(!is_dir($carpeta_imagenes)){
                    mkdir($carpeta_imagenes, 0755, true);
                    } 

                    //dar formato a las imagenes
                    $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('png', 80);
                    $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800,800)->encode('webp', 80);

                    //para generar un nombre aleatorio
                    $nombre_imagen =md5(uniqid(rand(), true));

                    //guardar el nombre
                    $_POST['imagen'] = $nombre_imagen;

                } else {
                    $_POST['imagen'] = $imagen_actual;
                }
                //añadimos las redes actualizadas
                $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

                //sincronizamos
                $ponente->sincronizar($_POST);

                //validamos fallos
                $alertas = $ponente->validar();

                if(empty($alertas)){
                    if(isset($nombre_imagen)){
                        //guardar las imagenes
                        $imagen_png->save($carpeta_imagenes. '/'. $nombre_imagen. '.png');
                        $imagen_webp->save($carpeta_imagenes. '/'. $nombre_imagen. '.webp');
                    }
                    $resultado = $ponente->guardar();

                    if($resultado){
                        header('Location: /admin/ponentes');
                    }
                }
            }

            $router->render('admin/ponentes/editar', [
                'titulo' => 'Actualizar Ponente',
                'alertas' => $alertas,
                'ponente' => $ponente,
                'redes' => json_decode($ponente->redes)
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
            $ponente = Ponente::find($id);
            if(!$ponente){
                header('Location: /admin/ponentes');
            }
            //si el ponente existe y el resultado funciona
            $resultado = $ponente->eliminar();
            if($resultado){
                header('Location: /admin/ponentes');
            }

        }
    }
}