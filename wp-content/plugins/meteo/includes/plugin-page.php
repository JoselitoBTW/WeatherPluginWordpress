<?php

$curl = curl_init('api.openweathermap.org/data/2.5/weather?q=London,uk&appid=c75cdaff0f7fb687d159345a9bb16c0d');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($curl);
    if ($data === false){
        var_dump(curl_error($curl));
    }else{

    }

 ?>   