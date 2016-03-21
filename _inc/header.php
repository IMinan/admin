<?php ob_start(); session_start(); ?>
<?php
	if(file_exists('_conf.php')) { include('_conf.php'); }
	elseif(file_exists('../_conf.php')) { include('../_conf.php'); }
	elseif(file_exists('../../_conf.php')) { include('../../_conf.php'); }
	elseif(file_exists('../../../_conf.php')) { include('../../../_conf.php'); }
	else { include('../../../_conf.php'); }
?>
<?php
	if(file_exists('_inc/functions.php')) { include('_inc/functions.php'); }
	elseif(file_exists('../_inc/functions.php')) { include('../_inc/functions.php'); }
	elseif(file_exists('../../_inc/functions.php')) { include('../../_inc/functions.php'); }
	elseif(file_exists('../../../_inc/functions.php')) { include('../../../_inc/functions.php'); }
	else { include('../../../_inc/functions.php'); }
?>

<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js ie6 lt-ie7"> <![endif]-->
<!--[if IE 7]> <html class="no-js ie7 lt-ie8 lt-ie9"> <![endif]-->
<!--[if IE 8]> <html class="no-js ie8 lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<?php if(strstr($_SERVER['SCRIPT_NAME'],'list_detail.php')): ?>
		<?php
		$list = get_single_list($_GET['id']);
		$corporate = get_user($list['user_id']);
		$product_name = trim(brand($list['brand_id']).' '.$list['code'].' '.$list['code_type']);

		$meta['title'] = $product_name.' - '.$corporate['company_name'];

		$meta['description'] = $product_name.' ürün detayları, boyutları, ölçüleri, görselleri ve bu ürünü satan firmalara ulaşabilirsiniz.';
		if($list['price'] > 0) { $meta['description'] = $meta['description'].' '.$product_name.' satış fiyati: '.number_format($list['price'],2).' '.currency_to_text($list['currency'], false); } else {  $meta['description'] = $meta['description'].' Bu ürün için fiyat teklifi alabilirsiniz.';}

		$meta['keywords'] = brand($list['brand_id']).','.$list['code']; if(strlen($list['code_type']) > 0) { $meta['keywords'] = $meta['keywords'].','.$list['code_type']; }
		$meta['keywords'] = $meta['keywords'].','.$corporate['company_name'];

		?>
	<?php elseif(strstr($_SERVER['SCRIPT_NAME'],'corporate.php')): ?>
		<?php
		$corporate = get_user($_GET['id']);
		$meta['title'] = $corporate['company_name'].' | rulmanlistesi.com';
		$meta['description'] = $corporate['company_name'].' firmasına ait rulman listelerine ulaşabilir, teklif alabilir, verebilirsiniz.';
		$meta['keywords'] = $corporate['company_name'].','.$corporate['name'].' '.$corporate['surname'].','.$corporate['city'];
		?>
	<?php else: ?>
		<?php
		$meta['title'] = 'RulmanListesi | rulmanlistesi.com';
		$meta['description'] = 'Yüzlerce rulman listesi tek bir sitede. Rulman arayabilir, satabilir, listenizi ekleyebilirsiniz.';
		$meta['keywords'] = 'rulman,bilya,bilye,sanayi,kayış,rulman firmaları, istanbul rulmancılar, skf, fag, urb, ino, ors';
		?>
	<?php endif; ?>


	<title><?php echo $meta['title']; ?></title>
	<meta name="description" content="<?php echo $meta['description']; ?>">
	<meta name="keywords" content="<?php echo $meta['keywords']; ?>">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- favicon -->
	<link rel="icon" href="<?php echo site_url('img/favicon.ico'); ?>" type="image/ico"/>

	<!-- bootstrap -->
	<link rel="stylesheet" href="<?php echo site_url('css/bootstrap.min.css'); ?>">
	<script src="<?php echo site_url('js/jquery.min.js'); ?>"></script>
	<script src="<?php echo site_url('js/bootstrap.min.js'); ?>"></script>

	<!-- fontawesome -->
	<link rel="stylesheet" href="<?php echo site_url('css/font-awesome.min.css'); ?>">

	<!-- datatable -->
	<link rel="stylesheet" type="text/css" href="<?php echo site_url('css/datatables.min.css'); ?>"/>
 	<script type="text/javascript" src="<?php echo site_url('js/datatables.min.js'); ?>"></script>


	<!-- custom style -->
	<link rel="stylesheet" href="<?php echo site_url('css/app.css'); ?>">
	<script src="<?php echo site_url('js/app.js'); ?>"></script>
	  <script src="<?php echo site_url('js/nicEdit.js'); ?>"></script>



	<meta property="og:site_name" content="RulmanListesi | rulmanlistesi.com>"/>
	<meta property="og:title" content="<?php echo $meta['title']; ?>"/>
	<meta property="og:description" content="<?php echo $meta['description']; ?>" />
	<meta property="og:url" content="<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>"/>
	<meta property="og:image" content="http://senetlearaba.net/wp-content/uploads/2015/11/gumus-gri-renk-logan-resimleri-32540.jpg"/>


	<script type="application/ld+json">
	{
	   "@context": "http://schema.org",
	   "@type": "WebSite",
	   "url": "http://rulmanlistesi.com",
	   "potentialAction": {
	     "@type": "SearchAction",
	     "target": "http://rulmanlistesi.com/search.php?search={search_term_string}",
	     "query-input": "required name=search_term_string"
	   }
	}
	</script>

