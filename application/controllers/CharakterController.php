<?php

/**
 * Description of CharakterController
 *
 * @author Vosser
 */
class CharakterController extends Zend_Controller_Action{
    
    protected $_charakterService;
    protected $_layoutService;
    
    public function init() {
        $this->_charakterService = new Application_Service_Charakter();
        $this->_layoutService = new Application_Service_Layout();
        
        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $this->redirect('index');
        }  else {
            $this->view->layoutData = $this->_layoutService->getLayoutData($auth);
            $layout->setLayout('online');
        }
    }
    
    public function indexAction() {
        
    }
    
    public function friendsAction() {
        
    }
    
    public function erstellungAction() {
        $auth = Zend_Auth::getInstance()->getIdentity();
        $layout = $this->_helper->layout();
        $layout->setLayout('empty');
        $this->view->layoutData = $this->_layoutService->getLayoutData($auth);
        $erstellungsService = new Application_Service_Erstellung();
        $this->view->creationParams = $erstellungsService->getCreationParams();
    }
    
    public function punkteAction() {
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
    }
    
    public function beschreibungAction() {
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
    public function vorteilcountAction() {
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
}