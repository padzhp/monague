@extends('dashboard.layout.master')
@section('content')
                    {!! Form::open(array('route' => 'products.store','method'=>'POST','id'=>'form-submit')) !!}  
					<div class="wrapper">
						<div class="panel panel-monague">
                            <div class="panel-heading">
                                NEW ITEM
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">

                                       
                                    @include('dashboard.pages.product.form')
                                

                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                  
				 </div>

                 <div class="action-buttons-container">
                    <button type="button" id="btn-submit" class="btn-save btn btn-fixed-width btn-txt-lg btn-blue">SAVE</button>
                    <button type="button" class="btn-close btn btn-fixed-width btn-txt-lg btn-yellow">CLOSE</button>                 
                 </div>

                 {!! Form::close() !!}                 
                 
                

@stop

@section('footer-scripts')
		
@stop