<?php
namespace view\Frontend;

use \Blog_jean\view;

class FrontendApplication extends Application
{
    public function __construct()
    {
        parent::__construct();

        $this->name = 'Frontend';
    }

    public function run()
    {
        $controller = $this->getController();
        $controller->execute();

        $this->httpResponse->setPage($controller->page());
        $this->httpResponse->send();
    }
}