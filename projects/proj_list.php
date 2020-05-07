<?php

    $availablectabs = ['overview'=>'Overview',
                       'control'=>'Control',
                       ];

    foreach ($availablectabs as $tabcode => $tabname) {

        $linkstr = '<a href="index.php?project='.$tabcode.'&var=0" class="';
        if ($selectedvar == $project) {
            $linkstr = $linkstr . 'menuon';
        } else {
            $linkstr = $linkstr . 'menuoff';
        }
        $linkstr = $linkstr . '">'.$tabname.'</a>';
        echo $linkstr;
	}

    echo '<br><br>';
    echo "<span><b>Measurement sites</b></span><br>";

    $availablecampaigns= ['template'=>'Test',
                         ];

    foreach ($availablecampaigns as $campaigncode => $campaignname) {

        $linkstr = '<a href="index.php?project='.$campaigncode.'&var=0" class="';
        if ($selectedvar == $project) {
            $linkstr = $linkstr . 'menuon';
        } else {
            $linkstr = $linkstr . 'menuoff';
        }
        $linkstr = $linkstr . '">'.$campaignname.'</a>';
        echo $linkstr;
	}

?>
