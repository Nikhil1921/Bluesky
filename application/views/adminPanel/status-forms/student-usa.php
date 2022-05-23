<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-12 mb-2">
    <?= form_button([ 'content' => 'Add Application',
    'type'  => 'button',
    'onclick'  => "addFields('application', 'Application', true)",
    'class' => 'btn btn-outline-primary col-3']) ?>
</div>
<div class="col-12">
    <div class="row" id="application-fields">
    <?php if(isset($data['application'])): foreach($data['application'] as $k => $app): ?>
        <div class="col-6 application_<?= $k ?>">
            <div class="form-group">
                <?= form_label('Application', 'application') ?>
                <?= form_input([
                    'name' => "application[]",
                    'class' => "form-control",
                    'id' => "application",
                    'placeholder' => "Application",
                    'value' => $app
                ]) ?>
            </div>
        </div>
        <div class="col-5 application_<?= $k ?>">
            <div class="form-group">
                <?= form_label('Remarks', 'application-remarks') ?>
                <?= form_input([
                    'name' => "application-remarks[]",
                    'class' => "form-control",
                    'id' => "application-remarks",
                    'placeholder' => "Remarks",
                    'value' => isset($data['application-remarks'][$k]) ? $data['application-remarks'][$k] : ''
                ]) ?>
            </div>
        </div>
        <div class="col-1 mt-4 application_<?= $k ?>">
            <?= form_button([ 'content' => '<i class="fa fa-minus"></i>',
                'type'  => 'button',
                'onclick'  => "removeFields('application_".$k."')",
                'class' => 'btn btn-outline-danger col-12'])
            ?>
        </div>
    <?php endforeach; else: ?>
        <!-- <div class="col-6">
            <div class="form-group">
                <?= form_label('Application', 'application') ?>
                <?= form_input([
                    'name' => "application[]",
                    'class' => "form-control",
                    'id' => "application",
                    'placeholder' => "Application"
                ]) ?>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?= form_label('Remarks', 'application-remarks') ?>
                <?= form_input([
                    'name' => "application-remarks[]",
                    'class' => "form-control",
                    'id' => "application-remarks",
                    'placeholder' => "Remarks"
                ]) ?>
            </div>
        </div> -->
    <?php endif ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Bank Balance', 'bank-balance') ?>
        <?= form_input([
            'name' => "bank-balance",
            'class' => "form-control",
            'id' => "bank-balance",
            'placeholder' => "Bank Balance",
            'value' => isset($data['bank-balance']) ? $data['bank-balance'] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Bank Balance Date', 'bank-balance-date') ?>
        <?= form_input([
            'type' => 'date',
            'name' => "bank-balance-date",
            'class' => "form-control",
            'id' => "bank-balance-date",
            'value' => isset($data['bank-balance-date']) ? $data['bank-balance-date'] : ''
        ]) ?>
    </div>
</div>
<div class="col-8">
    <div class="form-group">
        <?= form_label('Remarks', 'bank-balance-remarks') ?>
        <?= form_input([
            'name' => "bank-balance-remarks",
            'class' => "form-control",
            'id' => "bank-balance-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['bank-balance-remarks']) ? $data['bank-balance-remarks'] : ''
        ]) ?>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <?= form_label('I-20', 'i20') ?>
        <?= form_input([
            'name' => "i20",
            'class' => "form-control",
            'id' => "i20",
            'placeholder' => "I-20",
            'value' => isset($data['i20']) ? $data['i20'] : ''
        ]) ?>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <?= form_label('Remarks', 'i20-remarks') ?>
        <?= form_input([
            'name' => "i20-remarks",
            'class' => "form-control",
            'id' => "i20-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['i20-remarks']) ? $data['i20-remarks'] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('DS-160 Fees', 'ds160-fees') ?>
        <select name="ds160-fees" id="ds160-fees" class="form-control">
            <option value="">Select DS-160 Fees</option>
            <option value="Paid" <?= isset($data['ds160-fees']) && $data['ds160-fees'] === 'Paid' ? 'selected' : '' ?> >Paid</option>
            <option value="Unpaid" <?= isset($data['ds160-fees']) && $data['ds160-fees'] === 'Unpaid' ? 'selected' : '' ?> >Unpaid</option>
        </select>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('DS-160 Fees Date', 'ds160-fees-date') ?>
        <?= form_input([
            'type' => 'date',
            'name' => "ds160-fees-date",
            'class' => "form-control",
            'id' => "ds160-fees-date",
            'value' => isset($data['ds160-fees-date']) ? $data['ds160-fees-date'] : ''
        ]) ?>
    </div>
</div>
<div class="col-8">
    <div class="form-group">
        <?= form_label('Remarks', 'ds160-fees-remarks') ?>
        <?= form_input([
            'name' => "ds160-fees-remarks",
            'class' => "form-control",
            'id' => "ds160-fees-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['ds160-fees-remarks']) ? $data['ds160-fees-remarks'] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('SEVIS Fees', 'sevis-fees') ?>
        <select name="sevis-fees" id="sevis-fees" class="form-control">
            <option value="">Select SEVIS Fees</option>
            <option value="Paid" <?= isset($data['sevis-fees']) && $data['sevis-fees'] === 'Paid' ? 'selected' : '' ?> >Paid</option>
            <option value="Unpaid" <?= isset($data['sevis-fees']) && $data['sevis-fees'] === 'Unpaid' ? 'selected' : '' ?> >Unpaid</option>
        </select>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('SEVIS Fees Date', 'sevis-fees-date') ?>
        <?= form_input([
            'type' => 'date',
            'name' => "sevis-fees-date",
            'class' => "form-control",
            'id' => "sevis-fees-date",
            'value' => isset($data['sevis-fees-date']) ? $data['sevis-fees-date'] : ''
        ]) ?>
    </div>
</div>
<div class="col-8">
    <div class="form-group">
        <?= form_label('Remarks', 'sevis-fees-remarks') ?>
        <?= form_input([
            'name' => "sevis-fees-remarks",
            'class' => "form-control",
            'id' => "sevis-fees-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['sevis-fees-remarks']) ? $data['sevis-fees-remarks'] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Biometric', 'biometric') ?>
        <select name="biometric" id="biometric" class="form-control">
            <option value="">Select Biometric</option>
            <option value="Mumbai" <?= isset($data['biometric']) && $data['biometric'] === 'Mumbai' ? 'selected' : '' ?> >Mumbai</option>
            <option value="Delhi" <?= isset($data['biometric']) && $data['biometric'] === 'Delhi' ? 'selected' : '' ?> >Delhi</option>
            <option value="Kolkata" <?= isset($data['biometric']) && $data['biometric'] === 'Kolkata' ? 'selected' : '' ?> >Kolkata</option>
            <option value="Hyderabad" <?= isset($data['biometric']) && $data['biometric'] === 'Hyderabad' ? 'selected' : '' ?> >Hyderabad</option>
            <option value="Chennai" <?= isset($data['biometric']) && $data['biometric'] === 'Chennai' ? 'selected' : '' ?> >Chennai</option>
        </select>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Biometric Date', 'biometric-date') ?>
        <?= form_input([
            'type' => 'date',
            'name' => "biometric-date",
            'class' => "form-control",
            'id' => "biometric-date",
            'value' => isset($data['biometric-date']) ? $data['biometric-date'] : ''
        ]) ?>
    </div>
</div>
<div class="col-8">
    <div class="form-group">
        <?= form_label('Remarks', 'biometric-remarks') ?>
        <?= form_input([
            'name' => "biometric-remarks",
            'class' => "form-control",
            'id' => "biometric-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['biometric-remarks']) ? $data['biometric-remarks'] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Visa Interview', 'visa-interview') ?>
        <select name="visa-interview" id="visa-interview" class="form-control">
            <option value="">Select Visa Interview</option>
            <option value="Mumbai" <?= isset($data['visa-interview']) && $data['visa-interview'] === 'Mumbai' ? 'selected' : '' ?> >Mumbai</option>
            <option value="Delhi" <?= isset($data['visa-interview']) && $data['visa-interview'] === 'Delhi' ? 'selected' : '' ?> >Delhi</option>
            <option value="Kolkata" <?= isset($data['visa-interview']) && $data['visa-interview'] === 'Kolkata' ? 'selected' : '' ?> >Kolkata</option>
            <option value="Hyderabad" <?= isset($data['visa-interview']) && $data['visa-interview'] === 'Hyderabad' ? 'selected' : '' ?> >Hyderabad</option>
            <option value="Chennai" <?= isset($data['visa-interview']) && $data['visa-interview'] === 'Chennai' ? 'selected' : '' ?> >Chennai</option>
        </select>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Visa Interview Date', 'visa-interview-date') ?>
        <?= form_input([
            'type' => 'date',
            'name' => "visa-interview-date",
            'class' => "form-control",
            'id' => "visa-interview-date",
            'value' => isset($data['visa-interview-date']) ? $data['visa-interview-date'] : ''
        ]) ?>
    </div>
</div>
<div class="col-8">
    <div class="form-group">
        <?= form_label('Remarks', 'visa-interview-remarks') ?>
        <?= form_input([
            'name' => "visa-interview-remarks",
            'class' => "form-control",
            'id' => "visa-interview-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['visa-interview-remarks']) ? $data['visa-interview-remarks'] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Visa Outcome', 'outcome') ?>
        <select name="outcome" id="outcome" class="form-control">
            <option value="">Select Outcome</option>
            <option value="Approved" <?= isset($data['outcome']) && $data['outcome'] === 'Approved' ? 'selected' : '' ?> >Approved</option>
            <option value="Rejection" <?= isset($data['outcome']) && $data['outcome'] === 'Rejection' ? 'selected' : '' ?> >Rejection</option>
        </select>
    </div>
</div>
<div class="col-10">
    <div class="form-group">
        <?= form_label('Remarks', 'outcome-remarks') ?>
        <?= form_input([
            'name' => "outcome-remarks",
            'class' => "form-control",
            'id' => "outcome-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['outcome-remarks']) ? $data['outcome-remarks'] : ''
        ]) ?>
    </div>
</div>