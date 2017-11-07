@extends('dashboard.layout.master')
@section('styles')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('css/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/slim.min.css')}}" rel="stylesheet">
@stop
@section('content')
                    {!! Form::model($page, ['method' => 'PATCH','id'=>'form-pages','route' => ['pages.update', $page->id],'enctype'=>'multipart/form-data','class'=>'pages']) !!}
                    <div class="wrapper">
                        <div class="panel panel-monague">
                            <div class="panel-heading">
                                CUSTOMER INFO
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">

                                
                                    @include('dashboard.pages.page.form')
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
                 <input type="hidden" name="id" id="id" value="{{ $page->id }}" />                 
                 
                {!! Form::close() !!}

@stop

@section('footer-scripts')
        <script type="text/javascript" src="{{asset('js/slim.kickstart.min.js')}}"></script>
        <script src="{{asset('js/wysihtml5x-toolbar.min.js')}}"></script>
        <script src="{{asset('js/handlebars.runtime.min.js')}}"></script>        
        <script type="text/javascript" src="{{asset('js/bootstrap3-wysihtml5.min.js')}}"></script>
        <script language="javascript" type="text/javascript" src="{{asset('js/dashboard/pages.js')}}"></script>
        <script language="javascript" type="text/javascript">
            window.dashboard.pages.formSubmit();
            $('#content').wysihtml5({
                toolbar: {
                    "fa": true
                }
            });
        </script>
        
@stop