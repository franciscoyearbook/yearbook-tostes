<head>
<script type="text/javascript">
$(function(){
	destacarItemDeMenu('listagem-cidades');
});
</script>
</head>
<body>
<div class="container">
	<div class="page-header">
		<h1>Unidades da Federação</h1>
	</div>
	<div class="col-md-6">
		<table class="table">
			<tr>
				<th>Sigla</th>
				<th>Nome</th>
				<th>Ações</th>
			</tr>
			<?php foreach ($estados as $estado): ?>
			<tr>
				<td>
					<?php echo $estado['Estado']['sigaEstado']; ?>
				</td>
				<td>
					<?php echo $estado['Estado']['nomeEstado']; ?>
				</td>
				<td>
					<?php echo $this->Html->link('Ver cidades de '.$estado['Estado']['sigaEstado'],
		array('controller' => 'cidades', 'action' => 'index', $estado['Estado']['idEstado'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>
</body>