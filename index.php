<?php

session_start();
require_once 'config.php';
require_once PROJECT_ROOT . '/app/core/conexao.php';

$controllerName = 'LoginController';
$actionName = 'index';
$params = [];

if (isset($_GET['url'])) {
    $url = rtrim($_GET['url'], '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $urlParts = explode('/', $url);

    if (!empty($urlParts[0])) {
        $controllerName = ucfirst($urlParts[0]) . 'Controller';
    }

    if (!empty($urlParts[1])) {
        $actionName = $urlParts[1];
    }
    
    if (count($urlParts) > 2) {
        $params = array_slice($urlParts, 2);
    }
}

$controllerFile = PROJECT_ROOT . '/app/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $actionName)) {
            call_user_func_array([$controller, $actionName], $params);
        } else {
            echo "Erro: Método '{$actionName}' não encontrado no controller '{$controllerName}'.";
        }
    } else {
        echo "Erro: Classe '{$controllerName}' não encontrada.";
    }
} else {
    echo "Erro: Controller '{$controllerName}' não encontrado.";
}