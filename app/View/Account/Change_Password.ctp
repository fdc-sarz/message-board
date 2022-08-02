<?php
$this->assign('title', 'Account > Change Password');
?>
<div class="change-password-page">
  <h2>Change Password</h2>
  <?php
    echo $this->element('FormError');
    
    echo $this->Form->create('User');
    echo $this->Form->input('password', ['label' => __('label.new_password'), 'class' => 'form-control', 'value' => '', 'required' => false, 'error' => false]);
    echo $this->Form->input('password_confirmation', ['label' => __('label.new_password_confirmation'), 'class' => 'form-control', 'type' => 'password', 'value' => '']);
    echo $this->Form->end(['label' => 'Update Password', 'class' => 'btn btn-success mt-3']);
  ?>
</div>