@extends('admin.layouts.default')

@section('content')
<!-- CKeditor start here-->

{{ HTML::style('css/admin/custom_li_bootstrap.css') }}
{{ HTML::style('css/chosen.css') }}
{{ HTML::script('js/bootstrap.js') }}
{{ HTML::script('js/admin/ckeditor/ckeditor.js') }}
{{ HTML::script('js/chosen.jquery.js') }}

<!-- CKeditor ends-->

<div class="mws-panel grid_8">
	<div class="mws-panel-header" style="height: 46px;">
		<span> {{ trans("Add New Destination Country") }} </span>
		<a href="{{URL::to('admin/list-destination-country')}}" class="btn btn-success btn-small align">{{ trans("messages.system_management.back_to_cms") }} </a>
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
	
	{{ Form::open(['role' => 'form','url' => 'admin/save-destination-country','class' => 'mws-form', 'files' => true]) }}
	<div class="mws-panel-body no-padding">
		@if(count($languages) > 1)
			<div class="text-right mws-form-item" style="margin-right:20px; padding-top:10px; font-size: 12px;">
				<b></b>
			</div>
		@endif

		<div class="mws-form-inline">
			<div class="mws-form-row ">
				{{ HTML::decode( Form::label('region_name', trans("Region Name").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label chosen-select'])) }}
				<div class="mws-form-item">
						{{ Form::select(
							 'region_name',
							 [null => 'Please Select Region Name']+ $regionList,
							 '',
							 ['class'=>'small','id'=>'region_id']
							) 
						}}						<div class="error-message help-inline">
						<?php echo $errors->first('region_name'); ?>
					</div>
				</div>
			</div>

			<div class="mws-form-row ">
					{{ HTML::decode( Form::label('image', 'Image <span class="requireRed"> * </span>', ['class' => 'mws-form-label floatleft'])) }}
					<!-- Toll tip div start here -->
					<span class='tooltipHelp' title="" data-html="true" data-toggle="tooltip"  data-original-title="<?php echo "The attachment must be a file of type:".IMAGE_EXTENSION; ?>" style="cursor:pointer;">
						<i class="fa fa-question-circle fa-2x"> </i>
					</span>
					<!-- Toll tip div end here -->
					<div class="mws-form-item">
						{{ Form::file('image') }}
						<div class="error-message help-inline">
							<?php echo $errors->first('image'); ?>
						</div>
					</div>
			</div>

			<div class="mws-form-row ">
					{{ HTML::decode( Form::label('header_image', 'Header Image <span class="requireRed"> * </span>', ['class' => 'mws-form-label floatleft'])) }}
					<!-- Toll tip div start here -->
					<span class='tooltipHelp' title="" data-html="true" data-toggle="tooltip"  data-original-title="<?php echo "The attachment must be a file of type:".IMAGE_EXTENSION; ?>" style="cursor:pointer;">
						<i class="fa fa-question-circle fa-2x" title="please upload 1284*225 dimension Image."> </i>
					</span>
					<!-- Toll tip div end here -->
					<div class="mws-form-item">
						{{ Form::file('header_image') }}
						<p>Image dimenssions must be 1284px width and 250px height.</p>
						<div class="error-message help-inline">
							<?php echo $errors->first('header_image'); ?>
						</div>
					</div>
			</div>
		</div>

	</div>


	<div class="mws-panel-body no-padding tab-content">

		@foreach($languages as $value)
		<?php $i = $value->id; ?>
		<div id="{{ $i }}div" class="tab-pane {{ ($i ==  $language_code )?'active':'' }} ">


		<div class="mws-form-inline">
			<div class="mws-form-row ">
				{{ HTML::decode( Form::label($i.'name', trans("Name").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
				<div class="mws-form-item">
					{{ Form::text("data[$i][".'name'."]",'', ['class' => 'small']) }}
					<div class="error-message help-inline">
						<?php echo ($i ==  $language_code ) ? $errors->first('name') : ''; ?>
					</div>
				</div>
			</div>
			<div class="mws-form-row ">
				{{ HTML::decode( Form::label($i.'heading', trans("Heading").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
				<div class="mws-form-item">
					{{ Form::text("data[$i][".'heading'."]",'', ['class' => 'small']) }}
					<div class="error-message help-inline">
						<?php echo ($i ==  $language_code ) ? $errors->first('heading') : ''; ?>
					</div>
				</div>
			</div>

			<div class="mws-form-row ">
				{{ HTML::decode( Form::label($i.'_description', trans("Description").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
					<div class="mws-form-item">
						{{ Form::textarea("data[$i][".'description'."]",'', ['class' => 'small','id' => 'description_'.$i]) }}
						<span class="error-message help-inline">
						<?php echo ($i ==  $language_code ) ? $errors->first('description') : ''; ?>
						</span>
					</div>
					<script type="text/javascript">
					/* CKEDITOR fro description */
					CKEDITOR.replace( <?php echo 'description_'.$i; ?>,
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
				{{ HTML::decode( Form::label($i.'countryinfo', trans("Tribes").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
					<div class="mws-form-item">
						{{ Form::textarea("data[$i][".'countryinfo'."]",'', ['class' => 'small','id' => 'countryinfo'.$i]) }}
						<span class="error-message help-inline">
						<?php echo ($i ==  $language_code ) ? $errors->first('countryinfo') : ''; ?>
						</span>
					</div>
					<script type="text/javascript">
					/* CKEDITOR fro description */
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
			</div>

			<div class="mws-form-row ">
				{{ HTML::decode( Form::label($i.'art_architecture', trans("Art & Architecture").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
					<div class="mws-form-item">
						{{ Form::textarea("data[$i][".'art_architecture'."]",'', ['class' => 'small','id' => 'art_architecture'.$i]) }}
						<span class="error-message help-inline">
						<?php echo ($i ==  $language_code ) ? $errors->first('art_architecture') : ''; ?>
						</span>
					</div>
					<script type="text/javascript">
					/* CKEDITOR fro description */
					CKEDITOR.replace( <?php echo 'art_architecture'.$i; ?>,
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
				{{ HTML::decode( Form::label($i.'nature', trans("Nature").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
					<div class="mws-form-item">
						{{ Form::textarea("data[$i][".'nature'."]",'', ['class' => 'small','id' => 'nature'.$i]) }}
						<span class="error-message help-inline">
						<?php echo ($i ==  $language_code ) ? $errors->first('nature') : ''; ?>
						</span>
					</div>
					<script type="text/javascript">
					/* CKEDITOR fro description */
					CKEDITOR.replace( <?php echo 'nature'.$i; ?>,
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
				{{ HTML::decode( Form::label($i.'travel', trans("Travel").'<span class="requireRed"> * </span>', ['class' => 'mws-form-label'])) }}
					<div class="mws-form-item">
						{{ Form::textarea("data[$i][".'travel'."]",'', ['class' => 'small','id' => 'travel'.$i]) }}
						<span class="error-message help-inline">
						<?php echo ($i ==  $language_code ) ? $errors->first('travel') : ''; ?>
						</span>
					</div>
					<script type="text/javascript">
					/* CKEDITOR fro description */
					CKEDITOR.replace( <?php echo 'travel'.$i; ?>,
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


		</div>
		</div> 
	@endforeach
		<div class="mws-button-row">
			<div class="input" >
				<input type="submit" value="{{ trans('messages.system_management.save') }}" class="btn btn-danger">
				<a href="{{URL::to('admin/list-destination-country/add-destination-country')}}" class="btn primary"><i class=\"icon-refresh\"></i> {{ trans('messages.system_management.reset') }}</a>
			</div>
		</div>
	</div>
	{{ Form::close() }} 
</div>

<script>
	$(document).ready(function(){

		$('#region_id').chosen();

      	$('#company_id').on('change', function() {
			var company_id = $(this).val();
			$.ajax({
				 url: '<?php echo url('admin/list-destination-country/getlocation'); ?>/'+company_id,
				 type: "get",
				 dataType: "json",
                success:function(data) {
                    $('select[name="company_location"]').empty();
                    $('select[name="company_location"]').append('<option value="">Please Select Company Location');
                    $.each(data, function(key, value) {

                        $('select[name="company_location"]').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
			})	
		});
      	   /* localStorage.setItem('todos', $('#company_id').val());
      	    test = localStorage.getItem('todos'); 
      	   // alert(test);
      	    $('#company_id').val(test);*/
  	 	var company_id = $('#company_id').val();
		$.ajax({
			 url: '<?php echo url('admin/list-destination-country/getlocation'); ?>/'+company_id,
			 type: "get",
			 dataType: "json",
            success:function(data) {
                $('select[name="company_location"]').empty();
                $('select[name="company_location"]').append('<option value="">Please Select Company Location');
                $.each(data, function(key, value) {

                    $('select[name="company_location"]').append('<option value="'+ key +'" selected="selected">'+ value +'</option>');
                });
            }
		})	
	});
</script>

@stop

