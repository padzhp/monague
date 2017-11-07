@extends('dashboard.layout.master')

@section('content')
                    {!! Form::open(array('url' => 'dashboard/orders/update','method'=>'POST','id'=>'form-order')) !!} 
                    <div class="wrapper">
                        <div class="panel panel-monague">
                            <div class="panel-heading">
                                ORDER DETAILS
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">                               
                                    
                                <div class="margintop-10 marginbottom-10">
                                    <div class="row-normal order-details-wrapper">
                                        <div class="col-xs-5 col-sm-5 col-md-4">
                                           <div class="marginbottom-25">
                                                <label>WEB ORDER ID</label>&nbsp;&nbsp;<span>{{ $order->id }}</span>
                                           </div> 
                                           <div class="marginbottom-25">
                                                <label>COUNTRY</label>&nbsp;&nbsp;<span>{{ $order->order_country }}</span>
                                           </div> 
                                           <div class="marginbottom-25">
                                                <label>AMOUNT</label>&nbsp;&nbsp;<span>${{ number_format($order->total,2) }}</span>
                                           </div> 
                                           <div class="marginbottom-25">
                                                <label>PAYMENT TYPE</label>&nbsp;&nbsp;<span class="text-uppercase">{{ $order->payment_type }}</span>
                                           </div> 
                                           <div class="marginbottom-25">
                                                <label>DATE</label>&nbsp;&nbsp;<span>{{ date("m-d-Y", strtotime($order->created_at)) }}</span>
                                           </div> 
                                           <div class="marginbottom-25">
                                                <label>STATUS</label>&nbsp;&nbsp;<span>{{ $order->status }}</span>
                                           </div> 
                                           
                                        </div>
                                       <div class="col-xs-7 col-sm-7 col-md-8">
                                            <div class="marginbottom-15">
                                                <div><strong>BILLING ADDRESS</strong></div>
                                                <div>{{ $order->customer }}</div>
                                                <div>{{ $order->billing_address }}</div>
                                                <div>{{ $order->billing_city.' '.$order->billing_state }}</div>
                                                <div>{{ $order->billing_zip.' '.$order->billing_country }}</div>

                                           </div> 
                                           <div class="marginbottom-15">
                                                <div><label>PHONE</label>&nbsp;&nbsp;<span>{{ $order->phone }}</span></div>
                                                <div><label>EMAIL</label>&nbsp;&nbsp;<span>{{ $order->email }}</span></div>
                                           </div>

                                           <div class="marginbottom-15">
                                                <div><label>COMPANY NAME</label>&nbsp;&nbsp;<span>{{ $order->company }}</span></div>
                                                <div><label>TAX NO.</label>&nbsp;&nbsp;<span>{{ $order->tax_number }}</span></div>
                                           </div>

                                           <div class="marginbottom-15">
                                                <div><label>SHIPPING ADDRESS</label>
                                                    <div>{{ $order->shipping_address }}</div>
                                                </div>
                                           </div>

                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="order-items-grid">
                                        <div class="order-items-grid-header">
                                            <div class="order-items-grid-row">
                                                <div class="col-md-3">IMAGE</div>
                                                <div class="col-md-3">ITEM</div>
                                                <div class="col-md-2 text-center">QUANTITY</div>
                                                <div class="col-md-2 text-right">PRICE</div>
                                                <div class="col-md-2 text-right">SUBTOTAL</div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="order-items-grid-body">
                                            @foreach($order->orderitems as $item)
                                            <div class="order-items-grid-row">
                                                <div class="col-md-3">IMAGE</div>
                                                <div class="col-md-3">{{ $item->product_name }}</div>
                                                <div class="col-md-2 text-center">{{ $item->quantity }}</div>
                                                <div class="col-md-2 text-right">${{ number_format($item->product_price,2) }}</div>
                                                <div class="col-md-2 text-right">${{ number_format($item->subtotal,2) }}</div>
                                                <div class="clearfix"></div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>                                    
                                     
                                    <div class="clearfix"></div>

                                  
                                  
                                </div>


                                

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
                 <input type="hidden" name="id" id="id" value="{{ $order->id }}" />                 
                 
                {!! Form::close() !!}

@stop

@section('footer-scripts')
        <script language="javascript" type="text/javascript" src="{{asset('js/dashboard/orders.js')}}"></script>
        <script language="javascript" type="text/javascript">
            //window.dashboard.admins.formSubmit();
           
        </script>
        
@stop