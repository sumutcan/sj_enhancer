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

/**
 * Created by PhpStorm.
 * User: umutcan
 * Date: 8/24/15
 * Time: 1:16 AM
 */

class Person extends Entity
{

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