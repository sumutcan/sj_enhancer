<?php
/**
 * Created by PhpStorm.
 * User: umutcan
 * Date: 8/19/15
 * Time: 12:21 AM
 */

jimport("lib_sj.siwcms.SIWCMS");

class EntityAnnotation extends \siwcms\Enhancement {

    private $_entityRef;
    private $_textAnnotations;
    private $_entityLabel;
    private $_entityTypes = array();

    /**
     * @param bool $localname
     * @return array
     */
    public function getEntityTypes($localname=false)
    {
        if ($localname)
        {
            $localNames = array();
            foreach ($this->_entityTypes as $type){
                array_push($localNames,$type->localName());
            }

            return $localNames;
        }

        return $this->_entityTypes;
    }

    /**
     * @param array $entityTypes
     */
    public function setEntityTypes($entityTypes)
    {
        $this->_entityTypes = $entityTypes;
    }

    /**
     * @return mixed
     */
    public function getEntityLabel()
    {
        return $this->_entityLabel;
    }

    /**
     * @param mixed $entityLabel
     */
    public function setEntityLabel($entityLabel)
    {
        $this->_entityLabel = $entityLabel;
    }

    /**
     * @return mixed
     */
    public function getEntityRef()
    {
        return $this->_entityRef;
    }

    /**
     * @param mixed $entityRef
     */
    public function setEntityRef($entityRef)
    {
        $this->_entityRef = $entityRef;
    }

    /**
     * @return mixed
     */
    public function getTextAnnotations()
    {
        return $this->_textAnnotations;
    }

    /**
     * @param mixed $textAnnotations
     */
    public function setTextAnnotations(array $textAnnotations)
    {
        $this->_textAnnotations = $textAnnotations;
    }

    public function getEntityID()
    {
        return $this->_entityRef->localName();
    }

}