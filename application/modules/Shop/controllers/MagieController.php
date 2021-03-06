<?php

/**
 * Description of MagieController
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Shop_MagieController extends Zend_Controller_Action {
    
    /**
     * @var Application_Model_Charakter;
     */
    private $charakter;
    /**
     * @var Application_Service_Charakter;
     */
    private $charakterService;

    public function init(){
        if(!$this->_helper->logincheck()){
            $this->redirect('index/index');
        }
        $this->charakterService = new Application_Service_Charakter();
        $auth = Zend_Auth::getInstance()->getIdentity();
        $this->charakter = $this->charakterService->getCharakterByUserid($auth->userId);
        $this->charakter->setMagieschulen($this->charakterService->getMagieschulen($this->charakter->getCharakterid()));
        $this->charakter->setMagien($this->charakterService->getMagien($this->charakter->getCharakterid()));
        if($this->charakter === false){
            $this->redirect('index/index');
        }
        $config = HTMLPurifier_Config::createDefault();
        $this->view->purifier = new HTMLPurifier($config);
    }
    
    
    public function indexAction() {
        $service = new Shop_Service_Magie();
        $this->view->magieschulen = $service->getMagieschulenForCharakter($this->charakter);
    }
    
    public function unlockschoolAction() {
        $service = new Shop_Service_Magie();
        $service->unlockSchool($this->charakter, $this->getRequest()->getPost('magieschuleId'));
        $this->redirect('Shop/magie/index');
    }
    
    public function showAction() {
        $layout = $this->_helper->layout();
        $layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $this->charakter->setMagieStufe($this->charakterService->getMagieStufe($this->charakter->getCharakterid(), $this->getRequest()->getParam('id')));
        $service = new Shop_Service_Magie();
        $this->view->magien = $service->getUnlearnedMagienBySchulId($this->charakter, $this->getRequest()->getParam('id'));
        $html = $this->view->render('magie/show.phtml');
        echo json_encode(array('html' => $html));
    }
    
    public function unlockAction() {
        $this->charakter->setMagieStufe($this->charakterService->getMagieStufe($this->charakter->getCharakterid(), $this->getRequest()->getParam('id')));
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $service = new Shop_Service_Magie();
        echo json_encode($service->unlockMagie($this->charakter, $this->getRequest()->getParam('id')));
    }
    
    public function previewAction() {
        $service = new Shop_Service_Magie();
        $magie = $service->getMagieById($this->charakter, $this->getRequest()->getParam('id'));
        if($this->getRequest()->getParam('tooltip') !== null){
            $this->_helper->viewRenderer->setNoRender(true);
            $this->_helper->layout()->disableLayout();
            echo json_encode($magie);
        } else {
            $layout = $this->_helper->layout();
            $layout->setLayout('partials');
            $this->view->magie = $magie;
        }
    }
    
}
