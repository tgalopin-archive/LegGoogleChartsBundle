Internal
===================

- Hierarchical organization
	
	LegGoogleChartsBundle use a hierarchical organization with Inheritance.
	You can simply add your chart type in add file in your Bundle, named as you
	want, and a class in it which extends a basic chart type.
	
	See actual chart types to learn more (in Leg/GoogleChartsBundle/Charts).

- Drivers functionnality

	LegGoogleChartsBundle use "drivers" to transform a
	file into Chart class. For example, XmlDriver::import get a filename and
	return a class for this file.
		
	A driver must extends Leg\GoogleChartsBundle\Drivers\AbstractDriver, and it
	must have an "import($filename)" method which's return a chart class.
	
	In the import method in your driver, you can get the Symfony 2 Kernel with
	$this->kernel.
	
	See actual drivers to learn more (in Leg/GoogleChartsBundle/Drivers).