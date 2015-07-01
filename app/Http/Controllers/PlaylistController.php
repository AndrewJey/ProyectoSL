<?php

namespace App\Http\Controllers;

use DB;
use Session;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PlaylistController extends Controller {

    private $table = 'playlist';
    private $songsPlaylist = 'songsinplaylist';
    
    ///Index Action
    public function index() {
        
        Session::put('user_id', '10');
        
        ///gets the PlayLists for the given user
        $user_play_list = DB::table($this->table)->orderBy('name', 'asc')->get();
        
        ///Data used in the view
        $view_data = ['userPlaylists' => $user_play_list];

        return view('playlist.index', $view_data);
    }

    public function create() {

        return view('playlist.create');
    }

    public function createPost(Request $request) {
        
        ///Gets the Values from the form
        $name = $request->input('name');
        $user_id = Session::get('user_id');
        
        ///Inserts in the Db
        $new_id = DB::table($this->table)->insertGetId(array('name' => $name, 'users_id' => $user_id));
                
        ///Return the index view
        return Redirect::action('PlaylistController@index');
    }
    
    public function edit($playlist_id) {

        ///Gets the play list data
        $play_list = DB::table('playlist')->where('id', $playlist_id)->first();
        
        ///Data used in the view
        $view_data = ['playlist' => $play_list];
        
        return view('playlist.edit', $view_data);
    }
    
    public function editPost(Request $request) {
        
        ///Gets the Values from the form
        $name = $request->input('name');
        $playlist_id = $request->input('playlist_id');
        
        ///Inserts in the Db
        DB::table($this->table)
            ->where('id', $playlist_id)
            ->update(array('name' => $name));
            
        ///Return the index view
        return Redirect::action('PlaylistController@index');
    }

    public function delete($playlist_id) {

        ///Gets the play list data
        $play_list = DB::table($this->table)->where('id', $playlist_id)->first();
        
        ///Data used in the view
        $view_data = ['playlist' => $play_list];
        
        return view('playlist.delete', $view_data);
    }
    
    public function deletePost(Request $request) {
        
        ///Gets the Values from the form
        $playlist_id = $request->input('playlist_id');
        
        ///Inserts in the Db
        DB::table($this->table)
            ->where('id', $playlist_id)
            ->delete();
            
        ///Return the index view
        return Redirect::action('PlaylistController@index');
    }
    
    public function manageSongs($playlist_id) {
        $user_id = Session::get('user_id');
        
        $user_songs = DB::table('song')
                ->where('user_id', $user_id)
                ->get();
        
        $playlist_songs = DB::table($this->songsPlaylist)
                ->where('id_playlist', $playlist_id)
                ->get();
        
        $view_data = ['playlist_id' => $playlist_id,
            'user_songs' => $user_songs,
            'playlist_songs' => $playlist_songs];
        
        return view('playlist.manageSongs', $view_data);
    }
    
    public function saveSongs(Request $request) {
        
        $playlist_id = $request->input('playlist_id');
        $songs = $request->input('songs');
        
        DB::table($this->songsPlaylist)
            ->where('id_playlist', $playlist_id)
            ->delete();
        
        foreach ($songs as $song) {
        
            DB::table($this->songsPlaylist)
                    ->insert(array('id_song'=> $song,
                        'id_playlist'=>$playlist_id));
        }
        
        return Redirect::action('PlaylistController@manageSongs', [$playlist_id]);
    }
}
