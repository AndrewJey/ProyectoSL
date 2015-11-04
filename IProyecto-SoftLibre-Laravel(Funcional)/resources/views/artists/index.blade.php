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
	<div class="row">
		<table id="table" class="table table-striped table-hover"  style="width: 100%; word-wrap:break-word; table-layout: fixed;">
			<thead>
        		<tr>
            		<th>Id</th>
					<th>Name</th>
					<th>Actions</th>
        		</tr>
    		</thead>
    		@forelse($artists as $artist)
    		<tbody>
				<tr>
					<td style="width:10%">{{{ $artist->id }}}</td>
					<td style="width:60%">{{{ $artist->name }}}</td>
					<td style="width:30%">					
							<div class="form-group">
							<a href="/singers/edit/{{{$artist->id}}}" class="btn btn-primary">Edit</a>
							<button class="btn btn-danger delete-artist" data-toggle="modal" data-target="#confirm-dialog" data-id="{{{$artist->id}}}" data-name="{{{$artist->name}}}">Delete</button>
							</div>
					</td>
				</tr>
			</tbody>
			@empty
				<tr>
					<td colspan="3">No data</td>
				</tr>
			@endforelse
		</table>
	</div>

	<div id="confirm-dialog" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Delete Singer</h4>
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
	@include('pagination.default', ['paginator' => $artists])
	<p class="bs-component">
		<a href="/" class="btn btn-default btn-raised">Back</a>
		<a href="/singers/new" class="btn btn-primary btn-raised">New</a>
	</p>
</div>
@endsection

@section('scripts')
	<script src="/js/app.js"></script>
@endsection