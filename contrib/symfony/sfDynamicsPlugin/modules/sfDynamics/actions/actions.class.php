<?php

class sfDynamicsActions extends sfActions
{
  public function executeAsset($request)
  {
    try
    {
      $controller = new Dynamics_Controller(sfDynamics::getInstance()->getConfiguration());
      $result = $controller->run($request->getParameter('name'));

      $this->response->setContentType($controller->getContentType());
      return $this->renderText($result);
    }
    catch (Exception $e)
    {
      throw new sfError404Exception($e->getMessage());
    }
  }
}
