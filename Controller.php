<?php

namespace lexuanphat\phpmvc;

use lexuanphat\phpmvc\middlewares\BaseMiddleware;

class Controller
{

    public string $layout = 'main';
    public string $action = '';

    /**
     * @var \lexuanphat\phpmvc\middlewares\BaseMiddleware[]
     */

    protected array $middlewares = [];

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $params = [])
    {
        return App::$app->view->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware){

        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares() {
        return $this->middlewares;
    }
}
