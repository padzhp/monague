@extends('dashboard.layout.master')
@section('content')
					<div class="wrapper marginbottom-30">
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
                                        <tbody>
                                        	@foreach($orders as $order)
                                            <tr>
                                                <td>{{ date('m-d-Y', strtotime($order->created_at)) }}</td>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->order_country }}</td>
                                                <td>{{ $order->company }}</td>
                                                <td>{{ $order->customer }}</td>
												<td>${{ number_format($order->total,2) }}</th>
												<td>{{ $order->payment_type ? $lists['payment_types'][trim($order->payment_type)] : "" }}</td>
												<td>{{ $order->status }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>                                          
                                    </table>
                                </div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->                  
				 </div>


				 <div class="wrapper marginbottom-30">
						<div class="panel panel-monague">
                            <div class="panel-heading">
                                NEW CUSTOMERS FOR ACTIVATION
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-panel" id="datatable-orders">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Country</th>                                                
                                                <th>Company Name</th>
                                                <th>Customer Name</th>
												<th>Email Add</th>
												<th>&nbsp;</th>												
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	@foreach($customers as $customer)
                                            <tr>
                                                <td>{{ date('m-d-Y', strtotime($customer->created_at)) }}</td>
                                                <td>{{ $customer->billing_country == 1 ? "US" : "CAD" }}</td>
                                                <td>{{ $customer->company }}</td>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->email }}</td>
												<td><button type="button" data-loading-text="Activating..." data-id="{{ $customer->user_id }}" class="btn btn-sm btn-green btn-activate-user">ACTIVATE</button>
                                                    
                                                </td>												
                                            </tr>
                                            @endforeach
                                        </tbody>                                          
                                    </table>
                                </div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->                  
				 </div>
                 
                 <div class="wrapper">
					<div class="panel panel-monague">
                            <div class="panel-heading">
                                WEBSITE HIGHLIGHTS
                            </div>
							<div class="panel-body">
								<div class="top-buffer">
									<div class="col-lg-3 col-md-6">
										<div class="hero-widget well-sm">
											<div class="icon">
												<div class="mnc-hero-icons mnc-monthly-sales"></div>
											</div>
											<div class="text">
												<label class="hero-widget-title">TOTAL SALES<br />THIS MONTH</label>
											</div>	
											<div class="stats">												
												<label>{{ $lists['monthly_sales'] ? number_format($lists['monthly_sales'],0) : 0 }}</label>
											</div>											
										</div>
									</div>
									<div class="col-lg-3 col-md-6">
										<div class="hero-widget well-sm">
											<div class="icon">
												<div class="mnc-hero-icons mnc-customer-sales"></div>
											</div>
											<div class="text">
												<label class="hero-widget-title">TOTAL SALES<br />FROM NEW<br />CUSTOMERS</label>
											</div>
											<div class="stats">												
												<label>5,250</label>
											</div>												
										</div>
									</div>
									<div class="col-lg-3 col-md-6">
										<div class="hero-widget well-sm">
											<div class="icon">
												<div class="mnc-hero-icons mnc-customer-registered"></div>
											</div>
											<div class="text">												
												<label class="hero-widget-title">NEW CUSTOMER<br />REGISTRATIONS<br />THIS MONTH</label>
											</div>
											<div class="stats">												
												<label>{{ $lists['new_customers'] ? number_format($lists['new_customers'],0) : 0 }}</label>
											</div>																						
										</div>
									</div>
									<div class="col-lg-3 col-md-6">
										<div class="hero-widget well-sm">
											<div class="icon">
												<div class="mnc-hero-icons mnc-top10-items"></div>
											</div>
											<div class="text">												
												<label class="hero-widget-title">TOP 10 MOST<br />ORDERED<br />ITEMS</label>
											</div>
											<div class="stats">												
												<a href="/dashboard/index/top10">VIEW</a>
											</div>											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>

@stop

@section('footer-scripts')
		<script language="javascript" type="text/javascript" src="{{asset('js/dashboard/index.js')}}"></script>
        <script language="javascript" type="text/javascript">
            window.dashboard.index.init();
        </script>
@stop