<?php
/**
 * @category    Joomla_Plugin
 * @package     THM_Organizer
 * @name        model.php
 * @author      Samuel Huebl, <samuel.huebl@mni.thm.de>
 * @author      James Antrim, <james.antrim@mni.thm.de>
 * @copyright   2013 TH Mittelhessen
 * @license     GNU GPL v.2
 * @link        www.mni.thm.de
 */
use siwcms\SemanticEngine;

define('_JEXEC', 1);
define('JPATH_BASE', dirname(dirname(dirname(dirname(__FILE__)))));
define('DS', DIRECTORY_SEPARATOR);

require_once JPATH_BASE . DS . 'includes' . DS . 'defines.php';
require_once JPATH_BASE . DS . 'includes' . DS . 'framework.php';

require_once "stanbolenhancer/StanbolEngineInit.php";

//jimport("lib_sj.easyrdf.lib.EasyRdf");
jimport("lib_sj.siwcms.SIWCMS");


/**
 * Class Model for subjects editor extension plugin
 *
 * @category Joomla.Plugin.Editors-XTD
 * @package  SJ
 * @author   James Antrim, <james.antrim@mni.thm.de>
 * @license  GNU GPL v.2
 * @link     www.mni.thm.de
 */
class SJModel
{
    private $_semanticEngine;

    /**
     * Constructor
     *
     * @param SemanticEngine $engine The semantic engine object
     * that is used to interact with semantic backend
     */
    public function __construct(SemanticEngine $engine)
    {
        $this->_semanticEngine = $engine;
    }

    /**
     * Loads the forwarded language into the joomla context, and loads the
     * appropriate plugin language file.
     *
     * @return string
     */
    public static function initializeLanguage()
    {
        $lang = JFactory::getLanguage();
        $languageTag = JRequest::getString('languageTag');
        $lang->setLanguage($languageTag);
        $lang->load('plg_editors-xtd_sj_enhancer', JPATH_ADMINISTRATOR);
        $languageTags = explode('-', $languageTag);
        return $languageTags[0];
    }


    /**
     * Function that enhances the text
     * @param string $text Text to be enhanced
     * @return array enhancements array
     */
    public function enhance($text)
    {
        $enhancement=$this->_semanticEngine->runModule("enhancer", "enhance", $text);

        return $enhancement;

    }

}
