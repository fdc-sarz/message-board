
<?php
$form_errors = $form_errors ?? [];
?>
<div class="form-errors"<?php if(count($form_errors) == 0) { echo " style='display:none;'"; } ?>>
  <?php foreach($form_errors as $key => $error): ?>
  <div class="alert alert-danger" role="alert">
  <?php echo __d('errors', $error[0]); ?>
  </div>
  <?php endforeach; ?>
  <div ng-repeat="error in errors" class="alert alert-danger" role="alert">
  {{ error.message }}
  </div>
</div>