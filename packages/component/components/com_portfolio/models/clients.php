<?php
/**
 * ComPortfolio
 *
 * @author      Joep van der Heijden <joep.van.der.heijden@moyoweb.nl>
 */

class ComPortfolioModelClients extends ComDefaultModelDefault
{
    /**
     *
     */
    public function __construct(KConfig $config)
    {
        parent::__construct($config);

        $this->_state->insert('featured', 'int', null, true);
    }

    /**
     * @param KDatabaseQuery $query
     */
    protected function _buildQueryWhere(KDatabaseQuery $query)
    {
        $state = $this->_state;

        if($state->featured) {
            $query->where('tbl.featured', '=', $state->featured);
        }

        parent::_buildQueryWhere($query);

        $query->where('tbl.enabled', '=', 1);
    }

}