<?php
/**
 * Semantic Joomla! Enhancer Plugin
 *
 * @category  Joomla_Plugin
 * @package   SJ
 * @name      plgButtonSJ_Enhancer_Editors_XTD
 * @author    Umutcan Simsek, <umutcan.simsek@mni.thm.de>
 * @copyright 2015 TH Mittelhessen
 * @license   GNU GPL v.2
 * @link      www.mni.thm.de
 */

use siwcms\Entity;

jimport("lib_sj.siwcms.SIWCMS");

/**
 * The class that extends SIWCMS Enhancement class stores stanbol entity annotations
 *
 * @category Joomla.Plugin.Editors
 * @package  Thm_Organizer
 * @author   Umutcan Simsek, <umutcan.simsek@mni.thm.de>
 * @license  GNU GPL v.2
 * @link     www.mni.thm.de
 */
class EntityAnnotation extends \siwcms\Enhancement
{

    private $_entity;
    private $_textAnnotations;
    private $_entityLabel;
    private $_entityTypes = array();


    /**
     * Constructor
     * @param Entity $entity The entity to which the annotation is related.
     */
    public function __construct(Entity $entity)
    {

        $this->_entity = $entity;
    }


    /**
     * Returns the types of the entity
     * @param bool $localname boolean flag
     * that determines whether full uri will be returned
     * @return array
     */
    public function getEntityTypes($localname=false)
    {
        if ($localname) {
            $localNames = array();
            foreach ($this->_entityTypes as $type) {
                array_push($localNames, $type->localName());
            }

            return $localNames;
        }

        return $this->_entityTypes;
    }

    /**
     * Setter
     *
     * @param array $entityTypes types of entities
     *
     * @return void
     */
    public function setEntityTypes($entityTypes)
    {
        $this->_entityTypes = $entityTypes;
    }

    /**
     * Getter
     *
     * @return mixed
     */
    public function getEntityLabel()
    {
        return $this->_entityLabel;
    }

    /**
     * Setter
     *
     * @param string $entityLabel label of the entity
     *
     * @return void
     */
    public function setEntityLabel($entityLabel)
    {
        $this->_entityLabel = $entityLabel;
    }

    /**
     * Getter
     *
     * @return Entity
     */
    public function getEntity()
    {
        return $this->_entity;
    }

    /**
     * Setter
     *
     * @param Entity $entity the entity that is related to annotation
     *
     * @return void
     */
    public function setEntity($entity)
    {

        $this->_entity = $entity;
    }

    /**
     * Getter
     *
     * @return array
     */
    public function getTextAnnotations()
    {
        return $this->_textAnnotations;
    }

    /**
     * Setter
     *
     * @param array $textAnnotations Occurences of the entity
     * in the content (text annotations)
     *
     * @return void
     */
    public function setTextAnnotations(array $textAnnotations)
    {
        $this->_textAnnotations = $textAnnotations;
    }



}