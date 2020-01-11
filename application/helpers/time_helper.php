<?php
if ( ! function_exists('tanggalDariHariTerdekat')){
    function tanggalDariHariTerdekat($hari,$tanggal){
        $date = date("Y-m-d",strtotime("last ".$hari,strtotime($tanggal)));
        return $date;
    }   
}
if ( ! function_exists('tambahHariKeTanggal')){
    function tambahHariKeTanggal($tanggal,$hari,$satuan){
        
        $after = date("Y-m-d",strtotime($tanggal."+".$hari.$satuan));
        return $after;
    }   
}
if ( ! function_exists('kurangHariKeTanggal')){
    function kurangHariKeTanggal($tanggal,$hari,$satuan){
        
        $after = date("Y-m-d",strtotime($tanggal."-".$hari.$satuan));
        return $after;
    }   
}
?>