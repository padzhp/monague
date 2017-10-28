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
                                CUSTOMERS
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="margintop-10 marginbottom-10 datatable-filters form-group">
                                    <div class="col-xs-7 col-sm-7 col-md-7">                                       
                                        <label class="notbold marginright-20">Search by Company Name or Contact Name</label>
                                        <input type="text" class="form-control input-sm input-autosize" name="filter-search">                                       
                                    </div>
                                    <div class="col-xs-5 col-sm-5 col-md-5 text-right">
                                        <div class="col-xs-6 col-sm-4 col-md-4 pull-right">                                            
                                            {!! Form::select('filter-country', $lists['countries'], null, ['class' => 'form-control  input-sm']) !!}  
                                        </div> 
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="dataTable_wrapper">
                                    <table class="data-table table table-panel table-hover" id="datatable-customers">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="select-all"></th>
                                                <th>Country</th>
                                                <th>Company Name</th>
                                                <th>Contact Name</th>
                                                <th>Email Add</th>
                                                <th>Registration Date</th>												
                                            </tr>
                                        </thead>                                        
                                    </table>
                                </div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                  
				 
                 <div class="action-buttons-container">
                    <a role="button" href="{{ url('dashboard/customers/create') }}"" class="btn btn-fixed-width btn-two-lines-text btn-green">ADD NEW<br />CUSTOMER</a>
                    <button type="button" class="btn-confirm-delete btn btn-fixed-width btn-txt-lg btn-red">DELETE</button>
                    <button type="button" class="btn btn-fixed-width btn-brown">EXPORT<br />CSV</button>
                 </div>
                 <div class="pagination-container">
                 </div>


                

@stop

@section('footer-scripts')
		<script language="javascript" type="text/javascript" src="{{asset('js/dashboard/customers.js')}}"></script>
        <script language="javascript" type="text/javascript">
            window.dashboard.customers.init();
        </script>
@stop