<?php

defined('_JEXEC') or die;

class ComPortfolioRouter
{
    public static function getInstance()
    {
        static $instance;

        if (!$instance) {
            $instance = new ComPortfolioRouter();
        }

        return $instance;
    }

	public function build(&$query)
	{
		$segments	= array();

		if($query['id'] && !$query['slug']) {
			if($query['view'] == 'client') {
				$client = KService::get('com://site/portfolio.model.clients')->id($query['id'])->getItem();

				$segments['slug'] = $client->slug;
			}
		}

		return $segments;
	}

    public function parse($segments)
    {
        $vars = array();

        $menu_item = JSite::getMenu()->getItems('link', 'index.php?option=com_portfolio&view=clients', true);
        if ($menu_item) {
            $vars['Itemid'] = $menu_item->id;
        }

        return $vars;
    }
}

function PortfolioBuildRoute(&$query)
{
	return ComPortfolioRouter::getInstance()->build($query);
}

function PortfolioParseRoute($segments)
{
    return ComPortfolioRouter::getInstance()->parse($segments);
}
