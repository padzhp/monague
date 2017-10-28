
					<div class="margintop-10 marginbottom-10">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Activate Customer</label>
                                {!! Form::select('status', [0 => 'Deactivate', 1 => 'Activate'],null,['class'=>"form-control input-autosize"]); !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group"> 
                                {!! Form::label('email', 'Email:') !!}                               
                                {!! Form::Text('email', null, array('class' => 'form-control','required'=>'required','type'=>'email')) !!}

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group">
                                <label>Password</label>
                                {!! Form::Text('password', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                         <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group">
                                <label>Company Name</label>
                                {!! Form::Text('company', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group">
                                <label>Contact Name</label>
                                {!! Form::Text('name', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group">
                                <label>Billing Address</label>
                                {!! Form::Text('billing_street', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group">
                                <label>City</label>
                                {!! Form::Text('billing_city', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group">
                                <label>State / Province</label>
                                {!! Form::Text('billing_state', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-5 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>Country</label>
                                {!! Form::select('billing_country', $lists['countries'], null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-xs-5 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>Postal Code / Zip Code</label>
                                {!! Form::Text('billing_zip', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-5 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>Phone</label>
                                {!! Form::Text('phone',null,['class'=>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="col-xs-5 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>Fax</label>
                                {!! Form::Text('fax', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-5 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>PST / EIN Tax No.</label>
                                {!! Form::text('tax_number',null,['class'=>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="col-xs-5 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>Store Operation</label>
                               {!! Form::select('store_operation',['CA' => 'Canada', 'US' => 'USA'],null,['class'=>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-5 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>Type of Store</label>
                                {!! Form::select('store_type',['CA' => 'Canada', 'US' => 'USA'],null,['class'=>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="col-xs-5 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>Price Range</label>
                                {!! Form::select('price_range',['CA' => 'Canada', 'US' => 'USA'], null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                         <div class="col-xs-5 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>Where did you hear about us?</label>
                                {!! Form::select('heard_from',['CA' => 'Canada', 'US' => 'USA'],null,['class'=>"form-control"]) !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="marginleft-20 marginright-20" />

                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group">
                                <label>Shipping Address</label>
                                {!! Form::Text('shipping_street', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group">
                                <label>City</label>
                                {!! Form::Text('shipping_city', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group">
                                <label>State / Province</label>
                                {!! Form::Text('shipping_state', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-xs-5 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>Country</label>
                                 {!! Form::select('shipping_country', $lists['countries'], null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-xs-5 col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>Postal Code / Zip Code</label>
                                {!! Form::Text('shipping_zip', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="clearfix"></div>

                      
                      
                    </div>

