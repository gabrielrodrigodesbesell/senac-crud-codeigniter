<h1>Contatos</h1>
<?=anchor(base_url('contatos/create'),'Cadastrar contato');?>
<?=br(3)?>
<?=!empty($this->session->userdata('mensagem'))?$this->session->userdata('mensagem'):null;?>
<?php
if(!empty($contatos)){
	echo '<table border="1" width="100%">';
	echo '<tr><th>Id</th><th>Nome</th><th>E-mail</th><th>Arquivo</th><th>Opções</th></tr>';
	foreach ($contatos as $k){
		echo '<tr>';
			echo "<td>{$k->id}</td>";
			echo "<td>{$k->nome}</td>";
			echo "<td>{$k->email}</td>";
			echo "<td>{$k->arquivo}</td>";
			echo "<td>";
				echo anchor(base_url('contatos/update/'.$k->id),'Alterar');
				echo ' | ';
				echo anchor(base_url('contatos/delete/'.$k->id),'Apagar');
			echo "</td>";
		echo "</tr>";
	}
	echo '</table>';
}

