<?php
$this->Html->script('controllers/login', ['inline' => false, 'block' => 'script']);
$this->assign('title', __('meta.title.login'));
?>
<div ng-controller="LoginController" class="login-page row g-3">
  <?php echo $this->Html->tag('h2', __('label.login')); ?>
  <?php echo $this->element('FormError'); ?>
    <div class="col-12">
      <?php echo $this->Form->create('User'); ?>
    </div>
    <div class="col-12">
      <?php echo $this->Form->input('email', ['label' => __('label.email'), 'class' => 'form-control', 'required' => false]); ?>
    </div>
    <div class="col-12">
      <?php echo $this->Form->input('password', ['label' => __('label.password'), 'class' => 'form-control', 'required' => false]); ?>
    </div>
    <div class="col-12">
      <?php echo $this->Form->end(['label' => __('btn.login'), 'class' => 'btn btn-primary btn-sm']); ?>
    </div>
  <div class="register-link">
    <?php echo __('label.doesnt_have_account'); ?>
    <?php echo $this->Html->link(__('label.register_now'), ['controller' => 'auth', 'action' => 'register']); ?>
  </div>
</div>