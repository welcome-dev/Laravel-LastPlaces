@extends('layouts.inner')
@section('content')
<div class="page_title">
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-4">
                <h1>Trip Enquiry</h1>
            </div>
        </div>
    </div>
</div>
<div class="main_content">
    <!-- <div class="contact_map">
        <iframe src="{{ Config::get('Site.map')}}" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
    </div> -->
    <div class="container">
        <div class="row">
            <div class="col-sm-12" id="scroll_error_signup">
                <div class="login_form">
                    <?php //echo "<pre>"; print_r($tripDetail); ?>
                    <h2>{{ trans('messages.fillenquiryform') }}<br> <small>{{trans('messages.enquiryabout')}} {{ $tripDetail['tripname'] }} </small></h2>
                    <div id="error_div_signup" style="display:none"></div>
                    {{ Form::open(['role' => 'form','url' => 'save-trip-enquiry','id'=>'tripenquiry_form', 'name'=>'tripenquiry_form','method'=>'post','class'=>'form']) }}
                      {{Form::hidden('trip_id', $tripDetail['id'])}}
                      {{Form::hidden('trip_name', $tripDetail['tripname'])}}
                      <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                            {{ Form::text(
                                    'first_name', 
                                    null,
                                    ['class'=>'form-control','placeholder'=>trans('messages.firstname'),'required'=>'required','data-errormessage-value-missing' => 'First Name is required.']
                                    ) 
                                }}  
                            </div>
                            <div class="col-sm-6">
                                {{ Form::text(
                                    'last_name', 
                                    null,
                                    ['class'=>'form-control','placeholder'=>trans('messages.lastname'),'required', 'data-errormessage-value-missing' => 'Last Name is required.']
                                    ) 
                                }}                                 

                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                {{ Form::text(
                                    'phone', 
                                    isset($userPhone) ? $userPhone : '',
                                    ['class'=>'form-control','required','placeholder'=>trans('messages.phone'),'data-errormessage-type-mismatch'=>'Phone is Invalid.','data-errormessage-value-missing' => 'Phone is required.' ]
                                    ) 
                                }}  
                               
                            </div>
                            <div class="col-sm-6">
                                {{ Form::email(
                                    'email', 
                                    isset($userEmail) ? $userEmail : '',
                                    ['class'=>'form-control','required','placeholder'=>trans('messages.email'),'data-errormessage-type-mismatch'=>'Email Address is Invalid.','data-errormessage-value-missing' => 'Email Address is required.' ]
                                    ) 
                                }}  
                               
                            </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                {{ Form::textarea(
                                    'message', 
                                    null,
                                    ['class'=>'form-control','placeholder'=>trans('messages.message'),'required','data-errormessage-value-missing' => 'Message is required.']
                                    ) 
                                }}    
                            </div>
                        </div>
                      </div>
                      {{
                        Form::button(
                        'Submit',
                        ['class'=>'btn btn-primary','id'=>'submit_signup','type'=>'submit']
                        ) 
                    }}
                    <br>
                   {{ Form::close() }}
                </div>
                <br>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

        $(document).ready(function(){
            // ajax calling for signup
            var options = {
                beforeSubmit: function(){ 
                    $('#error_div_signup').hide();
                    $("#submit_signup").button('loading');
                    $("#overlay").show();
                },
                success:function(data){
                    $("#submit_signup").button('reset');
                    $("#overlay").hide();
                    if(data.success==1){
                        $('#error_div_signup').hide();
                            document.getElementById("tripenquiry_form").reset();
                            notice('Contact Us','Enquiry request has been sent successfully.','success');
                    }else{
                        error_msg   =   '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+data.errors+'</div>';
                        $('#error_div_signup').hide();
                        $('#error_div_signup').html(error_msg);
                        
                        // top position relative to the document
                        var pos = $("#scroll_error_signup").offset().top;
        
                        // animated top scrolling
                        $('body, html').animate({scrollTop: 0});
                        $('#error_div_signup').show('slow');
                    }
                    return false;
                },
                resetForm:false
            }; 
            // pass options to ajaxForm 
            $('#tripenquiry_form').ajaxForm(options);
    });
</script>

@stop
