<?php

namespace HefestoMVC\controllers;

use HefestoMVCLibrary\View;
use HefestoMVC\helpers\Pagination;
use HefestoMVC\database\models\Article;


class HomeController
{

    private $articleModel;
    private $pagination;

    public function __construct(Article $articleModel, Pagination $pagination)
    {
        $this->articleModel = $articleModel;
        $this->pagination = $pagination;
    }

    public function index()
    {
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 12;

        // Total de registros
        $totalRecords = $this->articleModel->countAll();

        // Configuração da paginação
        $pagination = new Pagination($totalRecords, $perPage, $currentPage);

        // Buscar registros com offset e limit
        $articles = $this->articleModel
            ->orderBy('created', 'DESC')
            ->limit($pagination->getLimit())
            ->offset($pagination->getOffset())
            ->get();

        // Dados da paginação
        $paginationData = [
            'currentPage' => $pagination->getCurrentPage(),
            'totalPages' => $pagination->getTotalPages(),
            'pages' => $pagination->getPageRange(5), // Range dinâmico de 5 páginas
            'nextPage' => $pagination->getNextPage(),
            'prevPage' => $pagination->getPrevPage(),
        ];

        // Renderizar a view
        View::render('home.twig', [
            'articles' => $articles,
            'pagination' => $paginationData,
        ]);
    }

    public function show($title, $id)
    {
        $article = $this->articleModel->find($id);

        // Verifica se o artigo foi encontrado
        if (!$article) {
            http_response_code(404);
            echo "Artigo não encontrado.";
            return;
        }
    
        // Passa os dados do artigo para a view
        View::render('show-article.twig', ['article' => $article, 'title' => $title]);
    }
}