<?php

function slugify($string)
{
    // Remove acentos
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    // Converte para minúsculas
    $string = strtolower($string);
    // Remove caracteres não alfanuméricos e substitui espaços por hifens
    $string = preg_replace('/[^a-z0-9]+/', '-', $string);
    // Remove hifens extras
    return trim($string, '-');
}