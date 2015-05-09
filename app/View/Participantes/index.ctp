<head>
<script type="text/javascript">
$(function(){
	destacarItemDeMenu('listagem-participantes');
});
</script>
</head>
<body>
<div class="container">
	<div class="page-header">
		<h1>Participantes do Curso</h1>
	</div>	
	<div class="row">
		<div class="col-lg-10 col-sm-10 col-xs-12">
		<table class="table">
			<tr>
				<th>Foto</th>
				<th>Nome</th>
				<th class="hidden-xs">Cidade</th>
				<th class="hidden-xs">Email</th>
			</tr>
			<?php foreach ($participantes as $participante): ?>
			<tr>
				<td>
					<?php
					$urlDetalhes = $this->Html->url(array(
		    				"controller" => "participantes",
		    				"action" => "detail",
							$participante['Participante']['login']
						));	  
					$urlImg = $this->Html->url(array(
		    			"controller" => "participantes",
		    			"action" => "retrieveThumbnail",
						$participante['Participante']['login']
					));
					echo '<a href="'.$urlDetalhes.'"><img src="'.$urlImg.'" /></a>';
					?>
				</td>
				<td>
					<?php 
						
						echo '<a href="'.$urlDetalhes.'">'.$participante['Participante']['nomeCompleto'].'</a>'; 
					?>
				</td>
				<td class="hidden-xs">
					<?php echo $participante['Cidade']['nomeCidade']; ?>
				</td>
				<td class="hidden-xs">
					<?php echo $participante['Participante']['email']; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		</div>
	</div>
</div>
</body>