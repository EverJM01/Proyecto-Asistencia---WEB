<?php 
    date_default_timezone_set('America/Bogota');
    
    define("BD_HOST", "localhost");
    define("BD_USERNAME", "root");
    define("BD_PASS", "");
    define("BD_NAME", "asistencia_bd");
      /*define("BD_HOST", "bitixnjxbdyzd88cidbi-mysql.services.clever-cloud.com");
    define("BD_USERNAME", "ui03lorn7dj2w16o");
    define("BD_PASS", "7wOu9PZnublCqyEtoFzB");
    define("BD_NAME", "bitixnjxbdyzd88cidbi");*/

    $conn = new mysqli(BD_HOST, BD_USERNAME, BD_PASS, BD_NAME);
?>