<?php
namespace WPMooStarter\Models;

use WPMoo\Database\Model;

class Book extends Model
{
    protected $table;
    protected $primaryKey = 'id';

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        if (!isset($this->table) || !$this->table) {
            $this->table = static::$connection->prefix() . 'wpmoo_books';
        }
    }
}
