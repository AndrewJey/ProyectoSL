<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model {

	protected $table = 'artists';
	protected $primaryKey = 'id';
	protected $fillable = ['name'];

	public static function getAll(){
		return self::lists('name', 'id');
	}
}
