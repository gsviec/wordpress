<?php
#-----------------------------------------
#	RT-Theme common_classes.php
#	version: 1.0
#-----------------------------------------

#
# 	Load the theme
#

class RTFramework_Common_Classes extends RTFramework{
	   
	#
	#	Convert Object to array
	#
	function rtframework_objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
 
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	}
	
}


?>