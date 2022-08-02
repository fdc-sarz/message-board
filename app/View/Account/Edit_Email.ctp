<?php
$this->assign('title', 'Account > Edit Email');
?>
<div class="edit-email-page">
  <h2>Edit Email</h2>
  <?php
    echo $this->element('FormError');
    
    echo $this->Form->create('User');
    echo $this->Form->input('email', ['type' => 'text', 'label' => __('label.email'), 'class' => 'form-control', 'required' => false, 'error' => false]);
    echo $this->Form->end(['label' => 'Edit Email', 'class' => 'btn btn-success mt-3']);
  ?>
</div>