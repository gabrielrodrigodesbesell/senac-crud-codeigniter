<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Realize o login</title>
</head>
<body>
<h2>Realize o login</h2>
<?php echo validation_errors(); ?>
<?=!empty($this->session->userdata('mensagem'))?$this->session->userdata('mensagem'):null;?>
<form method="post" action="<?=base_url('login/action')?>">
    E-mail:<input type="email" name="email"><br>
    Senha:<input type="password" name="senha"><br>
    <input type="submit" value="Entrar">
</form>
</body>
</html>
