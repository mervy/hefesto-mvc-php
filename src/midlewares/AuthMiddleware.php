<?php

namespace HefestoMVC\midlewares;


class AuthMiddleware
{
    public function index()
    {
        if (empty($_SESSION['user'])) {
            http_response_code(401);
            die('<h1>401 - Não autorizado</h1><p>Você precisa estar logado para acessar esta página.</p>');
        }
    }
}