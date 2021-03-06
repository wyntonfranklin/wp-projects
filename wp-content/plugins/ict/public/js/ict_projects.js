jQuery(function($){

    /* global ajax_url */

    var el = $('#modal-popup');
    var pj = $('#project-popup');
    var shortCodeContainer = $(".ict-project-table-container");
    var searchInput = $('#ict-search-table');
    var projectFilter = $('#project-type-filter');
    var clientFilter = $('#project-client-filter');

    var teamContent = $('#teams-content');
    var projectTeam = $('#team-title');
    $(document).ready( function () {
        var jTable = $('#ict-projects-table').DataTable({
            "order": [],
            "bLengthChange": false,
            "bFilter": false,
            "searching": true,
            sDom: 'ltipr',
        });

        searchInput.on( 'keyup', function () {
            searchTable();
        } );

        projectFilter.on('change',function(){
            searchTable();
        });

        clientFilter.on('change',function(){
           searchTable();
        });

        var searchTable = function ( ){
            var searchInputText = searchInput.val();
            var projectFilterText = projectFilter.val();
            var clientFilterText = clientFilter.val();
            var fullSearchText = searchInputText + " "
                + projectFilterText + " " + clientFilterText;
            jTable.search( fullSearchText ).draw();
        };

        var searchOnParam = function(){
            var param = shortCodeContainer.data('client');
            if( param !== undefined && param !== "" ){
                jTable.search( param ).draw();
            }
        };
        searchOnParam(); // call function
    } );

    $('.view-team').on('click',function(){
        projectTeam.text( $(this).data("project"));
        teamContent.empty().html('<tr><td colspan="2">Loading Content...</td></tr>');
        getTeamDetails($(this).data("id"));
        showTeamPopup();
        return false;
    });

    $('.proj-desc').on('click',function(){
        $('#project-title').empty().text( $(this).text() );
        $('#project-description').empty().html('<span>Loading Content...</span>');
        showProjectPopup();
        getProjectDetails( $(this).data('project') );
        return false;
    });


    var getProjectDetails = function(projectId){
        $.post(ajax_url,{action:"ict_ajax_projects","projId":projectId},function(data){
            updateProjectView(data);
        });
    };

    var updateProjectView = function(jsonData){
        var data = JSON.parse(jsonData);
        $('#project-description').empty().html(data.success.content);
    };

    var showProjectPopup = function(){
        pj.removeClass('no-show-popup');
        pj.addClass('show-popup');
        jQuery.magnificPopup.open({
            items: {
                src: '#project-popup',
                type: 'inline'
            }
        });
    };

    var getTeamDetails = function(projectId){
        $.post(ajax_url,{action:"ict_ajax_teams","id":projectId},function(data){
            updateTeamView(data);
        });
    };

    var updateTeamView = function( jsonData ) {
        var data = JSON.parse(jsonData);
        teamContent.empty().html(data.success.content);
    };

    var showTeamPopup = function(){
        el.removeClass('no-show-popup');
        el.addClass('show-popup');
        jQuery.magnificPopup.open({
            items: {
                src: '#modal-popup',
                type: 'inline'
            }
        });
    };

});