<h1>Participantes</h1>

<form>
	<label>Nome:</label><input type="text" />
	<input type="submit" value="Buscar" />
</form>
<table class="table">
	<tr>
		<th>Nome</th>
		<th>Email</th>
	</tr>
	<?php foreach ($participantes as $participante): ?>
	<tr>
		<td>
			<?php echo $participante['Participante']['nomeCompleto']; ?>
		</td>
		<td>
			<?php echo $participante['Participante']['email']; ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
