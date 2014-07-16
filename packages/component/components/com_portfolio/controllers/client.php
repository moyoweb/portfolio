<?php
/**
 * Com
 *
 * @author      Dave Li <dave@moyoweb.nl>
 * @category    Nooku
 * @package     Socialhub
 * @subpackage  ...
 * @uses        Com_
 */
 
defined('KOOWA') or die('Protected resource');

class ComPortfolioControllerClient extends ComDefaultControllerDefault
{
	/**
	 * @param KConfig $config
	 */
	protected function _initialize(KConfig $config)
	{
		$config->append(array(
			'behaviors' => array(
				'com://site/translations.controller.behavior.translatable'
			)
		));

		parent::_initialize($config);
	}

}