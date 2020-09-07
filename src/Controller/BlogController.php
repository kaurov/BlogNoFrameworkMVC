<?php

class BlogController implements ControllerInterface
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
        return $this->listAction($request);
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
        $userid = $this->userManager->isLoggedIn();
        if ($userid) {
            $res = $this->blogManager->addPost($request['title'], $request['content'], $userid);
        }
        if ($res) {
            $this->redirectAction();
        }
        else {
            $this->redirectAction("/?action=add&error=error");
        }
    }


    public function addcommentsubmittedAction($request)
    {
        $res = $this->blogManager->addComment(
            $request['name'],
            $request['content'],
            $request['post_id'],
            $request['email'],
            $request['url']
        );
        if ($res) $this->redirectAction("/?action=post&id=".$request['post_id']);
        else $this->redirectAction("/?action=post&id={$request['post_id']}&error=error");
    }


    public function redirectAction($route="/")
    {
        header("location: $route");
        exit;
    }


}