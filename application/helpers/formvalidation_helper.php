<?php
if(!function_exists("isChecked")){
    /*function ini ditujukan untuk validasi opsi yang menggunakan checkbox. Fungsi ini digunakan untuk melihat apakah checkbox tersebut di check atau tidak*/
    function isChecked($postvalue){
        foreach($postvalue as $a){
            return TRUE;
        }
        return FALSE;
    }
}

?>