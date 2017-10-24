@extends('dashboard.layout.master')
@section('content')
					<div class="wrapper">
						<div class="panel panel-monague">
                            <div class="panel-heading">
                                CUSTOMER INFO
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">

                                {!! Form::model($customer, ['method' => 'PATCH','route' => ['customers.update', $customer->user_id]]) !!}
                                    @include('dashboard.pages.customer.form')
                                {!! Form::close() !!}

                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                  
				 </div>                 
                 
                </div>

@stop

@section('footer-scripts')
		
@stop