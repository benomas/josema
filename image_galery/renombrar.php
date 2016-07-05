<?php

$archivos  = scandir('../josema.com.mx/daniel_morales/imagenes',1);

foreach ($archivos as $key => $value)
{
    $value2 = str_replace(".png", "C.png", $value);
    rename('../josema.com.mx/daniel_morales/imagenes/'.$value, '../josema.com.mx/daniel_morales/imagenes/'.$value2);
}
//debugg($archivos);
//rename("/tmp/archivo_tmp.txt", "/home/user/login/docs/mi_archivo.txt");
?>