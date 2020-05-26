<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
<link rel="stylesheet" href="<?php echo assets('global'); ?>css/custom.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
<script src="<?php echo base_url(); ?>assets/helpers/helper.js"></script>
<?php
if ('success' == $type) {
    echo "<script>success_alert('{$msg}')</script>";
}
if ('error' == $type) {
    echo "<script>error_alert('{$msg}')</script>";
}
if ('warning' == $type) {
    echo "<script>warning_alert('{$msg}')</script>";
}
