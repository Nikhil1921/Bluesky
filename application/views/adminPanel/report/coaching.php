<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="callout callout-info no-print row">
          <div class="col-sm-1">
            <?= form_label('Entry', 'page_entry') ?>
            <div class="input-group">
              <?= form_dropdown('page_entry', [ 10 => 10, 25 => 25, 50 => 50, 100 => 100, 'All' => 'All' ], set_value('page_entry'), [
              'class' => 'form-control select2',
              'id' => "page_entry",
              'onchange' => "getCoaching()"
              ]) ?>
            </div>
          </div>
          <div class="col-sm-4">
            <label>Select Date Range</label>
            <div class="input-group">
              <input type="text" class="form-control float-right" id="daterangecoach">
              <div class="input-group-prepend" id="cleardaterangecoach">
                <span class="input-group-text">
                  <i class="fa fa-undo"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="invoice p-3 mb-3">
          <div class="row">
            <div class="col-12">
              <h4>
              <i class="fas fa-globe"></i> <?= APP_NAME ?>
              <small class="float-right">Date: <?= date("d-m-Y") ?></small>
              </h4>
            </div>
          </div>
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              To
              <address>
                <strong><?= ucwords($data['name']) ?></strong><br>
                Phone: (+91) <?= $data['mobile'] ?><br>
                Email: <?= $data['email'] ?>
              </address>
            </div>
          </div>
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped datatable">
                <thead>
                  <tr>
                    <th class="target">Sr. No.</th>
                    <th>Ramarks</th>
                    <th>Created</th>
                  </tr>
                </thead>
                <tbody id="coaching_history">
                </tbody>
              </table>
            </div>
          </div>
          <div class="row no-print">
            <div class="col-12">
              <a href="<?= base_url($url) ?>" class="btn btn-outline-danger float-right ml-4 col-2"> Go Back </a>
              <a onclick="window.print()" class="btn btn-default float-right col-2"><i class="fas fa-print"></i> Print</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>