<?php

/**
 * Description of IndexController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Nachrichten_IndexController extends Zend_Controller_Action {

    private $service;
    
    public function init(){
        $this->_helper->logincheck();
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
        $this->service = new Nachrichten_Service_Nachrichten();
    }
    
    public function indexAction() {
        $this->redirect('Nachrichten/inbox/');
    }
    
    public function showAction() {
        if($this->getRequest()->getParam('read') == true){
            $this->service->readMessage($this->getRequest()->getParam('id'));
        }
        $this->view->nachricht = $this->service->getNachrichtById($this->getRequest()->getParam('id'));
    }
    
    public function newAction() {
        $userService = new Application_Service_User();
        $this->view->users = $userService->getUsers();
        if($this->getRequest()->getParam('id') !== null){
            $this->view->respondTo = $this->getRequest()->getParam('id');
        }
        
    }
    
    public function sendAction() {
        $this->service->saveMessage($this->getRequest());
        $this->redirect('Nachrichten');
    }
    
    public function archivAction() {
        
    }
    
}
