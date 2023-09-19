<?php

namespace Controllers;

use Model\Regalo;
use Model\Registro;

class APIRegalos {
    public static function index() {
        //protegemos la API de regalos
        if(!is_admin()){
            echo json_encode([]);
            return;
        }
        //traemos todos los regalos y los iteramos en regalos.js
        $regalos = Regalo::all();

        foreach($regalos as $regalo) {
            $regalo->total = Registro::totalArray(['regalo_id' => $regalo->id, 'paquete_id' => "1"]);
        }
        echo json_encode($regalos);
        return;
    }
}