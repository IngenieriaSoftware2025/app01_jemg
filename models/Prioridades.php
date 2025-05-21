<?php

namespace Model;

class Prioridades extends ActiveRecord {
    public static $tabla = 'prioridades';
    public static $columnasDB = [
        'pri_nivel',
    ];

    public static $idTabla = 'pri_id';
    public $pri_id;
    public $pri_nivel;

    public function __construct($args = []){
        $this->pri_id = $args['pri_id'] ?? null;
        $this->pri_nivel = $args['pri_nivel'] ?? '';
    }
}