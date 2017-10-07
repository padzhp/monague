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
                                    <table class="table table-striped table-panel table-hover" id="dataTables-example">
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
                                        <tbody>
                                            <tr class="">
                                                <td>09-11-2017</td>
                                                <td>1178</td>
                                                <td>US</td>
												<td>OK Gift Shop</td>
												<td>Tateko Takahashi</td>
                                                <td class="right">908.59</td>
												<td>ON MY ACCOUNT</td>
												<td>Pending</td>
                                            </tr>
                                            <tr class="">
                                                <td>09-11-2017</td>
                                                <td>1179</td>
                                                <td>CAD</td>
												<td>Warcraft Store</td>
												<td>Tateko Takahashi</td>
                                                <td class="right">1,345.80</td>
												<td>APPLY FOR NET30</td>
												<td>Confirmed</td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                  
				 </div>
                 
                 
                </div>

@stop

@section('footer-scripts')
		<script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                        responsive: true
                });
            });
        </script>
@stop