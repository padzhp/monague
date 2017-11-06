
                    <div class="margintop-10 marginbottom-10">
                        <div class="row-normal">
                            <div class="col-xs-8 col-sm-6 col-md-6">
                                <div class="form-group">
                                    {!! Form::label('status', 'Activate Admin', ['class'=>'label-block']) !!} 
                                    {!! Form::select('status', [0 => 'Deactivate', 1 => 'Activate'],null,['class'=>"form-control input-autosize"]); !!}
                                </div>
                            </div>
                           <div class="col-xs-4 col-sm-4 col-md-2">
                                <div class="form-group">
                                    <div class="slim-wrapper">
                                        <div class="slim"
                                             data-label="Image"
                                             data-fetcher="fetch.php"
                                             data-size="65,65"
                                             data-min-size="50,50"
                                             data-ratio="1:1">
                                             @if(isset($admin->photo))
                                             <img src="{{asset($admin->photo)}}" alt=""/>
                                             @endif
                                            <input type="file" name="slim[]" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
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

