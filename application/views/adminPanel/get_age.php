<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
  function getAge(val){
    dt1 = new Date();
    dt2 = new Date(val.value);
    let diff =(dt2.getTime() - dt1.getTime()) / 1000;
    diff /= (60 * 60 * 24);
    document.getElementById('approx-age').value = Math.abs(Math.round(diff/365.25));
  }
  getAge(document.getElementById('from'));
</script>