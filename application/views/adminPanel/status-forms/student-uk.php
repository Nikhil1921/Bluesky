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
<div class="col-12 mb-2">
    <?= form_button([ 'content' => 'Add Offer Letter',
    'type'  => 'button',
    'onclick'  => "addFields('offer-letter', 'Offer Letter', true)",
    'class' => 'btn btn-outline-primary col-3']) ?>
</div>
<div class="col-12">
    <div class="row" id="offer-letter-fields">
    <?php if(isset($data['offer-letter'])): foreach($data['offer-letter'] as $k => $app): ?>
        <div class="col-6 offer-letter_<?= $k ?>">
            <div class="form-group">
                <?= form_label('Offer Letter', 'offer-letter') ?>
                <?= form_input([
                    'name' => "offer-letter[]",
                    'class' => "form-control",
                    'id' => "offer-letter",
                    'placeholder' => "Offer Letter",
                    'value' => $app
                ]) ?>
            </div>
        </div>
        <div class="col-5 offer-letter_<?= $k ?>">
            <div class="form-group">
                <?= form_label('Remarks', 'offer-letter-remarks') ?>
                <?= form_input([
                    'name' => "offer-letter-remarks[]",
                    'class' => "form-control",
                    'id' => "offer-letter-remarks",
                    'placeholder' => "Remarks",
                    'value' => isset($data['offer-letter-remarks'][$k]) ? $data['offer-letter-remarks'][$k] : ''
                ]) ?>
            </div>
        </div>
        <div class="col-1 mt-4 offer-letter_<?= $k ?>">
            <?= form_button([ 'content' => '<i class="fa fa-minus"></i>',
                'type'  => 'button',
                'onclick'  => "removeFields('offer-letter_".$k."')",
                'class' => 'btn btn-outline-danger col-12'])
            ?>
        </div>
    <?php endforeach; else: ?>
        <!-- <div class="col-6">
            <div class="form-group">
                <?= form_label('Offer Letter', 'offer-letter') ?>
                <?= form_input([
                    'name' => "offer-letter[]",
                    'class' => "form-control",
                    'id' => "offer-letter",
                    'placeholder' => "Offer Letter"
                ]) ?>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?= form_label('Remarks', 'offer-letter-remarks') ?>
                <?= form_input([
                    'name' => "offer-letter-remarks[]",
                    'class' => "form-control",
                    'id' => "offer-letter-remarks",
                    'placeholder' => "Remarks"
                ]) ?>
            </div>
        </div> -->
    <?php endif ?>
    </div>
</div>
<div class="col-12 mb-2">
    <?= form_button([ 'content' => 'Add Conditions',
    'type'  => 'button',
    'onclick'  => "addFields('conditions', 'Conditions', true)",
    'class' => 'btn btn-outline-primary col-3']) ?>
