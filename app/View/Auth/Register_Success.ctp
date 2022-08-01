<?php
$this->assign('title', __('meta.title.register_success'));
?>
<div>
  <h1>Thank you for registering!</h1>
</div>
<div>
  <?php echo $this->Html->link(__('label.back_homepage'), Router::url('/'), ['class' => 'btn btn-success btn-lg']); ?>
</div>
