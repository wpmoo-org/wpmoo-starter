<?php
namespace WPMooStarter\Models;

use WPMoo\Database\Model;

/**
 * Simple Eloquent-like model for the demo "books" table.
 */
class Book extends Model {

	/**
	 * Table name (set on first construct using DB prefix).
	 *
	 * @var string
	 */
	protected $table;

	/**
	 * Primary key column.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';

	/**
	 * Set table name on first construction when missing.
	 *
	 * @param array $attributes Initial attributes.
	 */
	public function __construct( $attributes = array() ) {
		parent::__construct( $attributes );
		if ( ! isset( $this->table ) || ! $this->table ) {
			$this->table = static::$connection->prefix() . 'wpmoo_books';
		}
	}
}
