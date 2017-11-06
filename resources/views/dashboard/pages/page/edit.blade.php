@extends('dashboard.layout.master')
@section('styles')
    <link href="{{asset('css/slim.min.css')}}" rel="stylesheet">
@stop
@section('content')
                    {!! Form::model($admin, ['method' => 'PATCH','id'=>'form-admin','route' => ['admins.update', $admin->id],'enctype'=>'multipart/form-data','class'=>'avatar']) !!}
                    <div class="wrapper">
                        <div class="panel panel-monague">
                            <div class="panel-heading">
                                CUSTOMER INFO
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">

                                
                                    @include('dashboard.pages.admin.form')
                                    {{ method_field('PATCH') }} 
                                

                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                  
                 </div> 
                 <div class="action-buttons-container text-center">
                    <button type="submit" class="btn-save btn btn-fixed-width btn-txt-lg btn-blue">SAVE</button>
                    <button type="button" class="btn-confirm-delete btn btn-fixed-width btn-txt-lg btn-red">DELETE</button>
                    <button type="button" class="btn-close btn btn-fixed-width btn-txt-lg btn-yellow">CLOSE</button>
                 
                 </div> 
                 <input type="hidden" name="id" id="id" value="{{ $admin->id }}" />                 
                 
                {!! Form::close() !!}

@stop

@section('footer-scripts')
        <script type="text/javascript" src="{{asset('js/slim.kickstart.min.js')}}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('js/dashboard/admins.js')}}"></script>
        <script language="javascript" type="text/javascript">
            window.dashboard.admins.formSubmit();
           
        </script>
        
@stop