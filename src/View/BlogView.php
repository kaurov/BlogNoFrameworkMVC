<?php

class BlogView
{

    private $content; // content of page output


    public function __construct(BlogManager $converter)
    {
        $this->converter = $converter;

        $tmp = \debug_backtrace();
        $this->controller = \str_replace("controller", "", \strtolower($tmp[1]['class']));
        $this->action = \str_replace("action", "", \strtolower($tmp[1]['function']));
    }


    public function __destruct()
    {
        include '../src/View/Layout/layout.phtml';
    }


    public function renderView($variables = null)
    {
        \ob_start();
        require "../src/View/{$this->controller}/{$this->action}.phtml";
        $this->content = \ob_get_clean();
    }


    public function indexView()
    {
        $this->content = "Blog sample.
        Click <a href ='/about'>here</a> to see";
    }


}