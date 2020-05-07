<?php


if (isMobile()){

	$npmod=1;
	$nimod=1;
	} else {
	$npmod=2;
	$nimod=4;
}
#basic setup what we need to search for
# we get the project and variable from index.php

#which variable to look for
$ext = 'svg'

if (!in_array($project, $specialprojects)) {
    $dir    = './projects/'.$project.'/plots/';
    #start with the 1week first so its show the weekplots directly without ugly loading before since 1 week is the default
    $codes=['1week','0day','2month','3year'];
    $infofile= './projects/'.$project.'/info/info_'.$selectedvar.'.php';
    $statusfile= './projects/'.$project.'/info/info_'.$selectedvar.'.php';
    $nc = 0;
    foreach ($codes as $code) {
	#iplotfiles, number of plots = np
    	$np = 0;

    	echo '<div id="'.$code.'" class="svg_plts">
    	';
    	foreach (glob($dir . $code.'/*_'.$selectedvar.'_*.'.$ext) as $file) {
        	echo '                <a href="';
          	$tfile=explode('/',$file);
         	echo $file;
         	echo '" target="_blank" title ="Click to open in new tab"><img src="';
         	echo $file;
         	echo '" class="dolueg-svg" alt ="" /></a>
         		';
         $np=$np+1;
    }

    if ($np == 0) {echo '<div >No graphs for this selection.</div>' ;}
    
    if ($np % $npmod == 1){echo "</div>";}
        echo "</div>
        ";
        $nc=$nc+1;
    }

    echo '<div id="info" class="svg_plts">';
    
    # include an additional infofile that can exist but doesnt have to
    include $infofile;
	
    #switch codes for day week etc for the infofiles
    $codes=['0day','1week','2month','3year'];

    #infofiles, number of info = ni
    $inforange=['Tag','Woche','Monat','Jahr'];
    $nc = count(glob($dir.'*_'.$selectedvar.'i_*.'.$ext));
    if ($nc > 4 ) { $nc = 4;}
    $ni = 0;
    foreach ($codes as $code) {
	foreach (glob($dir.$code.'/*_'.$selectedvar.'i_*.'.$ext) as $file) {
        	echo '<a href="';
        	echo $file;
        	echo '" target="_blank" class="infolink" title ="Click to open in new tab">';
        	if ($ext == 'svg') {
			echo '
        		<embed src="';
        		echo $file . '"' ;
	        	echo ' class="dolueg-info scale-embed" alt ="" type="image/svg+xml"></embed>';
		} else {
			echo '
        		<img src="';
        		echo $file . '"' ;
	        	echo ' class="dolueg-info scale-embed" alt =""></embed>';
		}
		echo '</a>';
        	$ni=$ni+1;
    	}

    	foreach (glob($dir.$code.'/*_'.$selectedvar.'imax_*.'.$ext) as $file) {
        	echo '<a href="';
        	echo $file;
        	echo '" target="_blank" class="infolinkmax" title ="Click to open in new tab">';
        	
		if ($ext == 'svg') {
			echo '
        		<embed src="';
        		echo $file . '"' ;
	        	echo ' class="dolueg-info-max no-scale-embed" alt ="" type="image/svg+xml"></embed>';
		} else {
			echo '
        		<img src="';
        		echo $file . '"' ;
	        	echo ' class="dolueg-info scale-embed" alt =""></embed>';
		}
        	echo '</a>';
        	$ni=$ni+1;
    	}
    }
	
    if ($ni == 0 and filesize($infofile) <= 50) {echo '<div>No further information or maps available.<br></div>' ;}
    echo "
    </div>";


    #include the meteogram
    echo '
    <div id="meteogram" class="svg_plts">';
    echo '<img class="meteogram" src="projects/'.$project.'/mb_'.$project.'.php" alt="" />';
    echo "</div>   ";
} else {
	if ($project == 'campaigns') {
     		// if the project is other (projects2 include the corresponding folders and stuff from there)
		$subproject_index= "projects/" . $project . "/" . $subproject. "/site_list.php";

     		if ( file_exists($subproject_index)) {
        		include $subproject_index;
        	}
    	} else {
		#for all other projects just include every php in the project folder
     		$dir    = './projects/'.$project.'/';
		foreach (glob($dir . '*.php') as $file) {
             		if (strpos($file,$dir.'stat_list.php') !== 0) {include $file;}
		}
	}	

}
?>
