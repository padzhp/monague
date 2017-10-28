
                    <div class="margintop-10 marginbottom-10">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>Activate Admin</label>
                                {!! Form::select('status', [0 => 'Deactivate', 1 => 'Activate'],null,['class'=>"form-control input-autosize"]); !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group">
                                {!! Form::label('name', 'Name') !!} 
                                {!! Form::Text('name', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group"> 
                                {!! Form::label('email', 'Email') !!}                               
                                {!! Form::Text('email', null, array('class' => 'form-control','required'=>'required','type'=>'email')) !!}

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group">
                                {!! Form::label('password', 'Password') !!} 
                                {!! Form::Text('password', null, array('class' => 'form-control')) !!}
                            </div>
                        </div>
                         
                        <div class="clearfix"></div>

                      
                      
                    </div>

