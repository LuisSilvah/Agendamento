<?php

include_once("./src/components/header.php");

?>
<div class="bg-principal p-4">
	<header class="navbar bg-body">
		<a href="./" class="mx-4">
			<img src="./assests/selmi.jpg" height="60px" alt="" srcset="">
		</a>
	</header>

	<main class="form-signin w-25 m-auto ">
		<form action="./src/validate/validation.php" method="post">
			<!-- Uusário -->
			<div class="mt-4">
				<label for="usuario">Usuário:</label>
				<div class="input-group mt-2">
					<input type="text" name="username" class="form-control" placeholder="Usuário">
				</div>
			</div>

			<!-- Senha -->
			<div class="mt-4">
				<label for="senha">Senha:</label>
				<div class="input-group mt-2">
					<input type="password" name="password" class="form-control" placeholder="Senha">
				</div>
			</div>

			<!-- Botão -->
			<div class="mt-4">
				<button type="submit" class="btn w-100 btn-primary">Enviar</button>
			</div>

		</form>

		<?php

		session_start();

		if (isset($_SESSION['mensage'])) {
			echo $_SESSION['mensage'];
		} else {
			echo "";
		}

		?>

	</main>

</div>