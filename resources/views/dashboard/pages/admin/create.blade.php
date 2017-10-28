@extends('dashboard.layout.master')
@section('content')
                    {!! Form::open(array('route' => 'admins.store','method'=>'POST','id'=>'form-admin')) !!}  
                    <div class="wrapper">
                        <div class="panel panel-monague">
                            <div class="panel-heading">
                                ADMIN INFO
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">

                                       
                                    @include('dashboard.pages.admin.form')
                                

                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                  
                 </div>                 
                 
                 <input type="hidden" name="id" id="id" value="" />
                 <div class="action-buttons-container text-center">
                    <button type="submit" class="btn-save btn btn-fixed-width btn-txt-lg btn-blue">SAVE</button>
                    <button type="button" class="btn-close btn btn-fixed-width btn-txt-lg btn-yellow">CLOSE</button>
                 
                 </div>  
                 {!! Form::close() !!}  
                

@stop

@section('footer-scripts')
        <script language="javascript" type="text/javascript" src="{{asset('js/dashboard/admins.js')}}"></script>
        <script language="javascript" type="text/javascript">
            window.dashboard.admins.formSubmit();
        </script>
@stop