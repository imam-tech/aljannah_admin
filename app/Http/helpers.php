<?php


if(! function_exists('resultFunction')){
    function resultFunction($message, $status = false, $data = null){
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
    }
}

if(! function_exists('jenjangData')){
    function jenjangData(){
        $jenjangs = [
            "A" => "TK",
            "B" => "SD",
            "C" => "SMP",
            "D" => "SMA"
        ];
        return $jenjangs;
    }
}

if(! function_exists('gelombangData')){
    function gelombangData(){
        $gelombangs = ["Early Bird", "1", "2", "3", "4", "5"];
        return $gelombangs;
    }
}