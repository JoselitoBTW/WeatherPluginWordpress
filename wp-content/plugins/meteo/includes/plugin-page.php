<?php
// $keyapi = "c75cdaff0f7fb687d159345a9bb16c0d&units=metric&lang=Fr";
$apikey = $_POST['apikey'];
$cityname = $_POST['city'];

$curl = curl_init('http://api.openweathermap.org/data/2.5/weather?q='.$cityname.'&appid='.$apikey.'');
curl_setopt_array($curl, [
    CURLOPT_CAINFO          =>  __DIR__ . DIRECTORY_SEPARATOR . '../cert.pem',
    CURLOPT_RETURNTRANSFER  => true,
    CURLOPT_TIMEOUT         => 1
]);
    $data = curl_exec($curl);
    if ($data === false){
        var_dump(curl_error($curl));
    }else{
        (curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200);
        $data = json_decode($data, true);
        echo 'Il fait ' . $data['main']['temp'].' °C à '.$cityname;
    }
    curl_close($curl);
   
 ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <title>NeedWheater</title>
</head>

<body>

    <section>
        <!-- Formulaire API -->
        
        <!-- <div class="container col-6">
        <h1>Entrez votre clé d'API</h1>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="apikey" class="form-label">Clé d'API</label>
                    <input type="text" name="apikey" class="form-control" id="apikey">
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div> -->

    </section>

    <section>
        <!-- Formulaire communes -->
        <div class="container col-6">
            <h1 class="mt-3">Choisissez votre commune</h1>
            <form action="" method="post">
            <div class="mb-3">
                    <label for="apikey" class="form-label">Clé d'API</label>
                    <input type="text" name="apikey" class="form-control" id="apikey">
                </div>
                <div class="mb-3">
                    <label for="zipcode" class="form-label">Code Postal</label>
                    <input type="text" class="form-control" id="zipcode">
                    <div style="display: none; color: #f55" id="error-message"></div>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">Ville</label>
                    <select name="city" class="form-control" name="city" id="city"></select>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </section>

    <section>
        <!-- Récupération du shortcode -->
        <div class="container col-6">
            <h1 class="mt-3">Récuperez votre Shortcode</h1>
                <div class="d-flex mb-3">
                    <input type="text" class="form-control" id="textcopy">
                    <button type="submit" class="btn btn-secondary" id="copy"><i class="fas fa-copy"></i></button>
                </div>
                
            
        </div>
    </section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>


<script>
    $(document).ready(function(){
    const apiUrl = 'https://geo.api.gouv.fr/communes?codePostal=';
    const format = '&format=json';

    let zipcode = $('#zipcode');
    let city = $('#city');
    let errorMessage = $('#error-message');

    $(zipcode).on('blur', function(){
        let code = $(this).val();
        // console.log(code);
        let url = apiUrl+code+format;
        // console.log(url);

        fetch(url, {method: 'get'}).then(response => response.json()).then(results =>{
            // console.log(results);
            $(city).find('option').remove();
            if(results.length){
                $(errorMessage).text('').hide();
                $.each(results, function(key, value){
                    console.log(value);
                    console.log(value.nom);
                    $(city).append('<option value="'+value.nom+'">'+value.nom+'</option>');
                })
            }
            else{
                if($(zipcode).val()){
                    console.log('Ereur de code postal')
                    $(errorMessage).text('Aucune commune avec ce code postal').show();
                }
                else{
                    $(errorMessage).text('').hide();
                }
            }
        }).catch(err =>{
            console.log(err);
            $(city).find('option').remove();
        })
    })
})

let editor = document.querySelector('#textcopy');
let button = document.querySelector('#copy');

button.addEventListener('click', () => {
    editor.select();
    // document.execCommand('copy');
    navigator.clipboard.writeText(editor.value);
    button.innerText = "Copié";

})
</script>


