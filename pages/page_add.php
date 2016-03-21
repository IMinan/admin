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
        <li class="active">Yeni Sayfa</li>
      </ol>

        <?php
          if($_POST){
            $title = $_POST['title'];
            $content = trim($_POST['content']);
            if(!$title || !$content){
          		echo get_alert('Tüm Alanları eksiksiz şekilde Doldurunuz');
          	}
            elseif(strlen($content) < 10)
            {
              echo get_alert('İçerik alanı en az 10 karakter olmalı.');
            }
            else{
              if(add_pages($title, $content))
              {
                echo get_alert("Sayfa Başarılı Bir Şekilde Yüklendi", "Sayfa Yayınlandı", "success");
                header("Refresh:2;".site_url("pages/page_list.php"));
              }
          } }
        ?>
        <form class="" action="" method="post">
          <div class="form-group">
            <input type="text" name="title" class="form-control" placeholder="Sayfa Başlığını Giriniz">
          </div><!--/ .form-group /-->

          <div class="form-group">
            <textarea name="content" style="height: 500px;" class="form-control" rows="8" cols="40"></textarea>
          </div><!--/ .form-group /-->

          <div class="form-group text-right">
            <input type="submit" name="submit" class="btn btn-success" value="Yayınla">
          </div><!--/ .form-group /-->
        </form>
    </div><!--/ .col-md-9 /-->
  </div><!--/ .row /-->
<?php include('../_inc/footer.php'); ?>
