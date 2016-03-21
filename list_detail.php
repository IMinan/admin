

<div class="row">
	<div class="col-md-1"></div>
<div class="col-md-10 col-xs-12" itemscope itemtype="http://schema.org/Product">

	<?php $list_id = form_input_control($_GET['list_id']); ?>
	<?php $list = get_single_list($list_id); ?>
	<?php $corporate = get_user($list['user_id']); ?>

	<ol class="breadcrumb hidden-xs hidden-sm">
	  <li><a href="<?php echo $theme_url; ?>">Anasayfa</a></li>
	  <li><a href="<?php echo site_url(''); ?>"><?php echo $corporate['company_name']; ?></a></li>
	  <li class="active"><?php echo brand($list['brand_id'],'name'); ?> <?php echo $list['code']; ?> <?php echo $list['code_type']; ?></li>
	</ol>

	<h3 class="text-danger" itemprop="name"><span itemprop="brand"><?php echo brand($list['brand_id']); ?></span> <?php echo $list['code']; ?> <?php echo $list['code_type']; ?></h3>


	<?php $result = mysqli()->query("SELECT * FROM product WHERE brand_id='".$list['brand_id']."' AND code='".$list['code']."' AND code_type='".$list['code_type']."'"); ?>
	<?php if($result->num_rows > 0): ?>
		<?php $product = $result->fetch_assoc(); ?>
		<div class="bg-muted padding5">
			<table class="table table-condensed fs-11" style="margin-bottom:0px;">
				<thead>
					<tr>
						<th>İç (d)</th>
						<th>Dış (D)</th>
						<th>En (B)</th>
						<th>Ağırlık</th>
						<th>Referans Hızı</th>
						<th>Devir Hızı</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo $product['d0']; ?> <span class="text-muted">mm</span></td>
						<td><?php echo $product['D']; ?> <span class="text-muted">mm</span></td>
						<td><?php echo $product['B']; ?> <span class="text-muted">mm</span></td>
						<td><?php echo $product['mass']; ?> <span class="text-muted">kg</span></td>
						<td><?php echo $product['reference_speed']; ?> <span class="text-muted">/dakika</span></td>
						<td><?php echo $product['limiting_speed']; ?> <span class="text-muted">/dakika</span></td>
					</tr>
				</tbody>
			</table>
		</div> <!-- /.bg-muted -->
		<div class="h20"></div>
	<?php endif; ?>

	<div class="row">
		<div class="col-md-5" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<table class="table table-condensed fs-13">
				<tr>
					<th width="80">Fiyat</th>
					<td width="10">:</td>
					<td>
						<?php if($list['price'] == 0): ?>
							<link itemprop="availability" href="http://schema.org/PreOrder"/>
							<meta itemprop="priceCurrency" content="TRY" />
							<span itemprop="price">0.00</span>
							<span class="text-danger fs-12">Teklif alınız.</span>
						<?php else: ?>
							<?php if($list['currency'] == '0'): ?>
								<meta itemprop="priceCurrency" content="TRY" />
							<?php elseif($list['currency'] == '1'): ?>
								<meta itemprop="priceCurrency" content="USD" />
							<?php elseif($list['currency'] == '1'): ?>
								<meta itemprop="priceCurrency" content="EUR" />
							<?php endif; ?>
							<span itemprop="price"><?php echo number_format($list['price'],2); ?> <?php echo currency_to_text($list['currency']); ?></span>
							<link itemprop="availability" href="http://schema.org/InStock"/>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th>Firma</th>
					<td>:</td>
					<td><span itemprop="seller"><?php echo $corporate['company_name']; ?></span></td>
				</tr>
				<tr>
					<th>Yetkili Adı</th>
					<td>:</td>
					<td><?php echo $corporate['name']; ?> <?php echo $corporate['surname']; ?></td>
				</tr>
				<tr>
					<th>Gsm</th>
					<td>:</td>
					<td><?php echo $corporate['gsm']; ?></td>
				</tr>
				<tr>
					<th>E-posta</th>
					<td>:</td>
					<td><?php echo $corporate['email']; ?></td>
				</tr>
				<tfoot>
					<tr>
					</tr>
						<th></th>
						<th></th>
						<th></th>
				</tfoot>
			</table>
		</div> <!-- /.col-md-5 -->
		<div class="col-md-7">


			<?php
			if(isset($_POST['microtime']))
			{
				$message['name_surname'] = mb_ucwords(form_input_control($_POST['name_surname']));
				$message['phone'] = form_input_control($_POST['phone']);
				$message['email'] = strtolower(form_input_control($_POST['email']));
				$message['description'] = form_input_control($_POST['description']);

				if(is_login()){ $message['out_user_id'] = active_user('id'); } else { $message['out_user_id'] = ''; }

				if(add_message($message['out_user_id'], $list['user_id'], $message['description'], '', $message))
				{
					get_alert('Mesajınız ilgili firmaya başarı ile ulaşmıştır.', '', 'success', false);
				}
				else
				{
					get_alert('Bilinmeyen bir hata oluştu, mesaj gönderilemedi.', '', 'danger', false);
				}
			}
			?>

			<?php
			if($list['price'] == 0){ $message = 'Merhaba, '.brand($list['brand_id']).' '.$list['code'].' '.$list['code_type'].' ürününüz ile ilgili fiyat teklifi alabilir miyim?'; }
			else { $message = ''; }

			if(is_login())
			{
				$f_name = active_user('display_name');
				$f_mail = active_user('email');
				$f_gsm  = active_user('gsm');
				$f_readonly = 'readonly';
			}
			else
			{
				$f_name = '';
				$f_mail = '';
				$f_gsm = '';
				$f_readonly = '';
			}
			?>


			<?php if($list['user_id'] != active_user('id')): ?>
				<div class="bg-warning p10 radius3">
					<form name="form_message" id="form_message" action="" method="POST" class="validate">
						<legend><i class="fa fa-envelope-o"></i> Satıcı firmaya mesaj gönderin</legend>
						<div class="form-group">
							<input type="text" name="name_surname" id="name_surname" class="form-control input-sm required" minlength="3" maxlength="30" <?php echo $f_readonly; ?> placeholder="Adınız Soyadınız" value="<?php echo $f_name; ?>">
						</div> <!-- /.form-group -->

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" name="phone" id="phone" class="form-control input-sm required validatePhone digitsOnly" minlength="10" maxlength="11" <?php echo $f_readonly; ?> placeholder="Cep Telefonu" value="<?php echo $f_gsm; ?>">
								</div> <!-- /.form-group -->
							</div> <!-- /.col-md-6 -->
							<div class="col-md-6">
								<div class="form-group">
									<input type="text" name="email" id="email" class="form-control input-sm required email" maxlength="100" placeholder="E-posta" <?php echo $f_readonly; ?> value="<?php echo $f_mail; ?>">
								</div> <!-- /.form-group -->
							</div> <!-- /.col-md-6 -->
						</div> <!-- /.row -->

						<div class="form-group">
							<textarea name="description" id="description" class="form-control input-sm" style="height:100px;" minlength="10" maxlength="255" placeholder="Bir mesaj yazın"><?php echo $message; ?></textarea>
						</div> <!-- /.form-group -->
						<div class="text-right">
							<?php html_microtime(); ?>
							<button class="btn btn-default btn-sm">Mesaj Gönder</button>
						</div> <!-- /.text-right -->
					</form>
				</div> <!-- /.bg-muted -->
			<?php else: ?>
				<div class="bg-warning p10 radius3">
					Bu liste <strong>Firmanıza </strong> ait olduğu için teklif gönderemezsiniz.
				</div> <!-- /.bg-warning -->
			<?php endif; ?>
		</div> <!-- /.col-md-7 -->
	</div> <!-- /.row -->

</div> <!-- /.col-md-10 -->

<div class="col-md-1"></div><!-- /.col-md-1 -->
</div> <!-- /.row -->
