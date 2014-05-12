<?php

class ComPortfolioDispatcher extends ComDefaultDispatcher
{
    /**
     * @param KConfig $config
     */
    protected function _initialize(KConfig $config)
    {
        $config->append(array(
            'controller' => 'clients',
        ));

        parent::_initialize($config);
    }
}