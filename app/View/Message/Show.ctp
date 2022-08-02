<?php
$this->Html->script('controllers/message-thread', ['inline' => false, 'block' => 'script']);
$this->assign('title', 'Message > Message Thread');
?>
<script type="text/javascript">
  window.message_thread = {
    mid: <?php echo $message_data['Message']['id']; ?>
  }
</script>
<div ng-controller="MessageThreadController" class="message-thread-page">
  <div class="container mb-2">
    <p class="h3">FROM: <?php echo $message_data['Sender']['name']; ?>(<?php echo $message_data['Sender']['email']; ?>)</p>
    <p class="h3">TO: <?php echo $message_data['Recipient']['name']; ?>(<?php echo $message_data['Recipient']['email']; ?>)</p>
  </div>
  <div class="container mb-2">
    <textarea class="form-control" ng-model="reply_message" style="width:400px; height: 200px; resize: none;"></textarea>
    <button ng-disabled="reply_message.trim().length == 0" ng-click="onAddReply()" class="btn btn-primary btn-sm mt-2">Reply Message</button>
  </div>
  <div class="container">
    <div class="message-lists-container">
      <div ng-repeat="message in messages" class="card flex-row flex-wrap mb-2">
        <div ng-if="loggedId == message.Sender.id" class="card-header border-0">
          <img src="<?php echo Router::url(['controller' => 'document', 'action' => 'renderProfilePicture']); ?>/{{ message.Sender.id }}" class="rounded" style="width:200px; height: 200px;" />
        </div>
        <div class="card-block px-2">
          <p class="card-text">{{ message.MessageThread.message }}</p>
        </div>
        <div ng-if="loggedId != message.Sender.id" class="card-header border-0">
          <img src="<?php echo Router::url(['controller' => 'document', 'action' => 'renderProfilePicture']); ?>/{{ message.Sender.id }}" class="rounded" style="width:200px; height: 200px;" />
        </div>
        <div class="w-100"></div>
        <div class="card-footer w-100 text-muted text-end">
          {{ formatDate(message.MessageThread.created) | date: 'yyyy/MM/dd hh:mma' }}
        </div>
      </div>
      <div ng-if="isFetching" class="message-lists-fetching">Fetching message data...</div>
      <div ng-if="!isFetching && hasMoreData" class="message-lists-showmore"><a ng-click="loadMoreData()">Show More</a></div>
    </div>
  </div>
</div>