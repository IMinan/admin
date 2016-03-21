<?php include('_inc/header.php'); ?>
<?php page_access('corporate'); ?>

<div class="row">
<div class="col-md-3">
	<?php include('_inc/sidebar.php'); ?>
</div> <!-- /.col-md-3 -->
<div class="col-md-9">


<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Anasayfa</a></li>
  <li class="active">Profilim</li>
</ol>

<?php if(isset($_POST['update_corporate_account'])): ?>
	<?php
	$corporate['company_name'] = mb_ucwords(form_input_control($_POST['company_name']), 'utf-8');
	$corporate['name'] = mb_ucwords(form_input_control($_POST['name']), 'utf-8');
	$corporate['surname'] = mb_ucwords(form_input_control($_POST['surname']), 'utf-8');
	$corporate['email'] = strtolower(form_input_control($_POST['email']));
	$corporate['gsm'] = convert_gsm(form_input_control($_POST['gsm']));


	// form string kontrolleri
	form_string_control($corporate['company_name'], 'Firma adı', array('min'=>3, 'max'=>50));
	form_string_control($corporate['name'], 'Ad', array('min'=>3, 'max'=>50));
	form_string_control($corporate['surname'], 'Soyad', array('min'=>3, 'max'=>50));
	form_string_control($corporate['email'], 'E-posta', array('required'=>true, 'is_mail'=>true));
	form_string_control($corporate['gsm'], 'Cep telefonu', array('required'=>true, 'is_gsm'=>true));



		$corporate['status'] = '1';
		$corporate['user_type'] = 'corporate';

		if(is_user("gsm='".$corporate['gsm']."' AND id NOT IN ('".active_user('id')."')") > 0) {
			array_push($err_msg, '<strong>'.$corporate['gsm'].'</strong> telefon numarasına ait üyelik bulunmakta. Üyelik ile ilgili problem yaşıyorsanız <a href="'.site_url('iletisim').'" target="_blank">iletişim</a> sayfasından bizimle iletişime geçebilirsiniz.');
		}
		elseif(is_user("email='".$corporate['email']."'  AND id NOT IN ('".active_user('id')."") > 0) {
			array_push($err_msg, '<strong>'.$corporate['email'].'</strong> e-posta numarasına ait üyelik bulunmakta. Üyelik ile ilgili problem yaşıyorsanız <a href="'.site_url('iletisim').'" target="_blank">iletişim</a> sayfasından bizimle iletişime geçebilirsiniz.');
		}
		else
		{
			if(!is_form_error())
			{
				if(update_user(active_user('id'), $corporate))
				{
					get_alert('Güncelleme Başarılı', '', 'success', '');
				}
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
				<input type="text" name="company_name" id="company_name" class="form-control required" minlength="3" maxlength="50" placeholder="Firma adı" value="<?php echo $corporate['company_name']; ?>">
			</div> <!-- /.form-group -->

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" name="name" id="name" class="form-control required" minlength="3" placeholder="Ad"  value="<?php echo $corporate['name']; ?>">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-6 -->
				<div class="col-md-6">
					<div class="form-group">
						<input type="text" name="surname" id="surname" class="form-control required" minlength="3" placeholder="Soyad" value="<?php echo $corporate['surname']; ?>">
					</div> <!-- /.form-group -->
				</div> <!-- /.col-md-6 -->
			</div> <!-- /.row -->

			<div class="form-group">
				<input type="text" name="email" id="email" class="form-control required email" placeholder="E-posta" value="<?php echo $corporate['email']; ?>">
			</div> <!-- /.form-group -->

			<div class="form-group">
				<input type="text" name="gsm" id="gsm" class="form-control required digits digitsOnly"  minlength="10" maxlength="11" placeholder="Cep telefonu"  value="<?php echo $corporate['gsm']; ?>">
			</div> <!-- /.form-group -->

			<div class="text-left">
				 <input type="hidden" name="update_corporate_account">
				 <a href="#" class="btn btn-success" onclick="getElementById('form_create_update_account').submit();"><i class="fa fa-save"></i> Güncelle</a>
			</div> <!-- /.text-center -->
		</div> <!-- /.col-m-6 -->
		<div class="col-md-6">
			<div class="bg-warning padding10 fs-12">
				Bu panelden sadece profil bilgilerinizi güncelleyebilirsin. Şifreni değiştirmek için <a href="<?php echo site_url('edit_password.php'); ?>">Şifre Değiştir</a> sayfasını ziyaret et.
			</div>
		</div> <!-- /.col-md-6 -->
	</div> <!-- /.row -->
</form>


</div> <!-- /.col-md-9 -->
</div> <!-- /.row -->

<?php include('_inc/footer.php'); ?>
