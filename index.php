<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Mailchimp Diagram</title>
	<meta name="description" content="Interactive flowchart diagram implemented by GoJS in JavaScript for HTML." />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Copyright 1998-2019 by Northwoods Software Corporation. -->
	<link rel="stylesheet" href="https://sendplex.net/client/views/sp/assets/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://sendplex.net/client/views/sp/assets/css/style.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" media="all">
	<link rel="stylesheet" href="assets/diagram.css">
  <script src="assets/jquery.min.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="assets/jQueryRotateCompressed.2.2.js" type="text/javascript"></script>
	<script src="https://sendplex.net/client/views/sp/assets/bootstrap/dist/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="page-wrapper" id="app">
		<div class="col-md-12 col-lg-12 col-xs-12">
			<div class="white-box">
				<h3 class="box-title">Diagram</h3>
				<div class="diagram" id="diagram">
        </div>
        <div class="action">
          <button class="btn-sm btn-danger reset-btn" onclick="loadDiagram()">Reset</button>
          <button class="btn-sm btn-success save-btn" onclick="saveDiagram()">Save</button>
        </div>
			</div>
		</div>
    <div class="modal fade" tabindex="-1" role="dialog" id="edit_gp_obj">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content egp-show-start" id="egp_modal">
          <form id="egp_modal_form">
            <div class="modal-header">
              <h4 class="modal-title" id="egp_modal_title"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="form-group col-xs-6 pull-right mr-10 egp-title-outer">
                <select id="egp_object_type" class="form-control input-sm">
                  <!-- <option value="start" disabled>Start</option> -->
                  <option selected value="message">Message</option>
                  <option value="condition">Condition</option>
                </select>
                <select id="egp_path_str" class="form-control input-sm">
                  <option selected value=""></option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
              </div>
              <input type="hidden" id="egp_start" value="0" />
              <input type="hidden" id="egp_parent" value="0" />
              <input type="hidden" id="egp_flowID" value="1" />
              <input type="hidden" id="egp_flowOrder" value="0" />
              <input type="hidden" id="egp_campaignID" value="1" />
              <input type="hidden" id="egp_parent_cam" value="0" />
              <input type="hidden" id="egp_pos_x" value="0" />
              <input type="hidden" id="egp_pos_y" value="0" />
            </div>
            <div class="modal-body form-minline">
              <div class="form-group">
                <label class="" for="egp_title">Title</label>
                <input type="text" class="form-control input-sm" id="egp_title" placeholder="Title" value="Title">
              </div>
              <div class="form-group hidden">
                <label class="" for="egp_value_start">Trigger</label>
                <select class="form-control input-sm" id="egp_value_start" placeholder="Choose ..">
                  <option selected value="Add_To_List">Add To List</option>
                </select>
              </div>
              <div class="form-group hidden">
                <label class="" for="egp_value_detail_start">Value</label>
                <select class="form-control input-sm" id="egp_value_detail_start" placeholder="Choose ..">
                  <option selected value="Master_Abandon_Cart">Master Abandon Cart</option>
                  <option value="Master_Clicker_List">Master Clicker List</option>
                  <option value="Master_Buyer_List">Master Buyer List</option>
                </select>
              </div>
              <div class="form-group egp-show-message hidden">
                <label class="" for="egp_value_message">Content</label>
                <textarea type="text" class="form-control input-sm" id="egp_value_message" placeholder="Insert Message Content .."></textarea>
              </div>
              <div class="form-group egp-show-condition hidden">
                <label class="" for="egp_value_condition">Type</label>
                <select class="form-control input-sm" id="egp_value_condition" placeholder="Choose ..">
                  <option selected value="Conversion_Happened">Conversion Happened</option>
                </select>
              </div>
              <div class="form-group">
                <label class="egp-delay-label" for="egp_delay">Delay before next event</label>
                <input type="text" class="form-control input-sm egp-delay" id="egp_delay" placeholder="Delay .." value="0">
                <select class="form-control input-sm egp-delay-value" id="egp_delay_value" placeholder="Choose ..">
                  <option value="minute">Minute</option>
                  <option selected value="hour">Hour</option>
                  <option value="day">Day</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" onclick="deleteBox()" id="egp_delete_btn">Delete</button>
              <button type="button" class="btn btn-primary" onclick="saveBox()" id="egp_save_btn">Save</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
	<script src="assets/diagram.js"></script>
</body>

</html>