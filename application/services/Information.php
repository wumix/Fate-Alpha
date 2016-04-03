<?php

/**
 * Description of Information
 *
 * @author Vosser
 */
class Application_Service_Information {
    
    /**
     * @var Application_Model_Charakter
     */
    private $charakter;
    /**
     * @var Application_Service_Requirement
     */
    private $requirementValidator;
    
    /**
     * @param Application_Model_Charakter $charakter
     */
    public function setCharakter(Application_Model_Charakter $charakter) {
        $this->charakter = $charakter;
        $this->requirementValidator = new Application_Service_Requirement($charakter);
    }
    
    /**
     * @param Zend_Controller_Request_Http $request
     * @param int $userId
     * @return boolean | Application_Model_Information
     */
    public function getInformation(Zend_Controller_Request_Http $request, $userId) {
        $charakterService = new Application_Service_Charakter();
        $mapper = new Application_Model_Mapper_InformationMapper();
        $charakter = $charakterService->getCharakterByUserid($userId);
        if($charakter !== false){
            $this->setCharakter($charakter);
        }
        $information = $mapper->getInformation($request->getParam('id'));
        $information->setRequirementList($mapper->getRequirements($information->getInformationId()));
        if($this->checkValidation($information) === true){
            return $information;
        }else{
            return false;
        }
    }
    
    /**
     * @return array
     */
    public function getInformations() {
        $mapper = new Application_Model_Mapper_InformationMapper();
        $informations = $mapper->getInformations();
        foreach ($informations as $information) {
            
        }
        return $informations;
    }
    
    
    private function checkValidation(Application_Model_Information $information){
        return true;
    }
    
}