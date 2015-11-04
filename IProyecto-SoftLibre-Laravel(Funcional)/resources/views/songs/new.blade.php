@extends('app')
@section('singers')
    @if(Auth::user()->type)
        <li><a href="/singers">Singers</a></li>
    @endif
@endsection
@section('content')
<div class="jumbotron">
<div class="container">
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
		{!!Form::open(array('url' => "/songs", 'class' => 'form-horizontal', 'method' => 'POST', 'files' => true))!!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    		<fieldset>
        		<legend>New Songs</legend>
        		<div class="form-group">
           			<label class="col-lg-2 control-label">Name</label>
            		<div class="col-lg-10">
            			{!! Form::text('name','',array('class' => 'form-control', 'placeholder' => 'Name','required')); !!}
            		</div>
            		<label class="col-lg-2 control-label">Singer</label>
            		<div class="col-lg-10">
                		{!! Form::select('singer', $artists, 'id', array('class' => 'form-control','required')); !!}
            		</div>
            		<label class="col-lg-2 control-label">File</label>
            		<div class="col-lg-10">
                		 {!! Form::file('file', array('class'=>'form-control','required')) !!}
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
<script>

    </script>
@endsection