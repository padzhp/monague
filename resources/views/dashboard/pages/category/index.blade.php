@extends('dashboard.layout.master')
@section('content')
					<div class="wrapper">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
						<div class="panel panel-monague">
                            <div class="panel-heading">
                                CATEGORIES
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">                                
                                <div class="dataTable_wrapper">
                                    <table class="data-table table table-panel table-hover" id="datatable-categories">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select-all"></th>
                                                <th>Category</th>
                                                <th>Parent Category</th>
                                                <th>CAD</th>
                                                <th>US</th>
                                                <th>Ordering</th>												
                                            </tr>
                                        </thead>                                        
                                    </table>
                                </div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                  
				 </div>
                 <div class="action-buttons-container">
                    <button type="button" class="btn btn-fixed-width btn-blue">SAVE</button>
                    <button type="button" class="btn btn-fixed-width btn-brown">UPDATE</button>
                    <a role="button" href="{{ url('dashboard/categories/create') }}" class="btn btn-fixed-width btn-green btn-txt-lg">NEW</a> 
                    <button type="button" class="btn-confirm-delete btn btn-fixed-width btn-txt-lg btn-red">DELETE</button>
                    <button type="button" class="btn btn-fixed-width btn-yellow">CLOSE</button>
                 </div>
                 <div class="pagination-container">
                 </div>


                 
                </div>


                

@stop

@section('footer-scripts')
		<script language="javascript" type="text/javascript" src="{{asset('js/dashboard/categories.js')}}"></script>
@stop