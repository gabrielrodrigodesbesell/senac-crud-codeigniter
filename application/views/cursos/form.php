<fieldset>
	<legend><?=$title?></legend>
	<?php echo validation_errors(); ?>
	<form enctype="multipart/form-data" method="post" action="<?=$action?>">
		<input type="text" name="titulo" value="<?=$titulo?>" placeholder="Digite o titulo"><br>
		<input type="text" name="descricao" value="<?=$descricao?>" placeholder="Digite a descrição"><br>
        <select name="tipo">
            <option value="superior" <?=$tipo=='superior'?'selected':null?>>Superior</option>
            <option value="tecnico" <?=$tipo=='tecnico'?'selected':null?>>Técnico</option>
        </select>
        <br>
		<input name="imagem" type="file"><br>
        <?php
        if(!empty($imagem)){
            echo "<img src='".base_url("uploads/cursos/{$imagem}")."' width='150'>";
            echo "<input type='hidden' value='{$imagem}' name='imagem_aux'>";
        }
        ?>
		<input type="submit" value="Gravar">
	</form>
</fieldset>
