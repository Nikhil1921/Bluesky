<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
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
					<?= form_label('How many backlogs you have?', 'back_log') ?>
					<?= form_input([
					'type' => "number",
					'name' => "back_log",
					'class' => "form-control",
					'id' => "back_log",
					'placeholder' => "Enter backlogs",
					'value' => $data['back_log']
					]) ?>
				</div>
				<div class="col-sm-6">
					<?= form_label('Language Proficiency', 'overall_band') ?>
					<?= form_dropdown('overall_band', ['Beginner' => 'Beginner', 'Intermediate' => 'Intermediate', 'Proficient' => 'Proficient'], $data['overall_band'], [
					'class' => 'form-control',
					'id' => "overall_band"
					]) ?>
				</div>
				<div class="col-sm-6 mt-3">
					<?= form_label('Education Details') ?>
					<?= form_button([ 'content' => '<i class="fa fa-plus"></i>',
					'type'  => 'button',
					'id'    => 'education-button',
					'class' => 'btn btn-outline-primary col-2 float-right']) ?>
				</div>
				<div class="col-sm-6 mt-2">
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
				<div class="col-12 mt-4">
					<div class="row add-education">
						<?php if ($data['education']): $education = json_decode($data['education']) ?>
						<?php foreach ($education->degree as $edu => $educ): $remedu = $edu + 1 * rand(10, 99); ?>
						<div class="col-sm-12 mt-2">
							<div class="row">
								<div class="col-sm-2 remove-education">
									<div class="form-group">
										<label for="degree-<?= $remedu ?>">Degree Awarded</label>
										<input type="text" name="education[degree][]" value="<?= $educ ?>" class="form-control" id="degree-<?= $remedu ?>" placeholder="Degree Awarded">
									</div>
								</div>
								<div class="col-sm-2 remove-education">
									<div class="form-group">
										<label for="subject-<?= $remedu ?>">Core Subject</label>
										<input type="text" name="education[subject][]" value="<?= $education->subject[$edu] ?>" class="form-control" id="subject-<?= $remedu ?>" placeholder="Core Subject">
									</div>
								</div>
								<div class="col-sm-2 remove-education">
									<div class="form-group">
										<label for="board-<?= $remedu ?>">Board</label>
										<input type="text" name="education[board][]" value="<?= $education->board[$edu] ?>" class="form-control" id="board-<?= $remedu ?>" placeholder="Board">
									</div>
								</div>
								<div class="col-sm-2 remove-education">
									<div class="form-group">
										<label for="percentage-<?= $remedu ?>">CGPA/Percentage</label>
										<input type="text" name="education[percentage][]" value="<?= $education->percentage[$edu] ?>" class="form-control" id="percentage-<?= $remedu ?>" placeholder="CGPA/Percentage">
									</div>
								</div>
								<div class="col-sm-2 remove-education">
									<div class="form-group">
										<label for="year-<?= $remedu ?>">Passing Year</label>
										<input type="text" name="education[year][]" value="<?= $education->year[$edu] ?>" class="form-control" id="year-<?= $remedu ?>" placeholder="Passing Year">
									</div>
								</div>
								<div class="col-sm-2 remove-education">
									<div class="form-group">
										<label for="medium-<?= $remedu ?>">Medium</label>
										<input type="text" name="education[medium][]" value="<?= $education->medium[$edu] ?>" class="form-control" id="medium-<?= $remedu ?>" placeholder="Medium">
									</div>
								</div>
							</div>
						</div>
						<?php endforeach ?>
						<?php else: ?>
						<div class="col-sm-12 mt-2">
							<div class="row">
								<div class="col-sm-2 remove-education">
									<div class="form-group">
										<label for="degree">Degree Awarded</label>
										<input type="text" name="education[degree][]" value="" class="form-control" id="degree" placeholder="Degree Awarded">
									</div>
								</div>
								<div class="col-sm-2 remove-education">
									<div class="form-group">
										<label for="subject">Core Subject</label>
										<input type="text" name="education[subject][]" value="" class="form-control" id="subject" placeholder="Core Subject">
									</div>
								</div>
								<div class="col-sm-2 remove-education">
									<div class="form-group">
										<label for="board">Board</label>
										<input type="text" name="education[board][]" value="" class="form-control" id="board" placeholder="Board">
									</div>
								</div>
								<div class="col-sm-2 remove-education">
									<div class="form-group">
										<label for="percentage">CGPA/Percentage</label>
										<input type="text" name="education[percentage][]" value="" class="form-control" id="percentage" placeholder="CGPA/Percentage">
									</div>
								</div>
								<div class="col-sm-2 remove-education">
									<div class="form-group">
										<label for="year">Passing Year</label>
										<input type="text" name="education[year][]" value="" class="form-control" id="year" placeholder="Passing Year">
									</div>
								</div>
								<div class="col-sm-2 remove-education">
									<div class="form-group">
										<label for="medium">Medium</label>
										<input type="text" name="education[medium][]" value="" class="form-control" id="medium" placeholder="Medium">
									</div>
								</div>
							</div>
						</div>
						<?php endif ?>
					</div>
				</div>
				<div class="col-sm-6 mt-3">
					<?= form_label('Have you given an IELTS/CELPIP?') ?>
					<div class="form-group clearfix">
						<div class="icheck-primary d-inline col-12">
							<?= form_radio(['id' => 'Yes', 'name' => 'ielts'], 'Yes', ($data['language_data']) ? true : false, set_radio('ielts', 'Yes')) ?>
							<?= form_label('Yes', 'Yes') ?>
						</div>
						<div class="icheck-primary d-inline col-12">
							<?= form_radio(['id' => 'No', 'name' => 'ielts'], 'No', (!$data['language_data']) ? true : false, set_radio('ielts', 'No')) ?>
							<?= form_label('No', 'No') ?>
						</div>
						<?= form_button([ 'content' => '<i class="fa fa-plus"></i>',
						'type'  => 'button',
						'id'    => 'show-button',
						'class' => 'btn btn-outline-primary col-2 float-right',
						'style' => ($data['language_data']) ? '' : 'display: none;']) ?>
					</div>
				</div>
				<div class="col-12 mt-2">
					<div class="row add-ielts">
						<?php if ($data['language_data']): $language = json_decode($data['language_data'])?>
						<?php foreach ($language->language as $lan => $lang): $rem = $lan +1 * rand(10, 99); ?>
						<div class="col-sm-3 remove-ielts-<?= $rem ?>">
							<select name="laungauge[language][]" class="form-control" id="language">
								<option value="IELTS" <?= ($lang == "IELTS") ? 'selected' : '' ?>>IELTS</option>
								<option value="GMAT" <?= ($lang == "GMAT") ? 'selected' : '' ?>>GMAT</option>
								<option value="SAT" <?= ($lang == "SAT") ? 'selected' : '' ?>>SAT</option>
								<option value="GRE" <?= ($lang == "GRE") ? 'selected' : '' ?>>GRE</option>
								<option value="TOEFL" <?= ($lang == "TOEFL") ? 'selected' : '' ?>>TOEFL</option>
								<option value="PTE" <?= ($lang == "PTE") ? 'selected' : '' ?>>PTE</option>
							</select>
						</div>
						<div class="col-sm-3 remove-ielts-<?= $rem ?>">
							<button type="button" class="btn btn-outline-danger col-2 float-right remove-ielts-<?= $rem ?> remove-button" onclick="removeIelts('remove-ielts-<?= $rem ?>')"><i class="fa fa-minus"></i>
							</button>
						</div>
						<div class="col-sm-12 mt-2">
							<div class="row">
								<div class="col-sm-3 remove-ielts-<?= $rem ?>">
									<div class="form-group">
										<label for="Listening-<?= $rem ?>">Listening</label>
										<input type="text" name="laungauge[Listening][]" value="<?= $language->Listening[$lan] ?>" class="form-control" id="Listening-<?= $rem ?>" placeholder="Listening">
									</div>
								</div>
								<div class="col-sm-3 remove-ielts-<?= $rem ?>">
									<div class="form-group">
										<label for="Reading-<?= $rem ?>">Reading</label>
										<input type="text" name="laungauge[Reading][]" value="<?= $language->Reading[$lan] ?>" class="form-control" id="Reading-<?= $rem ?>" placeholder="Reading">
									</div>
								</div>
								<div class="col-sm-3 remove-ielts-<?= $rem ?>">
									<div class="form-group">
										<label for="Writing-<?= $rem ?>">Writing</label>
										<input type="text" name="laungauge[Writing][]" value="<?= $language->Writing[$lan] ?>" class="form-control" id="Writing-<?= $rem ?>" placeholder="Writing">
									</div>
								</div>
								<div class="col-sm-3 remove-ielts-<?= $rem ?>">
									<div class="form-group">
										<label for="Speaking-<?= $rem ?>">Speaking</label>
										<input type="text" name="laungauge[Speaking][]" value="<?= $language->Speaking[$lan] ?>" class="form-control" id="Speaking-<?= $rem ?>" placeholder="Speaking">
									</div>
								</div>
							</div>
						</div>
						<?php endforeach ?>
						<?php endif ?>
					</div>
				</div>
				<?php if ($name === 'ielts' && $data['ielts']): ?>
				<div class="col-md-6">
					<div class="form-group">
						<?= form_label('IELTS with grammer', 'grammer') ?>
						<br>
						<input type="checkbox" name="grammer" id="grammer" data-bootstrap-switch data-off-color="danger" data-on-color="success" <?= (set_value('grammer')) ? 'checked' : '' ?> />
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