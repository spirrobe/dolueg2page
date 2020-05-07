<?php
/**
 * Make strings safe for usage
 */ 
function str2safestr($str,$array = array('&&','||','union ',' union','select ',' select','or ',' or', ' and', 'and ','#','/','-',';',',',"'",'"','(',')')) {
    $str=trim(htmlspecialchars($str));
    foreach($array as $substr) {
        $str=str_replace($substr,'',$str);
    }
    return($str);
}

?>
