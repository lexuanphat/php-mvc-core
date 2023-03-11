<?php
namespace lexuanphat\phpmvc\middlewares;

use lexuanphat\phpmvc\App;
use lexuanphat\phpmvc\exception\ForbiddenException;

class AuthMiddleware extends BaseMiddleware{

    public array $actions = [];

    public function __construct(array $actions = []){
        $this->actions = $actions;


    }

    public function execute()
    {

        if(App::isGuest()){
            if(empty($this->actions) || in_array(App::$app->controller->action, $this->actions)){
                throw new ForbiddenException();
            }
        }
    }
}