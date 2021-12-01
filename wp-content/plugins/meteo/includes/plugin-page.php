<?php

// $curl = curl_init('http://api.openweathermap.org/data/2.5/weather?q=paris&appid=c75cdaff0f7fb687d159345a9bb16c0d&units=metric&lang=Fr');
// curl_setopt_array($curl, [
//     CURLOPT_CAINFO          =>  __DIR__ . DIRECTORY_SEPARATOR . '../cert.pem',
//     CURLOPT_RETURNTRANSFER  => true,
//     CURLOPT_TIMEOUT         => 1
// ]);
//     $data = curl_exec($curl);
//     if ($data === false){
//         var_dump(curl_error($curl));
//     }else{
//         (curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200);
//         $data = json_decode($data, true);
//         echo 'Il fait ' . $data['main']['temp'].' °C';
//     }
//     curl_close($curl);
   
 ?>   

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    
    <title>NeedWheater</title>
</head>
<body>

<div class="container">
    <!-- Formulaire API -->
    <div class="container">
            <form action="" method="post">
                <div class="form-group">
                    <label for="apikey">Clé d'API</label>
                    <input type="text" name="apikey" class="form-control" placeholder="Clé dAPI" id="apikey">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
    </div>

    <!-- Formulaire de commune -->
    <div class="container" id="container">
            <form action="" method="post">
                <div class="form-group">
                    <label for="zipcode">Code Postal</label>
                    <input type="text" name="zipcode" class="form-control" placeholder="Code postal" id="zipcode">
                    <div style="display: none; color: #f55" id="error-message"></div>
                </div>
                
                <div class="form-group">
                    <label for="city">Ville</label>
                    <select class="form-control" name="city" id="city">       
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
    </div>
</div>

   

</body>
</html>