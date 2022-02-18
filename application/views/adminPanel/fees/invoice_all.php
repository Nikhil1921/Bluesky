<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="invoice p-3 mb-3">
          <div class="row">
            <div class="col-12">
              <h4>
              <?= img(['src' => 'assets/images/logo.png', 'height' => 90, 'width' => 250 ]) ?>
              <small class="float-right">Date: <?= date('d M Y') ?></small>
              </h4>
            </div>
          </div>
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                <strong><?= APP_NAME ?></strong><br>
                2nd floor, B.N House,<br> Above IndusInd Bank Near Sukan Mall,<br> Science City Rd, <br>Ahmedabad, Gujarat 380060<br>
                <!-- Phone: (+91) <?= $this->session->mobile ?><br>
                Email: <?= $this->session->email ?> -->
              </address>
            </div>
            <div class="col-sm-4 invoice-col">
              To
              <address>
                <strong><?= ucwords($data['name']) ?></strong><br>
                Phone: <?= $data['mobile'] ?><br>
                Email: <?= $data['email'] ?><br>
                <span id="print-gst"></span>
              </address>
            </div>
          </div>
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Fee Against</th>
                    <th>Date</th>
                    <th>Fees</th>
                    <th>GST</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $total = 0; if ($fees): ?>
                  <?php foreach ($fees as $k => $f): $total += $f['fees']; $total += $f['gst'] ?>
                  <tr>
                    <td><?= $f['fee_type'] ?></td>
                    <td><?= date('d-m-Y', strtotime($f['created_at'])) ?></td>
                    <td>₹ <?= $f['fees'] ?></td>
                    <td><?= $f['gst'] ?></td>
                    <?php if ($f['gst_no'] != 'NA'): ?>
                      <script>
                        document.getElementById('print-gst').innerHTML = "GST No. : <?= $f['gst_no'] ?>"
                      </script>
                    <?php endif ?>
                  </tr>
                  <?php endforeach ?>
                  <?php endif ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
            </div>
            <div class="col-4">
              <p class="lead">Amount Paid</p>
              <div class="table-responsive">
                <table class="table">
                  <tr>
                    <th>Total :</th>
                    <td>₹ <?= $total ?></td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <div class="row no-print">
            <div class="col-12">
              <?= anchor($url, '<i class="fas fa-arrow-circle-left"></i> Go Back', 'class="btn btn-outline-danger col-sm-2 float-right" style="margin-right: 5px;"'); ?>
              <button type="button" onclick="window.print()" class="btn btn-default col-sm-2 float-right" style="margin-right: 5px;">
              <i class="fas fa-print"></i> Print
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>