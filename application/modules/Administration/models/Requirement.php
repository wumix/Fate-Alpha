<?php

/**
 * Description of Requirement
 *
 * @author Voß
 */
class Administration_Model_Requirement {
    
    /**
     * @var string
     */
    private $art;
    /**
     * @var int
     */
    private $requiredValue;
    
    public function getArt() {
        return $this->art;
    }

    public function getRequiredValue() {
        return $this->requiredValue;
    }

    public function setArt($art) {
        $this->art = $art;
    }

    public function setRequiredValue($requiredValue) {
        $this->requiredValue = $requiredValue;
    }
    
}
