<?php defined('BASEPATH') OR exit('No direct script access allowed');
$created_at = date('d/m/Y h:i A', strtotime($data['created_at']));
$date = date('d/m/Y', strtotime($data['dob']));
$languge_data =  json_decode($data['language_data']);
$degree_data =  json_decode($data['education']);
$spouse_languge =  json_decode($data['spouse_language_data']);
$spouse_education =  json_decode($data['spouse_education']);?>
<style>
body {
margin: 0;
padding: 0;
}
header {
background-color: #191246;
color: #fff;
display: flex;
height: 120px;
position: relative;
}
img.logo-img {
height: auto;
width: 100%;
padding: 20px;
margin-top: 15px;
margin-right: 15px;
}
.logo {
width: 15%;
}
.hwra {
text-align: right;
margin-top: 35px;
width: 42%;
}
.swra {
display: flex;;
align-items: center;
position: absolute;
right: 30px;
bottom: 50px;
}
span.sdate {
margin-left: 10px;
font-size: 15px;
color: red;
}
header h2{
font-size: 32px;
font-weight: 900;
}
form {
border-radius: 15px 15px 0 0;
padding: 20px;
margin-top: -11px;
background-color: #fff;
}
input {
width: 98%;
padding: 15px;
margin-bottom: 20px;
border-radius: 5px;
border: 1px solid gray;
outline: none;
}
input:focus {
background-color: #f2f2f2;
}
select:focus {
background-color: #f2f2f2;
}
.selectdiv {
position: relative;
width: 100%;
font-weight: 900;
}
.selectdiv:after {
/*content: '\f078';*/
font: normal normal normal 17px/1 FontAwesome;
color: gray;
right: 27px;
top: -5px;
height: 34px;
padding: 15px 0px 0px 8px;
position: absolute;
pointer-events: none;
}
.selectdiv select {
-webkit-appearance: none;
}
.red {
color: red;
margin: 0;
font-weight: 900;
}
select#country {
width: 100%;
padding: 13px;
border-radius: 5px;
border: 1px solid gray;
outline: none;
background-color: transparent;
}
option {
background-color: #191246;
color: #fff;
padding:20px;
}
.pv {
margin-top: 15px;
}
.rd {
display: flex;
margin-top: 15px;
margin-left: -10px;
font-weight: 600;
}
.rd input {
width: 3%;
position: relative;
}
.cd {
margin-bottom: 20px;
}
.done {
justify-content: center;
display: flex;
}
.btn-done {
padding: 12px 0px;
border-radius: 30px;
background-color: #191246;
border: none;
width: 200px;
outline: none;
}
.rd input:focus{
color:red;
}
.btn-done a {
color: #fff;
text-decoration: none;
font-size: 20px;
font-weight: 200;
font-weight: 200;
margin-left: -30px;
}
span.ra {
color: #191246;
background: #fff;
padding: 4px 6px;
position: absolute;
font-size: 22px;
border-radius: 20px;
margin-left: 45px;
font-weight: 600;
margin-top: -5px;
}
img.fo-img {
width: 100%;
margin-top: -300px;
}
.rd input:after {
position: absolute;
content: '';
border-radius: 15px;
width: 8px;
top: -1px;
left: 12px;
right: 0;
color: red!important;
bottom: 0;
height: 8px;
}
.son {
font-weight: 900;
font-size: 20px;
}
table#maintable {
width: 100%;
margin-bottom: 30px;
}
th {
padding: 10px;
background: #191246;
color: #fff;
}
td{
text-align: center;
background:#f2f2f2;
}
.balog {
width: 1.3%;
}
.lp {
display: flex;
}
.lp h3.red.pv.cd {
width: 20%;
}
.ie {
width: 2%;
margin-top: 20px;
margin-left: 15px;
}
.selectdiv.ies:after {
display: none;
}
.iespa {
font-weight: 600;
}
.pr {
margin-top: 30px;
}
.work {
display: flex;
}
.cw {
width: 82%;
margin-left: 16px;
margin-top: 0px;
}
.wec {
margin-top: 20px;
}
.ieselect {
width: 15%;
margin: 20px 0;
}
span.iespa.au {
width: 17%;
}
.ics {
margin-top: 10px;
}
.be {
margin-top: 10px;
}
.coex {
display: flex;
}
.com {
width: 50%;
font-weight: 900;
}
.expre {
margin-left: 20px;
width: 50%;
font-weight: 900;
}
span.compr {
color: red;
margin-bottom: 5px;
}
table, th, td {
border: 1px solid #000;
border-collapse: collapse;
}
.cwnow {
display: flex;
}
.seci {
margin-left: 20px;
}
/*Media Query*/
@media only screen and (max-width: 1200px) {
.rd input:after {
display: none!important;
}
img.logo-img {
margin-top: 18px;
}
.ieselect {
width: 30%;
}
}
@media only screen and (max-width: 768px) {
img.logo-img {
height: 50px;
width: 200%;
padding: 20px;
margin-top: 12px;
}
input {
width: 88%;
font-size: 16px;
}
.hwra {
font-size: 12px;
}
.red {
font-size: 18px;
}
}
@media only screen and (max-width: 722px) {
.hwra {
text-align: right;
margin-top: 11px;
width: 43%;
}
.swra {
display: flex;
align-items: center;
position: absolute;
right: 16px;
bottom: 52px;
}
}
@media only screen and (max-width: 420px) {
.hwra {
margin-left: 90px;
font-size: 12px;
}
header h2 {
font-size: 25px;
margin-top: 26px;
}
.selectdiv:after {
right: 25%;
}
.hwra {
width: 50%;
}
}
</style>
<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <!-- Main-body start -->
    <div class="main-body">
      <div class="page-wrapper">
        <!-- Page body start -->
        <div class="page-body">
          <form>
            <header style="margin-bottom: 48px;">
              <div class="logo">
                <img src="<?= base_url();?>form_image/white-logo.png" class="logo-img">
              </div>
              <div class="hwra">
                <h2>Permanent Resident</h2>
              </div>
              <div class="swra">
                <span class="son">Submited on:</span>
                <span class="sdate"><?= $created_at;?></span>
              </div>
            </header>
            <input type="text" placeholder="Country" value="<?= $data['country_name']; ?>" disabled>
            <input type="text" placeholder="Your Name" value="<?= $data['name']; ?>" disabled>
            <input type="text" placeholder="Email Id" value="<?= $data['email']; ?>" disabled >
            <input type="text" placeholder="dateofbirth" value="<?= $date; ?>" disabled>
            <input type="text" placeholder="Contact No." value="<?= $data['mobile']; ?>" disabled>
            <h3 class="red pv">Current Status</h3>
            <div class="rd">
              <input type="radio" placeholder="Married" <?php if($data['status'] == 'Married'){ echo "checked"; } ?> disabled>Married
              <input type="radio" placeholder="Unmarried" <?php if($data['status'] == 'Unmarried'){ echo "checked"; } ?> disabled>Unmarried
              <input type="radio" placeholder="Divorced" <?php if($data['status'] == 'Divorced'){ echo "checked"; } ?> disabled>Divorced
            </div>
            <?php if(!empty($degree_data)){ ?>
            <h3 class="red pv cd">Education details:</h3>
            <table id="maintable" >
              <tr>
                <th>Degree awarded</th>
                <th>Core Subject</th>
                <th>Board</th>
                <th>CGPA/Percentage</th>
                <th>Passing Year</th>
                <th>Medium</th>
              </tr>
              <?php foreach ($degree_data->degree as $key => $edu): ?>
              <tr>
                <td><?= $edu ?></td>
                <td><?= $degree_data->subject[$key] ?></td>
                <td><?= $degree_data->board[$key] ?></td>
                <td><?= $degree_data->percentage[$key] ?></td>
                <td><?= $degree_data->year[$key] ?></td>
                <td><?= $degree_data->medium[$key] ?></td>
              </tr>
              <?php endforeach ?>
            </table>
            <?php } ?>
            <h3 class="red pv">Work Experience :</h3>
            <div class="work wec">
              <span class="iespa">Are You Currently working? </span>
              <div class="rd cw">
                <input type="radio" placeholder="Yes" <?php if($data['work_experience'] == 'Yes'){ echo "checked"; } ?> disabled>Yes
                <input type="radio" placeholder="No" <?php if($data['work_experience'] == 'No'){ echo "checked"; } ?> disabled>No
              </div>
            </div>
            <div class="cwnow">
              <input type="text" placeholder="Position held" class="pr" value="<?= $data['work_position_held']; ?>" disabled>
              <input type="text" placeholder="Total Years of Experience" class="pr seci" value="<?= $data['work_total_experience']; ?>" disabled>
            </div>
            <div class="lp">
              <h3 class="red pv cd">Language Proficiency :</h3>
              <div class="selectdiv be" >
                <select id="country" disabled>
                  <option value=""><?= $data['overall_band']; ?></option>
                  
                </select>
              </div>
            </div>
            <div class="lp">
              <span class="iespa ics">Have you given an IELTS/PTE?</span>
              <div class="selectdiv ies" >
                <input type="radio" placeholder="yes" class="ie" <?php if(!empty($languge)){ echo "checked"; } ?> disabled>Yes
                <input type="radio" placeholder="No" class="ie " <?php if(empty($languge)){ echo "checked"; } ?> disabled>No
              </div>
            </div>
            <?php if (!empty($languge_data)): ?>
            <?php foreach ($languge_data->language as $k => $lan): ?>
            <div class="selectdiv ieselect" >
              <select id="country" disabled="" >
                <option value="Country List"><?= $lan;?></option>
              </select>
            </div>
            <table id="maintable" >
              <tr>
                <th>Listening</th>
                <th>Reading</th>
                <th>Writing</th>
                <th>Speaking</th>
              </tr>
              <tr>
                <td>
                  <?= $languge_data->Listening[$k];?>
                </td>
                <td>
                  <?= $languge_data->Reading[$k];?>
                </td>
                <td>
                  <?= $languge_data->Writing[$k];?>
                </td>
                <td>
                  <?= $languge_data->Speaking[$k];?>
                </td>
              </tr>
            </table>
            <?php endforeach ?>
            <?php endif ?>
            <div class="work">
              <span class="iespa au">Have You Given TEF?</span>
              <div class="rd cw">
                <input type="radio" placeholder="Yes" <?php if($data['tef_status'] == 'Yes'){ echo "checked"; } ?> disabled>Yes
                <input type="radio" placeholder="no" <?php if($data['tef_status'] == 'No'){ echo "checked"; } ?> disabled>No
              </div>
            </div>
            <?php if($data['tef_status'] == 'Yes'){ ?>
            <div class="coex">
              <div class="com">
                <span class="compr">Comprehension</span>
                <table id="maintable" >
                  <tr>
                    <th>Oral</th>
                    <th>Written</th>
                  </tr>
                  <tr>
                    <?php if ($data['comprehenstion']): $compr = json_decode($data['comprehenstion']) ?>
                    <td><?= $compr->oral ?></td>
                    <td><?= $compr->written ?></td>
                    <?php else: ?>
                    <td>NA</td>
                    <td>NA</td>
                    <?php endif ?>
                  </tr>
                </table>
              </div>
              <div class="expre">
                <span class="exp">Expression</span>
                <table id="maintable" >
                  <tr>
                    <th>Oral</th>
                    <th>Written</th>
                  </tr>
                  <tr>
                    <?php if ($data['exprestion']): $expr = json_decode($data['exprestion']) ?>
                    <td><?= $expr->oral ?></td>
                    <td><?= $expr->written ?></td>
                    <?php else: ?>
                    <td>NA</td>
                    <td>NA</td>
                    <?php endif ?>
                  </tr>
                </table>
              </div>
            </div>
            <?php } ?>
            <?php if($data['status'] == 'Married'){ ?>
            <h3 class="red pv">SPOUSE DETAILS :</h3>
            <input type="text" placeholder="Spouse Name" value="<?= $data['spouse_name']; ?>" disabled>
            <input type="text" placeholder="Spouse Date" value="<?= $data['spouse_date']; ?>" disabled >
            <?php if(!empty($spouse_education)){ ?>
            <h3 class="red pv cd">Education details:</h3>
            <table id="maintable" >
              <tr>
                <th>Degree awarded</th>
                <th>Core Subject</th>
                <th>Board</th>
                <th>CGPA/Percentage</th>
                <th>Passing Year</th>
                <th>Medium</th>
              </tr>
              <?php foreach ($spouse_education->degree as $ke => $educ): ?>
              <tr>
                <td><?= $educ ?></td>
                <td><?= $spouse_education->subject[$ke] ?></td>
                <td><?= $spouse_education->board[$ke] ?></td>
                <td><?= $spouse_education->percentage[$ke] ?></td>
                <td><?= $spouse_education->year[$ke] ?></td>
                <td><?= $spouse_education->medium[$ke] ?></td>
              </tr>
              <?php endforeach ?>
            </table>
            <?php } ?>
            <h3 class="red pv">Work Experience :</h3>
            <div class="work wec">
              <span class="iespa">Are You Currently working? </span>
              <div class="rd cw">
                <input type="radio" placeholder="Yes" <?php if($data['spouse_status'] == 'Yes'){ echo "checked"; } ?> disabled>Yes
                <input type="radio" placeholder="No" <?php if($data['spouse_status'] == 'No'){ echo "checked"; } ?> disabled>No
              </div>
            </div>
            <div class="cwnow">
              <input type="text" placeholder="Position held" class="pr" value="<?= $data['spouse_work_position_held']; ?>" disabled>
              <input type="text" placeholder="Total Years of Experience" class="pr seci" value="<?= $data['spouse_work_total_experience']; ?>" disabled>
            </div>
            <div class="lp">
              <h3 class="red pv cd">Language Proficiency :</h3>
              <div class="selectdiv be" >
                <select id="country" disabled>
                  <option value=""><?= $data['spouse_overall_band']; ?></option>
                  
                </select>
              </div>
            </div>
            <div class="work wec">
              <span class="iespa">Have you given an IELTS? </span>
              <div class="rd cw">
                <input type="radio" placeholder="Yes" <?php if(!empty($spouse_languge)) { echo "checked"; } ?> disabled>Yes
                <input type="radio" placeholder="No" <?php if(empty($spouse_languge)){ echo "checked"; } ?> disabled>No
              </div>
            </div>
            <?php if (!empty($spouse_languge)): ?>
            <?php foreach ($spouse_languge->language as $ka => $lang): ?>
            <div class="selectdiv ieselect" >
              <select id="country" disabled="" >
                <option value=""><?= $lang;?></option>
              </select>
            </div>
            <table id="maintable" >
              <tr>
                <th>Listening</th>
                <th>Reading</th>
                <th>Writing</th>
                <th>Speaking</th>
              </tr>
              <tr>
                <td>
                  <?= $spouse_languge->Listening[$ka];?>
                </td>
                <td>
                  <?= $spouse_languge->Reading[$ka];?>
                </td>
                <td>
                  <?= $spouse_languge->Writing[$ka];?>
                </td>
                <td>
                  <?= $spouse_languge->Speaking[$ka];?>
                </td>
              </tr>
            </table>
            <?php endforeach ?>
            <?php endif ?>
            <?php } ?>
            <div class="done no-print" onclick="window.print()">
              <button class="btn-done"><a href="">Print</a><span class="ra"> >> <span></button>
            </div>
            <footer>
              <img src="<?= base_url();?>form_image/footer.png" class="fo-img">
            </footer>
          </div>
        </div>
      </div>
    </div>
  </div>