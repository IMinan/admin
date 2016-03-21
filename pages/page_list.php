<?php include('../_inc/header.php'); ?>
  <div class="row">
    <div class="col-md-3">
      <?php include('../_inc/sidebar.php'); ?>
    </div><!--/ .col-md-4 /-->

    <div class="col-md-9">
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url(''); ?>">Anasayfa</a></li>
        <li><a href="<?php echo site_url('index.php'); ?>">Yönetim Paneli</a></li>
        <li class="active">Sayfa Listesi</li>
      </ol>
      <a href="<?php echo site_url('pages/page_add.php'); ?>" class="btn btn-default btn-lg"><i class="fa fa-plus"></i> Yeni Sayfa</a>
      <?php $results = get_list_pages(); if($results): ?>
      <table style="margin-top: 20px; " class="table table-list table-condensed table-hover table-bordered dataTable">
        <thead>
          <tr>
            <th class="col-md-2">İşlemler</th>
            <th class="col-md-3 col-xs-6">Başlık</th>
            <th class="col-md-6 hidden-xs hidden-sm">Makale</th>
          </tr>
        </thead>
        <tbody>
          <?php while($lists = $results->fetch_object()): if($lists->status == 1): ?>
            <tr>
              <td>
                <a href="<?php echo theme_url('pages.php?id=').$lists->id; ?>" class="btn btn-default btn-xs">Önizleme</a>
                <a href="<?php echo site_url('pages/page_edit.php?id=').$lists->id; ?>" data-toggle="tooltip" data-placement="top" title="Düzenle" class="btn btn-default edit_btn btn-xs"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo site_url('pages/page_delete.php?id=').$lists->id; ?>"  data-toggle="tooltip" data-placement="top" title="sil" class="btn btn-default delete_btn btn-xs"><i class="fa fa-trash"></i></a>
              </td>
              <td><?php echo substr($lists->title, 0, 26); ?></td>
              <td class="hidden-xs hidden-sm"><?php echo strip_tags(substr($lists->content, 0, 40).'...'); ?></td>
            </tr>
          <?php endif; ?>
          <?php endwhile; ?>
        </tbody>
      </table>

      <?php else: ?>
        <?php get_alert('Veritabanında Sayfa Bulunamadı'); ?>
      <?php endif; ?>
    </div><!--/ .col-md-9 /-->
  </div><!--/ .row /-->
<?php include('../_inc/footer.php'); ?>
