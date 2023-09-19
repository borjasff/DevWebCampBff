<?php

namespace Classes;

class Paginacion {
    
    public $pagina_actual;
    public $registros_por_pagina;
    public $total_registros;
    
    //valor por defoult =en los valores si no se pasan.
    public  function __construct ($pagina_actual = 1, $registros_por_pagina = 5, $total_registros = 0){

        //casteamos los valores
        $this->pagina_actual = (int) $pagina_actual;
        $this->registros_por_pagina = (int) $registros_por_pagina;
        $this->total_registros = (int) $total_registros;
    }
    //paginacion en la que nos encontramos
    public function offset(){
        return $this->registros_por_pagina  * ($this->pagina_actual - 1);
    }
    //total de las paginas
    public function total_paginas(){
        return ceil($this->total_registros / $this->registros_por_pagina);
    }

    //metodo para ir a la pagina anterior
    public function pagina_anterior(){
        $anterior = $this->pagina_actual - 1;
        return ($anterior > 0) ? $anterior : false;
    }

    //metodo para ir a la pagina siguiente
    public function pagina_siguiente(){
        $siguiente = $this->pagina_actual + 1;
        return ($siguiente <= $this->total_paginas()) ? $siguiente : false;
    }

    //metodo para enlace anterior
    public function enlace_anterior(){
        $html = '';
        if($this->pagina_anterior()){
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_anterior()}\">&laquo; Anterior </a>";
        }
        return $html;
    }

    //metodo para enlace siguiente
    public function enlace_siguiente(){
        $html = '';
        if($this->pagina_siguiente()){
            $html .= "<a class=\"paginacion__enlace paginacion__enlace--texto\" href=\"?page={$this->pagina_siguiente()}\">Siguiente &raquo;</a>";
        }
        return $html;
    }

    //metodo para mostrar el numero de paginas
    public function numero_paginas(){
        $html = '';
        for($i = 1; $i <= $this->total_paginas(); $i++){
            if($i === $this->pagina_actual){
                $html.= "<span class=\"paginacion__enlace paginacion__enlace--actual\">{$i}</span>";
            } else {
                $html.= "<a class=\"paginacion__enlace paginacion__enlace--numero\" href=\"?page={$i}\">{$i}</a>";  
            }

        }
        return $html;
    }

    //mostrar paginacion
    public function paginacion(){
        $html = '';
        if($this->total_registros > 1){
            $html .= '<div class="paginacion">';
            $html .= $this->enlace_anterior();
            $html.= $this->numero_paginas();
            $html .= $this->enlace_siguiente();
            $html .= '</div>';
        }
        return $html;
    }
}
