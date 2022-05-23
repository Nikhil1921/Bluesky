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
<div class="col-2">
    <div class="form-group">
        <?= form_label('Finance Submission', 'finance') ?>
        <?= form_input([
            'name' => "finance",
            'class' => "form-control",
            'id' => "finance",
            'placeholder' => "Finance Submission",
            'value' => isset($data['finance']) ? $data['finance'] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Submission Date', 'finance-date') ?>
        <?= form_input([
            'type' => "date",
            'name' => "finance-date",
            'class' => "form-control",
            'id' => "finance-date",
            'value' => isset($data['finance-date']) ? $data['finance-date'] : ''
        ]) ?>
    </div>
</div>
<div class="col-8">
    <div class="form-group">
        <?= form_label('Remarks', 'finance-remarks') ?>
        <?= form_input([
            'name' => "finance-remarks",
            'class' => "form-control",
            'id' => "finance-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['finance-remarks']) ? $data['finance-remarks'] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Finance Approval', 'finance-approval') ?>
        <select name="finance-approval" id="finance-approval" class="form-control">
            <option value="">Select Finance Approval</option>
            <option value="Yes" <?= isset($data['finance-approval']) && $data['finance-approval'] === 'Yes' ? 'selected' : '' ?> >Yes</option>
            <option value="No" <?= isset($data['finance-approval']) && $data['finance-approval'] === 'No' ? 'selected' : '' ?> >No</option>
        </select>
    </div>
</div>
<div class="col-10">
    <div class="form-group">
        <?= form_label('Remarks', 'finance-approval-remarks') ?>
        <?= form_input([
            'name' => "finance-approval-remarks",
            'class' => "form-control",
            'id' => "finance-approval-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['finance-approval-remarks']) ? $data['finance-approval-remarks'] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('GTE Submission', 'gte-submission-date') ?>
        <?= form_input([
            'type' => "date",
            'name' => "gte-submission-date",
            'class' => "form-control",
            'id' => "gte-submission-date",
            'value' => isset($data['gte-submission-date']) ? $data['gte-submission-date'] : ''
        ]) ?>
    </div>
</div>
<div class="col-10">
    <div class="form-group">
        <?= form_label('Remarks', 'gte-submission-remarks') ?>
        <?= form_input([
            'name' => "gte-submission-remarks",
            'class' => "form-control",
            'id' => "gte-submission-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['gte-submission-remarks']) ? $data['gte-submission-remarks'] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('GTE Approval', 'gte-approval') ?>
        <select name="gte-approval" id="gte-approval" class="form-control">
            <option value="">Select GTE Approval</option>
            <option value="Yes" <?= isset($data['gte-approval']) && $data['gte-approval'] === 'Yes' ? 'selected' : '' ?> >Yes</option>
            <option value="No" <?= isset($data['gte-approval']) && $data['gte-approval'] === 'No' ? 'selected' : '' ?> >No</option>
        </select>
    </div>
</div>
<div class="col-10">
    <div class="form-group">
        <?= form_label('Remarks', 'gte-approval-remarks') ?>
        <?= form_input([
            'name' => "gte-approval-remarks",
            'class' => "form-control",
            'id' => "gte-approval-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['gte-approval-remarks']) ? $data['gte-approval-remarks'] : ''
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
        <?= form_label('COE Letter', 'coe-letter') ?>
        <?= form_input([
            'type' => "date",
            'name' => "coe-letter",
            'class' => "form-control",
            'id' => "coe-letter",
            'value' => isset($data['coe-letter']) ? $data['coe-letter'] : ''
        ]) ?>
    </div>
</div>
<div class="col-10">
    <div class="form-group">
        <?= form_label('Remarks', 'coe-letter-remarks') ?>
        <?= form_input([
            'name' => "coe-letter-remarks",
            'class' => "form-control",
            'id' => "coe-letter-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['coe-letter-remarks']) ? $data['coe-letter-remarks'] : ''
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
            <option value="">Select Visa Outcome</option>
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