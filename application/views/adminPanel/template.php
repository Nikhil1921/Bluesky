<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= APP_NAME.' | '.ucwords($title) ?></title>
    <?= link_tag('assets/images/favicon.png','icon','image/x-icon') ?>
    <?= link_tag('assets/plugins/fontawesome-free/css/all.min.css','stylesheet','text/css') ?>
    
    <?php if (isset($dataTables)): ?>
    <?= link_tag('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css','stylesheet','text/css') ?>
    <?= link_tag('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css','stylesheet','text/css') ?>
    <?php endif ?>
    
    <?php if (isset($select)): ?>
    <?= link_tag('assets/plugins/select2/css/select2.min.css','stylesheet','text/css') ?>
    <?= link_tag('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css','stylesheet','text/css') ?>
    <?php endif ?>
    <?php if (isset($checkbox)): ?>
    <?= link_tag('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css','stylesheet','text/css') ?>
    <?php endif ?>
    <?= link_tag('assets/plugins/daterangepicker/daterangepicker.css','stylesheet','text/css') ?>
    <?= link_tag('assets/dist/css/adminlte.min.css','stylesheet','text/css') ?>
    <?= link_tag('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css','stylesheet','text/css') ?>
    <?= link_tag('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
    /* width */
    ::-webkit-scrollbar {
    width: 0;
    }
    /* Track */
    ::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px grey;
    border-radius: 15px;
    }
    
    /* Handle */
    ::-webkit-scrollbar-thumb {
    background: #6c757d;
    border-radius: 15px;
    }
    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
    background: #343a40;
    }
    </style>
  </head>
  <body class="hold-transition sidebar-mini <?= get_cookie('sidebar') ?>">
    <div class="wrapper">
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <?= anchor('#', '<i class="far fa-user"></i>', 'class="nav-link" data-toggle="dropdown" aria-expanded="false"') ?>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
              <span class="dropdown-header"><?= anchor(admin('profile'), 'Account Details', 'class="dropdown-item"') ?></span>
              <div class="dropdown-divider"></div>
              <?= anchor(admin('profile'), '<i class="fa fa-user mr-2"></i>'.ucwords($this->session->name), 'class="dropdown-item"') ?>
              <div class="dropdown-divider"></div>
              <?= anchor(admin('profile'), '<i class="fa fa-envelope mr-2"></i>'.$this->session->email, 'class="dropdown-item"') ?>
              <div class="dropdown-divider"></div>
              <?= anchor(admin('profile'), '<i class="fa fa-phone mr-2"></i>'.$this->session->mobile, 'class="dropdown-item"') ?>
              <div class="dropdown-divider"></div>
              <?= anchor('lead-example.csv', 'Download Sample CSV', 'class="dropdown-item dropdown-footer"') ?>
              <div class="dropdown-divider"></div>
              <?= anchor(admin('logout'), 'Log Out', 'class="dropdown-item dropdown-footer"') ?>
            </div>
          </li>
        </ul>
      </nav>
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <?= anchor(admin(), img(['src' => 'assets/images/favicon.png', 'alt' => '', 'class' => 'brand-image img-circle elevation-3']).strtoupper(APP_NAME), 'class="brand-link"') ?>
        <div class="sidebar">
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <?= img(['src' => 'assets/images/user.jpg', 'alt' => '', 'class' => 'img-circle elevation-2']) ?>
            </div>
            <div class="info">
              <?= anchor(admin(), ucwords($this->session->name), 'class="d-block"') ?>
            </div>
          </div>
          <nav class="mt-2" style="overflow-y: scroll; height: 100vh;">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <?= anchor(admin(), '<i class="nav-icon fas fa-home"></i><p>Dashboard</p>', 'class="nav-link '.(($name == 'dashboard') ? 'active' : '').'"') ?>
              </li>
              <?php if (in_array($this->role, ['Operation', 'Super Admin', 'Reception'])): ?>
              <li class="nav-item">
                <?= anchor(admin('inquiry/today'), '<i class="nav-icon fa fa-user"></i><p>Inquiries (Today)</p>', 'class="nav-link '.(($name == 'today') ? 'active' : '').'"') ?>
              </li>
              <li class="nav-item">
                <?= anchor(admin('meeting'), '<i class="nav-icon fa fa-user"></i><p>Meeting</p>', 'class="nav-link '.(($name == 'meeting') ? 'active' : '').'"') ?>
              </li>
              <li class="nav-item">
                <?= anchor(admin('inquiry'), '<i class="nav-icon fa fa-user"></i><p>Inquiries</p>', 'class="nav-link '.(($name == 'inquiry') ? 'active' : '').'"') ?>
              </li>
              <?php endif ?>
              <?php if (in_array($this->role, ['Operation', 'Super Admin', 'Counselor'])): ?>
              <li class="nav-item">
                <?= anchor(admin('counseling'), '<i class="nav-icon fa fa-user"></i><p>Counseling</p>', 'class="nav-link '.(($name == 'counseling') ? 'active' : '').'"') ?>
              </li>
              <?php endif ?>
              <?php if (in_array($this->role, ['Operation', 'Super Admin', 'Consultant'])): ?>
              <li class="nav-item">
                <?= anchor(admin('consulting'), '<i class="nav-icon fa fa-user"></i><p>Consulting</p>', 'class="nav-link '.(($name == 'consulting') ? 'active' : '').'"') ?>
              </li>
              <?php endif ?>
              <?php if (in_array($this->role, ['Operation', 'Super Admin', 'LMS'])): ?>
              <li class="nav-item">
                <?= anchor(admin('lead'), '<i class="nav-icon fa fa-user"></i><p>New Leads</p>', 'class="nav-link '.(($name == 'lead') ? 'active' : '').'"') ?>
              </li>
              <?php endif ?>
              <?php if (in_array($this->role, ['Operation', 'Super Admin', 'LMS', 'LMS Employee', 'Reception'])): ?>
                <li class="nav-item">
                  <?= anchor(admin('assignedLead'), '<i class="nav-icon fa fa-user"></i><p>Leads</p>', 'class="nav-link '.(($name == 'assignedLead') ? 'active' : '').'"') ?>
                </li>
                <li class="nav-item">
                  <?= anchor(admin('followUp'), '<i class="nav-icon fa fa-user"></i><p>Follow Up(s)</p>', 'class="nav-link '.(($name == 'followUp') ? 'active' : '').'"') ?>
                </li>
              <?php endif ?>
              <?php if (in_array($this->role, ['LMS Employee', 'Reception'])): ?>
              <li class="nav-item">
                <?= anchor(admin('selfReport'), '<i class="nav-icon fas fa-file"></i><p>Assigned</p>', 'class="nav-link '.(($name == 'selfReport') ? 'active' : '').'"') ?>
              </li>
              <?php endif ?>
              <?php if (in_array($this->role, ['Operation', 'Super Admin', 'IELTS Operation', 'IELTS Coaching'])): ?>
              <li class="nav-item has-treeview <?= (in_array($name, ['ielts', 'ieltsBatch', 'students'])) ? 'menu-open' : '' ?>">
                <?= anchor(admin(), '<i class="nav-icon fas fa-book"></i><p>IELTS<i class="right fas fa-angle-left"></i></p>', 'class="nav-link '.((in_array($name, ['ielts', 'ieltsBatch', 'students'])) ? 'active' : '' ).'"') ?>
                <ul class="nav nav-treeview">
                  <?php if (in_array($this->role, ['Operation', 'Super Admin', 'IELTS Operation'])): ?>
                  <li class="nav-item">
                    <?= anchor(admin('ielts'), '<i class="far fa-circle nav-icon"></i><p>IELTS</p>', 'class="nav-link '.(($name == 'ielts') ? 'active' : '').'"') ?>
                  </li>
                  <li class="nav-item">
                    <?= anchor(admin('ieltsBatch'), '<i class="far fa-circle nav-icon"></i><p>IELTS Batch</p>', 'class="nav-link '.(($name == 'ieltsBatch') ? 'active' : '').'"') ?>
                  </li>
                  <?php endif ?>
                  <?php if (in_array($this->role, ['IELTS Coaching'])): ?>
                  <li class="nav-item">
                    <?= anchor(admin('ieltsBatch'), '<i class="far fa-circle nav-icon"></i><p>IELTS Batch</p>', 'class="nav-link '.(($name == 'ieltsBatch') ? 'active' : '').'"') ?>
                  </li>
                  <li class="nav-item">
                    <?= anchor(admin('students'), '<i class="far fa-circle nav-icon"></i><p>Students</p>', 'class="nav-link '.(($name == 'students') ? 'active' : '').'"') ?>
                  </li>
                  <?php endif ?>
                </ul>
              </li>
              <?php endif ?>
              <?php if (in_array($this->role, ['Operation', 'Super Admin'])): ?>
              <li class="nav-item">
                <?= anchor(admin('country'), '<i class="nav-icon fa fa-globe"></i><p>Country Served</p>', 'class="nav-link '.(($name == 'country') ? 'active' : '').'"') ?>
              </li>
              <li class="nav-item">
                <?= anchor(admin('document'), '<i class="nav-icon fa fa-file"></i><p>Documents</p>', 'class="nav-link '.(($name == 'document') ? 'active' : '').'"') ?>
              </li>
              <li class="nav-item has-treeview <?= (in_array($name, ['banner', 'blog', 'video', 'news'])) ? 'menu-open' : '' ?>">
                <?= anchor(admin(), '<i class="nav-icon fas fa-bars"></i><p>App Settings<i class="right fas fa-angle-left"></i></p>', 'class="nav-link '.((in_array($name, ['banner', 'blog', 'video', 'news'])) ? 'active' : '' ).'"') ?>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <?= anchor(admin('banner'), '<i class="far fa-circle nav-icon"></i><p>Banners</p>', 'class="nav-link '.(($name == 'banner') ? 'active' : '').'"') ?>
                  </li>
                  <li class="nav-item">
                    <?= anchor(admin('blog'), '<i class="far fa-circle nav-icon"></i><p>Blogs</p>', 'class="nav-link '.(($name == 'blog') ? 'active' : '').'"') ?>
                  </li>
                  <li class="nav-item">
                    <?= anchor(admin('video'), '<i class="far fa-circle nav-icon"></i><p>Videos</p>', 'class="nav-link '.(($name == 'video') ? 'active' : '').'"') ?>
                  </li>
                  <li class="nav-item">
                    <?= anchor(admin('news'), '<i class="far fa-circle nav-icon"></i><p>News</p>', 'class="nav-link '.(($name == 'news') ? 'active' : '').'"') ?>
                  </li>
                </ul>
              </li>
              <?php endif ?>
              <?php if (in_array($this->role, ['IELTS Operation'])): ?>
              <li class="nav-item">
                <?= anchor(admin('book'), '<i class="nav-icon fas fa-book"></i><p>Books</p>', 'class="nav-link '.(($name == 'book') ? 'active' : '').'"') ?>
              </li>
              <?php endif ?>
              <?php if (in_array($this->role, ['IELTS Coaching'])): ?>
              <li class="nav-item">
                <?= anchor(admin('material'), '<i class="nav-icon fas fa-book"></i><p>Material</p>', 'class="nav-link '.(($name == 'material') ? 'active' : '').'"') ?>
              </li>
              <?php endif ?>
              <?php if (in_array($this->role, ['Operation', 'Super Admin', 'LMS', 'IELTS Operation'])): ?>
              <li class="nav-item">
                <?= anchor(admin('users'), '<i class="nav-icon fas fa-users"></i><p>Users</p>', 'class="nav-link '.(($name == 'users') ? 'active' : '').'"') ?>
              </li>
              <li class="nav-item">
                <?= anchor(admin('report'), '<i class="nav-icon fas fa-file"></i><p>Report</p>', 'class="nav-link '.(($name == 'report') ? 'active' : '').'"') ?>
              </li>
              <?php endif ?>
              <?php if (in_array($this->role, ['Super Admin', 'Accountant'])): ?>
              <li class="nav-item">
                <?= anchor(admin('todayInstallment'), '<i class="nav-icon fas fa-rupee-sign"></i><p>Today\'s Installment</p>', 'class="nav-link '.(($name == 'todayInstallment') ? 'active' : '').'"') ?>
              </li>
              <?php endif ?>
              <?php if (in_array($this->role, ['Super Admin', 'Accountant', 'Consultant'])): ?>
              <li class="nav-item">
                <?= anchor(admin('installment'), '<i class="nav-icon fas fa-rupee-sign"></i><p>Fees Installments</p>', 'class="nav-link '.(($name == 'installment') ? 'active' : '').'"') ?>
              </li>
              <?php endif ?>
              <?php if (in_array($this->role, ['Super Admin', 'Accountant'])): ?>
              <li class="nav-item">
                <?= anchor(admin('fees'), '<i class="nav-icon fas fa-rupee-sign"></i><p>Fees Collection</p>', 'class="nav-link '.(($name == 'fees') ? 'active' : '').'"') ?>
              </li>
              <?php endif ?>
              <?php if (in_array($this->role, ['Super Admin'])): ?>
              <li class="nav-item">
                <?= anchor(admin('home/backup'), '<i class="nav-icon fas fa-database"></i><p>Backup</p>', 'class="nav-link '.(($name == 'home/backup') ? 'active' : '').'"') ?>
              </li>
              <?php endif ?>
              <li class="nav-item">
                <?= anchor(admin('profile'), '<i class="nav-icon fa fa-user"></i><p>Profile</p>', 'class="nav-link '.(($name == 'profile') ? 'active' : '').'"') ?>
              </li>
            </ul>
          </nav>
        </div>
      </aside>
      <div class="content-wrapper">
        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1><?= ucwords($title) ?></h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item">
                    <?= anchor(admin(), 'Home', '') ?>
                  </li>
                  <li class="breadcrumb-item <?= (!empty($operation)) ? '' : 'active' ?> ">
                    <?= (!empty($operation)) ? anchor($url, ucwords($title), '') : ucwords($title) ?>
                  </li>
                  <?php if (!empty($operation)): ?>
                  <li class="breadcrumb-item active">
                    <?= ucwords($operation) ?>
                  </li>
                  <?php endif ?>
                </ol>
              </div>
            </div>
          </div>
        </section>
        <section class="content">
          <?php if ($this->session->success): ?>
          <div class="alert alert-success alert-messages">
            <?= $this->session->success ?>
          </div>
          <?php endif ?>
          <?php if ($this->session->error): ?>
          <div class="alert alert-danger alert-messages">
            <?= $this->session->error ?>
          </div>
          <?php endif ?>
          <?= $contents ?>
        </section>
      </div>
      <footer class="main-footer no-print">
        <div class="float-right d-none d-sm-block">
          <a href="https://densetek.com" target="_blank" title="Densetek Infotech"><b>Densetek Infotech</b></a>
        </div>
        <strong>Copyright &copy; <?= date("Y") ?>.</strong> All rights
        reserved.
      </footer>
    <aside class="control-sidebar control-sidebar-dark"></aside>
  </div>
  <input type="hidden" id="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
  <script src="<?= assets('plugins/jquery/jquery.min.js') ?>"></script>
  <script>
  $('form').attr('autocomplete','off');
  </script>
  <script src="<?= assets('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <?php if (isset($dataTables)): ?>
  <script src="<?= assets('plugins/datatables/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= assets('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
  <script src="<?= assets('plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
  <script src="<?= assets('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
  <script src="<?= assets('plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
  <script type="text/javascript" src="<?= assets('plugins/datatables/dataTables.buttons.min.js') ?>"></script>
  <script type="text/javascript" src="<?= assets('plugins/datatables/pdfmake.min.js') ?>"></script>
  <script type="text/javascript" src="<?= assets('plugins/datatables/dataTables.checkboxes.min.js') ?>"></script>
  <script type="text/javascript" src="<?= assets('plugins/datatables/vfs_fonts.js') ?>"></script>
  <script type="text/javascript" src="<?= assets('plugins/datatables/buttons.html5.min.js') ?>"></script>
  <script type="text/javascript" src="<?= assets('plugins/datatables/buttons.print.min.js') ?>"></script>
  <script type="text/javascript" src="<?= assets('plugins/datatables/buttons.colVis.min.js') ?>"></script>
  <?php endif ?>
  <?php if (isset($select)): ?>
  <script src="<?= assets('plugins/select2/js/select2.full.min.js') ?>"></script>
  <script type="text/javascript"> $('.select2').select2() </script>
  <?php endif ?>
  <script src="<?= assets('plugins/moment/moment.min.js') ?>"></script>
  <?php if (isset($inputmask)): ?>
  <script src="<?= assets('plugins/inputmask/min/jquery.inputmask.bundle.min.js') ?>"></script>
  <script type="text/javascript"> $('[data-mask]').inputmask() </script>
  <?php endif ?>
  <script src="<?= assets('dist/js/adminlte.min.js') ?>"></script>
  <script src="<?= assets('plugins/ckeditor/ckeditor.js') ?>"></script>
  <script src="<?= assets('plugins/daterangepicker/daterangepicker.js') ?>"></script>
  <script src="<?= assets('plugins/img-zoomify/dist/zoomify.js') ?>"></script>
  <script type="text/javascript">
  $('.zoom-img').zoomify({
  // animation duration
  duration: 200,
  // easing effect
  easing: 'linear',
  // zoom scale
  // 1 = fullscreen
  scale: 0.9
  });
  </script>
  <?php $this->load->view(admin('script')) ?>
  <div class="modal fade" id="history">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">History</h4>
          <?= form_button([ 'content' => '<span aria-hidden="true">&times;</span>', 'type'  => 'button','class' => 'close', 'data-dismiss' => "modal", 'aria-label' => "Close"]); ?>
        </div>
        <div class="modal-body" id="show-history">
          
        </div>
        <div class="modal-footer justify-content-between">
          <?= form_button([ 'content' => 'Close', 'type'  => 'button','class' => 'btn btn-default', 'data-dismiss' => "modal"]); ?>
          <?= form_button([ 'content' => 'Close History', 'type'  => 'button','class' => 'btn btn-outline-primary', 'data-dismiss' => "modal"]); ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>