<?php
namespace Core\Features\Menu\Entities;

class MenuEntity {
	public $id = 0;
	public $name = '';
	public $description = '';
	public $slug = '';
	public $parentId = 0;
	public $taxonomyId = 0;
	public $order = 0;
	public $location = '';
}
