<?php include('_inc/header.php'); ?>
<?php page_access('corporate'); ?>


<div class="row">
<div class="col-md-3">
	<?php include('_inc/sidebar.php'); ?>
</div> <!-- /.col-md-3 -->
<div class="col-md-9">

<?php $message_id = form_input_control($_GET['id']); if($message_id < 1) {exit();} ?>
<?php $message = get_message($message_id); if(!$message->num_rows){exit;} ?>
<?php $message = $message->fetch_assoc(); ?>

<?php
if($message['out_user_id'] == active_user('id')){}
elseif($message['in_user_id'] == active_user('id')){}
else {exit('bu mesaj size ait degil, erisim yetkiniz bulunmamakta.');}
?>

<ol class="breadcrumb">
  <li><a href="<?php echo site_url(''); ?>">Anasayfa</a></li>
  <li><a href="<?php echo site_url('message_inbox.php'); ?>">Gelen Kutusu</a></li>
  <li class="active"><?php echo $message['name_surname']; ?> &raquo; <?php echo active_user('company_name'); ?></li>
</ol>

<?php
// okundu olarak isaretle
if($message['reading'] == 0)
{
	$result = mysqli_query(mysqli(), "UPDATE message SET reading='1', reading_date='".date('Y-m-d H:i:s')."' WHERE id='$message_id'");
	$message = get_message($message_id)->fetch_assoc();
}
?>

<?php if($message['out_user_id'] < 1): ?>
	<div class="bg-warning padding5 text-muted fs-12 italic"><i class="fa fa-warning"></i> Bu bir ziyaretçi mesajıdır. Ziyaretçiler sitemize üye olmadıklarından kimlikleri doğrulanamayabilir.</div>
<?php endif; ?>

<div class="bg-muted padding20 fs-13">
	<table class="fs-12">
		<tr>
			<td width="80" class="text-right">Gönderen</td>
			<td width="10"></td>
			<td>
				<?php if($message['out_user_id'] < 1): ?>
					<strong><?php echo $message['name_surname']; ?></strong>
				<?php else: ?>
					<a href="<?php echo site_url('corporate.php?id='.$message['out_user_id']); ?>" target="_blank"><strong><?php echo $message['name_surname']; ?></strong></a>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td class="text-right">Telefon</td>
			<td></td>
			<td><strong><?php echo $message['phone']; ?></strong></td>
		</tr>
		<tr>
			<td class="text-right">E-posta</td>
			<td></td>
			<td><strong><?php echo $message['email']; ?></strong></td>
		</tr>
		<tr>
			<td class="text-right">Tarih</td>
			<td></td>
			<td class="text-muted"><?php echo substr($message['date'],0,16); ?> tarihinde ortalama <?php echo time_late($message['date']); ?> önce gönderildi</td>
		</tr>
		<tr>
			<td colspan="3"> &nbsp; </td>
		</tr>
		<tr class="">
			<td class="text-right text-danger">Mesaj</td>
			<td></td>
			<td class="fs-14 ff-2"><?php echo $message['description']; ?></td>
		</tr>
	</table>

</div> <!-- /.bg-muted -->

<div class="text-right text-muted fs-10 italic">bu mesaj <?php echo substr($message['reading_date'],0,16); ?> tarihinde okundu.</div>





</div> <!-- /.col-md-9 -->
</div> <!-- /.row -->

<?php include('_inc/footer.php'); ?>
