<script type="text/javascript">
<!--
	var url = "<?php echo $this->Html->url(array(
   		'controller' => 'estados',
   		'action' => 'listarCidades',
	)); ?>";
	$(function(){
		destacarItemDeMenu('novo-participante');
		var selectCidades = $("#selectCidades");
		$("#selectEstados").change(function(){
			estadoSelecionado = $(this).find('option:selected').attr('value');
			selectCidades.html('');
			loadCidades(url + "/" + estadoSelecionado, selectCidades, null);
		});
		
		loadEstadoCidadeIfNecessary();
		
		function loadEstadoCidadeIfNecessary(){
			var estado = "<?php if (array_key_exists('Cidade', $this->request->data) && array_key_exists('Estado', $this->request->data['Cidade'])) { echo $this->request->data['Cidade']['Estado']['idEstado']; } ?>";
			var cidade = "<?php if (array_key_exists('Cidade', $this->request->data)) { echo $this->request->data['Cidade']['idCidade']; } ?>";
			
			if (estado > 0){
				changeSelectedOption($("#selectEstados"), estado);
				loadCidades(url + "/" + estado, selectCidades, cidade);
			}
		}
	});

//-->
</script>
<?php 
	$optsFormFields = array('class' => 'form-control');
?>
<div class="users form container">
<div class="col-md-6">
<?php echo $this->Form->create('Participante', array('type' => 'file', 'role' => 'form')); ?>
    <fieldset>
        <legend><?php echo __('Inscrição de Novo Participante'); ?></legend>
        <?php echo $this->Form->input('email', $optsFormFields);
		if ($isEditForm){
        	echo $this->Form->input('login');
		} else {
		?>
		<div class="form-group">
		<?php
        	echo $this->Form->input('login', array('type' => 'text', 'class' => 'form-control'));
		?>
		</div>
		<?php
		}
		?>
		<div class="form-group">
		<?php 
        echo $this->Form->input('nomeCompleto', $optsFormFields);
		?>
		</div>
		<div class="form-group">
		<?php 
		echo $this->Form->input('Estado/Distrito',array(
			'empty'=>'Selecione uma...',
			'options'=>$estados,
			'name' => '',
			'id' => 'selectEstados',
			'class' => 'form-control'
		));
		?>
		<?php 
		echo $this->Form->input('cidade', array(
			'empty' => '',
			'options' => array(),
			'id' => 'selectCidades',
			'class' => 'form-control'
		));
		?>
		</div>
		<div class="form-group">
		<?php 
        echo $this->Form->input('descricao', array(
				'type' => 'textarea',
				'class' => 'form-control',
				'rows' => '3'
		));
		?>
		</div>
		<div class="form-group">
		<?php 
		
		$labelSenha = 'Senha';
		if ($isEditForm){
			$labelSenha = 'Nova senha';
		}
        echo $this->Form->input('senha', array(
					'type'=>'password', 
					'value'=>'', 
					'label' => $labelSenha,
					'autocomplete'=>'off',
					'required'=>!$isEditForm,
					'class' => 'form-control'
		));
		?>
		</div>
		<div class="form-group">
		<?php
		echo $this->Form->input('File.image', array('type' => 'file', 'label' => 'Foto', 'required' => !$isEditForm));

    ?>
    	</div>
    </fieldset>
<?php echo $this->Form->end(array("label" => "Inscrever", "class" => "btn btn-primary")); ?>
</div>
</div>