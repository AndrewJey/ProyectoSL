<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArtistsController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$artists =  \App\Models\Artist::paginate(15);
		return view('artists.index', compact('artists'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('artists.new');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		try{
			\App\Models\Artist::create(\Input::all());
			return redirect('singers')->withSuccess('Singer created!');
		} catch (\Illuminate\Database\QueryException $ABError) {
			return redirect('singers')->withWarning('Error, try again.');
		} catch (Exception $a) {
			return redirect('singers')->withWarning('Error, try again.');
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
		$singer = \App\Models\Artist::find($id);
		return view('artists.edit', compact('singer'));
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
			$singer = \App\Models\Artist::find($id);
			$name = \Input::get('name');
			$singer->name = $name;
			$singer->save();
			return redirect('singers')->withSuccess('Singer modified!');
		} catch (\Illuminate\Database\QueryException $ABError) {
			return redirect('singers')->withWarning('Error, try again.');
		} catch (Exception $a) {
			return redirect('singers')->withWarning('Error, try again.');
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
			$singer = \App\Models\Artist::find($id);
			$singer->delete();
			return redirect('singers')->withSuccess('Singer deleted!');
		} catch (\Illuminate\Database\QueryException $ABError) {
			return redirect('singers')->withWarning('Error, First delete the songs that depend on it.');
		} catch (Exception $a) {
			return redirect('singers')->withWarning('Error, try again.');
		}
	}
}