@extends('dashboard.layout.master')
@section('content')
					<div class="wrapper">
						<div class="panel panel-monague">
                            <div class="panel-heading">
                                NEW ITEM
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">

                                {!! Form::open(array('route' => 'products.store','method'=>'POST')) !!}         
                                    @include('dashboard.pages.product.form')
                                {!! Form::close() !!}

                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                  
				 </div>

                 <div class="action-buttons-container">
                    <button type="button" class="btn-save btn btn-fixed-width btn-txt-lg btn-blue">SAVE</button>
                    <button type="button" class="btn-close btn btn-fixed-width btn-txt-lg btn-yellow">CLOSE</button>
                 
                 </div>                 
                 
                

@stop

@section('footer-scripts')
		
@stop