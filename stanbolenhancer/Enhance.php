<?php
use siwcms\Entity;
use siwcms\Operation;
jimport("lib_sj.siwcms.SIWCMS");
/**
 * Created by PhpStorm.
 * User: umutcan
 * Date: 8/21/15
 * Time: 1:44 PM
 */

class Enhance extends Operation {

    private  $_graphURI;
    private  $_enhancements = array();
    /**
     * @return mixed
     */
    public function getGraphURI()
    {
        return $this->_graphURI;
    }

    /**
     * @param mixed $graphURI
     */
    public function setGraphURI($graphURI)
    {
        $this->_graphURI = $graphURI;
    }


    public function processResult()
    {
        $graph = new EasyRdf_Graph($this->_graphURI,$this->getResult());
        $this->loadEnhancements($graph);
        return $this->_enhancements;
    }

    /**
     *Set if there is any configuration or saving needs to be done before operation runs
     */
    protected function preRun()
    {

    }

    /**
     * Processes the enhancements are loads them into an array.
     *
     * @param $graph
     */
    private function loadEnhancements($graph)
    {
        EasyRdf_Namespace::set("stanbol","http://fise.iks-project.eu/ontology/");
        Entity::mapType("foaf:Person","Person");

        $textAnnotations = $graph->allOfType("http://fise.iks-project.eu/ontology/TextAnnotation");
        $entityAnnotations = $graph->allOfType("http://fise.iks-project.eu/ontology/EntityAnnotation");


        foreach ($entityAnnotations as $anno)
        {

            $entityAnnotation = new EntityAnnotation(Entity::create($anno));
            $entityAnnotation->setId($anno->getUri());
            $entityAnnotation->setTextAnnotations($this->createTextAnnotations($anno->allResources("dc:relation")));
           // $entityAnnotation->setEntity();
            $entityAnnotation->setConfidence($anno->getLiteral("stanbol:confidence")->getValue());
            $entityAnnotation->setEntityLabel($anno->getLiteral("stanbol:entity-label")->getValue());
            $entityAnnotation->setEntityTypes($anno->allResources("stanbol:entity-type"));
            array_push($this->_enhancements,$entityAnnotation);
        }
    }

    private function createTextAnnotations(array $resources)
    {
        $textAnnotations = array();
        foreach ($resources as $res) {
            array_push($textAnnotations, TextAnnotation::createFromRDF($res));
        }

        return $textAnnotations;
    }

}