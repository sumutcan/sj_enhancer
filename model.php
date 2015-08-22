<?php
/**
 * @category    Joomla plugin
 * @package     THM_Organizer
 * @subpackage  plg_thm_organizer_editor_xtd_subjects.site
 * @name        model.php
 * @author      Samuel Huebl, <samuel.huebl@mni.thm.de>
 * @author      James Antrim, <james.antrim@mni.thm.de>
 * @copyright   2013 TH Mittelhessen
 * @license     GNU GPL v.2
 * @link        www.mni.thm.de
 */
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
 * @category    Joomla.Plugin.Editors-XTD
 * @package     thm_organizer
 * @subpackage  plg_thm_organizer_editor_xtd_subjects.site
 */
class SJModel
{
    private $_enhancements = array();
    private $_semanticEngine;

    public function __construct(siwcms\SemanticEngine $engine)
    {
        $this->_semanticEngine = $engine;
    }

    /**
     * Loads the forwarded language into the joomla context, and loads the
     * appropriate plugin language file.
     *
     * @return  void
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



    public function enhance($text)
    {
       return  $this->_semanticEngine->runModule("enhancer","enhance",$text);

    }



    /**
     * @return mixed
     */
    public function getEnhancements()
    {
        return $this->_enhancements;
    }

    /**
     * @param mixed $enhancements
     */
    public function setEnhancements(array $enhancements)
    {
        $this->_enhancements = $enhancements;
    }







}
