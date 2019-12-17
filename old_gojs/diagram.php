<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Flowchart</title>
	<meta name="description" content="Interactive flowchart diagram implemented by GoJS in JavaScript for HTML." />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Copyright 1998-2019 by Northwoods Software Corporation. -->
	<link rel="stylesheet" href="https://sendplex.net/client/views/sp/assets/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://sendplex.net/client/views/sp/assets/css/style.css">
	<link rel="stylesheet" href="assets/diagram.css">
	<script src="assets/jquery.min.js"></script>
	<script src="https://sendplex.net/client/views/sp/assets/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="assets/diagram.js"></script>
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
          <!-- <button class="btn-sm btn-success add-btn pull-right" onclick="addDiagram()">Add</button> -->
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
              </div>
              <input type="hidden" id="egp_start" value="0" />
              <input type="hidden" id="egp_parent" value="0" />
              <input type="hidden" id="egp_right" value="0" />
              <input type="hidden" id="egp_flowID" value="1" />
              <input type="hidden" id="egp_flowOrder" value="0" />
              <input type="hidden" id="egp_campaignID" value="1" />
              <input type="hidden" id="egp_right_cam" value="0" />
              <input type="hidden" id="egp_down_cam" value="0" />
            </div>
            <div class="modal-body form-minline">
              <div class="form-group">
                <label class="" for="egp_title">Title</label>
                <input type="text" class="form-control input-sm" id="egp_title" placeholder="Title" value="Title">
              </div>
              <div class="form-group egp-show-start hidden">
                <label class="" for="egp_value_start">Trigger</label>
                <select class="form-control input-sm" id="egp_value_start" placeholder="Choose ..">
                  <option selected value="Add_To_List">Add To List</option>
                </select>
              </div>
              <div class="form-group egp-show-start hidden">
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

  <script>
    var flows = {};
    var campaign_id = getParam("campaignID") ? getParam("campaignID") : "1";
    flows[1] = [
      {
        flowOrder: "1",
        delay: "2",
        delay_value: "hour",
        down_cam: "2",
        campaignID: campaign_id,
        flowID: "1",
        object_type: "start",
        right_cam: "0",
        title: "Start",
        value: "Add_To_List",
        value_detail: "Master_Abandon_Cart"
      },
      {
        flowOrder: "2",
        delay: "3",
        delay_value: "hour",
        down_cam: "0",
        campaignID: campaign_id,
        flowID: "1",
        object_type: "message",
        right_cam: "0",
        title: "Initiate",
        value: "We noticed you didn’t complete your purchase, anything we can to help? [trackinglink]",
        value_detail: ""
      }
    ];

    function dataFromHTML() {
      return flows = "";
    };
    function dataToJson() {
      return JSON.stringify(flows);
    };
    function renderDiagram(flows) {
      var diagram_html = "";
      for (var flow in flows) {
        diagram_html += '<div class="graph gp-flow" gp-flowID="' + flow + '">';
        for (var obj in flows[flow]) {
          diagram_html += '<div class="gp-obj gp-' + flows[flow][obj]['object_type']; 
          diagram_html += flows[flow][obj]['down_cam'] > 0 ? ' gp-down' : ''; 
          diagram_html += flows[flow][obj]['right_cam'] > 0 ? ' gp-right' : '';
          diagram_html += '"';
          for (var column in flows[flow][obj]) {
            diagram_html += ' gp-' + column + '="' + flows[flow][obj][column] + '"';
          }
          diagram_html += '><div class="gp-box" onclick="editBox(' + flow + ', ' + flows[flow][obj]['flowOrder'] + ')">' + flows[flow][obj]['title'] + '</div>';
          var add_r_available, add_d_available = 0;
          if ((flows[flow]).length == flows[flow][obj]['flowOrder'] || flows[flow][obj]['object_type'] == "condition") {
            if (flows[flow][obj]['object_type'] == "condition") {
              if (flows[flow][obj]['right_cam'] == 0) {
                add_r_available = 1;
              } else if (flows[flow][obj]['down_cam'] == 0) {
                add_d_available = 1;
              }
            } else {
              add_d_available = 1;
            }
          }
          diagram_html += '<div class="gp-path gp-path-right' + (add_r_available ? ' gp-add-available" onclick="editBox(' + flow + ', ' + (Object.keys(flows[flow]).length + 1) + ', true)"' : '"') + '></div>';
          diagram_html += '<div class="gp-path' + (add_r_available ? '' : ' gp-path-down') + (add_d_available ? ' gp-add-available" onclick="editBox(' + flow + ', ' + (Object.keys(flows[flow]).length + 1) + ')"' : '"') + '></div></div>';
          diagram_html += flows[flow][obj]['right_cam'] > 0 ? '' : '<br>';
        }
        diagram_html += '</div>';
        // diagram_html += '<div class="gp-delete-btn" onclick="deleteDiagram(' + flow + ')"><i class="icon-trash"></i></div></div>';
      }
      $("#diagram").html(diagram_html);
    }
    function addDiagram() {
      var add = Math.max.apply(null,Object.keys(flows)) + 1;
      flows[add] = [
        {
          flowOrder: "1",
          delay: "2",
          delay_value: "hour",
          down_cam: "2",
          campaignID: campaign_id,
          flowID: add,
          object_type: "start",
          right_cam: "0",
          title: "Start",
          value: "Add_To_List",
          value_detail: "Master_Abandon_Cart"
        },
        {
          flowOrder: "2",
          delay: "3",
          delay_value: "hour",
          down_cam: "0",
          campaignID: campaign_id,
          flowID: add,
          object_type: "message",
          right_cam: "0",
          title: "Initiate",
          value: "We noticed you didn’t complete your purchase, anything we can to help? [trackinglink]",
          value_detail: ""
        }
      ];
      renderDiagram(flows);
    }
    function deleteDiagram(flow) {
      if (confirm('Do you want to delete this diagram?')) {
        delete flows[flow]
        renderDiagram(flows);
      }
    }
    function loadDiagram() {
      $.ajax({
        url: "diagram_ajax.php",
        type: "post",
        data: {
            "mode": "load",
            "userID": getParam("userID"),
            "flowID": getParam("flowID"),
            "campaignID": getParam("campaignID")
        },
        dataType: "json",
        success: function (response) {
          if (response == "empty") {

          } else {
            flows = response.data;
          }
          renderDiagram(flows);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
      });
    }
    function saveDiagram() {
      $.ajax({
        url: "diagram_ajax.php",
        type: "post",
        data: {
            "mode": "save",
            "data": dataToJson(),
            "userID": getParam("userID"),
            "flowID": getParam("flowID"),
            "campaignID": getParam("campaignID")
        },
        dataType: "json",
        success: function (response) {
            loadDiagram();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
      });
    }
    function editFlows(flow_data, right=false) {
      var key = null;
      var flow = flow_data['flowID'];
      var flow_order = flow_data['flowOrder'];
      for (var checker in flows[flow]) {
        if (flows[flow][checker]['flowOrder'] == flow_order) key = checker;
      }
      if (key === null ) {
        flows[flow][flow_order-1] = flow_data;
        if (right) {
          flows[flow][flow_order-2]['right_cam'] = flow_order;
        } else {
          if (flows[flow][flow_order-3]['right_cam'] != "0") {
            flows[flow][flow_order-3]['down_cam'] = flow_order;
          } else {
            flows[flow][flow_order-2]['down_cam'] = flow_order;
          }
        }
      } else {
        flows[flow][key] = flow_data;
      }

      renderDiagram(flows);
      // saveDiagram();
      $("#edit_gp_obj").modal('hide');
    }
    function deleteFlows(flow_data) {
      var key = null;
      var flow = flow_data['flowID'];
      var flow_order = flow_data['flowOrder'];
      var new_flows_data = [];
      for (var checker in flows[flow]) {
        if (flows[flow][checker]['flowOrder'] == flow_order) {
          key = checker;
          break;
        };
        new_flows_data[checker] = flows[flow][checker];
      }
      // console.log(new_flows_data[key-1])
      new_flows_data[key-1]['right_cam'] = 0;
      new_flows_data[key-1]['down_cam'] = 0;
      if (new_flows_data[key-2]['right_cam'] != "0") {
        new_flows_data[key-2]['down_cam'] = 0;
      }

      flows[flow] = new_flows_data;

      renderDiagram(flows);
      // saveDiagram();
      $("#edit_gp_obj").modal('hide');
    }
    function editBox(flow, flow_order, right=false) {
      var box_data = {};
      for (var checker in flows[flow]) {
        if (flows[flow][checker]['flowOrder'] == flow_order) box_data = flows[flow][checker];
      }
      var isEdit = 0;
      if (Object.keys(box_data).length) { 
        isEdit = 1;
      } else {
        box_data = {
          flowOrder: flow_order,
          delay: "0",
          delay_value: "hour",
          down_cam: "0",
          campaignID: campaign_id,
          flowID: flow,
          object_type: "message",
          right_cam: "0",
          title: "",
          value: "",
          value_detail: ""
        };
      }
      // console.log(box_data);
      //reset modal form
      $("#egp_modal_form").trigger("reset");
      $("#egp_title").attr('readonly', false);
      $("#egp_object_type").attr('disabled', false)
      $("#egp_delete_btn").attr('disabled', false);
      $("#egp_right").val(0);
      $("#egp_start").val(0);
     
      //show principle items
      $("#egp_modal").removeClass('egp-show-start egp-show-message egp-show-condition').addClass('egp-show-' + box_data['object_type']);
      //change modal title [Edit | Add]
      $("#egp_modal_title").text('Edit Object');
      //change object type [Start | Message | Condition]
      $("#egp_object_type").val(box_data['object_type']);
      if (isEdit) { 
        $("#egp_object_type").attr('disabled', true);
      }
      //change properities
      if (right) {
        $("#egp_right").val(1);
      }
      $("#egp_flowID").val(box_data['flowID']);
      $("#egp_flowOrder").val(box_data['flowOrder']);
      $("#egp_right_cam").val(box_data['right_cam']);
      $("#egp_down_cam").val(box_data['down_cam']);
      $("#egp_campaignID").val(box_data['campaignID']);
      //change title
      $("#egp_title").val(box_data['title']);
      if (box_data['object_type'] == "start") { 
        $("#egp_start").val(1);
        $("#egp_title").attr('readonly', true);
        $("#egp_delete_btn").attr('disabled', true);
      }
      if (box_data['flowOrder'] == 2) {
        $("#egp_delete_btn").attr('disabled', true);
      }
      //change value & value_detail
      $("#egp_value_" + box_data['object_type']).val(box_data['value']);
      $("#egp_value_detail_" + box_data['object_type']).val(box_data['value_detail']);
      //change delay & delay_value
      $("#egp_delay").val(box_data['delay']);
      $("#egp_delay_value").val(box_data['delay_value']);

      //modal show
      $("#edit_gp_obj").modal('show');
    }
    function saveBox() {
      var right = $("#egp_right").val();
      var object_type = $("#egp_start").val() == 1 ? "start" : $("#egp_object_type").val();

      var box_data = {
        flowOrder:    $("#egp_flowOrder").val(),
        delay:        $("#egp_delay").val(),
        delay_value:  $("#egp_delay_value").val(),
        down_cam:     $("#egp_down_cam").val(),
        campaignID:   $("#egp_campaignID").val(),
        flowID:       $("#egp_flowID").val(),
        object_type:  object_type,
        right_cam:    $("#egp_right_cam").val(),
        title:        $("#egp_title").val(),
        value:        $("#egp_value_" + object_type).val(),
        value_detail: $("#egp_value_detail_" + object_type).val()
      };
      // console.log(box_data);
      if (right == 1) {
        editFlows(box_data, true);
      } else {
        editFlows(box_data);
      }
    }
    function deleteBox() {
      var box_data = {
        flowOrder:    $("#egp_flowOrder").val(),
        flowID:       $("#egp_flowID").val(),
      };
      if (confirm('Do you want to delete all object below this object?')) {
        deleteFlows(box_data);
      }
    }
    function getParam(name){
      if(name=(new RegExp('[?&]'+encodeURIComponent(name)+'=([^&]*)')).exec(location.search))
          return decodeURIComponent(name[1]);
    }
    $(document).ready(function () {
      loadDiagram();

      $("#egp_object_type").change(function () {
        var egp_object_type = $("#egp_object_type").val();
        $("#egp_modal").removeClass('egp-show-start egp-show-message egp-show-condition').addClass('egp-show-' + egp_object_type);
      })
    })
  </script>

</body>

</html>