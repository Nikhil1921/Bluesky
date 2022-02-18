<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <h5 class="card-title m-0"><?= ucwords($operation).' '.ucwords($title) ?></h5>
    </div>
    <?= form_open($url.'/update_details/'.e_id($data['id'])) ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Visa Type') ?>
            <?= form_input([
            'class' => "form-control",
            'readonly' => 'readonly',
            'name' => 'visa_type',
            'value' => $data['visa_type']
            ]) ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Country Of Visit') ?>
            <?php $cou = []; foreach ($country as $co):
            $cou[e_id($co['id'])] = ucwords($co['country_name']);
            endforeach ?>
            <?= form_dropdown('inquiry_country', $cou, e_id($data['c_id']), [
            'class' => 'form-control select2',
            'id' => "inquiry_country"
            ]) ?>
            <?= form_error('inquiry_country') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Name', 'name') ?>
            <?= form_input([
            'class' => "form-control",
            'disabled' => "",
            'value' => $data['name']
            ]) ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Mobile', 'mobile') ?>
            <?= form_input([
            'class' => "form-control",
            'disabled' => "",
            'value' => $data['mobile']
            ]) ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Email', 'email') ?>
            <?= form_input([
            'class' => "form-control",
            'disabled' => "",
            'value' => $data['email']
            ]) ?>
          </div>
        </div>
        <div class="col-md-5">
          <div class="form-group">
            <?= form_label('Date Of Birth', 'from') ?>
            <div class="input-group date" id="dob" data-target-input="nearest">
              <?= form_input([
              'class' => "form-control datetimepicker-input",
              'id' => "from",
              'name' => "dob",
              'data-target' => "#dob",
              'data-toggle' => "datetimepicker",
              'placeholder' => "Select Date Of Birth",
              'onfocusout' => 'getAge(this)',
              'value' => (!empty(set_value('dob'))) ? set_value('dob') : date("m/d/Y", strtotime($data['dob']))
              ]) ?>
              <div class="input-group-append" data-target="#dob" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
              </div>
            </div>
            <?= form_error('dob') ?>
          </div>
        </div>
        <div class="col-md-1">
          <div class="form-group">
            <?= form_label('Age') ?>
            <?= form_input([
              'class' => "form-control",
              'id' => "approx-age",
              'disabled' => 'disabled'
              ]) ?>
            <span id="approx-age"></span>
          </div>
        </div>
        <div class="col-sm-6">
          <?= form_label('Purpose Of Visit') ?>
          <div class="form-group clearfix">
            <div class="icheck-primary d-inline col-12">
              <?= form_radio(['id' => 'family-visit', 'name' => 'purpose'], 'Family Visit', (($data['purpose'] == 'Family Visit') ? true : false), set_radio('purpose', 'Family Visit')) ?>
              <?= form_label('Family Visit', 'family-visit') ?>
            </div>
            <div class="icheck-primary d-inline col-12">
              <?= form_radio(['id' => 'tourist', 'name' => 'purpose'], 'Tourist Visit', (($data['purpose'] == 'Tourist Visit') ? true : false), set_radio('purpose', 'Tourist Visit')) ?>
              <?= form_label('Tourist Visit', 'tourist') ?>
            </div>
            <div class="icheck-primary d-inline col-12">
              <?= form_radio(['id' => 'business-visit', 'name' => 'purpose'], 'Business Visit', (($data['purpose'] == 'Business Visit') ? true : false), set_radio('purpose', 'Business Visit')) ?>
              <?= form_label('Business Visit', 'business-visit') ?>
            </div>
          </div>
          <?= form_error('purpose') ?>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <?php if ($data['documents']):
            foreach (json_decode($data['documents']) as $va) :
            $docs[] = $va->document;
            $imgs[$va->document] = (isset($va->img)) ? $va->img : '';
            endforeach;
            echo form_hidden('imgs', json_encode($imgs));
            endif ?>
            <?= form_label('Documents', 'documents') ?>
            <select class="select2" multiple="multiple" data-placeholder="Select Documents" style="width: 100%;" name="documents[]" id="documents">
              <?php foreach ($documents as $doc): ?>
              <option value="<?= $doc['document'] ?>" <?= (!empty($data['documents']) && in_array($doc['document'], $docs)) ? 'selected' : '' ?>><?= ucwords($doc['document']) ?></option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
        <?php if ($name === 'ielts' && $data['ielts']): ?>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('IELTS with grammer', 'grammer') ?>
            <br>
            <input type="checkbox" name="grammer" id="grammer" data-bootstrap-switch data-off-color="danger" data-on-color="success" <?= ($data['grammer']) ? 'checked' : '' ?> />
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?php $batchs = $this->main->getall('ielts_batch', 'id, batch_name', ['is_deleted' => 0]) ?>
            <?= form_label('batch', 'batch') ?>
            <?php $batch[''] = 'Select batch'; foreach ($batchs as $b) {
            $batch[e_id($b['id'])] = ucwords($b['batch_name']);
            } ?>
            <?= form_dropdown('batch', $batch, (set_value('batch')) ? set_value('batch') : e_id($data['batch']),
            [
            'class' => 'form-control select2',
            'id' => "batch"
            ]) ?>
          </div>
        </div>
        <?php endif ?>
      </div>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-md-6">
          <?= form_button([ 'content' => 'Save',
          'type'  => 'submit',
          'class' => 'btn btn-outline-primary col-md-4']) ?>
        </div>
        <div class="col-md-6">
          <?= anchor($url, 'Cancel', 'class="btn btn-outline-danger col-md-4"'); ?>
        </div>
      </div>
    </div>
    <?= form_close() ?>
  </div>
</div>
<?php $this->load->view(admin('get_age')) ?>