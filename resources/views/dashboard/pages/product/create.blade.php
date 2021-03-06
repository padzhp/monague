@extends('dashboard.layout.master')
@section('styles')
    <link href="{{asset('css/slim.min.css')}}" rel="stylesheet">
@stop
@section('content')
                    {!! Form::open(array('route' => 'products.store','method'=>'POST','id'=>'form-product','class'=>'avatar','enctype'=>'multipart/form-data')) !!}  
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
                    <button type="submit" id="btn-submit" class="btn-save btn btn-fixed-width btn-txt-lg btn-blue">SAVE</button>
                    <button type="button" class="btn-close btn btn-fixed-width btn-txt-lg btn-yellow">CLOSE</button>                 
                 </div>

                 {!! Form::close() !!}                 
                 
                

@stop

@section('footer-scripts')
		<script type="text/javascript" src="{{asset('js/slim.kickstart.min.js')}}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('js/dashboard/products.js')}}"></script>
        <script language="javascript" type="text/javascript">
            window.dashboard.products.formSubmit();
            
        </script>
@stop