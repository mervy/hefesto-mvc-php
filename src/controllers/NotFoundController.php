<?php
namespace HefestoMVC\controllers;


class NotFoundController
{
    public function index()
    {
        echo '<h1>404 - Página não encontrada</h1>';
        echo '<p>A página que você está procurando não existe ou foi removida.</p>';
        echo '<a href="/">Voltar para a página inicial</a>';
    }
}