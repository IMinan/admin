<?php include('_inc/header.php'); ?>

<div class="h20"></div>

<div style="height:100px;" class="hidden-xs hidden-sm"></div>

<div class="row">
	<div class="col-md-3"></div> <!-- /.col-md-3 -->
	<div class="col-md-6">
		<h3 class="page-title">Yönetici Giriş</h3>
		<?php

		if(is_login())
		{
			header("Location: ".site_url('index.php'));
		}

		$login_error = '';
		if(isset($_POST['username']))
		{
			$username = convert_gsm(form_input_control($_POST['username']));
			$password = form_input_control($_POST['password']);

			$query = mysqli_query(mysqli(), "SELECT * FROM users WHERE email='$username' AND password='$password' OR gsm='$username' AND password='$password'");

			if($query->num_rows > 0)
			{
				$login_user = mysqli_fetch_assoc($query);
				$_SESSION['login_id'] = $login_user['id'];
				add_log(array('type'=>'login_success', 'description'=>"Giriş yapıldı.", 'user_id'=>$login_user['id']));
				header("Location: ".site_url('index.php'));
			}
			else
			{
				add_log(array('type'=>'login_error', 'description'=>"$username uye girisi basarisiz."));
				$login_error = get_alert('E-posta adresi, cep telefonu veya şifreniz hatalı olabilir. <br /> <span class="fs-11">Giriş bilgilerinizi unuttuysanız <a href="#">şifrenizi sıfırlayabilir</a> veya bizimle <a href="#">iletişime</a> geçebilirsiniz.</span>', 'Giriş Başarısız');
			}
		}
		?>

		<form name="form_user_login" id="form_user_login" action="login.php" method="POST" class="validate">
			<div class="bg-muted padding20 radius3">
				<h3 class="module-title"><strong>Yönetici</strong> Girişi</h3>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<input type="text" name="username" id="username" class="form-control required" placeholder="E-posta veya Cep Telefonu">
						</div> <!-- /.form-group -->
					</div> <!-- /.col-md- 6-->
					<div class="col-md-6">
						<div class="form-group">
							<input type="password" name="password" id="password" class="form-control required" placeholder="Şifre">
						</div> <!-- /.form-group -->
					</div> <!-- /.col-md- 6-->
				</div> <!-- /.row -->

				<div style="height:31px;"></div>
				<div>
					<input type="hidden" id="microtime" name="microtime" value="<?php echo microtime(); ?>">
					<button class="btn btn-success">Giriş Yap</button>
				</div>

			</div> <!-- /.bg-muted -->
		</form>
	</div> <!-- /.col-md-6 -->
	<div class="col-md-3"></div> <!-- /.col-md-3 -->
</div> <!-- /.row -->

<div style="height:100px;" class="hidden-xs hidden-sm"></div>
