<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<?php echo $this->Html->charset(); ?>
	<?php echo $this->Html->script('jquery-1.11.1'); ?>
	<?php echo $this->Html->script('jquery-ui-1.10.4.custom.min'); ?>
	<?php echo $this->Html->script('functions'); ?>
	<title>
	Yearbook
	</title>
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');
		echo $this->Html->css('jquery-ui/jquery-ui-1.10.4.custom.min');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
</head>
<body>
<?php 
	$linkInicio = $this->Html->link(
					    '<span class="glyphicon glyphicon-star-empty"></span> Minha Pagina',
					    array(
					        'controller' => 'participantes',
					        'action' => 'home'
					    ),
						array('escape' => false)
					);	

	$linkParticipantes = $this->Html->link(
					    '<span class="glyphicon glyphicon-user"></span> Listar Participantes',
					    array(
					        'controller' => 'participantes',
					        'action' => 'index'
					    ),
						array('escape' => false)
					);	

	$linkUfs = $this->Html->link(
					    '<span class="glyphicon glyphicon-flag"></span> Cidades',
					    array(
					        'controller' => 'estados',
					        'action' => 'index'
					    ),
						array('escape' => false)
					);


	$linkNovaInscricao = $this->Html->link(
					    '<span class="glyphicon glyphicon-plus"></span> Novo Participante',
					    array(
					        'controller' => 'participantes',
					        'action' => 'add'
					    ),					
						array('escape' => false)
					);				
			
	$linkDadosUsuarioLogado = $this->Html->link(
					    'Ver/Alterar Meus Dados',
					    array(
					        'controller' => 'participantes',
					        'action' => 'loggedUser'
					    )
					);				

	$linkLogout = $this->Html->link(
    						'Sair',
    						array(
        						'controller' => 'participantes',
        						'action' => 'logout'
    						)
						);
?>
	<div id="wrap">
		<nav class="navbar navbar-default" role="navigation">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="#">Yearbook</a>
		    </div>
		
		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li id="home"><?php echo $linkInicio; ?></li>
			 	<li class="divider"></li>
		        <li id="listagem-participantes">
			 		<?php echo $linkParticipantes; ?>
			 	</li>
		 		<li id="novo-participante">
					<?php echo $linkNovaInscricao; ?>
			 	</li>
			 	<li class="divider"></li>
		        
		        <li id="listagem-cidades"><?php echo $linkUfs; ?></li>
		      </ul>
		<?php 
		    $opcoesFormParticipante = array(
				'action' => 'search',
				'class'=>'navbar-form navbar-left',
				'role'=>'search',
				'inputDefaults' => array(
						'label' => false,
						'div' => false
				)
			);
			$opcoesFormParticipanteInput = array('label'=>'', 
												 'required' => false,
												 'id' => 'ParticipanteProcuradoId',	
												 'class'=>"form-control input-sm", 
												 'placeholder'=>"Nome do Participante");
		
		?>      
		        <?php echo $this->Form->create('Participante', $opcoesFormParticipante); ?>
		        <div class="form-group">
				<?php echo $this->Form->input('nomeCompleto', $opcoesFormParticipanteInput); ?>
		        </div>
				<?php echo $this->Form->end(array('class'=>'btn btn-default', 'div'=>false, 'label'=>'Procurar')); ?>
		
				<?php 
					$login = $this->Session->read('Participante.login');
					if ($login){
				?>
		      <ul class="nav navbar-nav navbar-right">
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		 								Ola, <?php echo $this->Session->read('Participante.nomeCompleto') ?><span class="caret"></span>
		 							</a>
		          <ul class="dropdown-menu" role="menu">
		            <li>
			 			<?php echo $linkDadosUsuarioLogado; ?>
			 		</li>
			 		<li class="divider"></li>
		 			<li>
						<?php echo $linkLogout; ?>
			 		</li>
		          </ul>
		        </li>
		      </ul>
					<?php 
							} else {
								echo $this->Form->create('User', 
									array(
										'class'=>'navbar-form navbar-right',  
										'role'=>'login', 
										'inputDefaults' => array(
											'label' => false,
											'div' => false
										)
									)); 
						?>
			        		<div class="form-group">
		        		<?php
								echo $this->Form->input('Participante.login', array(
									'type' => 'text', 
									'class'=>'form-control input-sm', 
									'placeholder'=>'Login' 
									)
								);
						?>
							</div>
			        		<div class="form-group">
							
						<?php 
		        				echo $this->Form->input('Participante.senha', array(
									'required'=>true,
									'type'=>'password', 
									'value'=>'', 
									'autocomplete'=>'off',
									'class'=>'form-control input-sm', 
									'placeholder'=>'Senha'
									)
								);
		    			?>
		    				</div>
						<?php 
								echo $this->Form->end(array('class'=>'btn btn-default', 'div'=>false, 'label'=>'Login')); 
							}
						?>        
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>


		<div id="content">
			<?php echo $this->Session->flash(); ?>
	
			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>

	
	<!-- Latest compiled and minified JavaScript -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>
</html>
