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
                                RECENT ORDERS
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
                                            <select class="form-control input-sm" name="filter-country">
                                                <option value="CA">CANADA</option>
                                                <option value="US">USA</option>
                                                <option value="ALL" selected="selected">ALL</option>
                                            </select>   
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
                  
				 </div>
                 <div class="action-buttons-container">
                    <button type="button" class="btn btn-fixed-width btn-green">ADD NEW<br />CUSTOMER</button>
                    <button type="button" class="btn-confirm-delete btn btn-fixed-width btn-txt-lg btn-red">DELETE</button>
                    <button type="button" class="btn btn-fixed-width btn-brown">EXPORT<br />CSV</button>
                 </div>
                 <div class="pagination-container">
                 </div>


                 
                </div>


                

@stop

@section('footer-scripts')
		<script language="javascript" type="text/javascript" src="{{asset('js/dashboard/customers.js')}}"></script>
@stop