<?php

class BlogView
{

    private $converter;
    private $content; // content of page output

    public function __construct(BlogManager $converter)
    {
        $this->converter = $converter;

        $tmp = debug_backtrace();
        $this->controller = str_replace("controller", "", strtolower($tmp[1]['class']));
        $this->action = str_replace("action", "", strtolower($tmp[1]['function']));
    }

    public function __destruct()
    {
        include '../Application/View/Layout/layout.phtml';
    }

    public function renderView($variables = null)
    {
        //@todo: use smarty here for template
        ob_start();
        require "../Application/View/$this->controller/$this->action.phtml";
        $this->content = ob_get_clean();
    }

    public function indexView()
    {
        $this->content = "Blog sample.
        Click <a href ='/?action=about'>here</a> to see";
    }

    public function outputHelper()
    {
        $html = '<form action="?action=convert" method="post">
					<input name="currency" type="hidden" value="' . $this->currency . '" />
					<label>' . $this->currency . ':</label>
					<input name="amount" type="text" value="' . $this->converter->get($this->currency) . '" />
					<input type="submit" value="Convert" />				
				</form>';

        return $html;
    }

}

class PostView
{

    private $converter;
    private $currency;

    public function __construct(BlogManager $converter, $currency)
    {
        $this->converter = $converter;
        $this->currency = $currency;
    }

    public function outputHelper()
    {
        $html = '<form action="?action=convert" method="post">
					<input name="currency" type="hidden" value="' . $this->currency . '" />
					<label>' . $this->currency . ':</label>
					<input name="amount" type="text" value="' . $this->converter->get($this->currency) . '" />
					<input type="submit" value="Convert" />				
				</form>';

        return $html;
    }

}
