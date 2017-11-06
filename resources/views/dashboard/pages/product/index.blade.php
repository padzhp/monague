@extends('dashboard.layout.master')
@section('styles')
    <link href="{{asset('css/slim.min.css')}}" rel="stylesheet">
@stop
@section('content')
					<div class="wrapper">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        
                        <!-- Modal -->
                        <div id="myModal" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-md">

                            <!-- Modal content-->
                            <div class="modal-content modal-custom">  
                                <div class="modal-header">                            
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <div><strong>DESCRIPTION</strong></div>
                                </div>                              
                              <div class="modal-body">
                                <textarea class="form-control" id="description-textarea" rows="5" maxlength="140">Some text in the modal.</textarea>
                                <p class="text-right margintop-10"><span class="chars-remaining">140</span> of 140 characters remaining</p>
                              </div>
                              <div class="text-center marginbottom-20">
                                <button type="button" class="btn-save-description btn btn-fixed-width btn-txt-lg btn-blue marginright-20">SAVE</button>
                                <button type="button" class="btn btn-fixed-width btn-txt-lg btn-yellow" data-dismiss="modal">CLOSE</button>
                              </div>
                              <input type="hidden" name="product_id" id="product-id" value="" />
                            </div>

                          </div>
                        </div>
						<div class="panel panel-monague">
                            <div class="panel-heading">
                                PRODUCTS
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
                                    <table class="data-table table table-panel table-hover">
                                        <thead>
                                            <tr>
                                                <th width="2%">&nbsp</th>
                                                <th width="16%">Item</th>
                                                <th width="12%">Country</th>
                                                <th width="14%">UPC Code</th>
                                                <th width="10%">1-5 PCS</th>
                                                <th width="10%">6+ PCS</th>												
                                                <th width="10%">PACK 6's</th>
                                                <th width="10%">PACK 12's</th>
                                                <th width="15%">Published</th>  
                                            </tr>
                                        </thead>                                        
                                    </table>
                                    <table class="data-table table table-panel table-hover no-table-header" id="datatable-products">
                                        <thead>
                                            <tr>
                                                <th width="5%">&nbsp;</th>                                                
                                                <th width="15%">&nbsp;</th>
                                                <th width="30%">&nbsp;</th>                                             
                                                <th width="20%">&nbsp;</th>
                                                <th width="10%">&nbsp;</th>
                                                <th width="20%">&nbsp;</th>  
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
                    <button type="button" class="btn-save btn btn-fixed-width btn-txt-lg btn-blue">SAVE</button>
                    <a role="button" href="{{ url('dashboard/products/create') }}" class="btn btn-fixed-width btn-green btn-txt-lg">NEW</a>                    
                    <button type="button" class="btn btn-fixed-width btn-brown">EXPORT<br />CSV</button>                    
                 </div>
                 <div class="pagination-container">
                 </div>

                             

@stop

@section('footer-scripts')
        <script type="text/javascript" src="{{asset('js/slim.kickstart.min.js')}}"></script>
		<script language="javascript" type="text/javascript" src="{{asset('js/dashboard/products.js')}}"></script>
        <script language="javascript" type="text/javascript">
            window.dashboard.products.init();
        </script>
@stop