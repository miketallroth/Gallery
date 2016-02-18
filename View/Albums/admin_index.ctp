<?php

$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('gallery', 'Gallery'))
	->addCrumb(__d('gallery', 'Albums'), $this->here);

echo $this->start('actions');
	echo $this->Html->link(__d('gallery','New album'), array(
		'action'=>'add',
	), array(
		'button' => 'default',
		'icon' => 'plus',
	));
echo $this->end();

$this->append('table-heading');
	$tableHeaders =  $this->Html->tableHeaders(array(
		$this->Paginator->sort('id'),
		__d('gallery','Order number'),
		__d('gallery', 'Title'),
		__d('gallery', 'Description'),
		__d('gallery', 'Type'),
		$this->Paginator->sort('status'),
		__d('gallery', 'Actions'),
	));
	echo $tableHeaders;
$this->end();

$this->append('table-body');
	$rows = array();
	foreach ($albums as $album):
		$actions = array();
		$actions[] = $this->Croogo->adminRowAction('',
			array('controller' => 'albums', 'action' => 'moveup', $album['Album']['id']),
			array('icon' => 'arrow-up', 'tooltip' => __d('gallery', 'Move up'))
		);
		$actions[] = $this->Croogo->adminRowAction('',
			array('controller' => 'albums', 'action' => 'movedown', $album['Album']['id']), array('icon' => 'arrow-down', 'tooltip' => __d('gallery', 'Move down'))
		);
		$actions[] = $this->Html->link('',
			array('controller' => 'albums', 'action' => 'upload', $album['Album']['id']),
			array(
				'class' => 'icon-large icon-picture',
				'tooltip' => __d('gallery','Photos in album'),
			)
		);
		$actions[] = $this->Croogo->adminRowActions($album['Album']['id']);
		$actions[] = $this->Croogo->adminRowAction('',
			array('controller' => 'albums', 'action' => 'edit', $album['Album']['id']),
			array('icon' => $this->Theme->getIcon('update'), 'tooltip' => __d('gallery', 'Edit'))
		);
		$actions[] = $this->Croogo->adminRowAction('',
			array('controller' => 'albums', 'action' => 'delete', $album['Album']['id']),
			array('icon' => $this->Theme->getIcon('delete'), 'tooltip' => __d('gallery', 'Delete')),
			__d('gallery', 'Are you sure you want to delete this album?')
		);

		$rows[] = array(
			$album['Album']['id'],
			$album['Album']['position'],
			$album['Album']['title'],
			$this->Text->truncate($album['Album']['description'], 50, array(
				'html' => true
			)),
			$album['Album']['type'],
			$this->element('admin/toggle', array(
				'id' => $album['Album']['id'],
				'status' => (int)$album['Album']['status'],
			)),
			$this->Html->div('item-actions', implode(' ', $actions)),
		);
	endforeach;
$this->end();

$this->append('table-body', $this->Html->tableCells($rows));

$this->append('table-footer', $tableHeaders);