<?php

namespace HefestoMVCLibrary;

use Twig\TwigFilter;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    public static function render(string $view, array $data = [])
    {

        $path = dirname(__FILE__) . '/../src/views/';

        $loader = new FilesystemLoader($path);
        $twig = new Environment($loader);
        $twig->addFilter(new TwigFilter('slugify', 'slugify'));


        echo $twig->render($view, $data);
    }
}