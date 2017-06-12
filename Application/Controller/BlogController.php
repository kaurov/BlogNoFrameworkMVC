<?php
class BlogController
{
    /*
     * $blogManager model instance
     */
    private $blogManager;
    
    /*
     * $blogManager model instance
     */
    private $userManager;

    public function __construct($blogModel, $userModel)
    {
        $this->blogManager = $blogModel;
        $this->userManager = $userModel;
    }

    public function indexAction($request)
    {
        $posts = $this->blogManager->findAllPublishedPosts();
        $View = new BlogView($this->blogManager);
        $View->renderView($posts);
    }

    public function listAction($request)
    {
        $posts = $this->blogManager->findAllPublishedPosts();
        $View = new BlogView($this->blogManager);
        $View->renderView($posts);
    }

    public function postAction($request)
    {
        $post = $this->blogManager->findOnePostById($request['id']);
        $View = new BlogView($this->blogManager);
        $View->renderView($post);
    }
    
    public function addAction($request)
    {
        $View = new BlogView($this->blogManager);
        $View->renderView($request);
    }
    
    
    public function addpostsubmittedAction($request)
    {
        $res = null;
        $userid = $this->userManager->is_logined();
        if ($userid) $res = $this->blogManager->addPost($request['title'], $request['content'], $userid);
        if ($res) $this->redirectAction();
        else $this->redirectAction("/?action=add&error=error");
    }


    
    public function redirectAction($route="/")
    {
        header("location: $route");
        exit;
    }
}