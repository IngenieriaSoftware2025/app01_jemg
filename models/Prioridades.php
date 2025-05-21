<?php

namespace Model;

class Prioridades extends ActiveRecord {
    public static $tabla = 'prioridades';
    public static $columnasDB = [
        'pri_id', 
        'pri_nombre', 

    ];

    public static $idTabla = 'prod_id';
    public $cat_id;
    public $cat_nombre;

    public function __construct($args = []){
        $this->cat_id = $args['cat_id'] ?? null;
        $this->cat_nombre = $args['cat_nombre'] ?? '';
    }
}