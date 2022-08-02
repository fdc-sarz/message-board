app = app || angular.module('app', []);

app.controller('MessageThreadController', messageThreadController);

function messageThreadController($scope) {
  var baseUrl = angular.copy(window.app_config.base_url);
  var mid = angular.copy(window.message_thread.mid);
  $scope.loggedId = angular.copy(window.app_config.loggedId);
  $scope.isFetching = false;
  $scope.messages = [];
  $scope.last_mtid = ''
  $scope.hasMoreData = true;
  $scope.reply_message = "";
  
  $scope.onAddReply = function() {
    if($scope.reply_message.trim().length == 0) { return; }
    $scope.isAdding = true;
    $.post(baseUrl + 'message/addThreadMessage/' + mid, { message: $scope.reply_message }, null, 'json').then(function(response) {
      if (response.success) {
        $scope.messages.unshift(angular.copy(response.message));
        $scope.isAdding = false;
        $scope.reply_message = "";
      }
      $scope.$digest();
    }, function() {
      alert(window.app_messages.cannot_connect_msg);
    });
  }
  
  $scope.formatDate = function(date){
    var dateOut = new Date(date);
    return dateOut;
  }
  
  $scope.loadMoreData = function() {
    $.get(baseUrl + 'message/getThreadMessages/' + mid, { 'last_mtid': $scope.last_mtid }, null, 'json').then(function(response) {
      if(response.success) {
        $scope.messages = $scope.messages.concat(response.messages);
        if(response.last_mtid) {
          $scope.last_mtid = angular.copy(response.last_mtid);
        }
        $scope.hasMoreData = angular.copy(response.more_message);
      }
      $scope.$digest();
    }, function() {
      $scope.isFetching = false;
      $scope.$digest();
      alert(window.app_messages.cannot_connect_msg);
    });
  }
  
  $scope.loadMoreData();
  
}