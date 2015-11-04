<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model {

	protected $table = 'songs';

	protected $fillable = ['artist_id','name','path'];

	public function artist()
    {
    	return $this->belongsTo('\App\Models\Artist');
    }

    public static function search($name, $title, $paginate){
    	$songs = self::select('songs.id','artists.name as artist','songs.name')
    				->where('songs.name','like',"%".$name."%")
					->join('artists', 'artists.id', '=' , 'songs.artist_id')
                    ->Where('artists.name','like',"%".$title."%");
        return $songs->paginate($paginate);
    }

    public static function getSongByPath($path){
        return self::select('*')->where('songs.path', $path)->first();
    }
}