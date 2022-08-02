app = app || angular.module('app', []);

app.controller('AddMessageController', addMessageController);

function addMessageController($scope) {
  var baseUrl = angular.copy(window.app_config.base_url);
  
  $scope.onBeforeSubmit = function(e) {
    e.preventDefault();
    var _this = $(e.currentTarget)
    clearErrors();
    var data = _this.serializeArray();
    var url = _this.attr('action') + '/json';
    $.post(url, data, null, 'json').then(function(response) {
      if(response.success) {
        window.location.href = response.redirect;
      } else {
        $(".form-errors").show();
        $scope.errors = angular.copy(response.errors);
      }
      $scope.$digest();
    }, function() {
      alert(window.app_messages.cannot_connect_msg);
    });
    
  }
  
  function clearErrors() {
    $scope.errors = [];
    $(".form-errors li").remove();
    $(".form-errors").hide();
  }
  
  $('#recipient').select2({
    placeholder: 'Search for a recipient',
    ajax: {
      url: baseUrl + 'user/loadRecipients',
      dataType: 'json',
      delay: 250,
      data: function (params) {
        var query = {
          search: params.term,
          limit: params.page
        }

        // Query parameters will be ?search=[term]&type=public
        return query;
      },
      processResults: function (data) {
        // Transforms the top-level key of the response object from 'items' to 'results'
        var results = data.items.map(function(item) {
          return { id: item.User.id, text: item.User.name };
        });
        return {
          results: results
        };
      }
    },
    templateResult: function(item) {
      if(item.loading || !item.id) {
        return item.text;
      }
      return $('<span><img src="'+ baseUrl + 'document/renderProfilePicture/' + item.id +'" style="width:50px; height: 50px;" />' + item.text + '</span>');
    },
    templateSelection: function(item) {
      if(!item.id) {
        return item.text;
      }
      return $('<span><img src="'+ baseUrl + 'document/renderProfilePicture/' + item.id +'" style="width:50px; height: 50px;" />' + item.text + '</span>');
    }
  });
}