</div>
<div class="col-12">
    <div class="row" id="conditions-fields">
    <?php if(isset($data['conditions'])): foreach($data['conditions'] as $k => $app): ?>
        <div class="col-6 conditions_<?= $k ?>">
            <div class="form-group">
                <?= form_label('Conditions', 'conditions') ?>
                <?= form_input([
                    'name' => "conditions[]",
                    'class' => "form-control",
                    'id' => "conditions",
                    'placeholder' => "Conditions",
                    'value' => $app
                ]) ?>
            </div>
        </div>
        <div class="col-5 conditions_<?= $k ?>">
            <div class="form-group">
                <?= form_label('Remarks', 'conditions-remarks') ?>
                <?= form_input([
                    'name' => "conditions-remarks[]",
                    'class' => "form-control",
                    'id' => "conditions-remarks",
                    'placeholder' => "Remarks",
                    'value' => isset($data['conditions-remarks'][$k]) ? $data['conditions-remarks'][$k] : ''
                ]) ?>
            </div>
        </div>
        <div class="col-1 mt-4 conditions_<?= $k ?>">
            <?= form_button([ 'content' => '<i class="fa fa-minus"></i>',
                'type'  => 'button',
                'onclick'  => "removeFields('conditions_".$k."')",
                'class' => 'btn btn-outline-danger col-12'])
            ?>
        </div>
    <?php endforeach; else: ?>
        <!-- <div class="col-6">
            <div class="form-group">
                <?= form_label('Conditions', 'conditions') ?>
                <?= form_input([
                    'name' => "conditions[]",
                    'class' => "form-control",
                    'id' => "conditions",
                    'placeholder' => "Conditions"
                ]) ?>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <?= form_label('Remarks', 'conditions-remarks') ?>
                <?= form_input([
                    'name' => "conditions-remarks[]",
                    'class' => "form-control",
                    'id' => "conditions-remarks",
                    'placeholder' => "Remarks"
                ]) ?>
            </div>
        </div> -->
    <?php endif ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Tution Fees', 'tution-fees') ?>
        <?= form_input([
            'name' => "tution-fees[]",
            'class' => "form-control",
            'id' => "tution-fees",
            'placeholder' => "Tution Fees",
            'value' => isset($data['tution-fees'][0]) ? $data['tution-fees'][0] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Tution Fees Date', 'tution-fees-date') ?>
        <?= form_input([
            'type' => "date",
            'name' => "tution-fees-date[]",
            'class' => "form-control",
            'id' => "tution-fees-date",
            'value' => isset($data['tution-fees-date'][0]) ? $data['tution-fees-date'][0] : ''
        ]) ?>
    </div>
</div>
<div class="col-8">
    <div class="form-group">
        <?= form_label('Remarks', 'tution-fees-remarks') ?>
        <?= form_input([
            'name' => "tution-fees-remarks[]",
            'class' => "form-control",
            'id' => "tution-fees-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['tution-fees-remarks'][0]) ? $data['tution-fees-remarks'][0] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Tution Fees', 'tution-fees') ?>
        <?= form_input([
            'name' => "tution-fees[]",
            'class' => "form-control",
            'id' => "tution-fees",
            'placeholder' => "Tution Fees",
            'value' => isset($data['tution-fees'][1]) ? $data['tution-fees'][1] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Tution Fees Date', 'tution-fees-date') ?>
        <?= form_input([
            'type' => "date",
            'name' => "tution-fees-date[]",
            'class' => "form-control",
            'id' => "tution-fees-date",
            'value' => isset($data['tution-fees-date'][1]) ? $data['tution-fees-date'][1] : ''
        ]) ?>
    </div>
</div>
<div class="col-8">
    <div class="form-group">
        <?= form_label('Remarks', 'tution-fees-remarks') ?>
        <?= form_input([
            'name' => "tution-fees-remarks[]",
            'class' => "form-control",
            'id' => "tution-fees-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['tution-fees-remarks'][1]) ? $data['tution-fees-remarks'][1] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('TB Report', 'tb-report') ?>
        <?= form_input([
            'type' => "date",
            'name' => "tb-report",
            'class' => "form-control",
            'id' => "tb-report",
            'value' => isset($data['tb-report']) ? $data['tb-report'] : ''
        ]) ?>
    </div>
</div>
<div class="col-10">
    <div class="form-group">
        <?= form_label('Remarks', 'tb-report-remarks') ?>
        <?= form_input([
            'name' => "tb-report-remarks",
            'class' => "form-control",
            'id' => "tb-report-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['tb-report-remarks']) ? $data['tb-report-remarks'] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('CAS Report', 'cas-report') ?>
        <?= form_input([
            'type' => "date",
            'name' => "cas-report",
            'class' => "form-control",
            'id' => "cas-report",
            'value' => isset($data['cas-report']) ? $data['cas-report'] : ''
        ]) ?>
    </div>
</div>
<div class="col-10">
    <div class="form-group">
        <?= form_label('Remarks', 'cas-report-remarks') ?>
        <?= form_input([
            'name' => "cas-report-remarks",
            'class' => "form-control",
            'id' => "cas-report-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['cas-report-remarks']) ? $data['cas-report-remarks'] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Visa Submission', 'visa-submission') ?>
        <?= form_input([
            'type' => "date",
            'name' => "visa-submission",
            'class' => "form-control",
            'id' => "visa-submission",
            'value' => isset($data['visa-submission']) ? $data['visa-submission'] : ''
        ]) ?>
    </div>
</div>
<div class="col-10">
    <div class="form-group">
        <?= form_label('Remarks', 'visa-submission-remarks') ?>
        <?= form_input([
            'name' => "visa-submission-remarks",
            'class' => "form-control",
            'id' => "visa-submission-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['visa-submission-remarks']) ? $data['visa-submission-remarks'] : ''
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