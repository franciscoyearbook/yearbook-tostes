<?php
$urlEdit = $this->Html->url ( array (
		"controller" => "participantes",
		"action" => "add",
		$participante ['Participante'] ['login'] 
) );
$urlDelete = $this->Html->url ( array (
		"controller" => "participantes",
		"action" => "delete",
		$participante ['Participante'] ['login'] 
) );
?>
<head>
<style type="text/css">
.destaque {
	font-weight: bold;
}
#comandos {
	text-align: center;
	padding-top: 20px;
}
#foto {
	margin-bottom: 10px;
}
</style>
<script type="text/javascript">

	function confirm() {
		$('<div><p>Sua conta será encerrada definitivamente no Yearbook. Não será possível restaurar os dados posteriormente.</p></div>').dialog({
			resizable : false,
			width: 500,
			modal : true,
			title: 'Encerrar conta no Yearbook',
			buttons : {
				"Encerrar minha conta no Yearbook" : function() {
					$(this).dialog("close");
					window.location.href = '<?php echo $urlDelete; ?>';
				},
				"Cancelar" : function() {
					$(this).dialog("close");
				}
			}
		});
	}
</script>
</head>
<body>
	<div class="container">
	<div class="page-header">
		<h1><?php echo $participante['Participante']['nomeCompleto']; ?></h1>
	</div>
	<div class="row">
		<div class="col-md-4">
		<section id="foto">
			<figure>
				<?php
				$url = $this->Html->url ( array (
						"controller" => "participantes",
						"action" => "retrieveOriginalImage",
						$participante ['Participante'] ['login'] 
				) );
				echo "<img src=\"$url\" class=\"img-responsive img-rounded\" />";
				?>
			</figure>
		</section>
		</div>	
		<div class="col-md-4">
		<section id="biografia">
			<p>
				Nome: <span class="destaque"><?php echo $participante['Participante']['nomeCompleto']; ?></span>
			</p>
			<p>
				Login: <span class="destaque"><?php echo $participante['Participante']['login']; ?></span>
			</p>
			<p>
				Email: <span class="destaque"><?php echo $participante['Participante']['email']; ?></span>
			</p>
			<p>
				Cidade: <span class="destaque"><?php echo $participante['Cidade']['nomeCidade']; ?></span>
			</p>
			<p>
				Descrição: <span class="destaque"><?php echo $participante['Participante']['descricao']; ?></span>
			</p>
		</section>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<p id="comandos">
				<a href="<?php echo $urlEdit; ?>">
					<button type="button" class="btn btn-primary btn-md">
					  <span class="glyphicon glyphicon-pencil"></span> Alterar Dados
					</button>
				</a>
				<a href="#" onclick="confirm();">
					<button type="button" class="btn btn-danger btn-md">
					  <span class="glyphicon glyphicon-remove"></span> Encerrar conta
					</button>
				</a>
			</p>
		</div>
	</div>
	</div>
</body>