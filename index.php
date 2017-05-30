<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Tiempo</title>
        <link rel="icon" href="images/favicon.ico">
        <link rel="stylesheet" href="css/estilo.css" />        
        <link rel="stylesheet" href="fonts.css" /> <!--Icono ir arriba-->
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="arriba.js"></script>
    </head>
    <body>
        <div id="content">
            <div id="header">
                <div id="cabecera">
                    <a onClick="window.location.reload()"><img id="logo" src="images/logo.png"></a>
                    <img id="logocabecera" src="images/cabecera.png">
                </div>
                <div id="barra_menu">
                </div>
            </div>
            <div id="principal">
                <!--Boton ir arriba -->    
                <span class="ir-arriba icon-arrow-up2"></span>
                
                
                
                <?php
                //Cuando pulsas el boton enviar hace lo siguiente
                if (isset($_POST['enviar']))             
                {
                    // Inicializamos curl
                    $curl = curl_init();

                    // Establecemos las opciones para curl. Fíjate que la URL se incluye la APIKey que
                    // tienes que haber solicitado previamente
                    // Key; eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJmcmFuamFpbmZvcm1hdGljYTIzQGdtYWlsLmNvbSIsImp0aSI6ImY1MWQ4MzI0LWY4YzktNDk0MS04ZTFjLTU3NDAxYjAwMTdkYyIsImV4cCI6MTQ5ODk5MTExNCwiaXNzIjoiQUVNRVQiLCJpYXQiOjE0OTEyMTUxMTQsInVzZXJJZCI6ImY1MWQ4MzI0LWY4YzktNDk0MS04ZTFjLTU3NDAxYjAwMTdkYyIsInJvbGUiOiIifQ.Oc9wYLFG35GsSKxX_CiXW-hJ_uHdGtp1skQdwOG4SvU
                    curl_setopt_array($curl, array(
                      CURLOPT_URL => "https://opendata.aemet.es/opendata/api/observacion/convencional/todas?api_key=eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJmcmFuamFpbmZvcm1hdGljYTIzQGdtYWlsLmNvbSIsImp0aSI6ImY1MWQ4MzI0LWY4YzktNDk0MS04ZTFjLTU3NDAxYjAwMTdkYyIsImV4cCI6MTQ5ODk5MTExNCwiaXNzIjoiQUVNRVQiLCJpYXQiOjE0OTEyMTUxMTQsInVzZXJJZCI6ImY1MWQ4MzI0LWY4YzktNDk0MS04ZTFjLTU3NDAxYjAwMTdkYyIsInJvbGUiOiIifQ.Oc9wYLFG35GsSKxX_CiXW-hJ_uHdGtp1skQdwOG4SvU",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "GET",
                      CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache"
                      ),
                      // Esta última opción la he incluido porque me da un error de que no reconoce el 
                      // certificado SSL. 
                      CURLOPT_SSL_VERIFYPEER => false
                    ));

                    // Una vez preparada la solicitud realizamos la llamada al servidor.
                    $resp = curl_exec($curl);

                    // Si el valor devuelto es false quiere decir que ha habido algún problema en la 
                    // comunicación con el servidor.Ten en cuenta que aquí se detectan errores de 
                    // comunicación pero no de la consulta. Así si por ejemplo escribes mal la URL
                    // y te devuelve un 404 lo detectas aquí, pero por el contrario si la APIKey no
                    // es válida lo tendrías que detectar leyendo el JSON que devuelve.
                    if(!$resp){
                        die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
                    }

                    // Imprimo el texto con el JSON solo para que veas que es lo que devuelve
                    print_r($resp);
                    echo("<br>");

                    // Ahora hay que parsear el JSON, para ello tenemos la función json_decode que 
                    // convertirá el texto en una serie de arrays anidados.
                    $json = json_decode($resp, true);

                    // Ahora ya podemos acceder a cualquier campo del JSON como si de un array se 
                    // tratara. Así por ejemplo para comprobar que la solicitud ha tenido éxito 
                    // puedes acceder al campo "estado" que te indicará por ejemplo con el código 200
                    // que está bien, con el 401 que hay un error en la APIKey, y así sucesivamente
                    // (en la documentación de la web tienes los diferentes códigos de error)
                    print("<b>Estado devuelto</b>: " . $json["estado"]. "<br>");

                    // Si has leido la documentación sabrás que el JSON con el que contesta no 
                    // contiene los datos sino la URL donde se encuentran. Esto quiere decir que 
                    // tras comprobar que el estado anterior es 200 debemos realizar una nueva llamada
                    // con curl a la dirección que obtenemos de $json["datos"]
                    // (Esto ya dejo que lo hagas tú)

                    // Finalmente tenemos que cerrar la conexión curl
                    curl_close($curl);




                    // Conexión 2
                    $curl2 = curl_init();
                    curl_setopt_array($curl2, array(
                        CURLOPT_URL => $json["datos"],                  //URL de petición
                        CURLOPT_RETURNTRANSFER => true,                 //Volver a la página web
                        CURLOPT_ENCODING => "",                         //Manejar toda la codificación
                        CURLOPT_MAXREDIRS => 10,                        //Para despues de 10 redirecciones
                        CURLOPT_TIMEOUT => 30,                          //tiempo de espera en responder
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,  //Versión http
                        CURLOPT_CUSTOMREQUEST => "GET",                 //Método de respuesta
                        CURLOPT_HTTPHEADER => array(                    //Array que se pasa en la cabecera
                          "cache-control: no-cache"
                        ),
                        // Esta última opción la he incluido porque me da un error de que no reconoce el 
                        // certificado SSL. 
                        CURLOPT_SSL_VERIFYPEER => false
                    ));

                    // Una vez preparada la solicitud realizamos la llamada al servidor.
                    $resp2 = curl_exec($curl2);

                    if(!$resp2){
                        die('Error: "' . curl_error($curl2) . '" - Code: ' . curl_errno($curl2));
                    }

                    print_r($resp2);
                    echo("<br>");
                    /*
                    $json2 = json_decode($resp2, true);

                    print("<b>REUS/AEROPUERTO</b>: " . $json2["idema"]. "<br>");

                    $tempe = array_column($json2, "ubi");
                    print_r($tempe);            

                    idemas = {estacion['ubi']:estacion['idema'] for estacion in datos}

                    print(idemas['GRANADA/AEROPUERTO'])

                    */
                    $curl = curl_init();


                    // Key; eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJmcmFuamFpbmZvcm1hdGljYTIzQGdtYWlsLmNvbSIsImp0aSI6ImY1MWQ4MzI0LWY4YzktNDk0MS04ZTFjLTU3NDAxYjAwMTdkYyIsImV4cCI6MTQ5ODk5MTExNCwiaXNzIjoiQUVNRVQiLCJpYXQiOjE0OTEyMTUxMTQsInVzZXJJZCI6ImY1MWQ4MzI0LWY4YzktNDk0MS04ZTFjLTU3NDAxYjAwMTdkYyIsInJvbGUiOiIifQ.Oc9wYLFG35GsSKxX_CiXW-hJ_uHdGtp1skQdwOG4SvU
                    curl_setopt_array($curl, array(
                      CURLOPT_URL => "https://opendata.aemet.es/opendata/api/prediccion/especifica/municipio/horaria/49021?api_key=eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJmcmFuamFpbmZvcm1hdGljYTIzQGdtYWlsLmNvbSIsImp0aSI6ImY1MWQ4MzI0LWY4YzktNDk0MS04ZTFjLTU3NDAxYjAwMTdkYyIsImV4cCI6MTQ5ODk5MTExNCwiaXNzIjoiQUVNRVQiLCJpYXQiOjE0OTEyMTUxMTQsInVzZXJJZCI6ImY1MWQ4MzI0LWY4YzktNDk0MS04ZTFjLTU3NDAxYjAwMTdkYyIsInJvbGUiOiIifQ.Oc9wYLFG35GsSKxX_CiXW-hJ_uHdGtp1skQdwOG4SvU",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "GET",
                      CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache"
                      ),

                      CURLOPT_SSL_VERIFYPEER => false
                    ));


                    $resp = curl_exec($curl);


                    if(!$resp){
                        die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
                    }


                    print_r($resp);
                    echo("<br>");


                    $json = json_decode($resp, true);

                    print($json);
                    print("<b>Estado devuelto</b>: " . $json["estado"]. "<br>");


                    curl_close($curl); 

                    // Conexión 2
                    $curl2 = curl_init();
                    curl_setopt_array($curl2, array(
                        CURLOPT_URL => $json["datos"],                  //URL de petición
                        CURLOPT_RETURNTRANSFER => true,                 //Volver a la página web
                        CURLOPT_ENCODING => "",                         //Manejar toda la codificación
                        CURLOPT_MAXREDIRS => 10,                        //Para despues de 10 redirecciones
                        CURLOPT_TIMEOUT => 30,                          //tiempo de espera en responder
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,  //Versión http
                        CURLOPT_CUSTOMREQUEST => "GET",                 //Método de respuesta
                        CURLOPT_HTTPHEADER => array(                    //Array que se pasa en la cabecera
                          "cache-control: no-cache"
                        ),
                        // Esta última opción la he incluido porque me da un error de que no reconoce el 
                        // certificado SSL. 
                        CURLOPT_SSL_VERIFYPEER => false
                    ));

                    // Una vez preparada la solicitud realizamos la llamada al servidor.
                    $resp2 = curl_exec($curl2);

                    if(!$resp2){
                        die('Error: "' . curl_error($curl2) . '" - Code: ' . curl_errno($curl2));
                    }

                    print_r($resp2);
                    echo("<br>");
                
                }
                else //Si no has pulsado el boton de enviar
                {        
                ?>
        
                <div id="cuadro_busqueda">
                    <table>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"            
                            <tr>            
                                <th>Selecciona tu ciudad: </th>
                                <th><input list="ciudad" name="ciudad">
                                    <datalist id="ciudad">
                                      <option value="Benavente">
                                      <option value="Zamora">
                                      <option value="León">
                                      <option value="Valladolid">
                                      <option value="Madrid">
                                    </datalist>
                                </th>
                            </tr>
                            <tr>
                                <th><input type="submit" name="enviar" value="enviar"/></th>
                            </tr>
                        </form>
                    </table>
                </div>
                <?php

                }
                ?>
            </div>
        </div> 
    </body>
</html>