@extends('dashboard.layout.master')
@section('content')
                    {!! Form::model($category, ['method' => 'PATCH','route' => ['categories.update', $category->id],'id'=>'form-categories']) !!}

					<div class="wrapper">
						<div class="panel panel-monague">
                            <div class="panel-heading">
                                CUSTOMER INFO
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">

                                
                                    @include('dashboard.pages.category.form')
                                

                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                  
				 </div> 

                 <div class="action-buttons-container">
                    <button type="submit" class="btn btn-fixed-width btn-blue">SAVE</button>
                    <button type="button" class="btn btn-fixed-width btn-yellow">CLOSE</button>
                 </div>                 
                 
                {!! Form::close() !!}

@stop

@section('footer-scripts')
		<script language="javascript" type="text/javascript" src="{{asset('js/dashboard/categories.js')}}"></script>
        <script language="javascript" type="text/javascript">
            window.dashboard.categories.formSubmit();
            
        </script>
@stop