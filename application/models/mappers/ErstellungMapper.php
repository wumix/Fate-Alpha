<?php

/**
 * Description of ErstellungMapper
 *
 * @author Philipp Voß <voss.ph@web.de>
 */
class Application_Model_Mapper_ErstellungMapper
{

    /**
     * @param $tablename
     *
     * @return Zend_Db_Table_Abstract
     * @throws Exception
     */
    public function getDbTable ($tablename): Zend_Db_Table_Abstract
    {
        $className = 'Application_Model_DbTable_' . $tablename;
        if (!class_exists($className)) {
            throw new Exception('Falsche Tabellenadapter angegeben');
        }
        $dbTable = new $className();
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        return $dbTable;
    }


    public function getVorteilIncompatibilities ($vorteilIds = null, $nachteilIds = null)
    {
        $disabledVorteile = [];
        foreach ($vorteilIds as $vorteilId) {
            $select1 = $this->getDbTable('VorteilToVorteil')->select();
            $select1->from('inkVorteilToVorteil', ['id' => 'vorteilId2']);
            $select1->where('vorteilId1 = ?', $vorteilId);

            $select2 = $this->getDbTable('VorteilToVorteil')->select();
            $select2->from('inkVorteilToVorteil', ['id' => 'vorteilId1']);
            $select2->Where('vorteilId2 = ?', $vorteilId);

            $select = $this->getDbTable('VorteilToVorteil')->select();
            $select->union([$select1, $select2]);
            $result = $this->getDbTable('VorteilToVorteil')->fetchAll($select);
            if ($result->count() > 0) {
                foreach ($result as $row) {
                    $disabledVorteile[] = $row->id;
                }
            }
        }
        foreach ($nachteilIds as $nachteilId) {
            $select = $this->getDbTable('NachteilToVorteil')->select();
            $select->from('inkNachteilToVorteil', ['id' => 'vorteilId']);
            $select->where('nachteilId = ?', $nachteilId);

            $result = $this->getDbTable('NachteilToVorteil')->fetchAll($select);
            if ($result->count() > 0) {
                foreach ($result as $row) {
                    $disabledVorteile[] = $row->id;
                }
            }
        }
        return $disabledVorteile;
    }

    public function getNachteilIncompatibilities ($nachteilIds = null, $vorteilIds = null)
    {
        $disabledNachteile = [];
        foreach ($nachteilIds as $nachteilId) {
            $select1 = $this->getDbTable('NachteilToNachteil')->select();
            $select1->from('inkNachteilToNachteil', ['id' => 'nachteilId2']);
            $select1->where('nachteilId1 = ?', $nachteilId);

            $select2 = $this->getDbTable('NachteilToNachteil')->select();
            $select2->from('inkNachteilToNachteil', ['id' => 'nachteilId1']);
            $select2->Where('nachteilId2 = ?', $nachteilId);

            $select = $this->getDbTable('NachteilToNachteil')->select();
            $select->union([$select1, $select2]);
            $result = $this->getDbTable('NachteilToNachteil')->fetchAll($select);
            if ($result->count() > 0) {
                foreach ($result as $row) {
                    $disabledNachteile[] = $row->id;
                }
            }
        }
        foreach ($vorteilIds as $vorteilId) {
            $select = $this->getDbTable('VorteilToNachteil')->select();
            $select->from('inkVorteilToNachteil', ['id' => 'nachteilId']);
            $select->where('vorteilId = ?', $vorteilId);

            $result = $this->getDbTable('VorteilToNachteil')->fetchAll($select);
            if ($result->count() > 0) {
                foreach ($result as $row) {
                    $disabledNachteile[] = $row->id;
                }
            }
        }
        return $disabledNachteile;
    }

    public function getAllNachteile ()
    {
        $return = [];
        $select = $this->getDbTable('Nachteil')->select();
        $result = $this->getDbTable('Nachteil')->fetchAll($select);
        foreach ($result as $row) {
            $model = new Application_Model_Nachteil();
            $model->setId($row->nachteilId);
            $model->setBezeichnung($row->name);
            $model->setBeschreibung($row->beschreibung);
            $model->setKosten($row->kosten);
            $return[] = $model;
        }
        return $return;
    }

    /**
     * @return Application_Model_Klasse[]
     */
    public function getAllClasses (): array
    {
        try {
            $select = $this->getDbTable('Klasse')->select();
            $result = $this->getDbTable('Klasse')->fetchAll($select);
        } catch (Exception $exception) {
            return [];
        }
        $return = [];
        foreach ($result as $row) {
            $model = new Application_Model_Klasse();
            $model->setId($row->klassenId);
            $model->setBezeichnung($row->klasse);
            $model->setBeschreibung($row->beschreibung);
            $model->setKosten($row->kosten);
            $model->setGruppe($row->klassengruppenId);
            $return[] = $model;
        }
        return $return;
    }

