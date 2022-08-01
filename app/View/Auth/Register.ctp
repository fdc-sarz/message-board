<?php
  $this->Html->script('controllers/register', ['inline' => false, 'block' => 'script']);
  $this->assign('title', __('meta.title.register'));
?>
<div ng-controller="RegisterController" class="register-page row g-3">
  <?php
    echo $this->Html->tag('h2', __('label.registration'));
    echo $this->element('FormError');
    echo $this->Form->create('User', ['novalidate', 'ng-submit' => 'validateSubmit($event)']);
    echo $this->Form->input('name', ['label' => __('label.name'), 'class' => 'form-control', 'required' => false, 'error' => false]);
    echo $this->Form->input('email', ['type' => 'text', 'label' => __('label.email'), 'class' => 'form-control', 'required' => false, 'error' => false]);
    echo $this->Form->input('password', ['label' => __('label.password'), 'class' => 'form-control', 'value' => '', 'required' => false, 'error' => false]);
    echo $this->Form->input('password_confirmation', ['label' => __('label.password_confirmation'), 'class' => 'form-control', 'type' => 'password', 'value' => '']);
    echo $this->Form->end(['label' => __('btn.save_user'), 'ng-click' => 'validateForm($event)', 'class' => 'mt-3 btn btn-success']);
  ?>
  <div class="login-link">
    <?php echo __('label.already_have_account'); ?>
    <?php echo $this->Html->link(__('label.signin'), ['controller' => 'auth', 'action' => 'login']); ?>
  </div>
</div>