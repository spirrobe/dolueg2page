<?php

    echo "<br>";
    echo "<h3>Variables</h3>";

    $availablevars = ['a'=>'Temperature and rel. humidity',
                      'b'=>'Precipitation and evaporation',
                      'c'=>'Wind and air pressure',
                      'd'=>'Radiation',
                      'e'=>'Energy fluxes',
                      'g'=>'Fog and clouds',
                      'f'=>'Status',
                     ];

    foreach ($availablevars as $varcode => $varname) {

        $linkstr = '<a href="index.php?project='.$project.'&var='.$varcode.'" class="';
        if ($selectedvar == $varcode) {
            $linkstr = $linkstr . 'submenuon';
        } else {
            $linkstr = $linkstr . 'submenuoff';
        }
        $linkstr = $linkstr . '">'.$varname.'</a>';
        echo $linkstr;
	}

?>
