@extends('admin.layouts.default')

@section('content')

<script type="text/javascript">
 //var action_url = '<?php echo WEBSITE_URL; ?>admin/email-manager/multiple-action';
</script>
 
{{{-- HTML::script('js/admin/multiple_delete.js') --}}}

<div id="mws-themer">
	<div id="mws-themer-content" style="<?php echo ($searchVariable) ? 'right: 256px;' : ''; ?>">
		<div id="mws-themer-ribbon"></div>
		<div id="mws-themer-toggle" class="<?php echo ($searchVariable) ? 'opened' : ''; ?>">
			<i class="icon-bended-arrow-left"></i> 
			<i class="icon-bended-arrow-right"></i>
		</div>
	
		{{ Form::open(['method' => 'get','role' => 'form','url' => 'admin/email-manager','class' => 'mws-form']) }}
		{{ Form::hidden('display') }}
		<div class="mws-themer-section">
			<div id="mws-theme-presets-container" class="mws-themer-section">
				<label>{{ trans("messages.system_management.name") }}</label><br/>
				{{ Form::text('name',((isset($searchVariable['name'])) ? $searchVariable['name'] : ''), ['class' => 'small']) }}
			</div>
		</div>
		
		<div class="mws-themer-section">
			<div id="mws-theme-presets-container" class="mws-themer-section">
				<label>{{ trans("messages.system_management.subject") }}</label><br/>
				{{ Form::text('subject',((isset($searchVariable['subject'])) ? $searchVariable['subject'] : ''), ['class' => 'small']) }}
			</div>
		</div>
		
		<div class="mws-themer-separator"></div>
		<div class="mws-themer-section" style="height:0px">
			<ul><li class="clearfix"><span></span> <div id="mws-textglow-op"></div></li> </ul>
		</div>
		<div class="mws-themer-section">
			<input type="submit" value='{{ trans("messages.system_management.search")}}' class="btn btn-primary btn-small">
			<a href="{{URL::to('admin/email-manager')}}"  class="btn btn-default btn-small">{{  trans("messages.system_management.reset") }}</a>
		</div>
		{{ Form::close() }}
	</div>
</div>

<div  class="mws-panel grid_8 mws-collapsible">
	<div class="mws-panel-header">
		<span>
			<i class="icon-table"></i> {{ trans("messages.system_management.email_templates") }} </span>
			@if(Config::get('app.debug'))
			<a href="{{URL::to('admin/email-manager/add-template')}}" class="btn btn-success btn-small align">{{ trans("messages.system_management.add_email_template") }} </a>
			@endif
	</div>
	<div class="dataTables_wrapper" style="background-color:#CCCCCC">
<!--
		<div id="DataTables_Table_0_length" class="dataTables_length">
			<?php //echo $this->element('paging_info'); ?><?php 
			$actionTypes	= array(
					'delete' 		=> trans("messages.global.delete_all"),
				 );
			?>
			{{ Form::open() }}
				{{ Form::checkbox('is_checked','',null,['class'=>'left checkAllUser'])}}
				{{ Form::select('action_type',array(''=>'Select Action')+$actionTypes,$actionTypes,['class'=>'deleteall selectUserAction'])}}
			{{ Form::close() }}
		</div>
-->
	</div>
	<div class="mws-panel-body no-padding dataTables_wrapper">
		<table class="mws-table mws-datatable">
			<thead>
				<tr>
<!--
					<th></th>
-->
					<th>
						{{
							link_to_route(
							'EmailTemplate.index',
							 trans("messages.system_management.name") ,
							array(
								'sortBy' => 'name',
								'order' => ($sortBy == 'name' && $order == 'desc') ? 'asc' : 'desc'
							),
							array('class' => (($sortBy == 'name' && $order == 'desc') ? 'sorting desc' : (($sortBy == 'name' && $order == 'asc') ? 'sorting asc' : 'sorting')) )
							)
						}}
					</th>
					<th>
						{{
							link_to_route(
							'EmailTemplate.index',
							 trans("messages.system_management.subject"),
							array(
								'sortBy' => 'subject',
								'order' => ($sortBy == 'subject' && $order == 'desc') ? 'asc' : 'desc'
							),
							array('class' => (($sortBy == 'subject' && $order == 'desc') ? 'sorting desc' : (($sortBy == 'subject' && $order == 'asc') ? 'sorting asc' : 'sorting')) )
							)
						}}
					</th>
					<th>
						
						{{
							link_to_route(
							'EmailTemplate.index',
							 trans("messages.system_management.created"),
							array(
								'sortBy' => 'created_at',
								'order' => ($sortBy == 'created_at' && $order == 'desc') ? 'asc' : 'desc'
							),
							array('class' => (($sortBy == 'created_at' && $order == 'desc') ? 'sorting desc' : (($sortBy == 'created_at' && $order == 'asc') ? 'sorting asc' : 'sorting')) )
							)
						}}
					</th>
					<th>{{ trans("messages.system_management.action") }}</th>
				</tr>
			</thead>
			<tbody id="powerwidgets">
				<?php
				if(!$result->isEmpty()){
				foreach($result as $record){?>
				<tr class="items-inner">
<!--
					<td data-th='{{ trans("messages.system_management.select")  }}'>
					{{ Form::checkbox('status',$record->id,null,['class'=> 'userCheckBox'] )}}
					</td>
-->
					<td data-th='{{  trans("messages.system_management.name")  }}'>{{ $record->name }}</td>
					<td data-th='{{ trans("messages.system_management.subject") }}'>{{ $record->subject }}</td>
					<td data-th='{{ trans("messages.system_management.created") }}'>{{ date(Config::get("Reading.date_format"),strtotime($record->created_at)) }}</td>
					<td data-th='Action'>
						<a href="{{URL::to('admin/email-manager/edit-template/'.$record->id)}}" class ="btn btn-info btn-small" >
							{{ trans("messages.system_management.edit") }} 
						</a>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php }else{ ?>
		<table class="mws-table mws-datatable details">	
			<tr>
				<td align="center" width="100%"> {{ trans("messages.system_management.no_record_found_message") }}</td>
			</tr>	
			<?php  } ?>
		</table>
	</div>
	@include('pagination.default', ['paginator' => $result])
</div>
@stop
