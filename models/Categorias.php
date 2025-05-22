<?php

namespace Model;

class Categorias extends ActiveRecord {

    public static $tabla = 'categorias';
    public static $columnasDB = [
        'cat_nombre',
        'cat_situacion' 
    ];

    public static $idTabla = 'cat_id';
    public $cat_id;
    public $cat_nombre;
    public $cat_situacion;

    public function __construct($args = []){
        $this->cat_id = $args['cat_id'] ?? null;
        $this->cat_nombre = $args['cat_nombre'] ?? '';
        $this->cat_situacion = $args['cat_situacion'] ?? 1;
    }
}