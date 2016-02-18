<?php

class Application_Service_Login{
 
    public function login(Zend_Controller_Request_Http $request){
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter,'benutzerdaten', 'username', 'passwort', 'MD5(?) AND active=1');

//        $authAdapter->setTableName('benutzerdaten')
//                    ->setIdentityColumn('username')
//                    ->setCredentialColumn('passwort')
//                    ->setCredentialTreatment('MD5(?)');
//        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        
        $authAdapter->setIdentity($request->getPost('username'));
        $authAdapter->setCredential($request->getPost('passwort'));
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);
        if($result->isValid()){
            $auth->getStorage()->write($authAdapter->getResultRowObject());
            $mapper = new Application_Model_Mapper_UserMapper();
            $mapper->logAction($auth->getIdentity()->userId);
            return true;
        } else {
            switch ($result->getCode()) {
                case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
                    $this->error = 'Benutzer nicht vorhanden';
                    break;
                case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
                    $this->error = 'Passwort falsch';
                    break;
                default:
                    $this->error = 'Login fehlgeschlagen';
                    break;
            }
            return $this->error;
        }

    }
    
}

