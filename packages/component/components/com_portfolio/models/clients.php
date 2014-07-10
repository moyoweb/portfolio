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

        $this->_state
            ->insert('featured', 'int', null, true)
            ->insert('next', 'int', null, true)
            ->insert('previous', 'int', null, true)
            ->insert('slug', 'string', null, true);
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

        if ($state->next) {
            $query->where('tbl.ordering', '>', $state->next);
            $query->order('tbl.ordering', 'ASC');
            $state->next = ''; // reset because of unique state
        } else if ($state->previous) {
            $query->where('tbl.ordering', '<', $state->previous);
            $query->order('tbl.ordering', 'DESC');
            $state->previous = ''; // reset because of unique state
        }

        $query->where('tbl.enabled', '=', 1);

        parent::_buildQueryWhere($query);
     }
}