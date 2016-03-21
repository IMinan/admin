<?php include('_inc/header.php'); ?>
<?php page_access('corporate'); ?>


<div class="row">
<div class="col-md-3">
	<?php include('_inc/sidebar.php'); ?>
</div> <!-- /.col-md-3 -->
<div class="col-md-9">


<?php $stock_id = form_input_control($_GET['id']); ?> <?php if($stock_id < 1){exit;} ?>
<?php $stock = get_single_list($stock_id); ?>


<?php if($stock['user_id'] != active_user('id')): ?> <?php exit('2. Dereceden Güvenlik İhlali. Bu sayfaya erişim güvenlik sebebi ile durdurulmuştur. Size ait olmayan bir ürünü güncelleeye çalışıyorsunuz. Ip adresiniz kayıt edilmiştir. Hakkınızda yasal işlem başlatılacaktır.'); ?> <?php endif; ?>

<?php if(!$stock): ?>
	<?php echo get_alert('Aradığınız sayfa bulunamadı.', 'Hatalı Giriş', 'danger', false); ?>
<?php else: ?>


<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Anasayfa</a></li>
  <li><a href="<?php echo site_url('stock_list_my.php'); ?>">Stok Listem</a></li>
  <li class="active"><?php echo brand($stock['brand_id'], 'name'); ?> <?php echo $stock['code']; ?> <?php echo $stock['code_type']; ?></li>
</ol>

<h3 class="page-title"><i class="fa fa-trash"></i> Stok Silme Sayfası</h3>

	<?php if(isset($_GET['delete_true'])): ?>
		<?php delete_list($stock['id']); ?>
		<?php echo get_alert(brand($stock['brand_id'],'name').' '.$stock['code'].' '.$stock['code_type'].' stok silindi.', '', 'danger', false); ?>
	<?php else: ?>
		<p><strong class="text-danger"><?php echo brand($stock['brand_id'],'name'); ?> <?php echo $stock['code']; ?> <?php echo $stock['code_type']; ?></strong> ürününü stok listenizden silmek istiyor musunuz?</p>

		<a href="?id=<?php echo $stock['id']; ?>&delete_true" class="btn btn-danger"><i class="fa fa-trash"></i> Evet, istiyorum</a> <a href="<?php echo site_url('list_my.php'); ?>" class="btn btn-default">Hayır, iptal et</a>
	<?php endif; ?>

<?php endif; ?>


</div> <!-- /.col-md-9 -->
</div> <!-- /.row -->

<?php include('_inc/footer.php'); ?>
