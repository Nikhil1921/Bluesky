<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-6">
    <div class="form-group">
        <?= form_label('ECA Application', 'eca') ?>
        <select name="eca" id="eca" class="form-control">
            <option value="">Select ECA Application</option>
            <option value="WES" <?= isset($data['eca']) && $data['eca'] === 'WES' ? 'selected' : '' ?> >WES</option>
            <option value="ICES" <?= isset($data['eca']) && $data['eca'] === 'ICES' ? 'selected' : '' ?> >ICES</option>
            <option value="ICAS" <?= isset($data['eca']) && $data['eca'] === 'ICAS' ? 'selected' : '' ?> >ICAS</option>
            <option value="IQAS" <?= isset($data['eca']) && $data['eca'] === 'IQAS' ? 'selected' : '' ?> >IQAS</option>
            <option value="CES" <?= isset($data['eca']) && $data['eca'] === 'CES' ? 'selected' : '' ?> >CES</option>
            <option value="MCC" <?= isset($data['eca']) && $data['eca'] === 'MCC' ? 'selected' : '' ?> >MCC</option>
            <option value="PEBC" <?= isset($data['eca']) && $data['eca'] === 'PEBC' ? 'selected' : '' ?> >PEBC</option>
        </select>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <?= form_label('ECA file number', 'file-no') ?>
        <?= form_input([
            'name' => "file-no",
            'class' => "form-control",
            'id' => "file-no",
            'placeholder' => "Enter file numner / Reference number",
            'value' => isset($data['file-no']) ? $data['file-no'] : ''
        ]) ?>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <?= form_label('ECA Application status', 'eca-status') ?>
        <select name="eca-status" id="eca-status" class="form-control">
            <option value="">Select ECA Application status</option>
            <option value="ON HOLD" <?= isset($data['eca-status']) && $data['eca-status'] === 'ON HOLD' ? 'selected' : '' ?> >ON HOLD</option>
            <option value="IN PROGRESS" <?= isset($data['eca-status']) && $data['eca-status'] === 'IN PROGRESS' ? 'selected' : '' ?> >IN PROGRESS</option>
            <option value="FINAL REVIEW" <?= isset($data['eca-status']) && $data['eca-status'] === 'FINAL REVIEW' ? 'selected' : '' ?> >FINAL REVIEW</option>
            <option value="COMPLETED" <?= isset($data['eca-status']) && $data['eca-status'] === 'COMPLETED' ? 'selected' : '' ?> >COMPLETED</option>
        </select>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <?= form_label('PR EOI Application', 'pr-eoi-app') ?>
        <select name="pr-eoi-app" id="pr-eoi-app" class="form-control">
            <option value="">Select PR EOI Application</option>
            <option value="Express Entry / Federal Skilled Worker Program" <?= isset($data['pr-eoi-app']) && $data['pr-eoi-app'] === 'Express Entry / Federal Skilled Worker Program' ? 'selected' : '' ?> >Express Entry / Federal Skilled Worker Program</option>
            <option value="Provincial Nominee Program (PNP)" <?= isset($data['pr-eoi-app']) && $data['pr-eoi-app'] === 'Provincial Nominee Program (PNP)' ? 'selected' : '' ?> >Provincial Nominee Program (PNP)</option>
            <option value="Family Sponsorship" <?= isset($data['pr-eoi-app']) && $data['pr-eoi-app'] === 'Family Sponsorship' ? 'selected' : '' ?> >Family Sponsorship</option>
            <option value="Self Employed Person" <?= isset($data['pr-eoi-app']) && $data['pr-eoi-app'] === 'Self Employed Person' ? 'selected' : '' ?> >Self Employed Person</option>
            <option value="Canadian Experience Class" <?= isset($data['pr-eoi-app']) && $data['pr-eoi-app'] === 'Canadian Experience Class' ? 'selected' : '' ?> >Canadian Experience Class</option>
            <option value="Federal Skilled Program" <?= isset($data['pr-eoi-app']) && $data['pr-eoi-app'] === 'Federal Skilled Program' ? 'selected' : '' ?> >Federal Skilled Program</option>
        </select>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <?= form_label('Points', 'points') ?>
        <?= form_input([
            'name' => "points",
            'class' => "form-control",
            'id' => "points",
            'placeholder' => "Enter file numner / Reference number",
            'value' => isset($data['points']) ? $data['points'] : ''
        ]) ?>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <?= form_label('EOI Application status', 'eoi-status') ?>
        <select name="eoi-status" id="eoi-status" class="form-control">
            <option value="">Select EOI Application status</option>
            <option value="Submitted" <?= isset($data['eoi-status']) && $data['eoi-status'] === 'Submitted' ? 'selected' : '' ?> >Submitted</option>
            <option value="Profile Ineligible" <?= isset($data['eoi-status']) && $data['eoi-status'] === 'Profile Ineligible' ? 'selected' : '' ?> >Profile Ineligible</option>
            <option value="Profile Expired" <?= isset($data['eoi-status']) && $data['eoi-status'] === 'Profile Expired' ? 'selected' : '' ?> >Profile Expired</option>
            <option value="ITA Invitation to Apply" <?= isset($data['eoi-status']) && $data['eoi-status'] === 'ITA Invitation to Apply' ? 'selected' : '' ?> >ITA Invitation to Apply</option>
        </select>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <?= form_label('Submitted date', 'sub-date') ?>
        <?= form_input([
            'type' => "date",
            'name' => "sub-date",
            'class' => "form-control",
            'id' => "sub-date",
            'value' => isset($data['sub-date']) ? $data['sub-date'] : ''
        ]) ?>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <?= form_label('Expiry date', 'exp-date') ?>
        <?= form_input([
            'type' => "date",
            'name' => "exp-date",
            'class' => "form-control",
            'id' => "exp-date",
            'value' => isset($data['exp-date']) ? $data['exp-date'] : ''
        ]) ?>
    </div>
