@extends('dashboard.layout.master')
@section('content')
					<div class="wrapper">
						<div class="panel panel-monague">
                            <div class="panel-heading">
                                NEW CATEGORY
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">

                                {!! Form::open(array('route' => 'categories.store','method'=>'POST')) !!}         
                                    @include('dashboard.pages.category.form')
                                {!! Form::close() !!}

                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                  
				 </div>

                 <div class="action-buttons-container">
                    <button type="button" class="btn btn-fixed-width btn-blue">SAVE</button>
                    <button type="button" class="btn btn-fixed-width btn-yellow">CLOSE</button>
                 </div>                 
                 
                </div>

@stop

@section('footer-scripts')
		
@stop