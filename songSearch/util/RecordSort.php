<?php
function record_sort($array, $key)
 {
    if(!empty($array)){
        for ($i = 0; $i < sizeof($array); $i++) {
             $sort_values[$i] = $array[$i][$key];
        }
        asort ($sort_values);
        reset ($sort_values);
        while (list ($arr_key, $arr_val) = each ($sort_values)) {
               $sorted_arr[] = $array[$arr_key];
        }
        return $sorted_arr;
    }else{
        return $array;
    }
 }
?>