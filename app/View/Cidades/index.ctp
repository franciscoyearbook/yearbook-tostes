<head>
<script type="text/javascript">
$(function(){
	destacarItemDeMenu('listagem-cidades');
});
</script>
</head>
<body>
	<div class="container">
		<h1>Cidades</h1>
		<div class="col-md-6">
		<table class="table">
			<tr>
				<th>Cidade</th>
				<th>UF</th>
			</tr>
	<?php foreach ($cidades as $cidade): ?>
			<tr>
				<td>
					<?php echo $cidade['Cidade']['nomeCidade']; ?>
				</td>
				<td>
					<?php echo $cidade['Estado']['sigaEstado']; ?>
				</td>
			</tr>
	<?php endforeach; ?>
		</table>
		<p>
			<?php echo $this->Paginator->numbers(array('first' => 'Início', 'last' => 'Última')); ?>
		</p>
		</div>
	</div>
</body>