    public function getAllClassgroups ()
    {
        $select = $this->getDbTable('Klassengruppe')->select();
        $result = $this->getDbTable('Klassengruppe')->fetchAll($select);
        if ($result->count() > 0) {
            $return = [];
            foreach ($result as $row) {
                $model = new Application_Model_Klassengruppe();
                $model->setId($row->klassengruppenId);
                $model->setBezeichnung($row->name);
                $model->setBeschreibung($row->beschreibung);
                $return[] = $model;
            }
            return $return;
        } else {
            return null;
        }
    }

    public function getAllCircuits ()
    {
        $select = $this->getDbTable('Circuit')->select();
        $result = $this->getDbTable('Circuit')->fetchAll($select);
        if ($result->count() > 0) {
            $return = [];
            foreach ($result as $row) {
                $model = new Application_Model_Circuit();
                $model->setId($row->circuitId);
                $model->setKategorie($row->kategorie);
                $model->setBeschreibung($row->besonderheit);
                $model->setMenge($row->menge);
                $model->setKosten($row->kosten);
                $return[] = $model;
            }
            return $return;
        } else {
            return null;
        }
    }

    public function getAllLuckvalues ()
    {
        $select = $this->getDbTable('Luck')->select();
        $result = $this->getDbTable('Luck')->fetchAll($select);
        if ($result->count() > 0) {
            $return = [];
            foreach ($result as $row) {
                $model = new Application_Model_Luck();
                $model->setId($row->luckId);
                $model->setKategorie($row->kategorie);
                $model->setBeschreibung($row->beschreibung);
                $model->setKosten($row->kosten);
                $return[] = $model;
            }
            return $return;
        } else {
            return null;
        }
    }

    /**
     * @return Application_Model_Element[]
     */
    public function getAllElements (): array
    {
        try {
            $select = $this->getDbTable('Element')->select();
            $result = $this->getDbTable('Element')->fetchAll($select);
        } catch (Exception $exception) {
            return [];
        }
        $return = [];
        foreach ($result as $row) {
            $model = new Application_Model_Element();
            $model->setId($row->elementId);
            $model->setBezeichnung($row->name);
            $model->setBeschreibung($row->beschreibung);
            $model->setCharakterisierung($row->charakterisierung);
            $return[] = $model;
        }
        return $return;
    }

    public function getAllOdo ()
    {
        $select = $this->getDbTable('Odo')->select();
        $result = $this->getDbTable('Odo')->fetchAll($select);
        if ($result->count() > 0) {
            $return = [];
            foreach ($result as $row) {
                $model = new Application_Model_Odo();
                $model->setId($row->odoId);
                $model->setKategorie($row->kategorie);
                $model->setAmount($row->menge);
                $model->setKosten($row->kosten);
                $return[] = $model;
            }
            return $return;
        } else {
            return null;
        }
    }

    /**
     * @param Application_Model_Charakter $charakter
     *
     * @return Erstellung_Model_Unterklasse[]
     * @throws Exception
     */
    public function getUnterklassenForCharakter (Application_Model_Charakter $charakter): array
    {
        $returnArray = [];
        $select = $this->getDbTable('Charakter')->select();
        $select->setIntegrityCheck(false);
        $select->from('charakter');
        $select->joinInner('klassen', 'charakter.klassengruppenId = klassen.klassengruppenId');
        $select->where('charakter.charakterId = ?', $charakter->getCharakterid());
        $result = $this->getDbTable('Charakter')->fetchAll($select);
        foreach ($result as $row) {
            if ($row->maxCount > 0) {
                $select = $this->getDbTable('Charakter')->select();
                $select->from('charakter');
                $select->where('klassenId = ? and active = 1', $row->klassenId);
                $result = $this->getDbTable('Charakter')->fetchAll($select);
                if ($result->count() >= $row->maxCount) {
                    continue;
                }
            }
            $klasse = new Erstellung_Model_Unterklasse();
            $klasse->setId($row->klassenId);
            $klasse->setBezeichnung($row->klasse);
            $klasse->setBeschreibung($row->beschreibung);
            $klasse->setKosten($row->kosten);
            $klasse->setFamilienname($row->familienname);
            $returnArray[] = $klasse;
        }

        return $returnArray;
    }

    /**
     * @param int $unterklassenId
     *
     * @return Erstellung_Model_Requirementlist
     * @throws Exception
     */
    public function getUnterklassenRequirements ($unterklassenId): Erstellung_Model_Requirementlist
    {
        $requirementList = new Erstellung_Model_Requirementlist();
        $select = $this->getDbTable('KlasseVoraussetzung')->select();
        $select->where('unterklassenId = ?', $unterklassenId);
        $result = $this->getDbTable('KlasseVoraussetzung')->fetchAll($select);
        foreach ($result as $row) {
            $requirement = new Erstellung_Model_Requirement();
            $requirement->setArt($row->art);
            $requirement->setRequiredValue($row->voraussetzung);
            $requirementList->addRequirement($requirement);
        }
        return $requirementList;
    }

}
