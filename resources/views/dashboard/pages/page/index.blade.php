@extends('dashboard.layout.master')
@section('content')
					<div class="wrapper">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        
                        <!-- Modal -->
                        
						<div class="panel panel-monague">
                            <div class="panel-heading">
                                EDIT PAGES
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">                                
                                <div class="dataTable_wrapper">
                                    <table class="data-table table table-panel table-hover" id="datatable-pages">
                                        <thead>
                                            <tr> 
                                                <th width="2%"><input type="checkbox" id="select-all"></th>    
                                                <th width="20%">PAGE</th>                                          
                                                <th>HEADER GRAPHIC</th>
                                                <th width="10%">ORDERING</th>
                                                <th width="10%">PUBLISHED</th>
                                                <th width="10%">PUBLIC</th>                                                 
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
                    <button type="submit" class="btn btn-fixed-width btn-blue">SAVE</button>
                    <a role="button" href="{{ url('dashboard/pages/create') }}" class="btn btn-fixed-width btn-green btn-txt-lg">NEW</a> 
                    <button type="button" class="btn-confirm-delete btn btn-fixed-width btn-txt-lg btn-red">DELETE</button>
                    <button type="button" class="btn btn-fixed-width btn-yellow">CLOSE</button>                   
                 </div>
                 <div class="pagination-container">
                 </div>


                 
                             

@stop

@section('footer-scripts')
		<script language="javascript" type="text/javascript" src="{{asset('js/dashboard/pages.js')}}"></script>
        <script language="javascript" type="text/javascript">
            window.dashboard.pages.init();
        </script>
@stop