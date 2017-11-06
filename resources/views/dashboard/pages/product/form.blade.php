                                                  
                                <div class="dataTable_wrapper">
                                    <table class="data-table non-striped dataTable table table-panel table-hover">
                                        <thead>
                                            <tr>
                                                <th width="2%">&nbsp</th>
                                                <th>Item</th>
                                                <th>Country</th>
                                                <th>UPC Code</th>
                                                <th>1-5 PCS</th>
                                                <th>6+ PCS</th>                                             
                                                <th>PACK 6's</th>
                                                <th>PACK 12's</th>
                                                <th>Published</th>  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="shown">
                                                <td width="2%">&nbsp</td>
                                                <td><input type="text" value="" name="name" class="form-control input-autosize input-sm" size="15" /></td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>
                                                    {!! Form::select('category_id', $lists['categories'], null, ['class' => 'form-control']) !!}
                                                </td>
                                                <td>&nbsp;</td>                                             
                                                <td>ORDER</td>
                                                <td><input type="text" class="form-control input-sm input-autosize" size="5" name="ordering" value="1"></td>
                                                <td>&nbsp;</td>  
                                            </tr>
                                            <tr class="subtable-row">
                                                <td class="subtable-row" colspan="9">
                                                    <div class="subtable-wrapper">
                                                        <table class="subtable" align="center">
                                                            <tbody>
                                                                <tr>
                                                                    <td rowspan="2" nowrap="">
                                                                        <div class="form-group">
                                                                            <div class="slim-wrapper">
                                                                                <div class="slim"
                                                                                     data-label="Image"
                                                                                     data-fetcher="fetch.php"
                                                                                     data-size="800,600"
                                                                                     data-min-size="50,50"
                                                                                     data-ratio="4:3">
                                                                                    <input type="file" name="slim[]" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td nowrap="">
                                                                        <input type="checkbox" value="1" name="ca_enabled"> CAD</td>
                                                                    <td nowrap="">
                                                                        <input type="text" class="form-control input-sm input-autosize" size="12" value="" name="ca_sku">
                                                                    </td>
                                                                    <td nowrap="">
                                                                        <input type="text" class="form-control input-sm input-autosize" size="6" value="" name="ca_price">
                                                                    </td>
                                                                    <td nowrap="">
                                                                        <input type="text" class="form-control input-sm input-autosize" size="6" value="" name="ca_six_plus">
                                                                    </td>
                                                                    <td nowrap="">
                                                                        <input type="text" class="form-control input-sm input-autosize" size="6" value="" name="ca_six_pack">
                                                                    </td>
                                                                    <td nowrap="">
                                                                        <input type="text" class="form-control input-sm input-autosize" size="6" value="" name="ca_dozen_pack">
                                                                    </td>
                                                                    <td nowrap="">
                                                                        <input type="checkbox" value="1" name="ca_published">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td nowrap="">
                                                                        <input type="checkbox" value="1" name="us_enabled"> USD</td>
                                                                    <td nowrap="">
                                                                        <input type="text" class="form-control input-sm input-autosize" size="12" value="" name="us_sku">
                                                                    </td>
                                                                    <td nowrap="">
                                                                        <input type="text" class="form-control input-sm input-autosize" size="6" value="" name="us_price">
                                                                    </td>
                                                                    <td nowrap="">
                                                                        <input type="text" class="form-control input-sm input-autosize" size="6" value="" name="us_six_plus">
                                                                    </td>
                                                                    <td nowrap="">
                                                                        <input type="text" class="form-control input-sm input-autosize" size="6" value="" name="us_six_pack">
                                                                    </td>
                                                                    <td nowrap="">
                                                                        <input type="text" class="form-control input-sm input-autosize" size="6" value="" name="us_dozen_pack">
                                                                    </td>
                                                                    <td nowrap="">
                                                                        <input type="checkbox" value="1" name="us_published">                                                                       
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="9">
                                                    <div class="form-group padded-20">
                                                        <label>DESCRIPTION</label>
                                                        <textarea class="form-control" id="description-textarea" name="description" maxlength="140"></textarea>
                                                         <p class="text-left margintop-10"><span class="chars-remaining">140</span> of 140 characters remaining</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>                                         
                                    </table>
                                </div>
                        
                      
                


                
