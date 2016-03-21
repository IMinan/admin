<?php include('_inc/header.php'); ?>
<?php page_access('corporate'); ?>
<?php if(isset($_GET['out'])){$in_out = '1';}else{$in_out = '0';} ?>

<div class="row">
<div class="col-md-3">
	<?php include('_inc/sidebar.php'); ?>
</div> <!-- /.col-md-3 -->
<div class="col-md-9">


<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Anasayfa</a></li>
  <li><a href="<?php echo site_url('index.php'); ?>">Yönetim Paneli</a></li>
  <li class="active"><?php if($in_out =='0'): ?>Stok Girişi<?php else: ?>Stok Çıkışı<?php endif; ?></li>
</ol>
<?php if($in_out =='0'): ?>
	<h3 class="page-title"><i class="fa fa-plus"></i> Stok Girişi</h3>
<?php else: ?>
	<h3 class="page-title"><i class="fa fa-minus"></i> Stok Çıkışı</h3>
<?php endif; ?>



<?php
if(isset($_POST['microtime']))
{
	$barcode = form_input_control($_POST['barcode']);
	$quantity = form_input_control($_POST['quantity']);
	if($quantity < 1){$quantity = 1;}

	// db.list_meta tablosundan list_id'yi buluyoruz
	$list_meta = get_list_meta(array('query'=>"_key='barcode' AND val_1='$barcode' AND user_id='".active_user('id')."'"), false);

	// guvenik icin liste kontolu yapalim
	$is_user_security = mysqli()->query("SELECT * FROM list WHERE id='".$list_meta['list_id']."' AND user_id='".active_user('id')."'");
	if($is_user_security->num_rows > 0) // eger barkod kodu kullanıcı listesine ait ise islemlere devam et
	{
		$query = mysqli()->query("SELECT * FROM list_stock WHERE microtime='".$_POST['microtime']."' AND user_id='".active_user('id')."'");
		if($query->num_rows < 1)
		{
			if($list_meta)
			{
				$insert_id = add_list_stock($list_meta['list_id'], $in_out, $quantity);
				if($insert_id > 0)
				{
					// db.list tablosundaki stok adetleri guncelle
					calc_list_stock($list_meta['list_id']);

					// mesaj kutularini ekrana bas
					if($in_out =='0'):
						get_alert('"'.$barcode.'" '.$quantity.' adet stok girişi yapıldı.', $quantity.' Adet Stok Eklendi', 'success');
					else:
						get_alert('"'.$barcode.'" '.$quantity.' adet stok çıkışı yapıldı.', $quantity.' Adet Stok Çıkarıldı', 'success');
					endif;
				}
				else
				{
					get_alert('"'.$barcode.'" barkod kodu eklenirken bilinmeyen bir hata oluştu.', 'Bilinmeyen Bir Hata', 'danger');
				}
			}
			else
			{
				get_alert('"'.$barcode.'" barkod kodu bulunamadı.', 'Barkod Kodu Yok', 'danger');
			}
		}
	}
	else
	{
		get_alert('"'.$barcode.'" barkod kodu bulunamadı. Henüz barkod koduna ait liste eklemediniz.', 'Barkod Kodu Yok', 'danger');
	}
}
else
{

}


?>

<?php print_alert($err_msg, 'danger', 'false'); ?>

<form name="form_add_list" id="form_add_list" action="?<?php if($in_out =='0'): ?>in<?php else: ?>out<?php endif; ?>" method="POST" class="validate">

	<div class="row stock-space">
		<div class="col-md-2">
			<img src="<?php echo site_url('/img/barcode_reader1.jpg'); ?>" alt="Barkod Okuyucu" class="img-responsive">
		</div> <!-- /.col-d-3 -->
		<div class="col-md-7">
			<div class="h10" style="height:15px;"></div>
			<div class="form-group">
			  <div class="input-group">
			    <span class="input-group-addon"><i class="fa fa-barcode fs-26"></i></span>
			    <input type="text" name="barcode" id="barcode" class="form-control input-lg" placeholder="Barkod Kodu">
			  </div>
			</div>
			<p class="bg-muted padding10 fs-12 text-right"><strong>*</strong> * Barkod kodunu okutunuz.</p>
			<script>$('#barcode').focus();</script>
		</div> <!-- /.col-md-7 -->
		<div class="col-md-2">
			<div class="h10" style="height:15px;"></div>
			<div class="form-group">
			  <div class="input-group">
			    <span class="input-group-addon"><i class="fs-12">adet</i></span>
			    <input type="text" name="quantity" id="quantity" class="form-control input-lg digits digitsOnly" value="1">
			  </div>
			</div>
		</div> <!-- /.col-md-2 -->
		<div class="col-md-1">
			<div class="h10" style="height:15px;"></div>
			<button class="btn btn-default btn-lg"><i class="fa fa-check"></i></button>
		</div> <!-- /.col-md-1 -->
	</div><!-- /.row -->

	<?php html_microtime(); ?>
</form>



</div> <!-- /.col-md-9 -->
</div> <!-- /.row -->

<?php include('_inc/footer.php'); ?>
