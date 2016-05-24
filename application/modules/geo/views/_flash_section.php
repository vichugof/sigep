<?php if($message !== NULL): ?>
    <div class="flashdata alert alert-<?php echo $css_class; ?> alert-dismissible fade in"> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong> <?php echo $message ?> </strong>
    </div>
<?php endif; ?>