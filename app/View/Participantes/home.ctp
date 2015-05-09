<head>
	<style type="text/css">
		section {
			padding: 10px 0px 0px 7px;
			margin-bottom: 10px;
		}
		#localidade, #descricao {
			border-width: 0px 0px thin thin;
			border-style: dotted;
		}
		#apresentacao {
			font-size: 2.0em;
			border-width: 0px 0px thin 0px;
			border-style: dotted;
		}
		.legend {
			font-size: 0.8em;
			margin-top: -4px;
			color: #003d4c;
			margin-left: -2px;
			font-weight: bold;
		}
	</style>
	<script type="text/javascript">
	$(function(){
		destacarItemDeMenu('home');
	});
	</script>
</head>
<body>
	<?php  
			$url = $this->Html->url(array(
    		"controller" => "participantes",
    		"action" => "retrieveOriginalImage",
			$participante['Participante']['login']
		));
	?>
	<div class="container">
		<div class="row">
		<div class="col-md-4">
			<section id="apresentacao">
				<span class="nome"><?php echo $participante['Participante']['nomeCompleto']; ?></span>
			</section>
			<section id="foto">
				<figure>
					<?php  echo "<img class=\"img-responsive img-rounded\" src=\"$url\" />"; ?>
				</figure>
			</section>
			<section id="descricao">
				<p class="legend">Quem sou eu?</p>
				<?php echo $participante['Participante']['descricao']; ?>
			</section>
			<section id="localidade">
				<p class="legend">Localidade</p>
				<span class="destaque"><?php echo $participante['Cidade']['nomeCidade']; ?></span>
			</section>	
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">
			<section id="conterraneos">
				<p class="legend">Outros participantes da sua cidade...</p>
				<?php if (count($conterraneos)> 0){ ?>
				<table class="table">
					<tr>
						<th>Foto</th>
						<th>Nome</th>
					</tr>
					<?php foreach ($conterraneos as $participante): ?>
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
					</tr>
					<?php endforeach; ?>
				</table>
				<?php } else { ?>
				<p>Nenhum outro participante da cidade '<?php echo $participante['Cidade']['nomeCidade']; ?>'.</p>
				<?php } ?>			
			</section>
		</div>
		<div class="col-md-4 col-sm-6 col-xs-12">
			<section id="vistosRecentemente">
				<p class="legend">Visitados recentemente...</p>
				<?php if (count($vistosRecentemente)> 0){ ?>
				<table class="table">
					<tr>
						<th>Foto</th>
						<th>Nome</th>
					</tr>
					<?php foreach ($vistosRecentemente as $participante): ?>
					<tr>
						<td>
							<?php
							$urlDetalhes = $this->Html->url(array(
	    				"controller" => "participantes",
	    				"action" => "detail",
						$participante['Participante']['login']
					));	  
				$urlImg
				 = $this->Html->url(array(
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
					</tr>
					<?php endforeach; ?>
				</table>
				<?php } else { ?>
				<p>Nenhuma visita realizada.</p>
				<?php } ?>
			</section>
		</div>
		</div>
	</div>
</body>