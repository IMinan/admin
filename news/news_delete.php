<?php include('../_inc/header.php'); ?>
  <div class="row">
    <div class="col-md-3">
      <?php include('../_inc/sidebar.php'); ?>
    </div><!--/ .col-md-3 /-->

    <div class="col-md-9">
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url(''); ?>">Anasayfa</a></li>
        <li><a href="<?php echo site_url('index.php'); ?>">Yönetim Paneli</a></li>
        <li class="active">Haber Silme Sayfası</li>
      </ol>

      <?php $is_box = true; ?>
      <?php if($id = $_GET["id"]): $news = get_news($id); ?>
        <?php if(isset($_GET['delete_true'])){
          delete_news($id);
          echo get_alert($news->title.' Başlıklı Haber Silinmiştir');
          header("Refresh:2;".site_url("news/news_list.php"));
          $is_box = false;
          }
        ?>
        <?php if($is_box == true): ?>
          <h3><i class="fa fa-trash"></i> Haber Silme</h3>
          <p><b class="text-danger"><?php echo $news->title; ?></b> başlıklı Haberi Silmek istiyor musunuz?</p>
          <a href="?id=<?php echo $id.'&delete_true'; ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Evet, İstiyorum</a>
          <a href="<?php echo site_url('news/news_list.php'); ?>" class="btn btn-default">Hayır, iptal et</a>
        <?php endif; ?>
      <?php endif; ?>
    </div><!--/ .col-md-9 /-->
  </div><!--/ .row /-->
<?php include('../_inc/footer.php'); ?>
