<?php

class AuthController implements ControllerInterface
{

    /**
     * $blogManager model instance
     * @var BlogManager
     */
    private $blogManager;

    /**
     * $blogManager model instance
     * @var UserManager
     */
    private $userManager;


    public function __construct($blogModel, $userModel)
    {
        $this->blogManager = $blogModel;
        $this->userManager = $userModel;
    }


    public function indexAction($request)
    {
        $this->loginAction();
    }


    public function loginAction()
    {
        if ($this->userManager->isLoggedIn()) {
            $this->redirectAction();
        }

        $View = new BlogView($this->blogManager);
        $View->renderView();
    }

    public function redirectAction($route = "/")
    {
        header("location: $route");
        exit;
    }

    public function loginsubmittedAction($request)
    {
        $res = $this->userManager->login($request['email'], $request['password']);
        if ($res) {
            $this->redirectAction();
        } else {
            $this->redirectAction("/login?error=error");
        }
    }

    public function logoutAction()
    {
        $this->userManager->logout();
        $this->redirectAction();
    }

}