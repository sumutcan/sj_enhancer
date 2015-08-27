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
use siwcms\Operation;
jimport("lib_sj.siwcms.SIWCMS");


/**
 * The class that extends SIWCMS Operation class and
 * manipulates the results coming from semantic engine
 *
 * @category Joomla.Plugin.Editors
 * @package  Thm_Organizer
 * @author   Umutcan Simsek, <umutcan.simsek@mni.thm.de>
 * @license  GNU GPL v.2
 * @link     www.mni.thm.de
 */
class Enhance extends Operation
{

    private  $_graphURI;
    private  $_enhancements = array();
    /**
     * Getter graph uri
     * @return string
     */
    public function getGraphURI()
    {
        return $this->_graphURI;
    }

    /**
     * Setter graph uri
     * @param mixed $graphURI uri of the graph
     * @return void
     */
    public function setGraphURI($graphURI)
    {
        $this->_graphURI = $graphURI;
    }


    /**
     * Overrides abstract processResult method in SIWCMS Operation class.
     * Loads the raw HTTP response coming from semantic engine to an RDF graph and
     * then stores it in an array
     *
     * @return array
     */
    public function processResult()
    {
        $graph = new EasyRdf_Graph($this->_graphURI, $this->getResult());
        $this->_loadEnhancements($graph);
        return $this->_enhancements;
    }

    /**
     * Set if there is any configuration or saving
     * needs to be done before operation runs
     * @return void
     */
    protected function preRun()
    {

    }

    /**
     * Processes the enhancements and loads them into an array.
     *
     * @param EasyRDF_Graph $graph RDF graph that holds the enhancements
     *
     * @return void
     */
    private function _loadEnhancements($graph)
    {
        EasyRdf_Namespace::set("stanbol", "http://fise.iks-project.eu/ontology/");
        Entity::mapType("foaf:Person", "Person");

        $entityAnnotations = $graph
            ->allOfType("http://fise.iks-project.eu/ontology/EntityAnnotation");


        foreach ($entityAnnotations as $anno) {

            $entityAnnotation = new EntityAnnotation(Entity::create($anno));
            $entityAnnotation->setId($anno->getUri());
            $entityAnnotation->setTextAnnotations(
                $this->_createTextAnnotations(
                    $anno->allResources("dc:relation")
                )
            );
            $entityAnnotation->setConfidence(
                $anno->getLiteral("stanbol:confidence")->getValue()
            );
            $entityAnnotation->setEntityLabel(
                $anno->getLiteral("stanbol:entity-label")->getValue()
            );
            $entityAnnotation->setEntityTypes(
                $anno->allResources("stanbol:entity-type")
            );
            array_push($this->_enhancements, $entityAnnotation);
        }
    }

    /**
     * Create text annotations
     * @param array $resources A collection of TextAnnotation RDF triples
     * @return array
     */
    private function _createTextAnnotations(array $resources)
    {
        $textAnnotations = array();
        foreach ($resources as $res) {
            array_push($textAnnotations, TextAnnotation::createFromRDF($res));
        }

        return $textAnnotations;
    }

}