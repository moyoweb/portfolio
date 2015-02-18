<?php

class ComPortfolioDatabaseTableClients extends KDatabaseTableDefault
{
	protected function _initialize(KConfig $config)
	{
		$relationable = $this->getBehavior('com://admin/taxonomy.database.behavior.relationable',
			array(
				'ancestors' => array(
					'category' => array(
						'identifier' => 'com://admin/makundi.model.categories',
						'identity_column' => 'makundi_category_id',
						'table' => '#__makundi_categories',
						'sort' => 'title',
					),
					'tags' => array(
						'identifier' => 'com://admin/terms.model.tags',
					)
				)
			)
		);

		$config->append(array(
			'behaviors' => array(
				'lockable',
				'com://admin/moyo.database.behavior.creatable',
				'modifiable',
				'identifiable',
				'orderable',
				'sluggable',
				'com://admin/cck.database.behavior.elementable',
				$relationable,
				'com://admin/translations.database.behavior.translatable',
//				'com://admin/kutafuta.database.behavior.searchable',
			),
			'filters' => array(
				'fields' => array('html')
			)
		));

		parent::_initialize($config);
	}

	public function update(KDatabaseRowInterface $row)
	{
		$context = null;
		$context->data = $row;

		if($context->data->language === 'nl-NL'){
			$context->table = 'nl_portfolio_clients';

			parent::update($row);

			if(isset($context->data->order) && isset($context->data->ordering)) {
				$this->order($context);
			}
		}
		else{
			parent::update($row);

		}


	}

	public function _buildQueryWhere(KDatabaseQuery $query)
	{

	}

	public function order($context)
	{
		$change = $context->data->order;

		//force to integer
		settype($change, 'int');

		if($change !== 0)
		{

			$old = (int) $context->data->ordering;
			$new = $context->data->ordering + $change;
			$new = $new <= 0 ? 1 : $new;


			$table = $context->table;
			$db    = $this->getDatabase();
			$query = $db->getQuery();

			//Build the where query
			$this->_buildQueryWhere($query);

			$update =  'UPDATE `'.$db->getTableNeedle().$table.'` ';

			if($change < 0)
			{
				$update .= 'SET ordering = ordering+1 ';
				$query->where('ordering', '>=', $new)
					->where('ordering', '<', $old);

			}
			else
			{
				$update .= 'SET ordering = ordering-1 ';
				$query->where('ordering', '>', $old)
					->where('ordering', '<=', $new);

			}

			$update .= (string) $query;


			$db->execute($update);

			$context->data->ordering = $new;

			$this->reorder($table);
		}

	}

	public function reorder($table, $base = 0)
	{

		//force to integer
		settype($base, 'int');

		$table  = $table;
		$db     = $this->getDatabase();
		$query  = $db->getQuery();

		//Build the where query
		$this->_buildQueryWhere($query);

		if ($base)  {
			$query->where('ordering', '>=', (int) $base);
		}

		$db->execute("SET @order = $base");
		$db->execute(
			'UPDATE '.$db->getTableNeedle().$table.' '
			.'SET ordering = (@order := @order + 1) '
			.(string) $query.' '
			.'ORDER BY ordering ASC'
		);

		return $this;
	}
}