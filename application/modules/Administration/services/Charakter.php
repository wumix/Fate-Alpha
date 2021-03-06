<?php

/**
 * Description of Administration_Service_Charakter
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Administration_Service_Charakter extends Application_Service_Charakter {

    /**
     * @param Zend_Controller_Request_Http $request
     *
     * @return int
     * @throws Exception
     */
    public function saveCharakterData(Zend_Controller_Request_Http $request) {
        $charakter = new Application_Model_Charakter();
        $charakter->setCharakterid($request->getPost('charakterId'));
        
        $charakter->setVorname($request->getPost('vorname'));
        $charakter->setNachname($request->getPost('nachname'));
        $charakter->setNickname($request->getPost('nickname'));
        $charakter->setAugenfarbe($request->getPost('augenfarbe'));
        $charakter->setGeburtsdatum($request->getPost('geburtsdatum'));
        $charakter->setGeschlecht($request->getPost('geschlecht'));
        $charakter->setSexualitaet($request->getPost('sex'));
        $charakter->setSize($request->getPost('size'));
        
        $odo = new Application_Model_Odo();
        $odo->setId($request->getPost('odo'));
        $charakter->setOdo($odo);
        
        $element = new Application_Model_Element();
        $element->setId($request->getPost('element'));
        $charakter->setNaturElement($element);
        
        $luck = new Application_Model_Luck();
        $luck->setId($request->getPost('luck'));
        $charakter->setLuck($luck);
        
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->editCharakter($charakter);
    }
    
    
    public function saveCharakterWerte(Zend_Controller_Request_Http $request) {
        $charakter = new Application_Model_Charakter();
        $charakter->setCharakterid($request->getPost('charakterId'));
        
        $charakterWerte = new Application_Model_Charakterwerte();
        $charakterWerte->setStaerke($request->getPost('staerke'));
        $charakterWerte->setAgilitaet($request->getPost('agilitaet'));
        $charakterWerte->setAusdauer($request->getPost('ausdauer'));
        $charakterWerte->setKontrolle($request->getPost('kontrolle'));
        $charakterWerte->setDisziplin($request->getPost('disziplin'));
        $charakterWerte->setUebung($request->getPost('uebung'));
        $charakterWerte->setFp($request->getPost('fp'));
        $charakterWerte->setStartpunkte($request->getPost('bonustage'));
        
        $charakter->setCharakterwerte($charakterWerte);
        
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->editCharakterWerte($charakter);
    }
    
    
    public function getCharaktersByNextBirthdays() {
        $mapper = new Application_Model_Mapper_CharakterMapper();
        return $mapper->getCharaktersOrderedByNextBirthday();
    }
    
}
