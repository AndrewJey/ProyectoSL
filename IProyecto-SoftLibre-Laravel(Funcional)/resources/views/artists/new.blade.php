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
		<form class="form-horizontal" action="/singers" method="POST">
    		<fieldset>
        		<legend>New Singers</legend>
        		<div class="form-group">
        			<input type="hidden" name="_token" value="{{ csrf_token() }}">
           			<label class="col-lg-2 control-label">Name</label>
            		<div class="col-lg-8">
                		<input name="name" type="text" class="form-control" id="inputName" placeholder="Name" required>
            		</div>
        		</div>
       			<div class="form-group">
            		<div class="col-lg-8 col-lg-offset-2">
                		<a href="/singers" class="btn btn-default btn-raised">Cancel</a>
                		<button type="submit" class="btn btn-primary">Submit</button>
            		</div>
        		</div>
    		</fieldset>
		</form>
	</div>
</div>
</div>
@endsection
