@extends('dashboard.layout.master')
@section('content')
                    {!! Form::model($customer, ['method' => 'PATCH','id'=>'form-customer','route' => ['customers.update', $customer->user_id]]) !!}
					<div class="wrapper">
						<div class="panel panel-monague">
                            <div class="panel-heading">
                                CUSTOMER INFO
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">

                                
                                    @include('dashboard.pages.customer.form')
                                    {{ method_field('PATCH') }} 
                                

                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                  
				 </div> 
                 <div class="action-buttons-container text-center">

                    <button type="submit" class="btn-save btn btn-fixed-width btn-txt-lg btn-blue">SAVE</button>
                    @if($customer->status == 0)
                     <button type="button" data-status="1" class="btn-confirm-activate btn btn-fixed-width btn-txt-lg btn-green">ACTIVATE</button>
                    @else
                     <button type="button" data-status="0" class="btn-confirm-activate btn btn-fixed-width btn-txt-lg btn-green">DEACTIVATE</button>
                    @endif
                    <button type="button" class="btn-confirm-delete btn btn-fixed-width btn-txt-lg btn-red">DELETE</button>
                    <button type="button" class="btn-close btn btn-fixed-width btn-txt-lg btn-yellow">CLOSE</button>
                 
                 </div> 
                 <input type="hidden" name="id" id="id" value="{{$customer->user_id}}" />                
                 
                {!! Form::close() !!}

@stop

@section('footer-scripts')
        <script language="javascript" type="text/javascript" src="{{asset('js/dashboard/customers.js')}}"></script>
        <script language="javascript" type="text/javascript">
            window.dashboard.customers.formSubmit();
        </script>
		
@stop