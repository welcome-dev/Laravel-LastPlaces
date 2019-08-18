@extends('admin.layouts.default')

@section('content')

<!--- graph js start here-->
{{ HTML::script('js/admin/plugins/jqplot/jquery.jqplot.js') }}
{{ HTML::script('js/admin/plugins/jqplot/plugins/jqplot.barRenderer.js') }}
{{ HTML::script('js/admin/plugins/jqplot/plugins/jqplot.pointLabels.js') }}
{{ HTML::script('js/admin/plugins/jqplot/plugins/jqplot.categoryAxisRenderer.js') }}
{{ HTML::script('js/admin/plugins/jqplot/plugins/jqplot.highlighter.js') }}
{{ HTML::script('js/admin/plugins/jqplot/plugins/jqplot.canvasTextRenderer.min.js') }}
{{ HTML::script('js/admin/plugins/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js') }}
{{ HTML::script('js/admin/plugins/jqplot/plugins/jqplot.pieRenderer.min.js') }}

{{ HTML::style('css/admin/jqplot/jquery.jqplot.css') }}

<!-- graph js end here -->
<script type="text/javascript">
	
	var barSeriesDefault	=	{
		renderer:$.jqplot.BarRenderer,
		pointLabels: { show: true },
		rendererOptions: {
		barPadding: 8,
		barMargin: 10,
		barWidth: 15,
		barDirection: 'vertical',
		shadowOffset: 2,
		shadowDepth: 5,
		shadowAlpha: 0.8,
			
		},
	};

	/** USERS  #START **/
	$(document).ready(function(){
		var ticks1 = new Array();
		var var1	=	[];
		var var2	=	[];
		<?php 
		$num = 1;
		foreach($allUsers as $graphData){ ?>
			var1.push([<?php echo $num; ?>, <?php echo $graphData['users']; ?>]);
			ticks1.push([ "<?php echo date('M' ,strtotime($graphData['month'])); ?>"]);
		<?php 
		$num ++;
		}  ?> 
		<?php 
		$num_lawyer = 1;
		foreach($allinactive as $graphLawyerData){ ?>
		var2.push([<?php echo $num_lawyer; ?>, <?php echo $graphLawyerData['users']; ?>]);
		<?php $num_lawyer ++; } ?>
		
		plot2 = $.jqplot('chart_of_users', [var1, var2], {
						
		seriesDefaults: barSeriesDefault,
					
		seriesColors:['#18bc9c', '#e64264'],	// colors of the bar
									
		series:			
			[
				{label: "No. of Active User"},
				{label: "No. of InActive User"}
			],
		legend:			
			{
			   renderer: $.jqplot.EnhancedLegendRenderer,
			   show:true,
			   location: 'nw',
			},
									
		axes: 
			{
				xaxis: {
					renderer: $.jqplot.CategoryAxisRenderer,
					ticks: ticks1,
					axisLabel: "Months",
					axisLabelUseCanvas: true,
					axisLabelFontSizePixels: 12,
					axisLabelFontFamily: 'Verdana, Arial',
					
				},
				yaxis: {
					min:0,
					axisLabel: "No. of users",
					axisLabelUseCanvas: true,
					axisLabelFontSizePixels: 12,
					axisLabelFontFamily: 'Verdana, Arial',
					axisLabelPadding: 3,
					tickInterval: 1, 
					tickOptions: { 
						formatString: '%d' 
					}
				},
			},
														
		 highlighter: 
			{
				showMarker: false,
				tooltipAxes: 'xy',
				showTooltip: true,
				show: true,
				sizeAdjust: 10,
				tooltipContentEditor:customCompanyTooltip
				
			},
					
		});
	});
	/**
	 * Function for tooltip
	 */
	function customCompanyTooltip(str, seriesIndex, pointIndex, plot) {
		var label	=	'';
		if(seriesIndex == 0)
			label	=	"No. of Active Users";
		else if(seriesIndex == 1)
			label	=	"No. of Active Users";
		
		var users	=	str.split(', ')
		
		return plot.series[seriesIndex]["label"] + "<br> " + plot.options.axes.xaxis.ticks[pointIndex] + " : " + users[1];
	}
</script>

<div class="mws-stat-container clearfix" style="font-size:12px">
	<!-- Statistic Item -->
	<a class="mws-stat" href="{{ URL::to('admin/users')}}">
		<!-- Statistic Icon (edit to change icon) -->
		
		<span class="mws-stat-icon icol32-group"></span>
		
		<!-- Statistic Content -->
		<span class="mws-stat-content">
			<span class="mws-stat-title">{{ trans("messages.dashboard.all_users")}}</span>
			<span class="mws-stat-value"><?php echo isset($totalUser) ? $totalUser : 0; ?></span>
		</span>
	</a>
	<a class="mws-stat" href="{{ URL::to('admin/users') }}">
		<!-- Statistic Icon (edit to change icon) -->
		
		<span class="mws-stat-icon icol32-group"></span>
		
		<!-- Statistic Content -->
		<span class="mws-stat-content">
			<span class="mws-stat-title">{{ trans("messages.dashboard.active_users")}}</span>
			<span class="mws-stat-value"><?php echo isset($totalActiveUser) ? $totalActiveUser : 0; ?></span>
		</span>
	</a>
	<a class="mws-stat" href="{{ URL::to('admin/users') }}">
		<!-- Statistic Icon (edit to change icon) -->
		
		<span class="mws-stat-icon icol32-group"></span>
		
		<!-- Statistic Content -->
		<span class="mws-stat-content">
			<span class="mws-stat-title">{{ trans("messages.dashboard.inactive_users")}}</span>
			<span class="mws-stat-value"><?php echo isset($totalInActiveUser) ? $totalInActiveUser : 0; ?></span>
		</span>
	</a>
</div>
<div class="mws-panel grid_8">
	<div class="mws-panel-header">
		<span><i class="icon-graph"></i>{{ trans("messages.dashboard.users_status")}}</span>
	</div>
	<div class="mws-panel-body">
		<div id="chart_of_users"></div>
	</div>
</div>
@stop
