<?php include('_inc/header.php'); ?>
  <div class="row">
    <div class="col-md-3">
      <?php include('_inc/sidebar.php'); ?>
    </div><!--/ .col-md-3 /-->

    <div class="col-md-9">
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url(''); ?>">Anasayfa</a></li>
        <li class="active">Google Analytics Kodu Ekleme</li>
      </ol>

      <?php
      if(isset($_POST['update_options']))
      {
        add_options("google_analytics", $_POST['google_analytics']);
        add_options("google_remarketing", $_POST['google_remarketing']);
        add_options("google_map", $_POST['google_map']);
        add_options("facebook_pixel", $_POST['facebook_pixel']);
        add_options("facebook_remarketing", $_POST['facebook_remarketing']);
        add_options("yandex_analytics", $_POST['yandex_analytics']);

        echo get_alert("", "Kodlar Güncelendi", "success");
      }
      ?>

      <form action="" method="post">
        <div class="form-group">
          <label for="google_analytics"><h4>Google Analytics</h4></label>
          <textarea class="form-control" name="google_analytics" id="google_analytics" rows="4" cols="40"><?php get_options("google_analytics", 'val_1', true); ?></textarea>
        </div><!--/ .form-group /-->

        <div class="form-group">
          <label for="google_remarketing"><h4>Google Remarketing</h4></label>
          <textarea class="form-control" name="google_remarketing" id="google_remarketing" rows="4" cols="40"><?php get_options("google_remarketing", 'val_1', true); ?></textarea>
        </div><!--/ .form-group /-->

        <div class="form-group">
          <label for="google_map"><h4>Google Haritalar</h4></label>
          <textarea class="form-control" name="google_map" id="google_map" rows="4" cols="40"><?php get_options("google_map", 'val_1', true); ?></textarea>
        </div><!--/ .form-group /-->

        <div class="form-group">
          <label for="facebook_pixel"><h4>Facebook Pixel</h4></label>
          <textarea class="form-control" name="facebook_pixel" id="google_remarketing" rows="4" cols="40"><?php get_options("facebook_pixel", 'val_1', true); ?></textarea>
        </div><!--/ .form-group /-->

        <div class="form-group">
          <label for="facebook_remarketing"><h4>Facebook Remarketing</h4></label>
          <textarea class="form-control" name="facebook_remarketing" id="google_remarketing" rows="4" cols="40"><?php get_options("facebook_remarketing", 'val_1', true); ?></textarea>
        </div><!--/ .form-group /-->

        <div class="form-group">
          <label for="yandex_analytics"><h4>Yandex</h4></label>
          <textarea class="form-control" name="yandex_analytics" id="yandex_analytics" rows="4" cols="40"><?php get_options("yandex_analytics", 'val_1', true); ?></textarea>
        </div><!--/ .form-group /-->

        <div class="form-group">
          <input type="hidden" name="update_options">
          <input class="btn btn-success pull-right" type="submit" value="Kaydet">
        </div><!--/ .form-group /-->
      </form>
    </div><!--/ .col-md-9 /-->
  </div><!--/ .row /-->
<?php include('_inc/footer.php'); ?>
