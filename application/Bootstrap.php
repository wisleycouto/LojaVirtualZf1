<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initLogger()
    {
        $this->bootstrap('log');
        Zend_Registry::set('logger', $this->getResource('log'));
    }

    /**
     * Initialize autoloader
     *
     * Use the setFallbackAutoloader() method to have the autoloader act
     * as a catch-all
     *
     * @return void
     */
    protected function _initPlaceholders() {
        $this->bootstrap("frontController");
        $this->bootstrap('View');
        $view = $this->getResource('View');
        //doctype
        $view->doctype('HTML4_STRICT');
        //meta tag
        $view->headMeta()->appendHttpEquiv('Content-Type', 'Text/html; charset=UTF-8');
        //favicon
        //$view->headLink()->headLink(array('rel' => 'shortcut icon', 'href' => $view->baseUrl('/img/animated_favicon_creadf.gif'), 'type' => 'image/x-icon', 'PREPEND'));
        //Vars Definitions
        $view->basePath = BASE_PATH;// caminho da pasta 'public'
    }

    protected function _initAutoload() {
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->setFallbackAutoloader(true);
        $loaderHelper = Zend_Loader_Autoloader::getInstance();
        $loaderHelper->registerNamespace('Helper_');
    }

    //initializing Helpers
    protected function _initHelpers() {
        // Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . '/actionHelpers');
    }

}//class

