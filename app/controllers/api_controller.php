<?php
class ApiController extends AppController
{
    public $uses = array('Language');
    public $helper = array('Languages');

    public function beforeFilter()
    {
        parent::beforeFilter();

        // setting actions that are available to everyone, even guests
        $this->Auth->allowedActions = array("*");
    }

    public function beforeRender()
    {
        $this->layout = 'json';
    }

    function languages()
    {
    }
}
?>