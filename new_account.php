<?php include('_inc/header.php'); ?>

<div class="h20"></div>
<div class="page-title"><h3 class="page-title"><i class="fa fa-user"></i> Yeni Kurumsal Hesap</h3></div>
<div class="h20"></div>

<?php
$corporate['company_name'] = '';
$corporate['name'] = '';
$corporate['surname'] = '';
$corporate['email'] = '';
$corporate['gsm'] = '';
$corporate['password'] = '';
$corporate['district'] = '';
?>
<?php if(isset($_POST['new_corporate_account'])): ?>
	<?php
	$corporate['company_name'] = mb_ucwords(form_input_control($_POST['company_name']));
	$corporate['name'] = mb_ucwords(form_input_control($_POST['name']));
	$corporate['surname'] = mb_ucwords(form_input_control($_POST['surname']));
	$corporate['email'] = strtolower(form_input_control($_POST['email']));
	$corporate['gsm'] = convert_gsm(form_input_control($_POST['gsm']));
	$corporate['password'] = form_input_control($_POST['password']);
	$corporate['city'] = mb_ucwordsform_input_control($_POST['city']));
	$corporate['district'] = mb_ucwords(form_input_control($_POST['district']));


	// form string kontrolleri
	form_string_control($corporate['company_name'], 'Firma adı', array('min'=>3, 'max'=>50));
	form_string_control($corporate['name'], 'Ad', array('min'=>3, 'max'=>50));
	form_string_control($corporate['surname'], 'Soyad', array('min'=>3, 'max'=>50));
	form_string_control($corporate['email'], 'E-posta', array('required'=>true, 'is_mail'=>true));
	form_string_control($corporate['gsm'], 'Cep telefonu', array('required'=>true, 'is_gsm'=>true));
	form_string_control($corporate['password'], 'Şifre', array('required'=>true, 'min'=>6, 'max'=>32));



	if(!is_form_error())
	{
		$corporate['status'] = '1';
		$corporate['date'] = date('Y-m-d H:i:s');
		$corporate['user_type'] = 'corporate';

		if(is_user("gsm='".$corporate['gsm']."'") > 0) {
			array_push($err_msg, '<strong>'.$corporate['gsm'].'</strong> telefon numarasına ait üyelik bulunmakta. Üyelik ile ilgili problem yaşıyorsanız <a href="'.site_url('iletisim').'" target="_blank">iletişim</a> sayfasından bizimle iletişime geçebilirsiniz.');
		}
		elseif(is_user("email='".$corporate['email']."'") > 0) {
			array_push($err_msg, '<strong>'.$corporate['email'].'</strong> e-posta numarasına ait üyelik bulunmakta. Üyelik ile ilgili problem yaşıyorsanız <a href="'.site_url('iletisim').'" target="_blank">iletişim</a> sayfasından bizimle iletişime geçebilirsiniz.');
		}
		else
		{
			// her sey duzgun ise veritabani ekleyelim

			$corporate_id = add_user($corporate);
			if($corporate_id > 0)
			{
				$corporate = get_user($corporate_id);
				$_SESSION['login_id'] = $corporate['id'];
				header("Location: ".site_url(''));
			}
		}
	}
	?>
<?php endif; ?>


<?php if(is_form_error()): ?><div class="row"><div class="col-md-3"></div><div class="col-md-6">	<?php print_alert($err_msg, 'danger', 'false'); ?> </div> <!-- /.col-md-3 --><div class="col-md-3"></div></div> <!-- /.row --> <?php endif; ?>


