<?php

/**
 * This is unfinshed work, probably not useable at all.
 */
class ZFDynamics_Plugin extends Zend_Controller_Plugin_Abstract {
    public function __construct($options = null)
    {
        $this->_front_controller = Zend_Controller_Front::getInstance();


        $this->dispatcher = $dispatcher;

        // TODO $this->dispatcher->connect('task.cache.clear', array('sfDynamicsCache', 'clearSuperCache'));

        array(
                Dynamics_Configuration::ROUTING_SERVICE_CLASS => 'sfDynamicsRouting',
                Dynamics_Configuration::WEB_DIR => sfConfig::get('sf_web_dir'),
                Dynamics_Configuration::CACHE_SERVICE_CLASS => 'sfDynamicsSymfonyCacheAdapter',
                Dynamics_Configuration::CACHE_SERVICE_OPTIONS => array(
                    array(
                        'implementation' => 'Dynamics_Cache_NoCache' /* TODO adapt symfony cache */,
                        'cache_dir' => '/tmp' /* TODO use sf cache dir */,
                        )
                    ),
             );

        parent::__construct($this->configuration);
    }

      public function loadOptions($options)
      {
          // guess what ... load options here TODO
      }


    /**
     * Called before Zend_Controller_Front begins evaluating the
     * request against its routes.
     *
     * @param Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function routeStartup(Zend_Controller_Request_Abstract $request) {
      $this->_front_controller->addControllerDirectory(dirname(__FILE__).'/Resources/controllers/', 'dynamics');

      $this->_front_controller
        ->getRouter()
        ->addRoute(
          'ZFDynamics',
          new Zend_Controller_Router_Route(
            'dynamics/:name',
            array(
              'module' => 'dynamics',
              'controller' => 'main',
              'action' => 'render'
            )
          )
        );
    }


    /**
     * Defined by Zend_Controller_Plugin_Abstract
     */
    public function dispatchLoopShutdown()
    {
        $html = '';

        if ($this->getRequest()->isXmlHttpRequest()) {
            return;
        }

        $html = '<script type="text/javascript">console.log("tiptop");</script>';

        $this->_output($html);
    }

    /**
     * Appends Debug Bar html output to the original page
     *
     * @param string $html
     * @return void
     */
    #protected function _output($html)
    #{
    #    $response = $this->getResponse();
    #    $response->setBody(preg_replace('/(<head.*>)/i', '$1'.$html, $response->getBody()));
    #}
    protected function _output($html)
    {
        // TODO $prepend  = sfDynamicsConfig::getAssetsPositionInHead() == 'prepend';
        $prepend = true;

        $response = $this->getResponse();
        $content = $response->getBody();

        if ($prepend) {
            $pos = strpos($content, '<head>');

            if ($pos !== false) {
                // skip the <head> tag
                $pos += 6;
            }
        }
        else {
            $pos = strpos($content, '</head>');
        }

        if (false !== $pos) {
            if ($html) {
                $content = substr($content, 0, $pos)."\n".$html.substr($content, $pos);
            }
        }

        $response->setBody($content);
    }
}
# vim: et ts=4 sw=4