</head>
<body>
<header>


<?php if(is_login()): ?>
<div class="container bg">
	<div class="rl-menu-top">
		<div class="row">
			<div class="col-xs-3 col-sm-5 col-md-4">
				<a class="navbar-brand" href="<?php echo site_url(); ?>"><span><img src="<?php echo site_url(); ?>/img/logo.png" class="img-responsive logo" alt="RulmanSoft.com Logo"></span><span class="logo-text hidden-xs">RulmanSoft</span></a>
			</div> <!-- /.col-md-4 -->
			<div class="col-md-2 hidden-xs hidden-sm">

			</div> <!-- /.col-md-2 -->
			<div class="col-xs-9 col-sm-7 col-md-6">
				<?php if(is_login()): ?>
					<ul class="top-menu is_login">
						<li><a href="<?php echo site_url('message_inbox.php'); ?>"><i class="fa fa-envelope"></i><span class="count"><?php echo get_count_in_message(active_user('id')); ?></span></a></li>
						<li class="dropdown"><a href="#" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<img src="<?php echo site_url('upload/profile/24/profile.jpg'); ?>">
							<?php echo active_user('display_name'); ?>  <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo site_url('index.php'); ?>" title="Profilim"><i class="fa fa-folder-open"></i> Yönetim Paneli</a></li>
			                  	<li role="separator" class="divider"></li>
			                  	<li><a href="<?php echo site_url('edit_profile.php'); ?>" title="Profilim"><i class="fa fa-user"></i> Profilim</a></li>
			                  	<li><a href="<?php echo site_url('message_inbox.php'); ?>"><i class="fa fa-envelope"></i> Mesaj Kutusu</a></li>
			                  	<li><a href="#"><i class="fa fa-cog"></i> Ayarlar</a></li>
			                  	<li role="separator" class="divider"></li>
			                  	<li><a href="<?php echo site_url('logout.php'); ?>"><i class="fa fa-power-off"></i> Çıkış Yap</a></li>
			                </ul>
						</li>
					</ul> <!-- /.top-menu -->
				<?php else: ?>
					<ul class="top-menu">
						<li><a href="<?php echo site_url('login.php'); ?>">Giriş Yap</a></li>
						<li><a href="<?php echo site_url('login.php'); ?>">Üye Ol</a></li>
					</ul> <!-- /.top-menu -->
				<?php endif; ?>
			</div> <!-- /.col-md-6 -->
		</div>
	</div> <!-- /.menu -->



	<div class="clearfix"></div>

	<div class="rl-menu">

			<ul>
				<li><a href="<?php echo site_url(); ?>" title="Rulman Listesi Anasayfa" class="active"><i class="fa fa-desktop"></i> Yönetim Paneli</a></li>
				<li><a href="<?php echo site_url('list_my.php'); ?>" title="Listeler"><i class="fa fa-list"></i> Listelerim</a></li>
				<li><a href="<?php echo site_url('pages/contact.php'); ?>" title="İletişim" class="hidden-xs hidden-sm"><i class="fa fa-ambulance"></i> Teknik Destek</a></li>
				<li><a href="<?php echo theme_url(''); ?>" title="Web Sitesi" class="hidden-xs hidden-sm"><i class="fa fa-sitemap"></i> Web Sitesi</a></li>
			</ul>

	</div> <!-- /.rl-menu -->
</div> <!--./container bg -->
<?php endif; ?>
</header>
<div class="container bg container-content">
