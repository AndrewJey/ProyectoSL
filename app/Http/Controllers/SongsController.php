<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use DB;
use Session;
use Redirect;
use Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

/**
 * Description of SongsController
 *
 * @author dgutierrez-as
 */
class SongsController extends Controller {
    //put your code here
    private $table = 'song';
    
    ///Index Action
    public function index() {
        
        Session::put('user_id', '10');
        
        ///gets the PlayLists for the given user
        $songs = DB::table($this->table)->orderBy('id', 'asc')->get();
        
        ///Data used in the view
        $view_data = ['songs' => $songs];

        return view('songs.index', $view_data);
    }

    public function create() {

        return view('songs.create');
    }

    public function createPost(Request $request) {
        
        ///Gets the Values from the form
        $name = $request->input('name');
        $author = $request->input('author');
        $gender = $request->input('gender');
        $file = $request->file('file');
        $public = $request->input('public');
        
        if ($public) {
            $public = 1;
        }
        else {
            $public = 0;
        }
        
        $user_id = Session::get('user_id');
        
        ///Inserts in the Db
        $new_id = DB::table($this->table)->insertGetId(
                array(
                    'name' => $name,
                    'author' => $author,
                    'gender' => $gender,
                    'public' => $public,
                    'user_id' => $user_id
                    ));
        
        $new_file_name = 'file_' . $new_id . '.' . $file->getExtension();

        DB::table($this->table)->where('id', $new_id )
                ->update(array(
                    'file' => $new_file_name
                    ));
        
        //$extension = $file->getExtension();
        //Storage::disk('/../app/storage')->put('patito.txt',  File::get($file));
        Storage::disk('local')->put($new_file_name, File::get($file));
        ///Return the index view
        return Redirect::action('SongsController@index');
    }
    
    public function edit($song_id) {

        ///Gets the play list data
        $song = DB::table($this->table)->where('id', $song_id)->first();
        
        ///Data used in the view
        $view_data = ['song' => $song];
        
        return view('songs.edit', $view_data);
    }
    
    public function editPost(Request $request) {
        
        DB::disableQueryLog();
        ///Gets the Values from the form
        $id = $request->input('id');
        $name = $request->input('name');
        $author = $request->input('author');
        $gender = $request->input('gender');
        $file = $request->file('file');
        $public = $request->input('public');
        
        if ($public) {
            $public = 1;
        }
        else {
            $public = 0;
        }
        
        ///Inserts in the Db
        DB::table($this->table)->where('id', $id)
                ->update(array(
                    'name' => $name,
                    'author' => $author,
                    'gender' => $gender,
                    'public' => $public
                    ));
        
        if($file !== null){
            
            Storage::disk('local')->put('file_'. $id .'.tmp', File::get($file));
        }
        ///Return the index view
        return Redirect::action('SongsController@index');
    }

    public function delete($song_id) {
        ///Gets the play list data
        $song = DB::table($this->table)->where('id', $song_id)->first();
        
        ///Data used in the view
        $view_data = ['song' => $song];
        
        return view('songs.delete', $view_data);
    }
    
    public function deletePost(Request $request) {
        
        ///Gets the Values from the form
        $song_id = $request->input('id');
        
        ///Inserts in the Db
        DB::table($this->table)
            ->where('id', $song_id)
            ->delete();
        
        Storage::delete('file_'. $song_id .'.tmp');
            
        ///Return the index view
        return Redirect::action('SongsController@index');
    }
    
    public function getSong($song_id){
        //PDF file is stored under project/public/download/info.pdf
        $file = storage_path() .'/app/'. DB::table($this->table)->where('id', $song_id)->pluck('file');
        $headers = array(
              'Content-Type: application/mp3',
            );
        return Response::download($file, '', $headers);
    }
}
