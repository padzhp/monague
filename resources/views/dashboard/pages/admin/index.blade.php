@extends('dashboard.layout.master')
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
                                ADMINS
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="margintop-10 marginbottom-10 datatable-filters form-group">
                                    <div class="col-xs-7 col-sm-7 col-md-7">                                       
                                        <label class="notbold marginright-20">Search by Email or Name</label>
                                        <input type="text" class="form-control input-sm input-autosize" name="filter-search">                                       
                                    </div>
                                    <div class="col-xs-5 col-sm-5 col-md-5 text-right">
                                        &nbsp;
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="dataTable_wrapper">
                                    <table class="data-table table table-panel table-hover" id="datatable-admins">
                                        <thead>
                                            <tr>                                               
                                                <th>Username</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Last Login</th>                                                 
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
                    <a role="button" href="{{ url('dashboard/admins/create') }}" class="btn btn-fixed-width btn-green btn-txt-lg">NEW</a>                    
                    <button type="button" class="btn btn-fixed-width btn-brown">EXPORT<br />CSV</button>                    
                 </div>
                 <div class="pagination-container">
                 </div>


                 
                </div>


                

@stop

@section('footer-scripts')
		<script language="javascript" type="text/javascript" src="{{asset('js/dashboard/admins.js')}}"></script>
        <script language="javascript" type="text/javascript">
            window.dashboard.admins.init();
        </script>
@stop