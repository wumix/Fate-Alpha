<?php

/**
 * Description of Schule
 *
 * @author Vosser
 */
class Shop_Model_Schule extends Application_Model_Schule {
    
    /**
     * @var bool
     */
    private $learned;
    /**
     * @var Shop_Model_Requirementlist
     */
    private $requirementList;
    
    public function getLearned() {
        return $this->learned;
    }

    public function setLearned($learned) {
        $this->learned = $learned;
    }
    
    public function getRequirementList() {
        return $this->requirementList;
    }

    public function setRequirementList(Shop_Model_Requirementlist $requirementList) {
        $this->requirementList = $requirementList;
    }
    
}
