<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<script src="<?= assets('plugins/bootstrap-switch/js/bootstrap-switch.min.js') ?>"></script>
<?php if (isset($daterangepicker)): ?>
<script src="<?= assets('plugins/daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?= assets('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<script>
    $('#dob, #spouse_date, #follow_date, #from_date, #to_date').datetimepicker({
        format: 'L'
    });
    $('#daterange, #daterangereport, #daterangecoach').daterangepicker();
    $('#daterange').val('');
    $('#daterangereport').val('');
    $('#daterangecoach').val('');
    $('#follow_time, #from_time, #to_time').datetimepicker({
      format: 'LT'
    })
<?php if (isset($multipledaterange)): ?>
    <?php foreach ($installments as $k => $v): ?>
        $('#dob_<?= $k+1 ?>').datetimepicker({
            format: 'L'
        });
    <?php endforeach ?>
<?php endif ?>
</script>
<?php endif ?>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
        $("input[data-bootstrap-switch]").each(function(){
          $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

        $(document).on('click', '.sidebar-mini', function(){
            if ($(this).hasClass("sidebar-collapse") == true)
                document.cookie = "sidebar=sidebar-collapse; path=/";
            else
                document.cookie = "sidebar=; path=/";
        });

		setTimeout(function(){ $(".alert-messages").remove(); }, 3000);
		
        <?php if (isset($dataTables)): ?>
      	var table = $('.datatable').DataTable({
            dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50, 100, -1 ],
                [ '10', '25', '50', '100', 'All' ]
            ],
            buttons: [
                'pageLength',
                {
                    extend: 'print',
                    footer: true,
                    exportOptions: {
                        columns: ':visible'
                    },
                },
                {
                    extend: 'csv',
                    footer: true,
                    exportOptions: {
                        columns: ':visible'
                    },
                },
                'colvis'
            ],
            columnDefs: [ {
                targets: -1,
                visible: false
            } ],
            "processing": true,
            "serverSide": true,
            'language': {
                'loadingRecords': '&nbsp;',
                'processing': 'Processing',
                'paginate': {
                    'first': '|',
                    'next': '<i class="fa fa-arrow-circle-right"></i>',
                    'previous': '<i class="fa fa-arrow-circle-left"></i>',
                    'last': '|'
                }
            },
            "order": [],
            "ajax": {
                url: "<?= base_url($url) ?>",
                type: "POST",
                data: function(data) {
                    data.blue_sky_overseas_token = $('#'+"<?= strtolower(str_replace(" ", '_', APP_NAME)).'_token' ?>").val();
                    data.daterange = $('#daterange').val();
                    data.new_lead = $('#new_lead').val();
                    data.archive = $('#archive').val();
                    data.lmsemp = $('#lmsemp').val();
                    data.client_type = $('#client_type').val();
                    data.today = $('#today').val();
                    data.pay_type = $('#pay_type_change').val();
                },
                complete: function(response) {
                    var data = JSON.parse(response.responseText).blue_sky_overseas_token;
                    $('#'+"<?= strtolower(str_replace(" ", '_', APP_NAME)).'_token' ?>").val(data);
                },
            },
            "columnDefs": [{
                "targets": <?= ($name === 'lead') ? 7 : '"target"' ?>,
                "orderable": false,
                <?php if ($name === 'lead'): ?>
                    'checkboxes': { 'selectRow': false }
                <?php endif ?>
            },]
        });

        $('#pay_type_change').on('change', function(){
            table.ajax.reload();
        })

        $('#assign-lms').on('submit', function(){
              let form = this;
              let rows_selected = table.column(7).checkboxes.selected();
              $.each(rows_selected, function(index, leadId){
                $.ajax({
                    url: form.action,
                    type: 'POST',
                    async: false,
                    data: {id: leadId, lms: form.lms.value},
                    success: function(result) {
                        if (rows_selected.length === index + 1)
                        {
                            alert(result);
                            location.reload();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        if (rows_selected.length === index + 1){
                            alert('Something went wrong.');
                            location.reload();
                        }
                    }
                });
              });
           });

        $("#lmsemp, #client_type").change(function(){
            table.ajax.reload();
        });

        $('.change-lead').click(function(){
            $("#archive").val($(this).data('status'));
            table.ajax.reload();
        });

        <?php endif ?>

        <?php if (isset($daterangepicker)): ?>
            $('#daterange').on('apply.daterangepicker', function() {
              table.ajax.reload();
            });

            $('#daterangereport').on('apply.daterangepicker', function() {
                getInqury();
            });

            $('#daterangelead').on('apply.daterangepicker', function() {
                getFollowup();
            });

            $('#daterangecoach').on('apply.daterangepicker', function() {
                getCoaching();
            });

            $('#cleardaterange').on('click', function() {
              $('#daterange').val('');
              table.ajax.reload();
            });

            $('#cleardaterangereport').on('click', function() {
              $('#daterangereport').val('');
              getInqury();
            });

            $('#cleardaterangelead').on('click', function() {
              $('#daterangelead').val('');
              getFollowup();
            });

            $('#cleardaterangecoach').on('click', function() {
              $('#daterangecoach').val('');
              getCoaching();
            });
        <?php endif ?>

        $('input[type=radio][name=ielts]').change(function() {
            if (this.value == 'Yes') {
                $("#show-button").show();
                $(".add-ielts").html('<div class="col-sm-3 remove-ielts"> <select name="laungauge[language][]" class="form-control" id="language"><option value="IELTS">IELTS</option><option value="GMAT">GMAT</option><option value="SAT">SAT</option><option value="GRE">GRE</option><option value="TOEFL">TOEFL</option><option value="PTE">PTE</option> </select></div><div class="col-sm-3 remove-ielts"> <button type="button" class="btn btn-outline-danger col-2 float-right remove-ielts remove-button" onclick="removeIelts(\'remove-ielts\')"><i class="fa fa-minus"></i></button></div><div class="col-sm-12 mt-2"><div class="row"><div class="col-sm-3 remove-ielts"><div class="form-group"> <label for="Listening">Listening</label>                                       <input type="text" name="laungauge[Listening][]" value="" class="form-control" id="Listening" placeholder="Listening" /></div></div><div class="col-sm-3 remove-ielts"><div class="form-group"> <label for="Reading">Reading</label>                                      <input type="text" name="laungauge[Reading][]" value="" class="form-control" id="Reading" placeholder="Reading" /></div></div><div class="col-sm-3 remove-ielts"><div class="form-group"> <label for="Writing">Writing</label>                                        <input type="text" name="laungauge[Writing][]" value="" class="form-control" id="Writing" placeholder="Writing" /></div></div><div class="col-sm-3 remove-ielts"><div class="form-group"> <label for="Speaking">Speaking</label>                                      <input type="text" name="laungauge[Speaking][]" value="" class="form-control" id="Speaking" placeholder="Speaking" /></div></div></div></div>');
            }
            else if (this.value == 'No') {
                $("#show-button").hide();
                $(".add-ielts").html('');
            }
        });

        $('input[type=radio][name=spouse_ielts]').change(function() {
            if (this.value == 'Yes') {
                $("#spouse-show-button").show();
                $(".spouse-add-ielts").html('<div class="col-sm-3 spouse-remove-ielts"> <select name="spouse_laungauge[language][]" class="form-control" id="spouse-language"><option value="IELTS">IELTS</option><option value="GMAT">GMAT</option><option value="SAT">SAT</option><option value="GRE">GRE</option><option value="TOEFL">TOEFL</option><option value="PTE">PTE</option> </select></div><div class="col-sm-3 spouse-remove-ielts"> <button type="button" class="btn btn-outline-danger col-2 float-right spouse-remove-ielts spouse-remove-button" onclick="removeIelts(\'spouse-remove-ielts\')"><i class="fa fa-minus"></i></button></div><div class="col-sm-12 mt-2"><div class="row"><div class="col-sm-3 spouse-remove-ielts"><div class="form-group"> <label for="spouse-Listening">Listening</label>                                       <input type="text" name="spouse_laungauge[Listening][]" value="" class="form-control" id="spouse-Listening" placeholder="Listening" /></div></div><div class="col-sm-3 spouse-remove-ielts"><div class="form-group"> <label for="spouse-Reading">Reading</label>                                      <input type="text" name="spouse_laungauge[Reading][]" value="" class="form-control" id="spouse-Reading" placeholder="Reading" /></div></div><div class="col-sm-3 spouse-remove-ielts"><div class="form-group"> <label for="spouse-Writing">Writing</label>                                        <input type="text" name="spouse_laungauge[Writing][]" value="" class="form-control" id="spouse-Writing" placeholder="Writing" /></div></div><div class="col-sm-3 spouse-remove-ielts"><div class="form-group"> <label for="spouse-Speaking">Speaking</label>                                      <input type="text" name="spouse_laungauge[Speaking][]" value="" class="form-control" id="spouse-Speaking" placeholder="Speaking" /></div></div></div></div>');
            }
            else if (this.value == 'No') {
                $("#spouse-show-button").hide();
                $(".spouse-add-ielts").html('');
            }
        });

        $('#spouse-show-button').click(function(){
            var button =  $('.spouse-remove-button').length + Math.floor((Math.random() * 10) + 10);
            $(".spouse-add-ielts").append('<div class="col-sm-3 spouse-remove-ielts-'+button+'"> <select name="spouse_laungauge[language][]" class="form-control" id="spouse-language-'+button+'"><option value="IELTS">IELTS</option><option value="GMAT">GMAT</option><option value="SAT">SAT</option><option value="GRE">GRE</option><option value="TOEFL">TOEFL</option><option value="PTE">PTE</option> </select></div><div class="col-sm-3 spouse-remove-ielts-'+button+'"> <button type="button" class="btn btn-outline-danger col-2 float-right spouse-remove-ielts-'+button+' remove-button" onclick="removeIelts(\'spouse-remove-ielts-'+button+'\')"><i class="fa fa-minus"></i></button></div><div class="col-sm-12 mt-2"><div class="row"><div class="col-sm-3 spouse-remove-ielts-'+button+'"><div class="form-group"> <label for="spouse-Listening-'+button+'">Listening</label>                                       <input type="text" name="spouse_laungauge[Listening][]" value="" class="form-control" id="spouse-Listening-'+button+'" placeholder="Listening" /></div></div><div class="col-sm-3 spouse-remove-ielts-'+button+'"><div class="form-group"> <label for="spouse-Reading-'+button+'">Reading</label>                                      <input type="text" name="spouse_laungauge[Reading][]" value="" class="form-control" id="spouse-Reading-'+button+'" placeholder="Reading" /></div></div><div class="col-sm-3 spouse-remove-ielts-'+button+'"><div class="form-group"> <label for="spouse-Writing-'+button+'">Writing</label>                                        <input type="text" name="spouse_laungauge[Writing][]" value="" class="form-control" id="spouse-Writing-'+button+'" placeholder="Writing" /></div></div><div class="col-sm-3 spouse-remove-ielts-'+button+'"><div class="form-group"> <label for="spouse-Speaking-'+button+'">Speaking</label>                                      <input type="text" name="spouse_laungauge[Speaking][]" value="" class="form-control" id="spouse-Speaking-'+button+'" placeholder="Speaking" /></div></div></div></div>');
        });

        $('input[type=radio][name=work_experience]').change(function() {
            if (this.value == 'Yes') {
                $("#work-experience").show();
            }
            else if (this.value == 'No') {
                $("#work-experience").hide();
            }
        });

        $('input[type=radio][name=tef_status]').change(function() {
            if (this.value == 'Yes') {
                $("#tef-status").show();
            }
            else if (this.value == 'No') {
                $("#tef-status").hide();
            }
        });

        /*$('input[type=radio][name=canada_status]').change(function() {
            if (this.value == 'Yes') {
                $("#australia-status").show();
            }
            else if (this.value == 'No') {
                $("#australia-status").hide();
            }
        });*/

        $('input[type=radio][name=include_gst]').change(function() {
            if (this.value == 'Yes') {
                $("#fees_collect").trigger('keyup');
            }
            else {
                $("#fees_gst").val('');
                $("#gst_no").val('');
            }
        });

        $("#fees_collect").keyup(function(){
            if ($('input[type=radio][name=include_gst]:checked').val() === 'Yes'){
                let fees = Math.ceil(parseInt(this.value) * 0.18);
                if (isNaN(fees)) { 
                    alert('Enter valid fees.'); 
                    $('#fees_gst').val('');
                    $('#gst_no').prop( "readonly", true );
                    return false; 
                }else{
                    $('#fees_gst').val(fees);
                    $('#gst_no').prop( "readonly", false );
                }
            }else{
                $('#fees_gst').val('');
                $('#gst_no').prop( "readonly", true );
            }
        });

        $('input[type=radio][name=sp_work_experience]').change(function() {
            if (this.value == 'Yes') {
                $("#spouse-work-experience").show();
            }
            else if (this.value == 'No') {
                $("#spouse-work-experience").hide();
            }
        });

        $('input[type=radio][name=status]').change(function() {
            if (this.value == 'Married') {
                $("#spouse-details").show();
            }
            else {
                $("#spouse-details").hide();
            }
        });

        $('#show-button').click(function(){
            var button =  $('.remove-button').length + Math.floor((Math.random() * 10) + 10);
            $(".add-ielts").append('<div class="col-sm-3 remove-ielts-'+button+'"> <select name="laungauge[language][]" class="form-control" id="language-'+button+'"><option value="IELTS">IELTS</option><option value="GMAT">GMAT</option><option value="SAT">SAT</option><option value="GRE">GRE</option><option value="TOEFL">TOEFL</option><option value="PTE">PTE</option> </select></div><div class="col-sm-3 remove-ielts-'+button+'"> <button type="button" class="btn btn-outline-danger col-2 float-right remove-ielts-'+button+' remove-button" onclick="removeIelts(\'remove-ielts-'+button+'\')"><i class="fa fa-minus"></i></button></div><div class="col-sm-12 mt-2"><div class="row"><div class="col-sm-3 remove-ielts-'+button+'"><div class="form-group"> <label for="Listening-'+button+'">Listening</label>                                       <input type="text" name="laungauge[Listening][]" value="" class="form-control" id="Listening-'+button+'" placeholder="Listening" /></div></div><div class="col-sm-3 remove-ielts-'+button+'"><div class="form-group"> <label for="Reading-'+button+'">Reading</label>                                      <input type="text" name="laungauge[Reading][]" value="" class="form-control" id="Reading-'+button+'" placeholder="Reading" /></div></div><div class="col-sm-3 remove-ielts-'+button+'"><div class="form-group"> <label for="Writing-'+button+'">Writing</label>                                        <input type="text" name="laungauge[Writing][]" value="" class="form-control" id="Writing-'+button+'" placeholder="Writing" /></div></div><div class="col-sm-3 remove-ielts-'+button+'"><div class="form-group"> <label for="Speaking-'+button+'">Speaking</label>                                      <input type="text" name="laungauge[Speaking][]" value="" class="form-control" id="Speaking-'+button+'" placeholder="Speaking" /></div></div></div></div>');
        });

        $('#education-button').click(function(){
            var button =  $('.remove-education-button').length + Math.floor((Math.random() * 10) + 10);
            $(".add-education").append('<div class="col-sm-3 remove-education-'+button+'"> <button type="button" class="btn btn-outline-danger col-4 float-left remove-education-'+button+' remove-education-button" onclick="removeIelts(\'remove-education-'+button+'\')"><i class="fa fa-minus"></i></button></div><div class="col-sm-12 mt-2"><div class="row"><div class="col-sm-2 remove-education-'+button+'"><div class="form-group"> <label for="degree-'+button+'">Degree Awarded</label> <input type="text" name="education[degree][]" value="" class="form-control" id="degree-'+button+'" placeholder="Degree Awarded"></div></div><div class="col-sm-2 remove-education-'+button+'"><div class="form-group"> <label for="subject-'+button+'">Core Subject</label> <input type="text" name="education[subject][]" value="" class="form-control" id="subject-'+button+'" placeholder="Core Subject"></div></div><div class="col-sm-2 remove-education-'+button+'"><div class="form-group"> <label for="board-'+button+'">Board</label> <input type="text" name="education[board][]" value="" class="form-control" id="board-'+button+'" placeholder="Board"></div></div><div class="col-sm-2 remove-education-'+button+'"><div class="form-group"> <label for="percentage-'+button+'">CGPA/Percentage</label> <input type="text" name="education[percentage][]" value="" class="form-control" id="percentage-'+button+'" placeholder="CGPA/Percentage"></div></div><div class="col-sm-2 remove-education-'+button+'"><div class="form-group"> <label for="year-'+button+'">Passing Year</label> <input type="text" name="education[year][]" value="" class="form-control" id="year-'+button+'" placeholder="Passing Year"></div></div><div class="col-sm-2 remove-education-'+button+'"><div class="form-group"> <label for="medium-'+button+'">Medium</label> <input type="text" name="education[medium][]" value="" class="form-control" id="medium-'+button+'" placeholder="Medium"></div></div></div></div>');
            });

        $('#spouse-education-button').click(function(){
            var button =  $('.remove-education-button-spose').length + Math.floor((Math.random() * 10) + 10);
            $(".spouse-add-education").append('<div class="col-sm-3 spouce-remove-education-'+button+'"> <button type="button" class="btn btn-outline-danger col-4 float-left spouce-remove-education-'+button+' spouce-remove-education-button-spose" onclick="removeIelts(\'spouce-remove-education-'+button+'\')"><i class="fa fa-minus"></i></button></div><div class="col-sm-12 mt-2"><div class="row"><div class="col-sm-2 spouce-remove-education-'+button+'"><div class="form-group"> <label for="degree-'+button+'">Degree Awarded</label> <input type="text" name="spouse_education[degree][]" value="" class="form-control" id="degree-'+button+'" placeholder="Degree Awarded"></div></div><div class="col-sm-2 spouce-remove-education-'+button+'"><div class="form-group"> <label for="subject-'+button+'">Core Subject</label> <input type="text" name="spouse_education[subject][]" value="" class="form-control" id="subject-'+button+'" placeholder="Core Subject"></div></div><div class="col-sm-2 spouce-remove-education-'+button+'"><div class="form-group"> <label for="board-'+button+'">Board</label> <input type="text" name="spouse_education[board][]" value="" class="form-control" id="board-'+button+'" placeholder="Board"></div></div><div class="col-sm-2 spouce-remove-education-'+button+'"><div class="form-group"> <label for="percentage-'+button+'">CGPA/Percentage</label> <input type="text" name="spouse_education[percentage][]" value="" class="form-control" id="percentage-'+button+'" placeholder="CGPA/Percentage"></div></div><div class="col-sm-2 spouce-remove-education-'+button+'"><div class="form-group"> <label for="year-'+button+'">Passing Year</label> <input type="text" name="spouse_education[year][]" value="" class="form-control" id="year-'+button+'" placeholder="Passing Year"></div></div><div class="col-sm-2 spouce-remove-education-'+button+'"><div class="form-group"> <label for="medium-'+button+'">Medium</label> <input type="text" name="spouse_education[medium][]" value="" class="form-control" id="medium-'+button+'" placeholder="Medium"></div></div></div></div>');
            });
	});
    
    <?php if (in_array($name, ['inquiry', 'lead', 'ielts', 'assignedLead'])): ?>
        function getCountry(visa) {
            var val = $("#inquiry_type").data("value");
            var dependent = $("#inquiry_type").data('dependent');
            
            $.ajax({
                url: "<?= base_url($url) ?>"+"/getCountry",
                type: 'POST',
                data: {visa: visa},
                async: false,
                dataType: "html",
                success: function(result) {
                    $("#"+dependent).html(result);
                    $('#'+dependent).val(val);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#"+dependent).html('<option value="" selected="" disabled="">Select Country</option>');
                    /*console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);*/
                }
            });
        }
        $('#inquiry_type').trigger('change');
    <?php endif ?>
    
    function removeIelts(clas) {
        $('.'+clas).remove();
    }
    
    function remove(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "This will be deleted from your data!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) $('#'+id).submit();
      })
    }
    
    function ielts(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "This will enable IELTS for the user!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) $('#ielts'+id).submit();
      })
    }
    
    function creds(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "This will create credentials for the user!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) $('#creds'+id).submit();
      })
    }
    
    function returnBook(id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "This will return book from the student!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) $('#book'+id).submit();
      })
    }

    function assign(id) {
      $("#lead_id").val(id);
      $(".inquiry_id").val(id);
    }

    function statusCheck(id) {
      $.ajax({
            url: "<?= base_url($url) ?>"+"/statusCheck",
            type: 'POST',
            data: {id: id},
            success: function(result) {
                $("#show-status").html(result);
                $("#add-status").modal();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert('Something not going good. Please try again.');
            }
        });
      $(".inquiry_id").val(id);
    }

    function counselor(id) {
      $("#inquiry_id").val(id);
      $(".inquiry_id").val(id);
    }

    function print_form() {
      $('.logo-img').attr('src', "<?= assets('images/logo.png') ?>");
      window.print();
    }

    function viewFollowUps(id) {
        $.ajax({
            url: "<?= base_url($url) ?>"+"/followUps",
            type: 'POST',
            data: {id: id},
            success: function(result) {
                $("#show-history").html(result);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#show-history").html('<div class="text-center">No History Available.</div>');
                /*console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);*/
            }
        });
    }

    function viewBookHistory(id) {
        $.ajax({
            url: "<?= base_url($url) ?>"+"/viewBookHistory",
            type: 'POST',
            data: {id: id},
            success: function(result) {
                $("#show-history").html(result);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#show-history").html('<div class="text-center">No History Available.</div>');
            }
        });
    }

    function viewHistory(id) {
        $.ajax({
            url: "<?= base_url($url) ?>"+"/viewHistory",
            type: 'POST',
            data: {id: id},
            success: function(result) {
                $("#show-history").html(result);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#show-history").html('<div class="text-center">No History Available.</div>');
                /*console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);*/
            }
        });
    }

    function viewAttendance(id) {
        $.ajax({
            url: "<?= base_url($url) ?>"+"/viewAttendance",
            type: 'POST',
            data: {id: id},
            success: function(result) {
                $("#show-history").html(result);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#show-history").html('<div class="text-center">No History Available.</div>');
            }
        });
    }

    function viewBatch(id) {
        $.ajax({
            url: "<?= base_url($url) ?>"+"/viewBatch",
            type: 'POST',
            data: {id: id},
            success: function(result) {
                $("#show-batch").html(result);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#show-batch").html('<div class="text-center">No Users Available.</div>');
            }
        });
    }

    function makeAttendance(id) {
        $.ajax({
            url: "<?= base_url($url) ?>"+"/makeAttendance",
            type: 'POST',
            data: {id: id},
            success: function(result) {
                $("#view-batch").html(result);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#view-batch").html('<div class="text-center">No Users Available.</div>');
            }
        });
    }

    function viewFees(id) {
        $.ajax({
            url: "<?= base_url($url) ?>"+"/viewFees/"+id,
            type: 'GET',
            success: function(result) {
                $("#show-history").html(result);
                $("#history").modal('toggle');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $("#show-history").html('<div class="text-center">No History Available.</div>');
                $("#history").modal('toggle');
            }
        });
    }

    function saveAttendance(id) {
        $.post({
            url: "<?= base_url($url) ?>"+"/saveAttendance",
            data: $('#'+id).serialize(),
            dataType: "JSON",
            success: function(result) {
                Swal.fire({
                    title: result.title,
                    text: result.text,
                    icon: result.icon
                  }).then(() => {
                    $("#make-attendance").modal('toggle');        
                  });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Swal.fire({
                    title: 'Error',
                    text: 'Some error occurred.',
                    icon: 'error'
                  });
            }
        });
    }

    <?php if (isset($getInqury)): ?>
        function getInqury(){
            $.ajax({
                url: "<?= base_url($url) ?>"+"/getInqury",
                type: 'POST',
                data: {id: <?= $id ?>, page_entry: $('#page_entry').val(), daterangereport: $('#daterangereport').val()},
                success: function(result) {
                    $("#inquiry_history").html(result)
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#inquiry_history").html('<tr><td colspan="11" class="text-center">No History Available</td></tr>');
                }
            });
        }
        getInqury();
    <?php endif ?>

    <?php if (isset($getFollowup)): ?>
        function getFollowup(){
            $.ajax({
                url: "<?= base_url($url) ?>"+"/getFollowup",
                type: 'POST',
                data: {id: <?= $id ?>, page_entry: $('#page_entry_lead').val(), daterangereport: $('#daterangelead').val()},
                success: function(result) {
                    $("#lead_history").html(result)
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#lead_history").html('<tr><td colspan="11" class="text-center">No History Available</td></tr>');
                }
            });
        }
        getFollowup();
    <?php endif ?>

    <?php if (isset($getCoaching)): ?>
        function getCoaching(){
            $.ajax({
                url: "<?= base_url($url) ?>"+"/getCoaching",
                type: 'POST',
                data: {id: <?= $id ?>, page_entry: $('#page_entry').val(), daterangereport: $('#daterangecoach').val()},
                success: function(result) {
                    $("#coaching_history").html(result)
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#coaching_history").html('<tr><td colspan="11" class="text-center">No History Available</td></tr>');
                }
            });
        }
        getCoaching();
    <?php endif ?>
</script>