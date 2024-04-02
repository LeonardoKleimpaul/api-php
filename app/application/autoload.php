<?php

/**
 * Autoload
 *
 * @param $classe
 */
function autoload($classe)
{
    $diretorioBase = __DIR__ . DS;
    $classe = $diretorioBase . str_replace('\\', DS, $classe) . '.php';

    if (file_exists($classe) && !is_dir($classe)) {
        include $classe;
    }
}

spl_autoload_register('autoload');