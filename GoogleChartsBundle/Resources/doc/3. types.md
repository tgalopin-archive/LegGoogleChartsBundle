Chart types and their properties
===================

For more informations and attributes, see :

	http://code.google.com/apis/chart/image/

###########################################################
BasicChart :
<ul>
	<li>type [string] : Type (Bar, Line, ...)</li>
	<li>width [integer] : Width</li>
	<li>height [integer] : Height</li>
	<li>datas [array] : Array of datas values</li>
	<li>labels [array] : Array of datas labels</li>
	<li>labels_options [array] : Array of options for the labels
		<ul>
			<li>text-align [string] : Alignement</li>
			<li>color [string] : Color</li>
			<li>font-size [integer] : Size</li>
		</ul>
	</li>
	<li>colors [array] : Colors for the chart</li>
	<li>title [string] : Title</li>
	<li>title_options [array] : Array of options for the title
		<ul>
			<li>text-align [string] : Alignement</li>
			<li>color [string] : Color</li>
			<li>font-size [integer] : Size</li>
		</ul>
	<li>transparency [boolean] : Set if the chart is transparent</li>
	<li>margins [array] : Margins
		<ul>
			<li>top [integer] : Margin-top</li>
			<li>bottom [integer] : Margin-bottom</li>
			<li>left [integer] : Margin-left</li>
			<li>right [integer] : Margin-right</li>
			<li>legend-width [integer] : Legend's margin right and left</li>
			<li>legend-height [integer] : Legend's margin top and bottom</li>
		</ul>
	</li>
</ul>
	
###########################################################	
BarChart extends BasicChart :
<ul>
	<li>axsis [array] : Array of visible axes</li>
	<li>zero_lines [array] : Custom zero line for your chart</li>
	<li>bar_width [integer] : Width for bars</li>
	<li>bar_spacing [integer] : Spacing beetween bars</li>
</ul>
	
###########################################################
Bar\HorizontalGroupedChart [extends BarChart]

###########################################################
Bar\VerticalGroupedChart [extends BarChart]

###########################################################
Bar\VerticalStackedChart [extends BarChart] :
<ul>
	<li>stacked_mode [string] : Stacked mode for the bars (atop or front)</li>
</ul>

###########################################################
GomChart [extends BasicChart]

###########################################################
LineChart [extends BasicChart]

###########################################################
Line\BothAxsisChart [extends LineChart]

###########################################################
Line\NoAxsisChart [extends LineChart]

###########################################################
PieChart [extends BasicChart] :
<ul>
	<li>rotation [integer] : Pie rotation</li>
</ul>

###########################################################
Pie\ConcentricChart [extends PieChart]

###########################################################
Pie\ThreeDimensionsChart [extends PieChart]

###########################################################
RadarChart [extends BasicChart]

###########################################################
ScatterChart [extends BasicChart]

###########################################################
VennChart [extends BasicChart]
	
	
	
	