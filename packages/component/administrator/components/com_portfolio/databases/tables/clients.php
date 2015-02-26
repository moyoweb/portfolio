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

}