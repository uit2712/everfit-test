<?php
namespace Core\Features\Post\Entities;

class PostEntity {
	public $id = 0;
	public $firstAuthorId = 0;
	public $secondAuthorId = 0;
	public $createdDate = '';
	public $createdDateGmt = '';
	public $publishedDate = '';
	public $publishedDateGmt = '';
	public $content = '';
	public $title = '';
	public $excerpt = '';
	public $url = '';
	public $thumbnail = '';
	public $thumbnailFull = '';
	public $thumbnailMedium = '';
	public $thumbnailLarge = '';
	/**
	 * @var string $status Status. Ref: `PostStatus`.
	 */
	public $status = '';
	public $name = '';
	public $modifiedDate = '';
	public $modifiedDateGmt = '';
	/**
	 * @var string $type Type. Ref: `PostType`.
	 */
	public $type = '';
	public $guid = '';
}
