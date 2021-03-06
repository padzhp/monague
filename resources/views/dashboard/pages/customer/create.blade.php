@extends('dashboard.layout.master')
@section('content')
                    {!! Form::open(array('route' => 'customers.store','method'=>'POST','id'=>'form-customer')) !!}  
					<div class="wrapper">
						<div class="panel panel-monague">
                            <div class="panel-heading">
                                CUSTOMER INFO
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">

                                       
                                    @include('dashboard.pages.customer.form')
                                

                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                  
				 </div>                 
                 
                 
                 <div class="action-buttons-container text-center">
                    <button type="submit" class="btn-save btn btn-fixed-width btn-txt-lg btn-blue">SAVE</button>
                    <button type="button" class="btn-close btn btn-fixed-width btn-txt-lg btn-yellow">CLOSE</button>
                 
                 </div> 
                 <input type="hidden" name="id" id="id" value="" /> 
                 {!! Form::close() !!}  
                

@stop

@section('footer-scripts')
		<script language="javascript" type="text/javascript" src="{{asset('js/dashboard/customers.js')}}"></script>
        <script language="javascript" type="text/javascript">
            window.dashboard.customers.formSubmit();
        </script>
@stop