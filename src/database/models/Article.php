<?php

namespace HefestoMVC\database\models;

use HefestoMVC\database\Model;


class Article extends Model
{
    public function __construct() {
        // Definir o nome da tabela como 'users'
        parent::__construct('articles');
    }
}