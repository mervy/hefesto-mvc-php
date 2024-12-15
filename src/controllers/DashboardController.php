<?php

namespace HefestoMVC\controllers;

use HefestoMVC\helpers\SessionHelper;

class DashboardController
{
    public function edit()
    {
        // Obtém o usuário autenticado da sessão
        $user = SessionHelper::getSession('user');

        if (!$user) {
            http_response_code(401);
            echo '<h1>401 - Não autorizado</h1>';
            echo '<p>Você precisa estar logado para acessar esta página.</p>';
            echo '<a href="/login">Ir para a página de login</a>';
            return;
        }

        // Renderiza a página de edição de perfil
        echo '<h1>Editar Perfil</h1>';
        echo '<p>Bem-vindo, ' . htmlspecialchars($user['name']) . '</p>';
        echo '<form method="POST" action="/profile/update">
                <label>Nome:</label><br>
                <input type="text" name="name" value="' . htmlspecialchars($user['name']) . '"><br>
                <button type="submit">Salvar</button>
              </form>';
    }
}