<?php
$this->Html->css('select2.min', ['inline' => false, 'block' => 'css']);
$this->Html->script('select2.min', ['inline' => false, 'block' => 'script']);
$this->Html->script('controllers/add-message', ['inline' => false, 'block' => 'script']);
$this->assign('title', 'Message > Add Message');
?>
<div ng-controller="AddMessageController" class="add-message-page">
  Add Message
  <?php echo $this->element('FormError'); ?>
  <?php echo $this->Form->create('', ['ng-submit' => 'onBeforeSubmit($event)']); ?>
  <div class="row">
    <div class="col-12">
      <select id="recipient" name="recipient" class="form-control"></select>
    </div>
    <div class="col-12">
      <textarea name="message" class="form-control mt-2" placeholder="Message"></textarea>
    </div>
  </div>
  <?php echo $this->Form->end(['label' => 'Add Message', 'class' => 'btn btn-success btn-sm mt-2']); ?>
</div>
