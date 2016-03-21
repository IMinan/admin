<?php include('_inc/header.php'); ?>
<?php page_access('corporate'); ?>


<div class="row">
<div class="col-md-3">
	<?php include('_inc/sidebar.php'); ?>
</div> <!-- /.col-md-3 -->
<div class="col-md-9">


<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Anasayfa</a></li>
  <li><a href="<?php echo site_url('index.php'); ?>">Yönetim Paneli</a></li>
  <li><a href="<?php echo site_url('stock_list_my.php'); ?>">Stok Listem</a></li>
  <li class="active">Yeni Ekle</li>
</ol>
<h3 class="page-title"><i class="fa fa-plus"></i> Yeni Stok Kartı</h3>


<?php



if(isset($_POST['microtime']))
{
	$list['brand_id'] = form_input_control($_POST['brand_id']);
	$list['code'] = form_input_control($_POST['code']);
	$list['code_type'] = mb_strtoupper(form_input_control($_POST['code_type']),'utf-8');
	$list['price'] = form_input_control($_POST['price']);
	$list['currency'] = form_input_control($_POST['currency']);

	if($list['code_type'] == '')
	{
		if(strstr($list['code'], ' '))
		{
			$input = $list['code'];
			$explode = explode(' ', $input);
			if(ctype_digit($explode[0]))
			{
				$list['code'] = trim($explode[0]);
				$list['code_type'] = trim(mb_strtoupper(str_replace($list['code'], '', $input),'utf-8'));
			}
		}
	}


	$is_user_list = is_user_list(active_user('id'), $list['code'], $list['code_type'], $list['brand_id']);

	if($is_user_list)
	{
		array_push($err_msg, $list_brand[$list['brand_id']]['name'].' '.$list['code'].' '.$list['code_type'].' ürün daha önceden eklenmiş.');
	}
	else
	{
		if(add_list($list))
		{
			get_alert('Stok listesi eklendi.', '', 'success', false);
		}
	}
}
else
{
	$list['brand_id'] = '';
	$list['currency'] = '0';
}

?>

<?php print_alert($err_msg, 'danger', 'false'); ?>

<form name="form_add_list" id="form_add_list" action="?" method="POST" class="validate">
	<div class="row stock-space">
		<div class="col-md-2">
			<div class="form-group">
				<select class="form-control" name="brand_id" id="brand_id">
					<?php foreach($list_brand as $brand): ?>
						<option value="<?php echo $brand['id']; ?>" <?php echo option_selected($brand['id'], $list['brand_id']); ?>><?php echo $brand['name']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div> <!-- /.col-md-2 -->
		<div class="col-md-5">
			<div class="form-group">
				<input type="text" name="code" id="code" class="form-control required" maxlength="20" placeholder="Stok Kodu">
			</div>
		</div> <!-- /.col-md-5 -->
		<div class="col-md-1">
			<div class="form-group">
				<input type="text" name="code_type" id="code_type" class="form-control col-md-4" placeholder="Türü">
			</div>
		</div> <!-- /.col-md-1 -->
		<div class="col-md-1">
			<div class="form-group">
				<input type="text" name="price" id="price" class="form-control col-md-4" placeholder="Fiyat">
			</div>
		</div> <!-- /.col-md-1 -->
		<div class="col-md-2" style="width: 70px;">
			<div class="form-group">
				<select class="form-control" name="currency" id="currency">
					<option value="0" <?php echo option_selected('0', $list['currency']); ?>>TRY</option>
					<option value="1" <?php echo option_selected('1', $list['currency']); ?>>USD</option>
					<option value="2" <?php echo option_selected('2', $list['currency']); ?>>EUR</option>
				</select>
			</div>
		</div> <!-- /.col-md-2 -->
		<div class="col-md-1">
			<?php html_microtime(); ?>
			<button class="btn btn-success btn-block"><i class="fa fa-plus"></i></button>
		</div> <!-- /.col-md-1 -->
	</div><!-- /.row -->

	<p class="bg-muted padding10 fs-12 text-right"><strong>*</strong> Fiyat kutusu boş bırakılır ise, fiyat teklifi alınız ibaresi yer alacaktır.</p>
</form>

<script>$('#code').focus();</script>


</div> <!-- /.col-md-9 -->
</div> <!-- /.row -->

<?php include('_inc/footer.php'); ?>
