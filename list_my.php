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
  <li class="active">Stok Listem</li>
</ol>

<?php $result = get_list(active_user('id')); ?>


<?php if($result->num_rows < 1): ?>
	<?php get_alert('Veritabanlarımızda firmanıza ait ürün bulunamadı. Yeni bir stok listesi oluşturmak ister misiniz? <br /> <a href="'.site_url('list_add.php').'">Evet, ürün eklemek istiyorum</a>.', 'Stok Listesi Yok!', 'warning', false); ?>
<?php else: ?>

	<table class="table table-list table-condensed table-hover table-bordered dataTable">
		<thead>
			<tr>
				<th class="hidden"></th>
				<th class="buttons" width="120"></th>
				<th>Marka</th>
				<th>Stok Kodu</th>
				<th>Adet</th>
				<th>Fiyat</th>
			</tr>
		</thead>
		<tbody>
		<?php while($obj = $result->fetch_object()): ?>
			<tr>
				<td class="hidden"></td>
				<td>
					<a href="<?php echo site_url('list.php?id='.$obj->id); ?>" target="_blank" class="btn btn-default btn-xs detail_btn">detaylar</a>
					<a href="<?php echo site_url('list_edit.php?id='.$obj->id); ?>" target="_blank" class="btn btn-default btn-xs edit_btn" data-toggle="tooltip" data-placement="top" title="Düzenle"><i class="fa fa-pencil"></i></a>
					<a href="<?php echo site_url('list_delete.php?id='.$obj->id); ?>" target="_blank" class="btn btn-default btn-xs delete_btn" data-toggle="tooltip" data-placement="top" title="Sil"><i class="fa fa-trash"></i></a>
				</td>
				<td><?php echo brand($obj->brand_id, 'name'); ?></td>
				<td><?php echo $obj->code; ?> <span class="text-muted fs-12"><?php echo $obj->code_type; ?></span></td>
				<td class="text-center"><?php echo $obj->quantity; ?></td>
				<td class="text-right"><?php echo number_format($obj->price,2); ?> <?php echo currency_to_text($obj->currency); ?></td>
			</tr>
		<?php endwhile; ?>
		</tbody>
	</table>

<?php endif; ?>




</div> <!-- /.col-md-9 -->
</div> <!-- /.row -->

<?php include('_inc/footer.php'); ?>
