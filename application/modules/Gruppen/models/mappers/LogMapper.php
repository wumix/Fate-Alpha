<?php

class Gruppen_Model_Mapper_LogMapper extends Application_Model_Mapper_LogMapper {
    
    /**
     * @param int $logId
     * @param int $gruppenId
     * @return int
     */
    public function connectGroupToLog($logId, $gruppenId) {
        $data = array(
            'logId' => $logId,
            'gruppenId' => $gruppenId,
        );
        return parent::getDbTable('LogToGruppe')->insert($data);
    }
    
    
    public function getLogsByGruppe($gruppenId) {
        $returnArray = array();
        $select = $this->getDbTable('LogToGruppe')->select();
        $select->setIntegrityCheck(false);
        $select->from('logsToGruppe');
        $select->join('logs', 'logs.logId = logsToGruppe.logId');
        $select->where('logsToGruppe.gruppenId = ?', $gruppenId);
        $result = $this->getDbTable('LogToGruppe')->fetchAll($select);
        if($result->count() > 0){
            foreach ($result as $row) {
                $log = new Application_Model_Log();
                $log->setId($row->logId);
                $log->setName($row->name);
                $log->setMd5($row->md5);
                $log->setOwner($row->owner);
                $log->setStatus($row->status);
                $log->setPlotId($row->plotId);
                $log->setCreateDate($row->createDate);
                $returnArray[] = $log;
            }
        }
        return $returnArray;
    }
    
}
