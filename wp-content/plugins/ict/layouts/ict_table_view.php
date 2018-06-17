<div ng-app="myApp" class="ict-experience-table" style="max-width: 1200px;">
	<div id = "search-form">
		<div id = "small-div">
			<div class="form-group">
				<div class="inner-addon right-addon">
					<h3 id = "contact-heading" style = "color:#757280;"></h3>
					<div class="search">
						<span class="fa fa-search"></span>
						<input class="form-control" type="text" placeholder="Search" ng-model="info">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div>
		<strong>Type of Project:</strong>
		<select ng-model="ptype">
			<option value=""></option>
			<option value="Conferance">Consultancy</option>
			<option value="Luanch">Training</option>
			<option value="Presentation">Cloud Platform</option>
			<option value="Website Development">Website Development</option>
			<option value="Network Infrastructure">Network Infrastructure</option>
			<option value="Design & Installation">Design & Installation</option>
			<option value="IT Audit">IT Audit</option>
		</select>
		<strong>Client:</strong>
		<div ng-controller="contactsCtrl as contactsList">
			<select ng-model="client">
				<option value=""></option>
				<option ng-repeat="x in contactsList.data" value="{{x.owner}}">{{x.owner}}</option>
			</select>
		</div>
	</div>

	<table ng-hide="info.length" id="squadTable" class="table table-dark table-striped" ng-controller="contactsCtrl as contactsList">

		<tr>
			<th data-filter-value="projectName">Project Name</th>
			<th data-filter-value="typeOfProject">Type of Project</th>
			<th data-filter-value="client">Client</th>
			<th data-filter-value="projectTeam">Project Team</th>
			<th data-filter-value="startDate">Start Date</th>
			<th data-filter-value="endDate">End Date</th>
			<th data-filter-value="reference">Reference</th>
		</tr>

		<tr ng-repeat="x in contactsList.data | limitTo:10:begin | filter:info | filter:ptype:true">
            <td><a ng-href="{{x.eventurl}}" target="_blank">{{x.name}}</a></td>
			<td align="center">{{x.type}}</td>
			<td align="center">{{x.owner}}</td>
            <td>
                <div data-ng-repeat="i in [1,2]"> <!-- Team data [] -->
                    <a ng-click="go($event)" data-team="{{x.contact}}" href="www.google.com" target="_blank">{{x.contact.name}}</a>,
                </div>
            </td>
			<td align="center">{{x.start_date}}</td>
			<td align="center">{{x.end_date}}</td>
			<td align="center"><a ng-href="{{x.document_link}}" target="_blank">Reference.pdf</a></td>
		</tr>
		<tr>
			<td colspan="7" bgcolor="white"> <input ng-init = "begin = 0" ng-model = "begin" type="hidden" id ="start-number" size="2" ng-max="20"/>
				<input class="wpcf7-form-control wpcf7-submit" type = "submit" value="←Prev" ng-click = "begin >= 10 ? begin = begin - 10 : begin = 0"/>
				<input ng-disabled = "begin >= contactsList.data.length - 10" class="wpcf7-form-control wpcf7-submit" type = "submit" value="Next→" ng-click = "begin = begin + 10"/>
				<p id = "picture-pages">Page {{(begin+10)/10 + " of " + contactsList.data.pageNumber}}</p>  </td>
		</tr>

	</table>

</div>

<div class="white-popup-block no-show-popup" id="modal-popup">
    <div class="white-popup-header">
        <h3 id="md-title">header content</h3>
    </div>
    <div style="margin-bottom: 10px; text-align: center;">
        <img src="http://ict.xhuma.co/event_logos/blue_background.jpg" width="50%">
    </div>
    <div>
        <table class="table table-user-information">
            <tbody>
            <tr>
                <td><b>Team Title:</b> &nbsp;<span id="team-job">A Team Tile</span></td>
                <td><b>Team Description:</b> &nbsp; <span id="team-description">A descripton of team member</span></td>
            </tr>
            <tr>
                <td colspan="2"><b>Team Status:</b> <span id="team-experience">A place for stats</span></td>
            </tr>
            </tbody>
        </table>
    </div>
    <button title="Close" type="button" class="mfp-close">&#215;</button>
</div>
