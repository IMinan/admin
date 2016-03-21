<?php if(is_login()): ?>
<nav class="admin-menu nav navbar-inverse">
  <div class="container">
    <div class="row">
      <div class="admin-menu-header col-md-4 col-xs-12">
        <button type="button" class="navbar-toggle admin-navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="http://rulmansoft.com"><span><img src="http://localhost/sablon/medical/admin/img/logo.png" class="img-responsive admin-menu-logo" alt="RulmanSoft.com Logo"></span><span class="logo-text">RulmanSoft</span></a>
      </div><!--/ .admin-menu-header /-->

      <div class="admin-menu-collapse navbar-right collapse navbar-collapse" id="bs-example-navbar-collapse-2">
        <ul class="nav navbar-nav">
          <li><a href="admin"><i class="fa fa-user"></i> Admin Paneli</a></li>
          <li><a href="#"><i class="fa fa-truck"></i> Gelen Siparişler</a></li>
          <li><a href="admin/list_add.php"><i class="fa fa-plus"></i> Yeni Stok Kartı</a></li>
          <li><a href="admin/message_inbox.php"><i class="fa fa-envelope"></i> Mesajlar</a></li>
        </ul>
      </div><!--/ admin-menu-collpase /-->
    </div><!--/ .row /-->
  </div><!--/ .container /-->
</nav>

<style media="screen">
  .admin-menu{
    background: #23282d !important;
  }

  .admin-menu-header a{
    padding: 0 10px;
  }

  .admin-menu-logo{
    width: 40px;
    padding: 5px 0;
    display: inline;
    margin-right: 10px;
  }
  .logo-text{
    color: #fff;
  }
  .admin-menu .navbar-nav>li>a{
    transition: all 200ms ease;
  }
  .admin-menu .navbar-nav>li>a:hover{
    background: #32373c;
    color: #00b9eb;
  }

  .admin-menu .admin-navbar-toggle{
    background: #f8f8f8;
  }

  .admin-menu .admin-navbar-toggle:hover,
  .admin-menu .admin-navbar-toggle:focus{
    background: #f8f8f8;
  }

  .admin-menu .admin-navbar-toggle span{
    background: #333 !important;
  }
</style>
<?php endif; ?>