<form name="form_create_new_account" id="form_create_new_account" action="" method="POST" class="validate">
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<input type="text" name="company_name" id="company_name" class="form-control input-sm required" minlength="3" maxlength="50" placeholder="Firma adı" value="<?php echo $corporate['company_name']; ?>">
		</div> <!-- /.form-group -->

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<input type="text" name="name" id="name" class="form-control input-sm required" minlength="3" maxlength="20" placeholder="Ad" value="<?php echo $corporate['name']; ?>">
				</div> <!-- /.form-group -->
			</div> <!-- /.col-md-6 -->
			<div class="col-md-6">
				<div class="form-group">
					<input type="text" name="surname" id="surname" class="form-control input-sm required" minlength="3" maxlength="20" placeholder="Soyad" value="<?php echo $corporate['surname']; ?>">
				</div> <!-- /.form-group -->
			</div> <!-- /.col-md-6 -->
		</div> <!-- /.row -->

		<div class="form-group">
			<input type="text" name="email" id="email" class="form-control input-sm required email" placeholder="E-posta" value="<?php echo $corporate['email']; ?>">
		</div> <!-- /.form-group -->

		<div class="form-group">
			<input type="text" name="gsm" id="gsm" class="form-control input-sm required digits digitsOnly" minlength="10" maxlength="11" placeholder="Cep telefonu" value="<?php echo $corporate['gsm']; ?>">
		</div> <!-- /.form-group -->

		<div class="form-group">
			<input type="password" name="password" id="password" class="form-control input-sm required" minlength="6" minlen placeholder="Şifre" value="<?php echo $corporate['password']; ?>">
		</div> <!-- /.form-group -->


		<div class="row">
			<div class="col-md-6">

				<div class="form-group">
					<select name="city" id="city" class="form-control input-sm">
						<option value="Adana">Adana</option>
						<option value="Adıyaman">Adıyaman</option>
						<option value="Afyon">Afyon</option>
						<option value="Ağrı">Ağrı</option>
						<option value="Aksaray">Aksaray</option>
						<option value="Amasya">Amasya</option>
						<option value="Ankara">Ankara</option>
						<option value="Antalya">Antalya</option>
						<option value="Ardahan">Ardahan</option>
						<option value="Artvin">Artvin</option>
						<option value="Aydın">Aydın</option>
						<option value="Balıkesir">Balıkesir</option>
						<option value="Bartın">Bartın</option>
						<option value="Batman">Batman</option>
						<option value="Bayburt">Bayburt</option>
						<option value="Bilecik">Bilecik</option>
						<option value="Bingöl">Bingöl</option>
						<option value="Bitlis">Bitlis</option>
						<option value="Bolu">Bolu</option>
						<option value="Burdur">Burdur</option>
						<option value="Bursa">Bursa</option>
						<option value="Çanakkale">Çanakkale</option>
						<option value="Çankırı">Çankırı</option>
						<option value="Çorum">Çorum</option>
						<option value="Denizli">Denizli</option>
						<option value="Diyarbakır">Diyarbakır</option>
						<option value="Düzce">Düzce</option>
						<option value="Edirne">Edirne</option>
						<option value="Elazığ">Elazığ</option>
						<option value="Erzincan">Erzincan</option>
						<option value="Erzurum">Erzurum</option>
						<option value="Eskişehir">Eskişehir</option>
						<option value="Gaziantep">Gaziantep</option>
						<option value="Giresun">Giresun</option>
						<option value="Gümüşhane">Gümüşhane</option>
						<option value="Hakkari">Hakkari</option>
						<option value="Hatay">Hatay</option>
						<option value="Iğdır">Iğdır</option>
						<option value="Isparta">Isparta</option>
						<option value="İçel">İçel</option>
						<option value="İstanbul" selected>İstanbul</option>
						<option value="İzmir">İzmir</option>
						<option value="Kahramanmaraş">Kahramanmaraş</option>
						<option value="Karabük">Karabük</option>
						<option value="Karaman">Karaman</option>
						<option value="Kars">Kars</option>
						<option value="Kastamonu">Kastamonu</option>
						<option value="Kayseri">Kayseri</option>
						<option value="Kırıkkale">Kırıkkale</option>
						<option value="Kırklareli">Kırklareli</option>
						<option value="Kırşehir">Kırşehir</option>
						<option value="Kilis">Kilis</option>
						<option value="Kilis">Kocaeli</option>
						<option value="Konya">Konya</option>
						<option value="Kütahya">Kütahya</option>
						<option value="Malatya">Malatya</option>
						<option value="Manisa">Manisa</option>
						<option value="Mardin">Mardin</option>
						<option value="Muğla">Muğla</option>
						<option value="Muş">Muş</option>
						<option value="Nevşehir">Nevşehir</option>
						<option value="Niğde">Niğde</option>
						<option value="Ordu">Ordu</option>
						<option value="Osmaniye">Osmaniye</option>
						<option value="Rize">Rize</option>
						<option value="Sakarya">Sakarya</option>
						<option value="Samsun">Samsun</option>
						<option value="Siirt">Siirt</option>
						<option value="Sinop">Sinop</option>
						<option value="Sivas">Sivas</option>
						<option value="Şanlıurfa">Şanlıurfa</option>
						<option value="Şırnak">Şırnak</option>
						<option value="Tekirdağ">Tekirdağ</option>
						<option value="Tokat">Tokat</option>
						<option value="Trabzon">Trabzon</option>
						<option value="Tunceli">Tunceli</option>
						<option value="Uşak">Uşak</option>
						<option value="Van">Van</option>
						<option value="Yalova">Yalova</option>
						<option value="Yozgat">Yozgat</option>
						<option value="Zonguldak">Zonguldak</option>
					</select>
				</div> <!-- /.form-gorup -->
			</div> <!-- /.col-md-6 -->
			<div class="col-md-6">
				<div class="form-group">
					<input type="text" name="district" id="district" class="form-control input-sm required" minlength="3" maxlength="20" placeholder="İlçe" value="<?php echo $corporate['district']; ?>">
				</div> <!-- /.form-group -->
			</div> <!-- /.col-md-6 -->
		</div> <!-- /.row -->

		<div class="text-center">

	<div class="checkbox">
	    <label>
	      <input type="checkbox" name="terms" id="terms" class="required">  <span class="fs-12"><a href="#">Üyelik Sözleşmesi Koşulları</a>'nı ve <a href="#">Gizlilik Politikası</a>'nı kabul ediyorum.</span>
	    </label>
	 </div> <!-- /.checkbox -->
	 <br />
	 <input type="hidden" name="new_corporate_account">
	 <button class="btn btn-success">Kurumsal Hesap Aç</button>

</div> <!-- /.text-center -->

	</div> <!-- /.col-md-4 -->
	<div class="col-md-8"></div>
</div> <!-- /.row -->



</form>


<?php include('_inc/footer.php'); ?>
