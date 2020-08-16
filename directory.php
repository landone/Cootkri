<?php

function echoDir($path) {
	
	if ($handle = opendir($path)) {
		
		while (false !== ($entry = readdir($handle))) {
			
			if ($entry != "." && $entry != "..") {
				
				echo "<a href=\"".$path."/".$entry."\">".$entry."</a><br>";
				
			}
			
		}
		
		closedir($handle);
		
	}
	
}

?>