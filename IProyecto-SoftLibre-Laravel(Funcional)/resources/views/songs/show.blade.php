@extends('app')
@section('singers')
	@if(Auth::user()->type)
		<li><a href="/singers">Singers</a></li>
	@endif
@endsection
@section('content')
<div class="container-fluid jumbotron">
	<div class="row">
		<table id="table" class="table table-striped table-hover" style="width: 100%; word-wrap:break-word; table-layout: fixed;">
			<thead>
        		<tr>
            		<th>Id</th>
					<th>Name</th>
					<th>Singer</th>
					<th>Actions</th>
        		</tr>
    		</thead>
    		<tbody>
				<tr>
					<td style="width:10%">{{{ $song->id }}}</td>
					<td style="width:20%">{{{ $song->name }}}</td>
					<td style="width:40%">{{{ $song->artist->name }}}</td>
					<td style="width:30%">
						{!!Form::open(array('url' => "/songs/$song->id/enqueue", 'class' => 'form-inline', 'method' => 'POST'))!!}
							<div class="form-group">
							<button class="btn btn-primary">Send to queue</button>
							</div>
						{!!Form::close()!!}
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<p class="bs-component">
		<a href="/songs" class="btn btn-default btn-raised">Back</a>
	</p>
</div>
@endsection
