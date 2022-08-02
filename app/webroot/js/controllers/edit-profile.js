app = app || angular.module('app', []);

app.controller('EditProfileController', editProfileController);

function editProfileController($scope) {
  
  $scope.photo = null;
  $scope.originalPhoto = angular.copy(window.uploadPhoto.originalPhoto);
  $scope.generating = false;
  
  $scope.onSelectPicture = function(e) {
    e.preventDefault();
    $("#profile_picture").trigger("click");
  }
  
  $("#birthdate-temp").datepicker({
    maxDate: 0,
    dateFormat: 'm/dd/yy',
    altField: "#UserDetailBirthDate",
    altFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true
  });
  
  $(document).on("change", "#profile_picture", function(e) {
    var file = e.currentTarget.files[0];
    if(file) {
      $scope.generating = true;
      $scope.photo = null;
      $scope.$digest();
      var reader = new FileReader();
      reader.onload = function() {
        $scope.generating = false;
        $scope.photo = angular.copy(reader.result);
        $scope.$digest();
      };
      reader.readAsDataURL(file);
    }
  });
}