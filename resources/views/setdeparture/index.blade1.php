<?php 
    //echo "<pre>";
    //print_r($blocksBlog);
    //die;
?>
@include('element.flash_message')
@extends('layouts.inner')
@section('content')

<?php $i=0;?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#depart_date_from" ).datepicker();
     $( "#depart_date_to" ).datepicker();
  } );
 </script>

<style>
   
   input#depart_date {
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    select#destination {
   
        height: 34px;
        font-size: 17px;
        background: #f3efe4;
    }

.view_all {
    margin-left: 18px;
    font-size: 16px;
}


.departfilter_form input, .departfilter_form select {
    border: 1px solid #B0B0B0;
    padding: 5px 12px;
    width: 100%;
    height: auto !important;
}

.form-group1.submit-btn input.btn {
    color: #fff;
    font-size: 17px;
    padding: 2px 21px;
    border-radius: 0;
    font-weight: 500;
}
.departfilter_form .form-group1 {display: inline-block;}




</style>
<div class="page_title">
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-4">
                <h1>{{ trans('messages.set_departures') }}</h1>
            </div>
        </div>
    </div>
</div>
<div class="main_content">
    <div class="container">
        <div class="departform">
            <div class="depart_filter col-sm-12" style="margin-bottom: 1%;">
                <form method="GET">
                    <div class="departfilter_form">
                    <div class="form-group1">
                        <label>{{ trans('messages.from') }}</label>
                        <input type="text" name="depart_date_from" id="depart_date_from" placeholder="{{ trans('messages.from') }}">
                    </div>
                    <div class="form-group1">
                        <label>{{ trans('messages.to') }}</label>
                        <input type="text" name="depart_date_to" id="depart_date_to" placeholder="{{ trans('messages.to') }}">
                    </div>
                    <div class="form-group1">
                        <label>{{ trans('messages.destinations') }}</label>
                        <!-- <input type="text" name="destination" id="destination"> -->
                        {{ Form::select(
                             'destination',
                             [null => trans('messages.alldestinations')]+ $countryList,
                             '',
                             ['class'=>'small','id'=>'destination']
                            ) 
                        }}
                    </div>
                    <div class="form-group1 submit-btn">
                        <input type="button" value="{{ trans('messages.submit') }}" class="btn btn-primary" id="sub_p">
                    </div>
                </div>
                </form>
               
            </div>
             <div class="view_all">
                 <a href="{{ URL::to('setdepartures') }}">{{ trans('messages.viewall') }}</a>
            </div>
            <div class="col-sm-12">                
               
                <ul class="blog_page_list" id="indexlist">
                   @if(sizeof($tripslist)>0)

                    @foreach($tripslist as $tripsdetails)


                        <li class="hbl_item">
                            <div class="row">
                                <div class="col-sm-4 col-lg-3 col-md-3">
                                <div class="hbl_item_img-box">
                                    <a href="{{ URL::to('trips/'.''.$tripsdetails->name.'/'.$tripsdetails->slug) }}">
                                        <img src="<?php echo WEBSITE_URL.'image.php?width=163px&height=163px&image='.TRIP_IMAGE_URL.$tripsdetails->image;?>" alt="" />
                                    </a>
                                </div>
                                </div>
                                <div class="col-sm-8 col-lg-9 col-md-9">
                                 
                                    <section class="bigpost_description_heading">
                                        <a href="{{ URL::to('trips/'.''.$tripsdetails->name.'/'.$tripsdetails->slug) }}">
                                                {{str_limit($tripsdetails->tripname, 150)}}
                                        </a>
                                    </section>
                                    <section class="bigpost_description">
                                            {{str_limit($tripsdetails->description, 140)}}
                                    </section>

                                     <section class="bigpost_top">
                                        <div class="bigpost_time"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                            <?php 
                                            $tripdates=date('Y',strtotime($tripsdetails->tripdates));
                                            if($tripdates=="1970"){$tripdates='';}else{ $tripdates=date('M d, Y',strtotime($tripsdetails->tripdates));}?>
                                            {{$tripdates}}
                                        </div>
                                    <div class="bigpost_comments"><i class="fa fa-calendar" aria-hidden="true"></i> 
                                        {{$tripsdetails->tripdays}} {{ trans('messages.days') }}
                                    </div>
                                    <div class="bigpost_comments"><i class="fa fa-euro" aria-hidden="true"></i> 
                                        {{ $tripsdetails->baseprice}}
                                    </div>
                                    <!-- <button type="button" class="btn btn-info comment-btn" data-toggle="collapse" data-target="#demo_{{$i}}">{{trans('messages.clicktocomment')}}</button>  -->
                                     
                                    </section> 

                                </div>
                            </div>
                        </li>
                    <?php $i++ ; ?>
                    @endforeach
                    {{$tripslist}}
                    @else
                    <p>No Data Found.</p>
                    @endif
                </ul>

            </div>

        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#sub_p").click(function(){
             
             var depart_date_from=$('#depart_date_from').val();
             var destination=$('#destination').val();
             var depart_date_to=$('#depart_date_to').val();
           
           
               jQuery.ajax({
                url: '/setdepartures',
                type: 'POST',
                data: { from_date: depart_date_from,to_date:depart_date_to,destination:destination },
                success:function(data)
                {
                    console.log(data);
                   $('#indexlist').html(data);
                   // console.log(data);
                    
                } 
             });

      });
       
    });
    
</script>

@stop
