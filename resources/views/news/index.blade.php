<?php 
    //echo "<pre>";
    //print_r($blocksBlog);
    //die;
?>
@extends('layouts.inner')
@section('content')
<?php $i=0;?>
<div class="page_title">
    <div class="container">
        <div class="row">
            <div class="col-sm-offset-4">
                <h1>News</h1>
            </div>
        </div>
    </div>
</div>
<div class="main_content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">                
                <ul class="blog_page_list">
                   
                    @foreach($blocksNews as $news)
                        <li class="hbl_item">
                            <div class="row">
                                <div class="col-sm-4 col-lg-3 col-md-3">
                                <div class="hbl_item_img-box">
                                    <a href="{{ URL::to('news/'.$news->slug) }}">
                                        <img src="<?php echo WEBSITE_URL.'image.php?width=163px&height=163px&image='.NEWS_IMAGE_URL.$news->image;?>" alt="" />
                                    </a>
                                    </div>
                                </div>
                                <div class="col-sm-8 col-lg-9 col-md-9">
                                 
                                    <div class="bigpost_description_heading">
                                    <a href="{{ URL::to('news/'.$news->slug) }}">
                                            {{str_limit($news->newsDescription->name, 150)}}
                                    </a>
                                    </div>
                                    <div class="bigpost_description">
                                        {{ strip_tags(Str::limit($news->newsDescription->description, 250)) }}
                                    </div>
                                    <div class="bigpost_top">
                                        <div class="bigpost_time"><i class="fa fa-clock-o" aria-hidden="true"></i>
                                            {{date('M d, Y',strtotime($news->created_at))}}
                                        </div>
                                    <div class="bigpost_comments"><i class="fa fa-comments-o" aria-hidden="true"></i> 
                                        {{$news->newsComments->count()}} {{ trans('messages.Comments') }}
                                    </div>
                                    <div class="bigpost_comments"><i class="fa fa-user" aria-hidden="true"></i> 
                                        {{ $news->newsAuthor->first_name . " " . $news->newsAuthor->last_name }}
                                    </div>
                                    <button type="button" class="btn btn-info comment-btn" data-toggle="collapse" data-target="#demo_{{$i}}">{{trans('messages.clicktocomment')}}</button> 
                                    <div id="demo_{{$i}}" class="collapse bigpost-comment-form"> 
                                       <form action ="{{URL::to('/save-comment1')}}" method="post" name="comment-form" id="comment-form">
                                            <input type="hidden" value="{{$news->id}}" name="news_id">
                                            <div class="form-group">
                                                <label for="firstName" class="control-label">Full Name</label>
                                                
                                                    <input type="text" id="name" name="name" placeholder="Full Name" class="form-control" required />
                                               
                                            </div>
                                            <div class="form-group">
                                                <label for="firstName" class=" control-label">Email</label>
                                                
                                                    <input type="email" id="email" name="email" placeholder="Email" class="form-control" required />
                                                
                                            </div>
                                            <div class="form-group">
                                                <label for="firstName" class=" control-label">Comment</label>
                                                
                                                    <textarea id="comment" name="comment" placeholder="Comment" class="form-control" required></textarea>
                                               
                                            </div>
                                            <div class="form-group">
                                                
                                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                             </div>
                                       </form>
                                    </div>    
                                    </div>                                
                                </div>
                            </div>
                        </li>
                    <?php $i++ ; ?>
                    @endforeach

                </ul>

            </div>
<?php
$link_limit = 6; 
?>
            @if ($blocksNews->lastPage() > 1)
            <div class="row">
                <div class="col-sm-12">
                    <nav aria-label="Page navigation" class="blog-pagination">
                      <ul class="pagination">
                        <li class="page-item {{ ($blocksNews->currentPage() == 1) ? ' disabled' : '' }}">
                          <a class="page-link" href="{{ ($blocksNews->currentPage() == 1) ? 'javascript:void(0)' : $blocksNews->url($blocksNews->currentPage()-1) }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                          </a>
                        </li>

                        @for ($i = 1; $i <= $blocksNews->lastPage(); $i++)
                            <?php
                            $half_total_links = floor($link_limit / 2);
                            $from = $blocksNews->currentPage() - $half_total_links;
                            $to = $blocksNews->currentPage() + $half_total_links;
                            if ($blocksNews->currentPage() < $half_total_links) {
                               $to += $half_total_links - $blocksNews->currentPage();
                            }
                            if ($blocksNews->lastPage() - $blocksNews->currentPage() < $half_total_links) {
                                $from -= $half_total_links - ($blocksNews->lastPage() - $blocksNews->currentPage()) - 1;
                            }
                            ?>

                             @if ($from < $i && $i < $to)
                            <li class="page-item {{ ($blocksNews->currentPage() == $i) ? ' active' : '' }}">

                <a class="page-link" href='{{ str_replace('/?','?',$blocksNews->url("$i")) }}'>{{ $i }}</a>

                            </li>

                             @endif

                        @endfor





                        <li class="page-item {{ ($blocksNews->currentPage() == $blocksNews->lastPage()) ? ' disabled' : '' }}">
                          <a class="page-link" href="{{ ($blocksNews->currentPage() == $blocksNews->lastPage()) ? 'javascript:void(0)' : str_replace('/?','?',$blocksNews->url($blocksNews->currentPage()+1))  }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                          </a>
                        </li>
                      </ul>
                    </nav>
                </div>
            </div>
            @endif



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
                            document.getElementById("contactus_form").reset();
                            notice('Contact Us','Contact request has been sent successfully.','success');
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
            $('#contactus_form').ajaxForm(options);
    });
</script>

@stop
