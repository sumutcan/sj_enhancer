<?php

use siwcms\Entity;

/**
 * Created by PhpStorm.
 * User: umutcan
 * Date: 8/24/15
 * Time: 1:16 AM
 */

class Person extends Entity {

    /**
     * @param $uri
     * @param null $graph
     */
    public function __construct($graph)
    {

        parent::__construct($graph->getUri(),$graph);
    }


    function getLabelsAsString()
    {

        $labels=array();
        foreach (parent::getLabels() as $literal)
        {
            array_push($labels,$literal->getValue());
        }

        return implode(",",$labels);
    }

}