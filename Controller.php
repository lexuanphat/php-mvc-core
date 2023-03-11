<?php

namespace app\core;

use app\core\middlewares\BaseMiddleware;

class Controller
{

    public string $layout = 'main';
    public string $action = '';

    /**
     * @var \app\core\middlewares\BaseMiddleware[]
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
