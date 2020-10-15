<h1>Cursos</h1>
<?=anchor(base_url('cursos/create'),'Cadastrar curso');?>
<?=br(3)?>
<?=!empty($this->session->userdata('mensagem'))?$this->session->userdata('mensagem'):null;?>
<?php
if(!empty($cursos)){
	echo '<table border="1" width="100%">';
	echo '<tr><th>Id</th><th>Título</th><th>Descrição</th><th>Tipo</th><th>Imagem</th><th>Opções</th></tr>';
	foreach ($cursos as $k){
		echo '<tr>';
			echo "<td>{$k->id}</td>";
			echo "<td>{$k->titulo}</td>";
			echo "<td>{$k->descricao}</td>";
			echo "<td>{$k->tipo}</td>";
			echo "<td><img src='uploads/cursos/{$k->imagem}' width='40'></td>";
			echo "<td>";
				echo anchor(base_url('cursos/update/'.$k->id),'Alterar');
				echo ' | ';
				echo anchor(base_url('cursos/delete/'.$k->id),'Apagar');
			echo "</td>";
		echo "</tr>";
	}
	echo '</table>';
}

