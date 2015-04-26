<?php

/**
 * Description of CharakterController
 *
 * @author Vosser
 */
class ErstellungController extends Zend_Controller_Action{
    
    protected $_charakterService;
    protected $_erstellungService;
    protected $_layoutService;
    protected $_validationService;

    public function init() {
        $this->_helper->viewRenderer->setNoRender(true);
        $layout = $this->_helper->layout();
        $auth = Zend_Auth::getInstance()->getIdentity();
        if($auth === null){
            $this->redirect('index');
        }  else {
            $layout->disableLayout();
        }
    }
    
    public function namevalidationAction() {
        $this->_validationService = new Application_Service_Validation();
        echo $this->_validationService->validateByRequest($this->getRequest());
    }
    
    public function infoAction() {
        $this->_erstellungService = new Application_Service_Erstellung();
        echo $this->_erstellungService->getCharakteristics($this->getRequest());
    }
    
    public function classAction() {
        $this->_erstellungService = new Application_Service_Erstellung($this->getRequest());
        echo $this->_erstellungService->getKlassengruppe($this->getRequest());
    }
    
}