<?php

namespace lexuanphat\phpmvc;

use lexuanphat\phpmvc\db\Database;

class App
{
    public static string $ROOT_DIR;

    public static App $app;
    public string $layout = 'main';
    public string $userClass;
    public Router $router;
    public Response $response;
    public Request $request;
    public Database $db;
    public ?Controller $controller = null;
    public Session $session;
    public ?UserModel $user;
    public View $view;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();
        $this->view = new View();

        $this->db = new Database($config['db']);

        $this->userClass = $config['userClass'];
        $userClass = new $this->userClass;
        
        $primaryKey = $userClass->primaryKey();
        $primaryValue = $this->session->get("user");

        if($primaryValue){
            $this->user = $userClass::findOne([$primaryKey => $primaryValue]);
        }else{
            $this->user = null;
        }
       
    }

    public function run()
    {
        try {

            echo $this->router->resolve();
             
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->view->renderView("_error", [
                   'exception' => $e,
               ]);
        }
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setController($controller)
    {

        $this->controller = $controller;
    }

    public function login(UserModel $user){
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        
        $this->session->set("user", $primaryValue);

        return true;
    }

    public function logout(){
        $this->user = null;
        $this->session->remove("user");
    }

    public static function isGuest() {
        return !self::$app->user;
    }
}