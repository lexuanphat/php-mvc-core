<?php

namespace app\core;

use app\core\exception\NotFoundException;

class Router
{

    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();

        $callback = $this->routes[$method][$path] ?? false;

        // $callback không tồn tại 
        if ($callback === false) {

            throw new NotFoundException();
        }

        // $app->router->get("/path", "view");
        if (is_string($callback)) {

            return App::$app->view->renderView($callback);
        }

        // $app->router->get("/path", [Controller::class, 'action']);
        if (is_array($callback)) {

            /* 
                $callback[0] => 'app\controllers\Controller'

                $callback[0] = new $callback[0];

                Khởi tạo đối tượng sau đó dùng call_user_func()
            */

            /**
             * @var \app\core\Controller $controller;
             */

            $controller = new $callback[0];
            App::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach($controller->getMiddlewares() as $middleware){
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request);
    }

    public function renderView($view, $params = [])
    {
        return App::$app->view->renderView($view, $params = []);
    }
}
