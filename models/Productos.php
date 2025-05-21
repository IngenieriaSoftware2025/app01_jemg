<?php

namespace Model;

class Productos extends ActiveRecord{

    public static $tabla = 'productos';
    public static $columnasDB = [
        'pro_nombre',
        'pro_cantidad',
        'cat_id',
        'pri_id',
        'pro_comprado'
    ];

    public static $idTabla = 'pro_id';
    public $pro_id;
    public $pro_nombre;
    public $pro_cantidad;
    public $cat_id;
    public $pri_id;
    public $pro_comprado;
    
    public function __construct($args = []) {
        $this->pro_id = $args['pro_id'] ?? null;
        $this->pro_nombre = $args['pro_nombre'] ?? '';
        $this->pro_cantidad = intval($args['pro_cantidad'] ?? 0);  //intval convierte un valor a tipo entero (int). porque en la DB este campo es NOT NULL
        $this->cat_id = intval($args['cat_id'] ?? 0);   //intval convierte un valor a tipo entero (int). porque en la DB este campo es NOT NULL
        $this->pri_id = intval($args['pri_id'] ?? 0);   //intval convierte un valor a tipo entero (int). porque en la DB este campo es NOT NULL
        $this->pro_comprado = intval($args['pro_comprado'] ?? 0);   //intval convierte un valor a tipo entero (int). porque en la DB este campo es NOT NULL

    }
}