@extends('app')
@section('singers')
	@if(Auth::user()->type)
		<li><a href="/singers">Singers</a></li>
	@endif
@endsection
@section('content')
<div class="container-fluid jumbotron">
	@if ( Session::has( 'warning' ) )
	<div class="alert alert-dismissable alert-danger">
		<button type="button" class="close" data-dismiss="alert">×</button>
		{{{ Session::get( 'warning' ) }}}
	</div>
	@elseif ( Session::has( 'success' ) )
	<div class="alert alert-dismissable alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		{{{ Session::get( 'success' ) }}}
	</div>
	@endif
	<div class="col-md-12">
		<div class="widget-head search_toggle">
			<button type="button" class="pull-left btn btn-primary" data-container="body">Advanced Search</button>
			<div class="clearfix"></div>
		</div>
		<div class="search_songs {{{isset($name) ? '': 'active_search'}}}">
			{!! Form::open(array('method' => 'GET','url' => "/songs", 'class'=>'form-horizontal margin-l-15')) !!}
			<div class="form-group">
				{!! Form::label('name', 'Name', array('class' => 'control-label col-lg-2')) !!}
				<div class="col-lg-10">
				{!! Form::text('name', isset($name) ? $name : null, array('class'=>'form-control', 'placeholder' => 'Name' )) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('artist', 'Singer', array('class' => 'control-label col-lg-2')) !!}
				<div class="col-lg-10">
				{!! Form::text('artist', isset($title) ? $title : null, array('class'=>'form-control', 'placeholder' => 'Singer' )) !!}
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-6 col-lg-offset-6 text-right">
					{!! Form::submit('Search',array('class'=>'btn btn-sm btn-primary pull-right btn-m-1')) !!}
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
	<div class="row">
		<table id="table" class="table table-striped table-hover" style="width: 100%; word-wrap:break-word; table-layout: fixed;">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Singer</th>
					@if(Auth::user()->type)<th>Actions</th>@endif
				</tr>
			</thead>
			@forelse($songs as $song)
			<tbody>
				<tr>
					<td style="width:10%">{{{ $song->id }}}</td>
					<td style="width:20%">{{{ $song->name }}}</td>
					<td style="width:30%">{{{ $song->artist }}}</td>
					<td style="width:40%">
						<p class="bs-component">
							<a href="/songs/{{{ $song->id }}}" class="btn btn-primary">Show</a>
					@if(Auth::user()->type)
							<a href="/songs/{{{$song->id}}}/edit" class="btn btn-primary">Edit</a>
							<button class="btn btn-danger delete-song" data-toggle="modal" data-target="#confirm-dialog" data-id="{{{$song->id}}}" data-name="{{{$song->name}}}">Delete</button>
					@endif
						</p>
					</td>
				</tr>
			</tbody>
			@empty
			<tr>
				<td colspan="4">No data</td>
			</tr>
			@endforelse
		</table>
	</div>

	<div id="confirm-dialog" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Delete Song</h4>
				</div>
				<div class="modal-body">
					<p id="name-delete">Are you sure you want to delete </p>
				</div>
				<div class="modal-footer">
					<p class="bs-component">
						<button class="btn btn-primary" data-dismiss="modal">Cancel</button>
						{!!Form::open(array('url' => "#", 'id' => 'modal', 'class' => 'form-inline', 'method' => 'DELETE'))!!}
						<button class="btn btn-danger">Delete</button>
						{!!Form::close()!!}
					</p>
				</div>
			</div>
		</div>
	</div>

	@include('pagination.default', ['paginator' => $songs])
	@if(Auth::user()->type)
		<p class="bs-component">
			<a href="/songs/create" class="btn btn-primary btn-raised">New</a>
		</p>
	@endif
</div>
@endsection

@section('scripts')
	<script src="/js/app.js"></script>
@endsection