/* global ajax_url */
(function(){

    var app = angular.module('myApp',[]);

    app.controller('contactsCtrl',function($window, $scope, $http ) {
        $scope.name = 'World';

        $scope.greet = function() {
            $window.alert('Hello ' + $scope.name);
        };

        var contactsList = this;
        $http({
            method:'POST',
            url: ajax_url,
            params:{
                action: "xhuma_ajax_projects",
            },
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function(data) {

            contactsList.data = data.data;
            pageCount = Math.ceil(contactsList.data.length / 10);
            contactsList.data.pageNumber = pageCount.toString();
            console.log(contactsList.data.pageNumber);
        }, function (error) {
            console.log(error);
        });

        $scope.go = function( $event ){
            $event.preventDefault();
            var el = angular.element($event.currentTarget);
            var modal = jQuery('#modal-popup');
            addContent( modal, el );
            showModal( modal );
            return false;
        };

        var showModal = function( el ) {
            el.removeClass('no-show-popup');
            el.addClass('show-popup');
            jQuery.magnificPopup.open({
                items: {
                    src: '#modal-popup',
                    type: 'inline'
                }
            });
        };

        var addContent = function( modal, el ){
            modal.find('#md-title').text(el.text());
            var teamData = el.data('team');
            modal.find('#team-job').text(teamData.name);
            modal.find('#team-description').text(teamData.email);
            modal.find('#team-experience').text(teamData.phone);
        };

    });


})();


