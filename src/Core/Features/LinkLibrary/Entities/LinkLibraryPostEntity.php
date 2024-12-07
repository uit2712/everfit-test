<?php
namespace Core\Features\LinkLibrary\Entities;

/**
 * @OA\Schema()
 */
class LinkLibraryPostEntity {
	/**
	 * @OA\Property(type="number")
	 */
	public $id = 0;
	/**
	 * @OA\Property(type="string")
	 */
	public $title = '';
	/**
	 * @OA\Property(type="string")
	 */
	public $createdDate = '';
	/**
	 * @OA\Property(type="string")
	 */
	public $url = '';
	/**
	 * @OA\Property(type="string")
	 */
	public $description = '';
	/**
	 * @OA\Property(type="string")
	 */
	public $largeDescription = '';
	/**
	 * @OA\Property(type="string")
	 */
	public $image = '';
	/**
	 * @OA\Property(type="number")
	 */
	public $price = 0;
	/**
	 * @OA\Property(type="string")
	 */
	public $priceCurrency = '';
	/**
	 * @OA\Property(type="string")
	 */
	public $email = '';
	/**
	 * @OA\Property(type="string")
	 */
	public $phone = '';
	/**
	 * @OA\Property(type="string")
	 */
	public $notes = '';
}
