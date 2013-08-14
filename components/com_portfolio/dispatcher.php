<?php

class ComPortfolioDispatcher extends ComDefaultDispatcher
{
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
                'controller' => 'cases'
        ));
        parent::_initialize($config);
    }
}