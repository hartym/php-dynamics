<?php

/**
 * This is unfinshed work, probably not useable at all.
 */
class Dynamics_MainController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }

    public function renderAction()
    {
      /* TODO

      $this->_helper->layout->disableLayout();
      $this->_helper->viewRenderer->setNoRender();

      require_once 'Dynamics/Autoloader.php';
      Dynamics_Autoloader::register();

      try
      {
        $configuration = new Dynamics_Configuration();
        $controller = new Dynamics_Controller($configuration);
        $result = $controller->run($request->getParameter('name'));

        $this->response->setContentType($controller->getContentType());
        return $this->renderText($result);
      }
      catch (Exception $e)
      {
        throw new sfError404Exception($e->getMessage());
      }
      */
    }
}

