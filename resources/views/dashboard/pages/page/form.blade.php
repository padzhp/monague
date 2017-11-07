
                    <div class="margintop-10 marginbottom-10 padded-20">
                        <div class="row-normal">
                            <div class="col-xs-8 col-sm-6 col-md-6">
                                <div class="form-group">
                                    {!! Form::label('title', 'PAGE TITLE', ['class'=>'label-block']) !!} 
                                    {!! Form::Text('title', null, array('class' => 'form-control','required'=>'required')); !!}
                                </div>
                            </div>                           
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group">
                                {!! Form::label('image', 'HEADER GRAPHIC') !!} 
                                <div class="slim-wrapper">                                        
                                    <div class="slim"
                                         data-label="Click to change header graphic image"
                                         data-fetcher="fetch.php"
                                         data-size="800,200"
                                         data-min-size="200,45"
                                         data-ratio="8:2">
                                         @if(isset($page->image))
                                         <img src="{{asset($page->image)}}" alt=""/>
                                         @endif
                                        <input type="file" name="slim[]" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group">                                
                                {!! Form::checkbox('published') !!}&nbsp;<span>Published</span>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group">                                                                
                                {!! Form::checkbox('public') !!}&nbsp;<span>Public</span>

                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8">
                            <div class="form-group">                                
                                {!! Form::label('ordering', 'ORDERING', ['class'=>'label-block']) !!} 
                                {!! Form::Text('ordering', null, array('class' => 'form-control input-autosize','size'=>'5','required'=>'required')); !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                {!! Form::label('content', 'CONTENT') !!} 
                                {!! Form::textarea('content', null, array('class' => 'form-control','required'=>'required')); !!}
                            </div>
                        </div>
                         
                        <div class="clearfix"></div>

                      
                      
                    </div>

