<?php include('_inc/header.php'); ?>
  <div class="row">
    <div class="col-md-3">
      <?php include('_inc/sidebar.php'); ?>
    </div><!--/ .col-md-3 /-->

    <div class="col-md-9">
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url(''); ?>">Anasayfa</a></li>
        <li class="active">Sosyal Medya Düzenleme</li>
      </ol>

      <?php
      if(isset($_POST['update_options']))
      {
        add_options("facebook", $_POST['facebook']);
        add_options("twitter", $_POST['twitter']);
        add_options("instagram", $_POST['instagram']);
        add_options("google_plus", $_POST['google_plus']);

        echo get_alert("", "Kod Güncelendi", "success");
      }
      ?>

      <form action="" method="post">
        <div class="form-group">
          <label for="facebook"><h4> <i class="fa fa-facebook-square"></i> Facebook</h4></label>
          <input type="text" class="form-control" id="facebook" name="facebook" value="<?php get_options('facebook', 'val_1', true); ?>">
        </div><!--/ .form-control /-->

        <div class="form-group">
          <label for="twitter"><h4><i class="fa fa-twitter-square"></i> Twitter</h4></label>
          <input type="text" class="form-control" id="twitter" name="twitter" value="<?php get_options('twitter', 'val_1', true); ?>">
        </div><!--/ .form-control /-->

        <div class="form-group">
          <label for="instagram"><h4><i class="fa fa-instagram"></i> İnstagram</h4></label>
          <input type="text" class="form-control" id="instagram" name="instagram" value="<?php get_options('instagram', 'val_1', true); ?>">
        </div><!--/ .form-control /-->

        <div class="form-group">
          <label for="Google_plus"><h4><i class="fa fa-google-plus-square"></i> Google+</h4></label>
          <input type="text" class="form-control" id="google_plus" name="google_plus" value="<?php get_options('google_plus', 'val_1', true); ?>">
        </div><!--/ .form-control /-->

        <div class="form-group">
          <input type="hidden" name="update_options">
          <input class="btn btn-success pull-right" type="submit" value="Kaydet">
        </div><!--/ .form-group /-->
      </form>
    </div><!--/ .col-md-9 /-->
  </div><!--/ .row /-->
<?php include('_inc/footer.php'); ?>
