<?php include('_inc/header.php'); ?>
<?php page_access('corporate'); ?>


<div class="row">
<div class="col-md-3">
	<?php include('_inc/sidebar.php'); ?>
</div> <!-- /.col-md-3 -->
<div class="col-md-9">


<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Anasayfa</a></li>
  <li class="active">Gelen Kutusu</li>
</ol>

<?php $messages = get_in_message_list(active_user('id'), ''); ?>
<?php $all_user = get_all_user(); ?>





<?php if($messages): ?>

	<table class="table table-hover table-condensed fs-13 dataTable">
	<thead>
		<tr>
			<th class="hidden"></th>
			<th>Gönderen</th>
			<th>Mesaj</th>
			<th>Tarih</th>
		</tr>
	</thead>
	<tbody>
		<?php while($list = $messages->fetch_assoc()): ?>
			<tr class="<?php if($list['reading'] == '0'): ?>bold<?php endif; ?>">
				<td class="hidden"></td>
				<td>
					<?php if($list['out_user_id'] > 0): ?>
						<?php echo $all_user[$list['out_user_id']]['company_name']; ?>
					<?php else: ?>
						<span class="text-muted"><?php echo $list['name_surname']; ?></span>
					<?php endif; ?>
				</td>
				<td><a href="<?php echo site_url('message_box.php?id='.$list['id']); ?>"><?php echo mb_substr($list['description'],0,70,'utf-8'); ?></a></td>
				<td class="text-muted"><?php echo time_late($list['date']); ?></td>
			</tr>
		<?php endwhile; ?>
	</table>

<?php endif; ?>






</div> <!-- /.col-md-9 -->
</div> <!-- /.row -->

<?php include('_inc/footer.php'); ?>
