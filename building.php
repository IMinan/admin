<?php include('_inc/header.php'); ?>
  <script type="text/javascript">bkLib.onDomLoaded(function() { nicEditors.editors.push( new nicEditor().panelInstance(  document.getElementById('information') ) ); });</script>
  <div class="row">
    <div class="col-md-3">
      <?php include('_inc/sidebar.php'); ?>
    </div><!--/ .col-md-3 /-->

    <div class="col-md-9">
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url(''); ?>">Anasayfa</a></li>
        <li class="active">Firma Bilgileri Düzenleme</li>
      </ol>

      <?php
      if(isset($_POST['update_options']))
      {
        add_options("building_info", $_POST['building_info']);
        add_options("phone", $_POST['phone']);
        add_options("mobile_phone", $_POST['mobile_phone']);
        add_options("address", $_POST['address']);
        add_options("email", $_POST['email']);
        add_options("fax", $_POST['fax']);
        add_options("province", $_POST['province']);
        add_options("country", $_POST['country']);
        add_options("information", $_POST['information']);

        echo get_alert("", "Firma Bilgileriniz Güncellendi!", "success");
      }
      ?>

      <form action="" method="post">
        <div class="form-group">
          <label for="building_info"><h4> <i class="fa fa-building"></i> Firma Adı</h4></label>
          <input type="text" class="form-control" id="building_info" name="building_info" value="<?php get_options('building_info', 'val_1', true); ?>">
        </div><!--/ .form-control /-->

        <div class="row">
          <div class="form-group col-md-6 col-xs-12">
            <label for="phone"><h4> <i class="fa fa-phone"></i> Firma Telefon</h4></label>
            <input type="text" class="col-md-6 col-xs-12 form-control" id="phone" name="phone" value="<?php get_options('phone', 'val_1', true); ?>">
          </div><!--/ .form-control /-->

          <div class="form-group col-md-6 col-xs-12">
            <label for="mobile_phone"><h4><i class="fa fa-mobile"></i> Yetkili Kişi Telefon</h4></label>
            <input type="text" class="form-control" id="mobile_phone" name="mobile_phone" value="<?php get_options('mobile_phone', 'val_1', true); ?>">
          </div><!--/ .form-control /-->
        </div><!--/ .row /-->

        <div class="row">
          <div class="form-group col-md-6 col-xs-12">
            <label for="email"><h4> <i class="fa fa-envelope"></i> E-Mail</h4></label>
            <input type="text" class="col-md-6 col-xs-12 form-control" id="email" name="email" value="<?php get_options('email', 'val_1', true); ?>">
          </div><!--/ .form-control /-->

          <div class="form-group col-md-6 col-xs-12">
            <label for="fax"><h4><i class="fa fa-fax"></i> Fax</h4></label>
            <input type="text" class="form-control" id="fax" name="fax" value="<?php get_options('fax', 'val_1', true); ?>">
          </div><!--/ .form-control /-->
        </div><!--/ .row /-->

        <div class="row">
          <div class="form-group col-md-6 col-xs-12">
            <label for="province"><h4> <i class="fa fa-map-marker"></i> İl - İlçe</h4></label>
            <input type="text" class="col-md-6 col-xs-12 form-control" id="province" name="province" value="<?php get_options('province', 'val_1', true); ?>">
          </div><!--/ .form-control /-->

          <div class="form-group col-md-6 col-xs-12">
            <label for="country"><h4><i class="fa fa-globe"></i> Ülke</h4></label>
            <input type="text" class="form-control" id="country" name="country" value="<?php get_options('country', 'val_1', true); ?>">
          </div><!--/ .form-control /-->
        </div><!--/ .row /-->

        <div class="form-group">
          <label for="address"><h4><i class="fa fa-location-arrow"></i> Adres Bilgileri</h4></label>
          <textarea class="form-control" name="address" id="address" rows="4" cols="40"><?php get_options('address', 'val_1', true); ?></textarea>
        </div><!--/ .form-control /-->

        <div class="form-group">
          <label for="information"><h4><i class="fa fa-info"></i> Firma hakkında</h4></label>
          <textarea class="form-control" name="information" id="information" rows="4" cols="40"><?php get_options('information', 'val_1', true); ?></textarea>
        </div><!--/ .form-control /-->

        <div class="form-group">
          <input type="hidden" name="update_options">
          <input class="btn btn-success pull-right" type="submit" value="Kaydet">
        </div><!--/ .form-group /-->
      </form>
    </div><!--/ .col-md-9 /-->
  </div><!--/ .row /-->
<?php include('_inc/footer.php'); ?>
