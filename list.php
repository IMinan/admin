<?php include('_inc/header.php'); ?>
<?php page_access('corporate'); ?>

<div class="row">
<div class="col-md-3">
	<?php include('_inc/sidebar.php'); ?>
</div> <!-- /.col-md-3 -->
<div class="col-md-9">


<?php $list_id = form_input_control($_GET['id']); ?>
<?php $list = get_single_list($list_id); ?>

<?php if($list['user_id'] != active_user('id')): ?> <?php exit('2. Dereceden Güvenlik İhlali. Bu sayfaya erişim güvenlik sebebi ile durdurulmuştur. Size ait olmayan bir ürünü güncellemeye çalışıyorsunuz. Ip adresiniz kayıt edilmiştir. Hakkınızda yasal işlem başlatılacaktır.'); ?> <?php endif; ?>

<?php if(!$list): ?>
	<?php echo get_alert('Aradığınız sayfa bulunamadı.', 'Hatalı Giriş', 'danger', false); ?>
<?php else: ?>


<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Anasayfa</a></li>
  <li><a href="<?php echo site_url('index.php'); ?>">Yönetim Paneli</a></li>
  <li><a href="<?php echo site_url('stock_list_my.php'); ?>">Stok Listem</a></li>
  <li class="active"><?php echo brand($list['brand_id'],'name'); ?> <?php echo $list['code']; ?> <?php echo $list['code_type']; ?></li>
</ol>


<h3 class="page-title"><i class="fa fa-clone"></i> <?php echo brand($list['brand_id'],'name'); ?> <?php echo $list['code']; ?> <?php echo $list['code_type']; ?> Stok Kartı</h3>


Bu sayfa tasarım aşamasında.<br />
Stok kartına ait bir detay bulunamadı.


<div class="row">
	<div class="col-md-6">

	</div> <!-- /.col-md-6 -->
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Barkod Paneli</h3></div>
			<div class="panel-body">
				<small class="bg-muted padding10">*Aşağıda barkod kodları bu stok kartı için geçerlidir.</small>
				<div class="clearfix"></div>
				<br />
				<style>
				.img-thumbnail-barcode:hover {
					border:1px solid #1987E6;
				}
				</style>
				<?php $barcodes = get_list_meta($list_id, 'barcode', '', true); ?>
				<?php
				if(!$barcodes) // eger barkod kodu yok ise
				{
					// otomatik barkod kodu olustur
					$barcode = trim(brand($list['brand_id'],'name').' '.$list['code'].' '.$list['code_type']);
					add_list_meta($list_id, array('_key'=>'barcode', 'val_1'=>$barcode));
					// barkod kodlarını degiskene tekrar ata
					$barcodes = get_list_meta($list_id, 'barcode', '', true);
				}
				?>
				<?php if($barcodes): ?>
					<?php foreach($barcodes as $barcode): ?>
						<a href="<?php echo site_url('print_barcode.php'); ?>?text=<?php echo $barcode['val_1']; ?>"
							onclick="return popitup('<?php echo site_url('print_barcode.php'); ?>?text=<?php echo $barcode['val_1']; ?>')"
						 	target="_blank" class="img-thumbnail img-thumbnail-barcode">
							<img src="<?php echo site_url('_inc/plugins/barcode.php'); ?>?text=<?php echo $barcode['val_1']; ?>" />
							<br />
							<div class="text-center" style="color:#000;"><?php echo $barcode['val_1']; ?></div>
						</a>
						<div class="h20"></div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div> <!-- /.panel-body -->
		</div>
	</div> <!-- /.col-md-6 -->
</div> <!-- /.row -->
<script>
function popitup(url) {
	newwindow=window.open(url,'name','resizable=0, toolbar=0, scrollbars=0, menubar=0, status=0, directories=0,left=300,top=100,height=100,width=300');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>

<?php endif; ?>

</div> <!-- /.col-md-9 -->
</div> <!-- /.row -->

<?php include('_inc/footer.php'); ?>
