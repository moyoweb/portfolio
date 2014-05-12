<? defined('KOOWA') or die; ?>

<?= @helper('behavior.mootools'); ?>

<?= @helper('behavior.keepalive'); ?>
<?= @helper('behavior.validator'); ?>

<script src="media://lib_koowa/js/koowa.js" />

<form action="" class="form-horizontal -koowa-form" method="post">
	<div class="row-fluid">
		<div class="span8">
			<fieldset>
				<legend><?= @text('CONTENT'); ?></legend>
				<div class="control-group">
					<label class="control-label"><?= @text('TITLE'); ?></label>
					<div class="controls">
						<input class="span12 required" type="text" name="title" value="<?= @escape($client->title); ?>" placeholder="<?= @text('TITLE'); ?>" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?= @text('SLUG'); ?></label>
					<div class="controls">
						<input class="span12" type="text" name="slug" value="<?= $client->slug; ?>" placeholder="<?= @text('SLUG'); ?>" />
					</div>
				</div>
			</fieldset>

			<? if($client->cck_fieldset_id) : ?>
				<fieldset>
					<legend><?= @text('FIELDS'); ?></legend>
					<?= @service('com://admin/cck.controller.element')->cck_fieldset_id($client->cck_fieldset_id)->row($client->id)->table('portfolio_clients')->getView()->assign('row', $form)->layout('list')->display(); ?>
				</fieldset>
			<? endif; ?>
		</div>
		<div class="span4">
			<fieldset>
				<legend><?= @text('DETAILS'); ?></legend>
				<div class="control-group">
					<label class="control-label"><?= @text('START_PUBLISHING'); ?></label>
					<div class="controls">
						<?= @helper('behavior.calendar', array('date' => $client->publish_up === '0000-00-00' ? date('Y-m-d') : $client->publish_up, 'name' => 'publish_up', 'format'  => '%Y-%m-%d')); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?= @text('END_PUBLISHING'); ?></label>
					<div class="controls">
						<?= @helper('behavior.calendar', array('date' => $client->publish_down, 'name' => 'publish_down', 'format'  => '%Y-%m-%d')); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?= @text('PUBLISHED'); ?></label>
					<div class="controls">
						<?= @helper('select.booleanlist', array('name' => 'enabled', 'selected' => $client->enabled)); ?>
					</div>
				</div>
				<? if($client->isTranslateable()) : ?>
					<div class="control-group">
						<label class="control-label"><?= @text('TRANSLATED'); ?></label>
						<div class="controls">
							<?= @helper('select.booleanlist', array('name' => 'translated', 'selected' => $client->translated)); ?>
						</div>
					</div>
				<? endif; ?>
			</fieldset>

			<fieldset>
				<legend><?= @text('RELATIONS'); ?></legend>
				<div class="control-group">
					<label class="control-label"><?= @text('CATEGORY'); ?></label>

					<? if($client->isRelationable()) : ?>
						<? $test = $client->getRelation(array('type' => 'ancestors', 'filter' => array('type' => 'category')))->getIds('taxonomy_taxonomy_id'); ?>
					<? endif; ?>

					<div class="controls">
						<?= @helper('com://admin/makundi.template.helper.listbox.categories', array(
							'value' => 'taxonomy_taxonomy_id',
							'deselect' => true,
							'check_access' => true,
							'name' => 'category',
							'attribs' => array('id' => 'parent_id'),
							'selected' => $test,
							'filter' => array('type' => 'category')
						)); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?= @text('TAGS'); ?></label>
					<div class="controls">
						<?= @helper('com://admin/taxonomy.template.helper.listbox.taxonomies', array(
							'identifier' => 'com://admin/terms.model.tags',
							'name' => 'tags[]',
							'attribs' => array('multiple' => true, 'size' => 10),
							'type' => 'tag',
							'relation' => 'ancestors'
						)); ?>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
</form>