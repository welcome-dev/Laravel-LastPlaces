@extends('admin.layouts.default')

@section('content')

<script type="text/javascript">
$(function(){
	$('[data-delete]').click(function(e){
		
	     e.preventDefault();
		// If the user confirm the delete
		if (confirm('Do you really want to delete the element ?')) {
			// Get the route URL
			var url = $(this).prop('href');
			// Get the token
			var token = $(this).data('delete');
			// Create a form element
			var $form = $('<form/>', {action: url, method: 'post'});
			// Add the DELETE hidden input method
			var $inputMethod = $('<input/>', {type: 'hidden', name: '_method', value: 'delete'});
			// Add the token hidden input
			var $inputToken = $('<input/>', {type: 'hidden', name: '_token', value: token});
			// Append the inputs to the form, hide the form, append the form to the <body>, SUBMIT !
			$form.append($inputMethod, $inputToken).hide().appendTo('body').submit();
		} 
	});
});
</script>

<div id="mws-themer">
	<div id="mws-themer-content" style="<?php echo ($searchVariable) ? 'right: 256px;' : ''; ?>">
		<div id="mws-themer-ribbon"></div>
		<div id="mws-themer-toggle" class="<?php echo ($searchVariable) ? 'opened' : ''; ?>">
			<i class="icon-bended-arrow-left"></i> 
			<i class="icon-bended-arrow-right"></i>
		</div>
	
		{{ Form::open(['method' => 'get','role' => 'form','url' => 'admin/settings','class' => 'mws-form']) }}
		{{ Form::hidden('display') }}
		<div class="mws-themer-section">
			<div id="mws-theme-presets-container" class="mws-themer-section">
				<label>{{ 'Title' }}</label><br/>
				{{ Form::text('title',((isset($searchVariable['title'])) ? $searchVariable['title'] : ''), ['class' => 'small']) }}
			</div>
		</div>
		<div class="mws-themer-separator"></div>
		<div class="mws-themer-section" style="height:0px">
			<ul><li class="clearfix"><span></span> <div id="mws-textglow-op"></div></li> </ul>
		</div>
		<div class="mws-themer-section">
			<input type="submit" value="Search" class="btn btn-primary btn-small">
			<a href="{{URL::to('admin/settings')}}"  class="btn btn-default btn-small">Reset</a>
		</div>
		{{ Form::close() }}
	</div>
</div>



<div  class="mws-panel grid_8 mws-collapsible">
	<div class="mws-panel-header">
		<span>
			<i class="icon-table"></i> {{ 'App Setting' }} </span>
			<a href="{{URL::to('admin/settings/add-setting')}}" class="btn btn-success btn-small align">{{ 'Add New Setting' }} </a>
	</div>
	<div class="mws-panel-body no-padding dataTables_wrapper">
		<table class="mws-table mws-datatable">
			<thead>
				<tr>
					<th width="10%" >
					{{
						link_to_route(
							'settings.listSetting',
							'Id',
							array(
								'sortBy' => 'id',
								'order' => ($sortBy == 'id' && $order == 'desc') ? 'asc' : 'desc'
							),
						   array('class' => (($sortBy == 'id' && $order == 'desc') ? 'sorting desc' : (($sortBy == 'id' && $order == 'asc') ? 'sorting asc' : 'sorting')) )
						)
					}}
					</th>
					<th width="30%">
					{{
						link_to_route(
							'settings.listSetting',
							'Title',
							array(
								'sortBy' => 'title',
								'order' => ($sortBy == 'title' && $order == 'desc') ? 'asc' : 'desc'
							),
						   array('class' => (($sortBy == 'title' && $order == 'desc') ? 'sorting desc' : (($sortBy == 'title' && $order == 'asc') ? 'sorting asc' : 'sorting')) )
						)
					}}
					</th>
					<th width="20%">
					{{
						link_to_route(
								'settings.listSetting',
								'Key',
								array(
									'sortBy' => 'key',
									'order' => ($sortBy == 'key' && $order == 'desc') ? 'asc' : 'desc'
								),
							   array('class' => (($sortBy == 'key' && $order == 'desc') ? 'sorting desc' : (($sortBy == 'key' && $order == 'asc') ? 'sorting asc' : 'sorting')) )
							)
					}}
	                </th>
					<th width="20%">
					{{
						link_to_route(
							'settings.listSetting',
							'Value',
							array(
								'sortBy' => 'value',
								'order' => ($sortBy == 'value' && $order == 'desc') ? 'asc' : 'desc'
							),
						   array('class' => (($sortBy == 'value' && $order == 'desc') ? 'sorting desc' : (($sortBy == 'value' && $order == 'asc') ? 'sorting asc' : 'sorting')) )
						)
					}}
	                </th>
					<th>{{ 'Action' }}</th>
				</tr>
			</thead>
			<tbody>
				@if(!$result->isEmpty())
				@foreach($result as $record)
				<?php
					$key = $record->key;
					$keyE = explode('.', $key);
					$keyPrefix = $keyE['0'];
					if (isset($keyE['1'])) {
						$keyTitle = '.' . $keyE['1'];
					} else {
						$keyTitle = '';
					}
					?>
				<tr>
					<td data-th='Id'>{{ $record->id }}</td>
					<td data-th='Title'>{{ $record->title }}</td>
					<td data-th='Key'>
						<a target="_blank" href="{{URL::to('admin/settings/prefix/'.$keyPrefix)}}" >{{ $keyPrefix }}</a>{{ $keyTitle }}
					</td>
					<td data-th='Value'>
						{{ strip_tags(Str::limit($record->value, 20)) }}
					</td>	
					<td data-th='Action'>
						<a href="{{URL::to('admin/settings/edit-setting/'.$record->id)}}" class="btn btn-info btn-small">{{ 'Edit' }} </a>
						<a href="{{URL::to('admin/settings/delete-setting/'.$record->id)}}" data-delete="delete" class="btn btn-danger btn-small no-ajax">{{ 'Delete' }} </a>
					</td>
				</tr>
				 @endforeach  
			</tbody>
		</table>
		
		@else
		<table class="mws-table mws-datatable details">	
			<tr>
				<td align="center" width="100%"> {{ 'No Records Found' }}</td>
			</tr>	
			@endif 
		</table>
	</div>
		@include('pagination.default', ['paginator' => $result])
</div>
@stop
