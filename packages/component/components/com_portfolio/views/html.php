<?php

defined('KOOWA') or die('Protected resource');

class ComPortfolioViewHtml extends ComDefaultViewHtml
{
	/**
	 * @return string
	 */
	public function display()
	{
		$app	= JFactory::getApplication();
		$params = $app->getParams();



		$params	= new KConfig($app->getParams()->toArray());
		$model	= $this->getModel();
//		$model->reset();
//		$model->getState()->limit = $params->get('limit');

//		echo "<pre>";
//		print_r(get_class_methods($params));
//		echo "</pre>";
//		exit;

		$this->assign('params', $params);

		return parent::display();
	}
}