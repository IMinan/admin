<?php include('_inc/header.php'); ?>
<?php page_access('corporate'); ?>

<div class="row">
<div class="col-md-3">
	<?php include('_inc/sidebar.php'); ?>
</div> <!-- /.col-md-3 -->
<div class="col-md-9">


<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Anasayfa</a></li>
  <li><a href="<?php echo site_url('edit_profile.php'); ?>">Profilim</a></li>
  <li class="active">Şifre Değiştir</li>
</ol>

<?php if(isset($_POST['update_password'])): ?>
	<?php
	$old_password = form_input_control($_POST['old_password']);
	$new_password = form_input_control($_POST['new_password']);
	$new_password_repear = form_input_control($_POST['new_password_repear']);

	if($old_password != active_user('password'))
	{
		array_push($err_msg, 'Eski şifreniz doğru değil. 5 defa üst üste hatalı girer iseniz hesabınız bloklanacaktır.');
	}
	if($new_password != $new_password_repear)
	{
		array_push($err_msg, 'Yeni şifreniz ile yeni şifrenizin tekrarı aynı değil. Lütfen kontrol ediniz.');
	}

	if(!is_form_error())
	{
		if($result = mysqli()->query("UPDATE users SET password='$new_password' WHERE id='".active_user('id')."'"))
		{
			get_alert('Tebrikler, şifreniz değitirilmiştir.', '', 'success', '');
		}
	}

	?>
<?php endif; ?>


<?php print_alert($err_msg, 'danger', 'false'); ?>



<?php $corporate = get_user($_SESSION['login_id']); ?>
<form name="form_create_update_account" id="form_create_update_account" action="" method="POST" class="validate">
	<div class="row">
		<div class="col-md-6">

			<div class="form-group">
				<input type="password" name="old_password" id="old_password" class="form-control required" minlength="6" placeholder="Eski Şifre" value="">
			</div> <!-- /.form-group -->

			<div class="form-group">
				<input type="password" name="new_password" id="new_password" class="form-control required" minlength="6" placeholder="Yen Şifre" value="">
			</div> <!-- /.form-group -->


			<div class="form-group">
				<input type="password" name="new_password_repear" id="new_password_repear" class="form-control required" minlength="6" placeholder="Yeni Şifre Tekrar" value="">
			</div> <!-- /.form-group -->


			<div class="text-left">
				 <input type="hidden" name="update_password">
				 <button class="btn btn-success"><i class="fa fa-save"></i> Şifre Değiştir</button>
			</div> <!-- /.text-center -->
		</div> <!-- /.col-m-6 -->
		<div class="col-md-6">

		</div> <!-- /.col-md-6 -->
	</div> <!-- /.row -->
</form>


</div> <!-- /.col-md-9 -->
</div> <!-- /.row -->

<?php include('_inc/footer.php'); ?>
