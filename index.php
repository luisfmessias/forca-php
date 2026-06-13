<?php

    session_start();
    $palavras=['COMPUTADOR','TECLADO','MONITOR'];

    if(!isset($_SESSION['palavra'])){
        $_SESSION['palavra']=$palavras[array_rand($palavras)];
        $_SESSION['vidas']=6;
        $_SESSION['usadas']=[];
    }
    
    $palavra=$_SESSION['palavra'];
    
    if(isset($_POST['letra'])){
        $l=strtoupper($_POST['letra']);

            if(!in_array($l,$_SESSION['usadas'])){
                $_SESSION['usadas'][]=$l;

                if(strpos($palavra,$l)===false) $_SESSION['vidas']--;
        }
}

    $exib='';

    foreach(str_split($palavra) as $c){
    $exib .= in_array($c,$_SESSION['usadas']) ? $c.' ' : '_ ';
    }
    
?>
<!DOCTYPE html><html><body>
<h1>Jogo da Forca (PHP)</h1>
<p><?= $exib ?></p>
<p>Vidas: <?= $_SESSION['vidas'] ?></p>
<p>Usadas: <?= implode(', ', $_SESSION['usadas']) ?></p>
<form method="post">
<input name="letra" maxlength="1">
<button>Tentar</button>
</form>
</body></html>