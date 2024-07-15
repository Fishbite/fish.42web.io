<?php 
// print the contents of an array in a pretty format
function print_arr($arr) {
    echo '<pre>';
    print_r($arr);
    echo '</pre><br>';
}

##### a helper function to wrap the
##### var_dump expresion in <pre> tags
// It dumps the variable that you give it in a pretty format
function d($data){
    echo '<pre>';    
    var_dump($data);
    echo '</pre>';
}
?>