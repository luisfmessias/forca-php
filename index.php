<?php

    session_start();

    $categorias = [
        'Computadores' => ['COMPUTADOR','TECLADO','MONITOR','INTERNET','MOUSE','PRINTER','FONE','WEBCAM'],
        'Animais' => ['CACHORRO','GATO','ELEFANTE','TIGRE','CAVALO','GALINHA','PASSARO','PEIXE'],
        'Paises' => ['BRASIL','PORTUGAL','ARGENTINA','CANADA','JAPAO','AUSTRALIA','ALEMANHA','ESPANHA']
    ];

    if(!isset($_SESSION['categoria'])){
        $_SESSION['categoria'] = array_key_first($categorias);
    }

    if(isset($_POST['categoria_select'])){
        $sel = $_POST['categoria_select'];
        if(isset($categorias[$sel])){
            $_SESSION['categoria'] = $sel;
            unset($_SESSION['palavra']);
        }
    }

    if(isset($_POST['reiniciar'])){
        unset($_SESSION['palavra']);
    }

    if(!isset($_SESSION['palavra'])){
        $lista = $categorias[$_SESSION['categoria']];
        $_SESSION['palavra'] = $lista[array_rand($lista)];
        $_SESSION['vidas'] = 6;
        $_SESSION['usadas'] = [];
    }

    $palavra = $_SESSION['palavra'];

    if(isset($_POST['letra'])){
        $l = strtoupper($_POST['letra']);
        if($l !== '' && !in_array($l, $_SESSION['usadas'])){
            $_SESSION['usadas'][] = $l;
            if(strpos($palavra, $l) === false) $_SESSION['vidas']--;
        }
    }

    $exib = '';
    foreach(str_split($palavra) as $c){
        $exib .= in_array($c, $_SESSION['usadas']) ? $c.' ' : '_ ';
    }

?>
<!DOCTYPE html>
<html>
<body>
<h1>Jogo da Forca (PHP)</h1>

<form method="post" style="margin-bottom:1em;">
    <label>Categoria:
        <select name="categoria_select" onchange="this.form.submit()">
            <?php foreach($categorias as $cat => $list): ?>
                <option value="<?= $cat ?>" <?= $cat==$_SESSION['categoria'] ? 'selected' : '' ?>><?= $cat ?></option>
            <?php endforeach; ?>
        </select>
    </label>
    <button type="submit" name="reiniciar" value="1">Nova partida</button>
</form>

<?php if($_SESSION['vidas'] <= 0): ?>
    <p>Você perdeu! Palavra: <?= $palavra ?></p>
    <form method="post"><button name="reiniciar">Jogar de novo</button></form>
<?php else: ?>
    <p><?= $exib ?></p>
    <p>Vidas: <?= $_SESSION['vidas'] ?></p>
    <p>Usadas: <?= implode(', ', $_SESSION['usadas']) ?></p>

    <?php if(strpos($exib, '_') === false): ?>
        <p>Parabéns! Você venceu!</p>
        <form method="post"><button name="reiniciar">Jogar de novo</button></form>
    <?php else: ?>
        <form method="post">
            <input name="letra" maxlength="1" autofocus>
            <button>Tentar</button>
        </form>
    <?php endif; ?>
<?php endif; ?>

</body>
</html>