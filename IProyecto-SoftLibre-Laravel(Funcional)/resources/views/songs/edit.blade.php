@extends('app')
@section('singers')
    @if(Auth::user()->type)
        <li><a href="/singers">Singers</a></li>
    @endif
@endsection
@section('content')
<div class="jumbotron">
<div class="container">
	<div class="row">
        {!!Form::open(array('url' => "/songs/$song->id", 'class' => 'form-horizontal', 'method' => 'PUT'))!!}
    		<fieldset>
        		<legend>Edit Singer</legend>
        		<div class="form-group">
           			<label class="col-lg-2 control-label">Name</label>
            		<div class="col-lg-10">
            			{!! Form::text('name', $song->name, array('class' => 'form-control', 'placeholder' => 'Name','required')); !!}
            		</div>
            		<label class="col-lg-2 control-label">Singer</label>
            		<div class="col-lg-10">
                		{!! Form::select('singer', $artists, 'id', array('class' => 'form-control','required')); !!}
            		</div>
        		</div>
       			<div class="form-group">
            		<div class="col-lg-8 col-lg-offset-2">
                		<a href="/songs" class="btn btn-default btn-raised">Cancel</a>
                		<button type="submit" class="btn btn-primary">Submit</button>
            		</div>
        		</div>
    		</fieldset>
		{!!Form::close()!!}
	</div>
</div>
</div>
@endsection
