Chart types and their properties
================================

For more informations and attributes, see : `http://code.google.com/apis/chart/image/`

### BaseChart :

- type [string] : Type (Bar, Line, ...)
- width [integer] : Width
- height [integer] : Height
- datas [array] : Array of datas values
- labels [array] : Array of datas labels
- labels_options [array] : Array of options for the labels
	- position [string] : Legend position
	- color [string] : Color
	- font-size [integer] : Size
- colors [array] : Colors for the chart
- title [string] : Title
- title_options [array] : Array of options for the title
	- text-align [string] : Alignement
	- color [string] : Color
	- font-size [integer] : Size
- transparency [boolean] : Set if the chart is transparent
- margins [array] : Margins
	- top [integer] : Margin-top
	- bottom [integer] : Margin-bottom
	- left [integer] : Margin-left
	- right [integer] : Margin-right
	- legend-width [integer] : Legend's margin right and left
	- legend-height [integer] : Legend's margin top and bottom

### BarChart [extends BasicChart] :

- axsis [array] : Array of visible axes
- zero_lines [array] : Custom zero line for your chart
- bar_width [integer] : Width for bars
- bar_spacing [integer] : Spacing beetween bars
	
### Bar\HorizontalGroupedChart [extends BarChart]

### Bar\VerticalGroupedChart [extends BarChart]

### Bar\VerticalStackedChart [extends BarChart] :
- stacked_mode [string] : Stacked mode for the bars (atop or front)

### GomChart [extends BasicChart]

### LineChart [extends BasicChart]

### Line\BothAxsisChart [extends LineChart]

### Line\NoAxsisChart [extends LineChart]

### PieChart [extends BasicChart] :
- rotation [integer] : Pie rotation

### Pie\ConcentricChart [extends PieChart]

### Pie\ThreeDimensionsChart [extends PieChart]

### RadarChart [extends BasicChart]

### ScatterChart [extends BasicChart]

### VennChart [extends BasicChart]


### Next Steps

The following documents are available:

- [Using cache with the CacheEngine](cache.md)
- [Avanced usage of LegGoogleChartsBundle](internal.md)
