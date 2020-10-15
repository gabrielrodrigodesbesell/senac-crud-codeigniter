<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestão</title>
</head>
<body>
Bem-vindo(a) <?=$this->session->userdata('nome')?><br>
<a href="<?=base_url('contatos')?>">Gerenciar contatos</a>
|
<a href="<?=base_url('cursos')?>">Gerenciar cursos</a>
|
<a href="<?=base_url('login/logout')?>">Sair</a>

