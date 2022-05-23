<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Category', 'category') ?>
        <select name="category" id="category" class="form-control">
            <option value="">Select Category</option>
            <option value="SDS" <?= isset($data['category']) && $data['category'] === 'SDS' ? 'selected' : '' ?> >SDS</option>
            <option value="Non SDS" <?= isset($data['category']) && $data['category'] === 'Non SDS' ? 'selected' : '' ?> >Non SDS</option>
        </select>
    </div>
</div>
<div class="col-10">
    <div class="form-group">
        <?= form_label('Remarks', 'category-remarks') ?>
        <?= form_input([
            'name' => "category-remarks",
            'class' => "form-control",
            'id' => "category-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['category-remarks']) ? $data['category-remarks'] : ''
        ]) ?>
    </div>
</div>
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
        <?= form_label('Tution fees', 'tution-fees') ?>
        <?= form_input([
            'name' => "tution-fees[]",
            'class' => "form-control",
            'id' => "tution-fees",
            'placeholder' => "Tution fees",
            'value' => isset($data['tution-fees'][0]) ? $data['tution-fees'][0] : ''
        ]) ?>
    </div>
</div>
<div class="col-10">
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
        <?= form_label('Tution fees', 'tution-fees') ?>
        <?= form_input([
            'name' => "tution-fees[]",
            'class' => "form-control",
            'id' => "tution-fees",
            'placeholder' => "Tution fees",
            'value' => isset($data['tution-fees'][1]) ? $data['tution-fees'][1] : ''
        ]) ?>
    </div>
</div>
<div class="col-10">
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
<div class="col-6">
    <div class="form-group">
        <?= form_label('GIC', 'gic') ?>
        <select name="gic" id="gic" class="form-control">
            <option value="">Select GIC</option>
            <option value="Scotia" <?= isset($data['gic']) && $data['gic'] === 'Scotia' ? 'selected' : '' ?> >Scotia</option>
            <option value="CIBC" <?= isset($data['gic']) && $data['gic'] === 'CIBC' ? 'selected' : '' ?> >CIBC</option>
            <option value="ICICI" <?= isset($data['gic']) && $data['gic'] === 'ICICI' ? 'selected' : '' ?> >ICICI</option>
            <option value="RBC" <?= isset($data['gic']) && $data['gic'] === 'RBC' ? 'selected' : '' ?> >RBC</option>
        </select>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <?= form_label('Remarks', 'gic-remarks') ?>
        <?= form_input([
            'name' => "gic-remarks",
            'class' => "form-control",
            'id' => "gic-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['gic-remarks']) ? $data['gic-remarks'] : ''
        ]) ?>
    </div>
</div>
<div class="col-4">
    <div class="form-group">
        <?= form_label('Medical', 'medical') ?>
        <?= form_input([
            'name' => "medical",
            'class' => "form-control",
            'id' => "medical",
            'placeholder' => "Medical",
            'value' => isset($data['medical']) ? $data['medical'] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Medical Date', 'medical-date') ?>
        <?= form_input([
            'type' => 'date',
            'name' => "medical-date",
            'class' => "form-control",
            'id' => "medical-date",
            'value' => isset($data['medical-date']) ? $data['medical-date'] : ''
        ]) ?>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <?= form_label('Remarks', 'medical-remarks') ?>
        <?= form_input([
            'name' => "medical-remarks",
            'class' => "form-control",
            'id' => "medical-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['medical-remarks']) ? $data['medical-remarks'] : ''
        ]) ?>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <?= form_label('Visa Submission', 'visa-submission-date') ?>
        <?= form_input([
            'type' => 'date',
            'name' => "visa-submission-date",
            'class' => "form-control",
            'id' => "visa-submission-date",
            'value' => isset($data['visa-submission-date']) ? $data['visa-submission-date'] : ''
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
        <?= form_label('Biometrics', 'biometrics-date') ?>
        <?= form_input([
            'type' => 'date',
            'name' => "biometrics-date",
            'class' => "form-control",
            'id' => "biometrics-date",
            'value' => isset($data['biometrics-date']) ? $data['biometrics-date'] : ''
        ]) ?>
    </div>
</div>
<div class="col-10">
    <div class="form-group">
        <?= form_label('Remarks', 'biometrics-remarks') ?>
        <?= form_input([
            'name' => "biometrics-remarks",
            'class' => "form-control",
            'id' => "biometrics-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['biometrics-remarks']) ? $data['biometrics-remarks'] : ''
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
<div class="col-2">
    <div class="form-group">
        <?= form_label('PPR Submission', 'ppr-date') ?>
        <?= form_input([
            'type' => 'date',
            'name' => "ppr-date",
            'class' => "form-control",
            'id' => "ppr-date",
            'value' => isset($data['ppr-date']) ? $data['ppr-date'] : ''
        ]) ?>
    </div>
</div>
<div class="col-10">
    <div class="form-group">
        <?= form_label('Remarks', 'ppr-remarks') ?>
        <?= form_input([
            'name' => "ppr-remarks",
            'class' => "form-control",
            'id' => "ppr-remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['ppr-remarks']) ? $data['ppr-remarks'] : ''
        ]) ?>
    </div>
</div>