<?php namespace App\Http\Controllers;
use Redis;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Jobs\SongEnqueue;

class SongsController extends Controller {
	
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$name  = \Input::get('name');
		$title  = \Input::get('artist');
		$songs =  \App\Models\Song::search($name, $title, 15);
		return view('songs.index', compact('songs','name','title'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$artists =  \App\Models\Artist::getAll();
		return view('songs.new', compact('artists'));
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		try{
			$destinationPath = 'uploads/songs/';
			$file = \Request::file('file');
			$extension = $file->getClientOriginalExtension();
			if ($extension != 'mp3') {
				return redirect('songs/create')->withWarning('Error, File extension not supported.');
			}
			do {
    			$fileName = rand(11111,99999).'.'.$extension;
			} while (\App\Models\Song::getSongByPath($destinationPath.$fileName) != null);
			
			$file->move($destinationPath, $fileName);
			$song = new \App\Models\Song;
			$song->name = \Input::get('name');
			$song->path = $destinationPath.$fileName;
			$song->artist_id = \Input::get('singer');
			$song->save();
			return redirect('songs')->withSuccess('Song created!');
		} catch (\Illuminate\Database\QueryException $ABError) {
			return redirect('songs')->withWarning('Error, try again.');
		} catch (Exception $a) {
			return redirect('songs')->withWarning('Error, try again.');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		try{
			$song = \App\Models\Song::find($id);
			if (isset($song)) {
				return view('songs.show', compact('song'));
			}
			return redirect('songs')->withWarning('Error, try again.');
		} catch (\Illuminate\Database\QueryException $ABError) {
			return redirect('songs')->withWarning('Error, try again.');
		} catch (Exception $a) {
			return redirect('songs')->withWarning('Error, try again.');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		try{
			$artists =  \App\Models\Artist::getAll();
			$song = \App\Models\Song::find($id);
			if (isset($song) && isset($artists)) {
				return view('songs.edit', compact('song','artists'));
			}
			return redirect('songs')->withWarning('Error, try again.');
		} catch (\Illuminate\Database\QueryException $ABError) {
			return redirect('songs')->withWarning('Error, try again.');
		} catch (Exception $a) {
			return redirect('songs')->withWarning('Error, try again.');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		try{
			$song = \App\Models\Song::find($id);
			$name = \Input::get('name');
			$singer = \Input::get('singer');
			$song->name = $name;
			$song->artist_id = $singer;
			$song->save();
			return redirect('songs')->withSuccess('Song modified!');
		} catch (\Illuminate\Database\QueryException $ABError) {
			return redirect('songs')->withWarning('Error, try again.');
		} catch (Exception $a) {
			return redirect('songs')->withWarning('Error, try again.');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try{
			$song = \App\Models\Song::find($id);
			\File::Delete($song->path);
			$song->delete();
			return redirect('songs')->withSuccess('Song deleted!');
		} catch (\Illuminate\Database\QueryException $ABError) {
			return redirect('songs')->withWarning('Error, try again.');
		} catch (Exception $a) {
			return redirect('songs')->withWarning('Error, try again.');
		}
	}

	public function enqueue($id)
	{
		try{
		$song = \App\Models\Song::find($id);
		$path = url() . "/" . $song->path;
		$this->dispatch(new SongEnqueue($path));
		return redirect('songs')->withSuccess('Song enqueue!');
	} catch (\Illuminate\Database\QueryException $ABError) {
			return redirect('songs')->withWarning('Error, try again.');
		} catch (Exception $a) {
			return redirect('songs')->withWarning('Error, try again.');
		}
	}

}