</div>
<div class="col-12">
    <div class="form-group">
        <?= form_label('Remarks', 'remarks') ?>
        <?= form_input([
            'name' => "remarks",
            'class' => "form-control",
            'id' => "remarks",
            'placeholder' => "Remarks",
            'value' => isset($data['remarks']) ? $data['remarks'] : ''
        ]) ?>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <?= form_label('PR Type', 'pr-type') ?>
        <select name="pr-type" id="pr-type" class="form-control">
            <option value="">Select PR Type</option>
            <option value="PNP" <?= isset($data['pr-type']) && $data['pr-type'] === 'PNP' ? 'selected' : '' ?> >PNP</option>
            <option value="Express Entry" <?= isset($data['pr-type']) && $data['pr-type'] === 'Express Entry' ? 'selected' : '' ?> >Express Entry</option>
        </select>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <?= form_label('PR Status', 'pr-status') ?>
        <select name="pr-status" id="pr-status" class="form-control">
            <option value="">Select PR Status</option>
            <option value="EOI Submitted Under Pool" <?= isset($data['pr-status']) && $data['pr-status'] === 'EOI Submitted Under Pool' ? 'selected' : '' ?> >EOI Submitted Under Pool</option>
            <option value="Waiting For Invitation (ITA)" <?= isset($data['pr-status']) && $data['pr-status'] === 'Waiting For Invitation (ITA)' ? 'selected' : '' ?> >Waiting For Invitation (ITA)</option>
        </select>
    </div>
</div>
<div class="col-12">
    <div class="form-group">
        <?= form_label('Territories') ?>
        <?php $terries = ['Alberta', 'Saskatchewan', 'Nova Scotia', 'Manitoba', 'Ontario', 'Quebec', 'British Columbia', 'New Brunswick', 'Newfoundland and Labrador', 'Nunavut', 'Yukon', 'Northwest Territories', 'Prince Edward Island']; ?>
        <div class="row">
            <?php foreach ($terries as $terri): ?>
                <div class="col-md-3">
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <?= form_checkbox('territories[]', $terri, (isset($data['territories']) && in_array($terri, $data['territories'])) ? true : false, ['id' => $terri]) ?>
                            <?= form_label($terri, $terri) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>
<div class="col-6">
    <div class="form-group">
        <?= form_label('Application Submission Status', 'app-status') ?>
        <?php if(isset($data['pr-eoi-app']) && in_array($data['pr-eoi-app'], ['Provincial Nominee Program (PNP)', 'Family Sponsorship', 'Canadian Experience Class', 'Federal Skilled Program'])): ?>
        <select name="app-status" id="app-status" class="form-control">
            <option value="">Select Application Submission Status</option>
            <?php if(isset($data['pr-eoi-app']) && in_array($data['pr-eoi-app'], ['Provincial Nominee Program (PNP)'])): ?>
            <option value="In Process" <?= isset($data['app-status']) && $data['app-status'] === 'In Process' ? 'selected' : '' ?> >In Process</option>
            <option value="Addition Documents Request" <?= isset($data['app-status']) && $data['app-status'] === 'Addition Documents Request' ? 'selected' : '' ?> >Addition Documents Request</option>
            <option value="Application Returned" <?= isset($data['app-status']) && $data['app-status'] === 'Application Returned' ? 'selected' : '' ?> >Application Returned</option>
            <option value="Application Nominated" <?= isset($data['app-status']) && $data['app-status'] === 'Application Nominated' ? 'selected' : '' ?> >Application Nominated</option>
            <?php elseif(isset($data['pr-eoi-app']) && in_array($data['pr-eoi-app'], ['Family Sponsorship', 'Canadian Experience Class', 'Federal Skilled Program'])): ?>
            <option value="Application Submitted" <?= isset($data['app-status']) && $data['app-status'] === 'Application Submitted' ? 'selected' : '' ?> >Application Submitted</option>
            <option value="Your Action Is Required" <?= isset($data['app-status']) && $data['app-status'] === 'Your Action Is Required' ? 'selected' : '' ?> >Your Action Is Required</option>
            <option value="Passport Request" <?= isset($data['app-status']) && $data['app-status'] === 'Passport Request' ? 'selected' : '' ?> >Passport Request</option>
            <?php endif ?>
        </select>
        <?php else: ?>
            <?= form_input([
                'name' => "app-status",
                'class' => "form-control",
                'id' => "app-status",
                'placeholder' => "Application Submission Status",
                'value' => isset($data['app-status']) ? $data['app-status'] : ''
            ]) ?>
        <?php endif ?>
    </div>
</div>