<?php include('_inc/header.php'); ?>
<?php page_access('corporate'); ?>


<div class="row">
<div class="col-md-3">
	<?php include('_inc/sidebar.php'); ?>
</div> <!-- /.col-md-3 -->
<div class="col-md-9">


<?php $stock_id = form_input_control($_GET['id']); ?>
<?php $stock = get_single_list($stock_id); ?>


<?php if($stock['user_id'] != active_user('id')): ?> <?php exit('2. Dereceden Güvenlik İhlali. Bu sayfaya erişim güvenlik sebebi ile durdurulmuştur. Size ait olmayan bir ürünü güncellemeye çalışıyorsunuz. Ip adresiniz kayıt edilmiştir. Hakkınızda yasal işlem başlatılacaktır.'); ?> <?php endif; ?>

<?php if(!$stock): ?>
	<?php echo get_alert('Aradığınız sayfa bulunamadı.', 'Hatalı Giriş', 'danger', false); ?>
<?php else: ?>


<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Anasayfa</a></li>
  <li><a href="<?php echo site_url('index.php'); ?>">Yönetim Paneli</a></li>
  <li><a href="<?php echo site_url('stock_list_my.php'); ?>">Stok Listem</a></li>
  <li class="active"><?php echo brand($stock['brand_id'],'name'); ?> <?php echo $stock['code']; ?> <?php echo $stock['code_type']; ?></li>
</ol>






<h3 class="page-title"><i class="fa fa-edit"></i> <?php echo brand($stock['brand_id'],'name'); ?> <?php echo $stock['code']; ?> <?php echo $stock['code_type']; ?> Stok Kartı Düzenle</h3>


<?php

if(isset($_POST['code']))
{
	$list['brand_id'] = form_input_control($_POST['brand_id']);
	$list['code'] = form_input_control($_POST['code']);
	$list['code_type'] = mb_strtoupper(form_input_control($_POST['code_type']),'utf-8');
	$list['price'] = form_input_control($_POST['price']);
	$list['currency'] = form_input_control($_POST['currency']);


	if(update_list($stock['id'], $list))
	{
		get_alert('Stok güncellendi.', '', 'success', false);
	}
}
else
{
	$list['currency'] = '0';
}

?>

<?php print_alert($err_msg, 'danger', 'false'); ?>
<?php $stock = get_single_list($stock_id); ?>

<form name="form_add_list" id="form_add_list" action="" method="POST" class="validate">
	<div class="row stock-space">
		<div class="col-md-2">
			<div class="form-group">
				<select class="form-control" name="brand_id" id="brand_id">
					<?php foreach($list_brand as $brand): ?>
						<option value="<?php echo $brand['id']; ?>" <?php echo option_selected($brand['id'], $stock['brand_id']); ?>><?php echo $brand['name']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div> <!-- /.col-md-2 -->
		<div class="col-md-5">
			<div class="form-group">
				<input type="text" name="code" id="code" class="form-control required" maxlength="10" placeholder="Stok Kodu" value="<?php echo $stock['code']; ?>">
			</div>
		</div> <!-- /.col-md-5 -->
		<div class="col-md-1">
			<div class="form-group">
				<input type="text" name="code_type" id="code_type" class="form-control col-md-4" placeholder="Türü" value="<?php echo $stock['code_type']; ?>">
			</div>
		</div> <!-- /.col-md-1 -->
		<div class="col-md-1">
			<div class="form-group">
				<input type="text" name="price" id="price" class="form-control col-md-4" placeholder="Fiyat" value="<?php echo number_format($stock['price'],2); ?>">
			</div>
		</div> <!-- /.col-md-1 -->
		<div class="col-md-2" style="width: 70px;">
			<div class="form-group">
				<select class="form-control" name="currency" id="currency">
					<option value="0" <?php echo option_selected('0', $stock['currency']); ?>>TRY</option>
					<option value="1" <?php echo option_selected('1', $stock['currency']); ?>>USD</option>
					<option value="2" <?php echo option_selected('2', $stock['currency']); ?>>EUR</option>
				</select>
			</div>
		</div> <!-- /.col-md-2 -->
		<div class="col-md-1">
			<?php html_microtime(); ?>
			<button class="btn btn-success btn-block"><i class="fa fa-save"></i></button>
		</div> <!-- /.col-md-1 -->
	</div><!-- /.row -->

	<p class="bg-muted padding10 fs-12 text-right"><strong>*</strong> Fiyat kutusu boş bırakılır ise, fiyat teklifi alınız ibaresi yer alacaktır.</p>
</form>

<?php endif; ?>


</div> <!-- /.col-md-9 -->
</div> <!-- /.row -->

<?php include('_inc/footer.php'); ?>
