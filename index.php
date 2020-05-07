<?php

    function consolelog($data) {
        if(is_array($data) || is_object($data)) {
                echo("<script>console.log('PHP: ".json_encode($data)."');</script>");
            } else {
                echo("<script>console.log('PHP: ".$data."');</script>");
            }
    }

    function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    include "str2safestr.php";

    if(isset($_REQUEST['project'])) {
        $project = str2safestr(strtolower($_REQUEST['project']));
        // project doesnt exit, go to overview
        if (!file_exists('projects/'.$project)){header("Refresh:0; url=index.php?project=overview");}
    } else {
        //just entered dolueg in header and no project? refresh and go to overview
        header("Refresh:0; url=index.php?project=overview");
    }


    $specialprojects = array("control", "overview");
    //we  only need the variable set if its not a special project
    if (!in_array($project, $specialprojects)) {
        if(isset($_REQUEST['var'])) {
            $selectedvar = ''. str2safestr(strtolower($_REQUEST['var']));
        } else {
            $selectedvar = '0';
        }
    }


    header("X-XSS-Protection: 1; mode=block");

?>

 <!DOCTYPE html>
 <html>

 <head>
  <title>Dolueg2 - measurement network of MCR Lab University of Basel, testversion!</title>
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="layout/dolueg_min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/css/theme.metro-dark.min.css" type="text/css" media="screen" />
 </head>

 <body>
  <div class="menu"> <a href="https://duw.unibas.ch/de/meteorologiemcrlab/" class="back" target=""><h2 class="title" title="Meteorology Climatology and Remote Sensing Lab, University of Basel">MCR@University of Basel</h2></a></div>

  <div class="submenu">
   <?php include "./projects/proj_list.php";?>
  </div>
  <div class="subsubmenu">

    <?php
         if (!in_array($project, $specialprojects)) {
           echo "<h3>Stations</h3>";
           // the stationlist should be unique for each campaign and thus is in subfolders
           include "./projects/$project/stat_list.php";
           // the varlist should be equal for all campaigns for better user experience
           include "./projects/var_list.php";
        }
   ?>
  </div>

  <div class="contentwrapper">
   <div>
    <?php
         echo '<div class="btncontainer">'."\n";
         if (!in_array($project, $specialprojects)) {
             echo '<button id="0daybutton" class="btnselector" onfocus="plots('."'0day'".')">Day</button>'."\n";
             echo '<button id="1weekbutton" class="btnselector" onfocus="plots('."'1week'".')" >Week</button>'."\n";
             echo '<button id="2monthbutton" class="btnselector" onfocus="plots('."'2month'".')">Month</button>'."\n";
             echo '<button id="3yearbutton" class="btnselector" onfocus="plots('."'3year'".')">Year</button>'."\n";
             echo '<button id="infobutton" class="btnselector" onfocus="plots('."'info'".')">Information</button>'."\n";
             echo '<button id="meteogram_mb" class="btnselector" onfocus="plots('."'meteogram'".')">Meteogram</button>'."\n";
        } else {
            if ($project == 'overview') {
                echo '<button  class="btnselector" onfocus="show('."'0'".')" autofocus>Current Data</button>'."\n";
                echo '<button class="btnselector forecastbutton" onfocus="show('."'1'".')" >Today forecast</button>'."\n";
                echo '<button class="btnselector forecastbutton" onfocus="show('."'2'".')" >Five day forecast</button>'."\n";
                echo '<button class="btnselector" onfocus="show('."'3'".')" >Windfield</button>'."\n";
                echo '<button class="btnselector" onfocus="show('."'4'".')" >About</button>'."\n";
            }
        }
        echo '</div>'."\n";
        echo "<br>";
        include "./projects/plot_search.php";
    ?>

     </div>
     <a href="https://meteo.duw.unibas.ch/index.php?id=51946" style="padding:0;margin:0;">
      <div id="logo_foot">
        <object data="./logos/logo_footer_unibas_mcr_combined.svg" id="logo" class="footer" alt="" type="image/svg+xml"></object>
      </div>
     </a>
  </div>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <?php
    if ($project =='control' or $project == 'overview') {
    ?>
    <script type="text/javascript">
	function controlupdate() {
		var now = new Date();
		var microsecond2hour = 1000 * 60 * 60;
		var checktimes = document.getElementsByClassName('checktime');

		for (i = 0; i < checktimes.length; i++) {

		    var element = checktimes[i];
		    var parenttable = $(element).closest("table")[0];
                    var good = parenttable.getAttribute('data-good');
		    var bad = parenttable.getAttribute('data-bad');

		    bad *= microsecond2hour;
	            good *= microsecond2hour;

		    var delay =$(element).next("td")[0];
	   	    var creationtime = new Date(element.innerHTML); //;+'+00:00');
	 	    var tdiff = now - creationtime;
		    if (tdiff >= bad) {
			$(delay).removeClass().addClass('bad');
			hourdelay = (tdiff / microsecond2hour).toFixed(1);
			if (hourdelay >= 96) {
				delay.innerHTML = '> 96H';
			} else {
				delay.innerHTML = hourdelay + ' H';
			}
	            } else if (tdiff <= good){

			if (tdiff / microsecond2hour > 1) {
				delay.innerHTML = (tdiff / microsecond2hour).toFixed(1) +' H';
	                } else {
	   		        if (tdiff < 0) {tdiff=0;}
				delay.innerHTML = (tdiff / microsecond2hour * 60).toFixed(0) +'M';
			}

			$(delay).removeClass().addClass('good');

	   	    } else {
			delay.innerHTML = (tdiff / microsecond2hour).toFixed(1) +' H';
			$(delay).removeClass().addClass('warn');
        	    }
	        }

		var creationheaders = document.getElementsByClassName('creationheader');

		for (i = 0; i < creationheaders.length; i++) {
			element = creationheaders[i];
			var timestamp = element.innerText.split(': ')[1];

			if (timestamp.length >= 19){
				timestamp = timestamp.slice(0,19);
			}
			//console.log(timestamp.innerHTML);
			var creationtime = new Date(timestamp); //+'+00:00');
			var tdiff = (now - creationtime)/microsecond2hour;

			if (tdiff >= 6) {
				 element.children[0].style.background='repeating-linear-gradient(45deg, rgb(102, 102, 102), rgb(102, 102, 102) 7px, firebrick 7px, firebrick 14px)';
			} else if (tdiff >= 3) {
                element.children[0].style.background='repeating-linear-gradient(45deg, rgb(119, 119, 119), rgb(119, 119, 119) 7px, gold 7px, gold 14px)';
			}

			//console.log(tdiff,element);
		}
	}
	// check the times once in the beginning to they are proper
	controlupdate();
	// adjust all the times of the control after 1 minute
	window.setInterval(controlupdate, 60000);
	// function to refresh
	function pagerefresh() {
		location.reload(true);
	}

	// refresh control page after 15 minutes because only our javascript timer runs but the actual data might have been updated
	var refreshtime = 900000;
    window.setTimeout(pagerefresh, refreshtime);

   </script>
   <?php
     }
   ?>
    <script type="text/javascript">

        function show(id) {
      for (i = 0; i < 50; i++) {
       if (i != id) {
        if (document.getElementById(i) != null) {
         var theid = document.getElementById(i);
         theid.style.display = "none";

        }
        else {
         if (document.getElementById(id) != null) {
          var theid = document.getElementById(id);
          theid.style.display = "inline";

         }
        }
       }
      }
      var x = document.getElementsByClassName('btnselector');
      if (x.length) {
       for (i = 0; i < x.length; i++) {
        var c = x[i].onfocus.toString();
        if (c.indexOf(id) > 0) {
         x[i].focus();
        }
       }
      }
     }

     function plots(v) {
      if (document.getElementById("0day") != null) {
       document.getElementById("0day").style.display = "none";
      }
      if (document.getElementById("1week") != null) {
       document.getElementById("1week").style.display = "none";
      }
      if (document.getElementById("2month") != null) {
       document.getElementById("2month").style.display = "none";
      }
      if (document.getElementById("3year") != null) {
       document.getElementById("3year").style.display = "none";
      }
      if (document.getElementById("info") != null) {
       document.getElementById("info").style.display = "none";
      }
      if (document.getElementById("meteogram") != null) {
       document.getElementById("meteogram").style.display = "none";
      }
      if (document.getElementById(v) != null) {
       document.getElementById(v).style.display = "inline";
      }
     }

     	$(document).ready(function () {
     	plots('1week');
     	});
    </script>

 </body>

 </html>
