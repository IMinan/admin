
<div class="col-md-1"></div>
<div class="col-md-10">
	<div class="h10"></div>
<?php
if(isset($_GET['search']))
{
	$search = mb_strtoupper(form_input_control($_GET['search']),'utf-8');

	foreach($list_brand as $brand)
	{
		if(strstr($search, $brand['name']))
		{
			$search = trim(str_replace($brand['name'], '', $search));
			$_GET['brand_id'] = $brand['id'];
		}
	}

}
else
{
	$search = '';
}

if(isset($_GET['brand_id']))
{
	$brand_id = form_input_control($_GET['brand_id']);
}
else
{
	$brand_id = '';
}
?>

	<ol class="breadcrumb">
	  <li><a href="<?php echo $theme_url; ?>">Anasayfa</a></li>
	  <li class="active">Ürün Arama</li>
	</ol>


	<form name="form-search" id="form-search" action="search.php" method="GET">
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<select class="form-control" name="brand_id" id="brand_id">
						<option value="">HEPSI</option>
						<?php foreach($list_brand as $brand): ?>
							<option value="<?php echo $brand['id']; ?>" <?php echo option_selected($brand['id'], $brand_id); ?>><?php echo $brand['name']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div> <!-- /.col-md-2 -->
			<div class="col-md-4">

				<div class="form-group">
				  <div class="input-group">

				    <input type="text" id="search" name="search" class="search form-control" placeholder="Örnek: 1206" value="<?php echo $search; ?>">
				    <span class="input-group-addon" onclick="getElementById('form-search').submit();"><i class="fa fa-search"></i></span>
				  </div>
				</div> <!-- /.form-group -->

			</div> <!-- /.col-md-4 -->
			<div class="col-md-8">

			</div> <!-- /.col-md-8 -->
		</div> <!-- /.row -->
	</form> <!-- /#form-search -->



	<?php
	function search_list($search_key, $custom_query='')
	{
		if(strlen($custom_query) > 0)
		{
			return $result = mysqli()->query($custom_query);
		}
		else
		{
			return $result = mysqli()->query("SELECT * FROM list WHERE code LIKE '%$search_key%' ORDER BY id DESC LIMIT 500");
		}

	}

	if(strlen($brand_id) > 0)
	{
		$result = search_list($search, "SELECT * FROM list WHERE code LIKE '%$search%' AND brand_id='$brand_id' ORDER BY id DESC LIMIT 500");
	}
	else
	{
		$result = search_list($search);
	}

	?>


	<?php $all_user = get_all_user(); ?>


	<?php if($result->num_rows > 0): ?>
		<table class="table table-list table-condensed table-hover table-bordered">
			<thead>
				<tr>
					<th class="hidden"></th>
					<th>Marka</th>
					<th>Stok Kodu</th>
					<th>Fiyat</th>
					<th style="width:80px;" class="hidden-xs hidden-sm"></th>
				</tr>
			</thead>
			<tbody>
			<?php while($list = $result->fetch_assoc()): ?>
				<tr>
					<td class="hidden"></td>
					<td><?php echo brand($list['brand_id'],'name'); ?></td>
					<td><?php echo $list['code']; ?> <span class="text-muted fs-12"><?php echo $list['code_type']; ?></span></td>
					<td class="text-right">
						<?php if($list['price'] == 0): ?>
							<span class="text-muted fs-12">Teklif alınız.</span>
						<?php else: ?>
							<?php echo number_format($list['price'],2); ?> <?php echo currency_to_text($list['currency']); ?>
						<?php endif; ?>
					</td>
					<td class="text-right hidden-xs hidden-sm"><a href="<?php echo theme_url('list_detail.php?list_id='.$list['id']); ?>">Detaylar &raquo;</a></td>
				</tr>
			<?php endwhile; ?>
			</tbody>
		</table>
	<?php else: ?>

		<hr />

		<div class="bg-warning " style="padding: 20px">
			<span class="no-space f16 bold"><i class="fa fa-exclamation-triangle"></i> <?php echo trim(@brand($brand_id).' '.$search.' Stok Kodu Bulunamadı.'); ?></span>
		</div> <!-- /.bg-warning -->
	<?php endif; ?>

</div> <!-- /.col-md-10 -->
<div class="col-md-1"></div>
</div> <!-- /.row -->
