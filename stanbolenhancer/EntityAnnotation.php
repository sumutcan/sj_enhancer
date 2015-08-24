<?php
/**
 * Created by PhpStorm.
 * User: umutcan
 * Date: 8/19/15
 * Time: 12:21 AM
 */

use siwcms\Entity;

jimport("lib_sj.siwcms.SIWCMS");

class EntityAnnotation extends \siwcms\Enhancement {

    private $_entity;
    private $_textAnnotations;
    private $_entityLabel;
    private $_entityTypes = array();


    /**
     * @param Entity $entity The entity to which the annotation is related.
     */
    public function __construct(Entity $entity)
    {

        $this->_entity = $entity;
    }


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
    public function getEntity()
    {
        return $this->_entity;
    }

    /**
     * @param EasyRDF_Resource $entity
     */
    public function setEntity($entity)
    {

        $this->_entity = $entity;
    }

    /**
     * @return array
     */
    public function getTextAnnotations()
    {
        return $this->_textAnnotations;
    }

    /**
     * @param array $textAnnotations
     */
    public function setTextAnnotations(array $textAnnotations)
    {
        $this->_textAnnotations = $textAnnotations;
    }



}