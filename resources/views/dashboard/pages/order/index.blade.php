@extends('dashboard.layout.master')
@section('content')
					<div class="wrapper">
						<div class="panel panel-monague">
                            <div class="panel-heading">
                                RECENT ORDERS
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-panel table-hover" id="datatable-orders">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>ID</th>
                                                <th>Country</th>
                                                <th>Company</th>
                                                <th>Customer Name</th>
												<th>Amount</th>
												<th>Payment Type</th>
												<th>Status</th>
                                            </tr>
                                        </thead>                                        
                                    </table>
                                </div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                  
				     </div>
                    
                    <div class="pagination-container">
                    </div>
                 
                </div>

@stop

@section('footer-scripts')
		<script language="javascript" type="text/javascript" src="{{asset('js/dashboard/orders.js')}}"></script>        
@stop