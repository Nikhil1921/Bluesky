<?php defined('BASEPATH') OR exit('No direct script access allowed');
$created_at = date('d/m/Y h:i A', strtotime($data['created_at']));
$dob = date('d/m/Y', strtotime($data['dob']));
?>
<link rel="stylesheet" href="<?= base_url('assets/dist/css/form.css')?>">
<div class="pcoded-content" id="pcoded-content">
	<div class="pcoded-inner-content">
		<div class="main-body">
			<div class="page-wrapper">
				<div class="page-body">
					<form>
						<header style="margin-bottom: 48px;">
							<div class="logo">
								<img src="<?= base_url('form_image/white-logo.png') ?>" class="logo-img">
							</div>
							<div class="hwra">
								<h2>Visitor Visa</h2>
							</div>
							<div class="swra">
								<span class="son">Submited on:</span>
								<span class="sdate"><?= $created_at; ?></span>
							</div>
						</header>
						<input type="text" placeholder="Your Name" value="<?= $data['name']; ?>" disabled>
						<input type="text" placeholder="" value="<?= $dob; ?>" disabled>
						<h3 class="red">Which country are you looking for?</h3>
						<div class="selectdiv">
							<select id="country" disabled="">
								<option value="<?= $data['country_name'] ?>"><?= $data['country_name']; ?></option>
							</select>
						</div>
						<h3 class="red pv">Purpose Of Visit:</h3>
						<div class="rd">
							<input type="radio" <?php if($data['purpose'] == 'Family Visit'){ echo "checked"; } ?> disabled>Family Visit
							<input type="radio" <?php  if($data['purpose'] == 'Business Visit'){ echo "checked"; } ?> disabled> Business Visit
							<input type="radio" <?php  if($data['purpose'] == 'Tourist Visit'){ echo "checked"; } ?> disabled>Tourist Visit
						</div>
						<h3 class="red pv cd">Contact Detail</h3>
						<input type="number" placeholder="Contact No."  value="<?= $data['mobile']; ?>" disabled>
						<input type="Email" placeholder="Email Id" value="<?= $data['email']; ?>" disabled >
						<div class="done no-print" onclick="window.print()">
							<button class="btn-done"><a href=""> Print </a><span class="ra"> >> <span></button>
						</div>
						<footer>
							<img src="<?= base_url('form_image/footer.png') ?>" class="fo-img">
						</footer>
					</span>
				</form>
			</div>
		</div>
	</div>
</div>