
<?php

    $stations = ['1'=>'Teststation',
                 ];

    foreach ($stations as $statcode => $statname) {
        $linkstr = '<a href="index.php?project='.$project.'&var='.$statcode.'" class="';
        if ($selectedvar == $statcode) {
            $linkstr = $linkstr . 'submenuon';
        } else {
            $linkstr = $linkstr . 'submenuoff';
        }
        $linkstr = $linkstr . '">'.$statname.'</a>';
        echo $linkstr;
	}

?>

