<?php
if ( ! function_exists('convertResultToKeyValueArray')){
    function convertResultToKeyValueArray($result){
        $resultArray = array();
        foreach($result->result() as $key=>$value){
            $resultArray += [$key => $value];
        }
        return $resultArray;
    }   
}
if ( ! function_exists('convertResultToKeyValueArray')){
    function convertResultBasedOnType($items,$type,$formType = ''){
        
        switch(strtolower($type)){
            case "html":
                $html = "";
                switch(strtolower($formType)){
                    case "select":
                    break;
                    case "checkbox":
                    break;
                    case "radio":
                    break;
                }
                return $html;
            break;
            case "array":
                return $items;
            break;
        }
    }   
}
if(! function_exists('foreachMultipleResult')){
    function foreachMultipleResult($result,$field,$print){
        /*
        $result = hasil query DB
        $data = data apa aja dari table itu yang ingin dimasukan kedalam array. Bentuknya array biasa
        contoh $data = ["nama_mahasiswa","kelas_mahasiswa"]
        */
        $counter = 0 ;
        $data = array();
        foreach($result->result() as $a){
            for($b = 0; $b<count($field);$b++){ /*untuk ngeloop semua variable yang dinginkan*/
                $string = $field[$b];
                $data[$counter][$print[$b]] = $a->$string; /* $data[0]["nama_mahasiswa"] = "joni"; $data[0]["jurusan_mahasiswa"] = "sistem informasi  */
            }
            $counter++;
        }
        return $data;
    }
}
if(! function_exists('foreachResult')){
    function foreachResult($result,$field,$print){
        /*
        $result = hasil query DB
        $data = data apa aja dari table itu yang ingin dimasukan kedalam array. Bentuknya array biasa
        contoh $data = ["nama_mahasiswa","kelas_mahasiswa"]
        */
        $data = array();
        foreach($result->result() as $a){
            for($b = 0; $b<count($field);$b++){ /*untuk ngeloop semua variable yang dinginkan*/
                $string = $field[$b];
                $data[$print[$b]] = $a->$string; /* $data[0]["nama_mahasiswa"] = "joni"; $data[0]["jurusan_mahasiswa"] = "sistem informasi  */
            }
        }
        return $data;
    }
}
if(! function_exists("foreachNameArray")){
    function foreachNameArray($value){
        $data = array();
        $counter = 0;
        foreach($value as $a){
            $data[$counter] = $a;
            $counter++;
        }
        return $data;
    }
}
?>