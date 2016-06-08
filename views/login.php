<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<meta charset="utf-8">
		<title>Template de Login do Bootstrap</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-sm-offset-3">
					<form class="form-signin" method="post" action="<?php echo PATH; ?>home/login/">
						<h2 class="form-signin-heading">Preencha os campos abaixo</h2>
						<input type="hidden" name="act" value="logar">
						<?php
							if($erro == 1) {
								?>
								<div class="alert alert-danger">Preencha todos os campos</div>
								<?php
							}elseif($erro == 2) {
								?>
								<div class="alert alert-danger">Usuário não encontrado!</div>
								<?php
							}
						?>
						<div class="form-group">
							<label>Login</label>
							<input type="text" name="login" id="iptLogin" class="form-control input-lg" placeholder="Login" value="<?php echo $login; ?>">
						</div>
						<div class="form-group">
							<label>Senha</label>
							<input type="password" name="senha" id="iptSenha" class="form-control input-lg" placeholder="Senha">
						</div>
						<input type="submit" id="btnLogar" class="btn btn-lg btn-block btn-primary" value="Logar">
					</form>
				</div>
			</div>
		</div> <!-- /container -->
	</body>
</html>