<head>
	
	<style type="text/css">
	#informe-rodape {
		padding: 20px 0px 20px 0px;
	}
	</style>
</head>
<body>
<div class="users form">
	<div class="container">
		<div class="col-md-6">
		<?php 
				$urlNew = $this->Html->url(array(
		    		"controller" => "participantes",
		    		"action" => "add"
				));
		?>
		<?php echo $this->Session->flash('auth'); ?>
		<?php echo $this->Form->create('User'); ?>
		    <fieldset>
		        <legend>
		            <?php echo __('Por favor, digite seu login e senha'); ?>
		        </legend>
		        <div class="form-group">
		        <?php 
		        
		        echo $this->Form->input('Participante.login', array('type' => 'text', 'class' => 'form-control'));
		        ?>
		        </div>
		        <div class="form-group">
		        <?php 
		        echo $this->Form->input('Participante.senha', array(
							'type'=>'password', 
							'value'=>'', 
							'autocomplete'=>'off',
							'required' => true,
							'class' => 'form-control'));
		    ?>
		    	</div>
		    </fieldset>
		<?php echo $this->Form->end(array("label" => "Logar", "class" => "btn btn-primary")); ?>
		
		<p id="informe-rodape">
			Ainda não está no Yearbook? <a href="<?php echo $urlNew; ?>">Inscreva-se clicando aqui</a>
		</p>
		</div>
	</div>
</div>
</body>