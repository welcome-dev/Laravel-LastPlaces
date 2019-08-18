@extends('admin.layouts.default')

@section('content')
<!-- CKeditor start here-->

{{ HTML::style('css/admin/custom_li_bootstrap.css') }}
{{ HTML::style('css/chosen.css') }}

{{ HTML::script('js/bootstrap.js') }}
{{ HTML::script('js/admin/ckeditor/ckeditor.js') }}
{{ HTML::script('js/chosen.jquery.js') }}

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#trip_date" ).datepicker();
  } );
 </script>
<style>
.chosen-container-single .chosen-single {
	padding:0px !important;
	height:30px;
}
</style>

<div class="mws-panel grid_8">

	<div class="mws-panel-header" style="height: 46px;">
		<span> {{ trans("messages.$modelName.table_heading_add") }} </span>
		<a href='{{ route("$modelName.index")}}' class="btn btn-success btn-small align">
		{{ trans("messages.global.back") }} </a>
	</div>

	@if(count($languages) > 1)
		<div  class="default_language_color">
			{{ Config::get('default_language.message') }}
		</div>
		<div class="wizard-nav wizard-nav-horizontal">
			<ul class="nav nav-tabs">
				@foreach($languages as $value)
				<?php $i = $value->id; ?>
					<li class=" {{ ($i ==  $language_code )?'active':'' }}">
						<a data-toggle="tab" href="#{{ $i }}div">
							{{ $value -> title }}
						</a>
					</li>
				@endforeach
			</ul>
		</div>
	@endif

		{{ Form::open(['role' => 'form','url' =>  route("$modelName.update","$trip->id"),'class' => 'mws-form', 'files' => true]) }}

		<div class="mws-panel-body no-padding">
		@if(count($languages) > 1)
			<div class="text-right mws-form-item" style="margin-right:20px; padding-top:10px; font-size: 12px;">
				<b>{{ trans("messages.global.language_field") }}</b>
			</div>
		@endif
		<div class="mws-form-inline">
			<div class="mws-form-row ">
				{{ HTML::decode( Form::label('country_id', trans("Country Name").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
				<div class="mws-form-item">
						{{ Form::select(
							 'country_id',
							 [null => 'Please Select Country Name']+ $countryList,
							 $trip->country_id,
							 ['class'=>'small','id'=>'country_id']
							) 
						}}						<div class="error-message help-inline">
						<?php echo $errors->first('country_id'); ?>
					</div>
				</div>
			</div>
		</div>
	<script>
		$(document).ready(function(e){
			$("#country_id").chosen();
		})
	</script>
		<div class="mws-form-row ">
				{{ HTML::decode( Form::label('image', 'Image <span class="requireRed"></span>', ['class' => 'mws-form-label floatleft'])) }}
			
				<span class='tooltipHelp' title="" data-html="true" data-toggle="tooltip"  data-original-title="<?php echo "The attachment must be a file of type:".IMAGE_EXTENSION; ?>" style="cursor:pointer;">
					<i class="fa fa-question-circle fa-2x"> </i>
				</span>
				
				<div class="mws-form-item">
					{{ Form::file('image') }}
					<div class="error-message help-inline">
						<?php echo $errors->first('image'); ?>

						<?php 
						$oldImage	=	Input::old('image');
						$image		=	isset($oldImage) ? $oldImage : $trip->image;
						?>
						@if($image !=''  && TRIP_IMAGE_ROOT_PATH.$image)
							{{ HTML::image( TRIP_IMAGE_URL.$trip->image, $trip->image , array(  'width' => 200, 'height'=> 200 )) }}
						@endif
					</div>
				</div>
		</div> 


		<div class="mws-form-row ">
				{{ HTML::decode( Form::label('header_image', 'Header Image <span class="requireRed"></span>', ['class' => 'mws-form-label floatleft'])) }}
			
				<span class='tooltipHelp' title="" data-html="true" data-toggle="tooltip"  data-original-title="<?php echo "The attachment must be a file of type:".IMAGE_EXTENSION; ?>" style="cursor:pointer;">
					<i class="fa fa-question-circle fa-2x" title="please upload 1284*225 dimension Image."> </i>
				</span>
				
				<div class="mws-form-item">
					{{ Form::file('header_image') }}
					<p>Image dimenssions must be 1284px width and 250px height.</p>
					<div class="error-message help-inline">
						<?php echo $errors->first('header_image'); ?>

						<?php 
						$oldImage	=	Input::old('header_image');
						$image		=	isset($oldImage) ? $oldImage : $trip->header_image;
						?>
						@if($image !=''  && TRIP_HEADER_IMAGE_ROOT_PATH.$image)
							{{ HTML::image( TRIP_HEADER_IMAGE_URL.$trip->header_image, $trip->header_image , array(  'width' => 200, 'height'=> 200 )) }}
						@endif
					</div>
				</div>
		</div> 

		<div class="mws-form-inline">
			<div class="mws-form-row">
				{{ HTML::decode( Form::label('baseprice', trans("messages.$modelName.baseprice").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
			
				<div class="mws-form-item">
					{{ Form::text('baseprice',$trip->baseprice, ['class' => 'small']) }}
					<div class="error-message help-inline">
						<?php echo $errors->first('baseprice'); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="mws-form-inline">
			<div class="mws-form-row">
				{{ HTML::decode( Form::label('tripdate', trans("messages.$modelName.tripdate"), ['class' => 'mws-form-label'])) }}
			
				<div class="mws-form-item">
					{{ Form::text('tripdate',$trip->tripdates, ['class' => 'small','id'=>'trip_date']) }}
					<div class="error-message help-inline">
						<?php echo $errors->first('tripdate'); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="mws-form-inline">
			<div class="mws-form-row">
				{{ HTML::decode( Form::label('tripdays', trans("messages.$modelName.tripdays").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
			
				<div class="mws-form-item">
					{{ Form::text('tripdays',$trip->tripdays, ['class' => 'small']) }}
					<div class="error-message help-inline">
						<?php echo $errors->first('tripdays'); ?>
					</div>
				</div>
			</div>
		</div>

		<!--<div class="mws-form-row">
				{{ HTML::decode( Form::label('baseprice', trans("messages.$modelName.baseprice").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
			
				<div class="mws-form-item">
					{{ Form::text('baseprice','', ['class' => 'small']) }}
					<div class="error-message help-inline">
							<?php echo $errors->first('baseprice'); ?>								
					</div>
				</div>
		</div> -->

	</div>

	<div class="mws-panel-body no-padding tab-content"> 
				@foreach($languages as $value)
					<?php $i = $value->id; ?>
					<div id="{{ $i }}div" class="tab-pane {{ ($i ==  $language_code )?'active':'' }} ">
						<div class="mws-form-inline">


						<div class="mws-form-row">
							{{ HTML::decode( Form::label($i.'.tripname', trans("messages.$modelName.tripname").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
						
							<div class="mws-form-item">
								{{ Form::text("data[$i][".'tripname'."]",isset($multiLanguage[$i]['tripname'])?$multiLanguage[$i]['tripname']:'', ['class' => 'small']) }}
								<div class="error-message help-inline">
										<?php echo ($i ==  $language_code ) ? $errors->first('tripname') : ''; ?>	
										@if($errors->any())
											{{$errors->first()}}										
										@endif							</div>
							</div>
						</div>


							<div class="mws-form-row ">
						{{ HTML::decode( Form::label($i.'_body', trans("messages.$modelName.description").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
						
						<div class="mws-form-item">
							{{ Form::textarea("data[$i][".'description'."]",isset($multiLanguage[$i]['description'])?$multiLanguage[$i]['description']:'', ['class' => 'small','id' => 'body_'.$i]) }}
							<span class="error-message help-inline">
								<?php echo ($i ==  $language_code ) ? $errors->first('description') : ''; ?>
							</span>
						</div>
						<script type="text/javascript">
						/* For CKEDITOR */
							
							CKEDITOR.replace( <?php echo 'body_'.$i; ?>,
							{
								height: 350,
								width: 600,
								filebrowserUploadUrl : '<?php echo URL::to('base/uploder'); ?>',
								filebrowserImageWindowWidth : '640',
								filebrowserImageWindowHeight : '480',
								enterMode : CKEDITOR.ENTER_BR
							});
								
						</script>
					</div>


					


					<div class="mws-form-row ">
						{{ HTML::decode( Form::label($i.'overview', trans("messages.$modelName.overview").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
						
						<div class="mws-form-item">
							{{ Form::textarea("data[$i][".'overview'."]",isset($multiLanguage[$i]['overview'])?$multiLanguage[$i]['overview']:'', ['class' => 'small','id' => 'overview'.$i]) }}
							<span class="error-message help-inline">
								<?php echo ($i ==  $language_code ) ? $errors->first('overview') : ''; ?>
							</span>
						</div>
						<script type="text/javascript">
						/* For CKEDITOR */
							
							CKEDITOR.replace( <?php echo 'overview'.$i; ?>,
							{
								height: 350,
								width: 600,
								filebrowserUploadUrl : '<?php echo URL::to('base/uploder'); ?>',
								filebrowserImageWindowWidth : '640',
								filebrowserImageWindowHeight : '480',
								enterMode : CKEDITOR.ENTER_BR
							});
								
						</script>
					</div>


					<div class="mws-form-row ">
						{{ HTML::decode( Form::label($i.'itinerary', trans("messages.$modelName.itinerary").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
						
						<div class="mws-form-item">
							{{ Form::textarea("data[$i][".'itinerary'."]",isset($multiLanguage[$i]['itinerary'])?$multiLanguage[$i]['itinerary']:'', ['class' => 'small','id' => 'itinerary'.$i]) }}
							<span class="error-message help-inline">
								<?php echo ($i ==  $language_code ) ? $errors->first('itinerary') : ''; ?>
							</span>
						</div>
						<script type="text/javascript">
						/* For CKEDITOR */
							
							CKEDITOR.replace( <?php echo 'itinerary'.$i; ?>,
							{
								height: 350,
								width: 600,
								filebrowserUploadUrl : '<?php echo URL::to('base/uploder'); ?>',
								filebrowserImageWindowWidth : '640',
								filebrowserImageWindowHeight : '480',
								enterMode : CKEDITOR.ENTER_BR
							});
								
						</script>
					</div>

					<?php  /*

					<div class="mws-form-row ">
						{{ HTML::decode( Form::label($i.'countryinfo', trans("messages.$modelName.countryinfo").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
						
						<div class="mws-form-item">
							{{ Form::textarea("data[$i][".'countryinfo'."]",isset($multiLanguage[$i]['countryinfo'])?$multiLanguage[$i]['countryinfo']:'', ['class' => 'small','id' => 'countryinfo'.$i]) }}
							<span class="error-message help-inline">
								<?php echo ($i ==  $language_code ) ? $errors->first('countryinfo') : ''; ?>
							</span>
						</div>
						<script type="text/javascript">
							
							CKEDITOR.replace( <?php echo 'countryinfo'.$i; ?>,
							{
								height: 350,
								width: 600,
								filebrowserUploadUrl : '<?php echo URL::to('base/uploder'); ?>',
								filebrowserImageWindowWidth : '640',
								filebrowserImageWindowHeight : '480',
								enterMode : CKEDITOR.ENTER_BR
							});
								
						</script>
					</div>   */ ?>



						</div>

					</div>

				@endforeach

				<div class="mws-button-row">
					<div class="input" >
						<input type="submit" value="{{ trans('messages.global.save') }}" class="btn btn-danger">
						<a href="{{ route($modelName.'.add')}}" class="btn primary"><i class=\"icon-refresh\"></i> {{ trans('messages.global.reset') }}</a>
					</div>
				</div>
	</div>

		{{ Form::close() }} 


</div>

@stop
