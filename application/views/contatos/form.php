<fieldset>
	<legend><?=$titulo?></legend>
	<?php echo validation_errors(); ?>
	<form enctype="multipart/form-data" method="post" action="<?=$action?>">
		<input type="text" name="nome" value="<?=$nome?>" placeholder="Digite o nome"><br>
		<input type="email" name="email" value="<?=$email?>" placeholder="Digite o e-mail"><br>
		<input name="arquivo" type="file"><br>
        <?php
        if(!empty($arquivo)){
            echo "<img src='".base_url("uploads/{$arquivo}")."' width='150'>";
            echo "<input type='hidden' value='{$arquivo}' name='arquivo_aux'>";
        }
        ?>
		<input type="submit" value="Gravar">
	</form>
</fieldset>
