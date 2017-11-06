
					           <div class="dataTable_wrapper">
                                    <table class="data-table dataTable table table-panel">
                                        <thead>
                                            <tr>  
                                                <th width="5%">&nbsp;</th>                                              
                                                <th>Category Name</th>
                                                <th>Parent Category</th>
                                                <th>CAD</th>
                                                <th>US</th>
                                                <th>Ordering</th>                                           
                                                <th width="5%">&nbsp;</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr> 
                                                <td>&nbsp;</td>                                               
                                                <td>{!! Form::Text('name', null, array('class' => 'form-control input-sm input-autosize','size' => '25')) !!}</td>
                                                <td>
                                                     {!! Form::select('parent', $lists['parent'], null, ['class' => 'form-control input-sm input-autosize']) !!}
                                                </td>
                                                <td>{!!Form::checkbox('ca_status') !!}</td>                                             
                                                <td>{!!Form::checkbox('us_status') !!}</td>
                                                <td>{!! Form::Text('ordering', null, array('class' => 'form-control input-sm input-autosize','size' => '5')) !!}</td>
                                                 <td>&nbsp;</td> 
                                            </tr>                                            
                                        </tbody>                                         
                                    </table>
                                </div>

