<?php include('../_inc/header.php'); ?>
  <script type="text/javascript">bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });</script>
  <div class="row">
    <div class="col-md-3">
      <?php include('../_inc/sidebar.php'); ?>
    </div><!--/ .col-md-3 /-->

    <div class="col-md-9">
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url(''); ?>">Anasayfa</a></li>
        <li><a href="<?php echo site_url('index.php'); ?>">Yönetim Paneli</a></li>
        <li class="active">Yeni Haber</li>
      </ol>

      <?php if(isset($_GET['id'])): $id = $_GET['id']; $news = get_news($id);
          if($_POST){
            $title = $_POST['title'];
            $content = $_POST['content'];
            $foo = new Upload($_FILES['img']);
            if(!$title || !$content){
          		echo get_alert('Tüm Alanları eksiksiz şekilde Doldurunuz');
          	}
            elseif(strlen($content) < 10)
            {
              echo get_alert('İçerik alanı en az 10 karakter olmalı.');
            }
            else{
              $uploaded_img = img_upload($foo);
              $img_name = $uploaded_img->file_dst_name;

              if(edit_news($id, $title, $content, $img_name))
              {
                $news = get_news($id);
                echo get_alert("Haber Başarılı Bir Şekilde Güncellendi", "Haber Güncellendi", "success");

              }
          } }
        ?>
        <form class="" action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <input type="text" name="title" class="form-control" value="<?php echo $news->title; ?>" placeholder="Haber Başlığını Giriniz">
          </div><!--/ .form-group /-->

          <div class="form-group">
            <input type="file" name="img" class="btn btn-default" value="">
          </div><!--/ .form-group /-->

          <div class="form-group">
            <textarea name="content" style="outline: none;" class="form-control" rows="8" cols="40"><?php echo $news->content; ?></textarea>
          </div><!--/ .form-group /-->

          <div class="form-group text-right">
            <input type="submit" name="submit" class="btn btn-success" value="Kaydet">
          </div><!--/ .form-group /-->
        </form>
      <?php else: ?>
        <?php get_alert("Aradığınız Haber Bulunamadı!"); ?>
      <?php endif; ?>
    </div><!--/ .col-md-9 /-->
  </div><!--/ .row /-->
<?php include('../_inc/footer.php'); ?>
