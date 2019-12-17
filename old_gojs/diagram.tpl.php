<?php
$xheader='
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/diagram.css">
<script src="assets/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="assets/jQueryRotateCompressed.2.2.js"></script>
<script src="assets/diagram.js"></script>
';
require_once 'sections/header.tpl.php';
require_once 'sections/navbar.tpl.php';
?>

<!--Content Starts from here -->
<div class="page-wrapper" id="app">
    <div class="container-fluid">
        <!-- .row -->
        <div class="row">
          <div class="col-sm-12">
              <div class="white-box">
                  <h3 class="box-title m-b-0">Flow Control</h3>
                  <p class="text-muted m-b-30">You can modify your flow belows.</p>

                  <!-- <iframe src="diagram_content.php?userID=7&flowID=3&campaignID=3" height="600" width="700"></iframe> -->
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
          </div>
        </div>



<?php
require_once 'sections/right-sidebar.tpl.php';
$xfooter = '
<script>
  var flows = {};
  var user_id = getParam("userID") ? getParam("userID") : "0";
  var campaign_id = getParam("campaignID") ? getParam("campaignID") : "1";
  var flow_id = getParam("flowID") ? getParam("flowID") : "1";
  flows[1] = [
    {
      campaignID: campaign_id,
      flowID: flow_id,
      flowOrder: "1",
      object_type: "start",
      title: "Start",
      value: "Add_To_List",
      value_detail: "Master_Abandon_Cart",
      delay: "2",
      delay_value: "hour",
      parent_cam: "0",
      path_str: "",
      pos_x: "100px",
      pos_y: "0",
    },
    {
      campaignID: campaign_id,
      flowID: flow_id,
      flowOrder: "2",
      object_type: "message",
      title: "Initiate",
      value: "We noticed you didn’t complete your purchase, anything we can to help? [trackinglink]",
      value_detail: "",
      delay: "3",
      delay_value: "hour",
      parent_cam: "1",
      path_str: "",
      pos_x: "96px",
      pos_y: "60px",
    }
  ];

  function renderDiagram(flows) {
    check_condition_value_detail();

    var diagram_html = "";
    for (var flow in flows) {
      diagram_html += \'<div class="graph gp-flow" gp-flowID="\' + flow + \'">\';
      for (var obj in flows[flow]) {
        if (flows[flow][obj][\'object_type\'] != "start") {
          diagram_html += \'<div class="gp-line" gp-from="\' + flows[flow][obj][\'parent_cam\'] + \'" gp-to="\' + flows[flow][obj][\'flowOrder\'] + \'"><div class="path-tri"></div><div class="path-str text-center">\' + flows[flow][obj][\'path_str\'] + \'</div></div>\';
        }
        diagram_html += \'<div class="gp-obj gp-\' + flows[flow][obj][\'object_type\'];
        diagram_html += \'"\';
        for (var column in flows[flow][obj]) {
          diagram_html += \' gp-\' + column + \'="\' + flows[flow][obj][column] + \'"\';
        }
        diagram_html += \' style="left: \' + flows[flow][obj][\'pos_x\'] + \'; top: \' + flows[flow][obj][\'pos_y\'] + \';">\';
        diagram_html += \'<div class="gp-box" ondblclick="editBox(\' + flows[flow][obj][\'flowOrder\'] + \')">\' + flows[flow][obj][\'title\'] + \'</div>\';
        diagram_html += \'<div class="gp-path gp-path-down gp-add-available" onclick="newBox(\' + flows[flow][obj][\'flowOrder\'] + \')"></div></div>\';
      }
      diagram_html += \'</div>\';
    }
    $("#diagram").html(diagram_html);

    $(".gp-obj").queue(function () {
      drawPath($(this))
    }).draggable({
      drag: function(event, ui){
        drawPath($(this))
      }
    });
  }
  function drawPath(thisBox) {
    var this_fo = $(thisBox).attr(\'gp-flowOrder\');
    flows[flow_id][this_fo-1][\'pos_x\'] = thisBox.css("left");
    flows[flow_id][this_fo-1][\'pos_y\'] = thisBox.css("top");

    $("div[gp-from=" + this_fo + "], div[gp-to=" + this_fo + "]").queue(function () {
      // console.log($(this));
      var path = $(this);

      var fromBox = $("div[gp-flowOrder=" + path.attr(\'gp-from\') + "]");
      var toBox = $("div[gp-flowOrder=" + path.attr(\'gp-to\') + "]");
      fromBox = fromBox.length > 0 ? fromBox : thisBox;

      var from_x = fromBox.offset().left + parseFloat(fromBox.css("width")) / 2;
      var from_y = fromBox.offset().top + (parseFloat(fromBox.css("height")) - 40) / 2;
      var to_x = toBox.offset().left + parseFloat(toBox.css("width")) / 2;
      var to_y = toBox.offset().top + (parseFloat(toBox.css("height")) - 40) / 2;

      var hypotenuse = Math.sqrt((from_x-to_x)*(from_x-to_x) + (from_y-to_y)*(from_y-to_y));
      var angle = Math.atan2((from_y-to_y), (from_x-to_x)) *  (180/Math.PI);
      if(angle >= 90 && angle < 180){
        from_y = from_y - (from_y-to_y);
      }
      if(angle > 0 && angle < 90){
        from_x = from_x - (from_x-to_x);
        from_y = from_y - (from_y-to_y);
      }
      if(angle <= 0 && angle > -90){
        from_x = from_x - (from_x-to_x);
      }

      path.queue(function(){
        $(this).offset({top: from_y, left: from_x});
        $(this).width(hypotenuse);
        $(this).rotate(angle);
        $(this).dequeue();
      });

      var tri_length = 20; //caculating now.
      // console.log(Math.abs(Math.abs(angle) - 90), Math.cos(Math.abs(Math.abs(angle) - 90)));
      path.children(".path-tri").css("left", tri_length + "px");

      path.children(".path-str").rotate(-angle);

      var max_height = 300;
      $(".gp-obj").each(function () {
        max_height = $(this).offset().top > max_height ? $(this).offset().top : max_height;
      })
      $(".graph").height(max_height)
      $(this).dequeue();
    })

  }
  function loadDiagram() {
    $.ajax({
      url: "diagram_ajax_new.php",
      type: "post",
      data: {
          "mode": "load",
          "userID": user_id,
          "flowID": flow_id,
          "campaignID": campaign_id
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
      url: "diagram_ajax_new.php",
      type: "post",
      data: {
          "mode": "save",
          "data": JSON.stringify(flows),
          "userID": user_id,
          "flowID": flow_id,
          "campaignID": campaign_id
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
  function editFlows(flow_data) {
    var key = null;
    var flow = flow_data[\'flowID\'];
    var flow_order = flow_data[\'flowOrder\'];
    for (var checker in flows[flow]) {
      if (flows[flow][checker][\'flowOrder\'] == flow_order) key = checker;
    }
    if (key === null) {
      flows[flow][flow_order-1] = flow_data;
    } else {
      flows[flow][key] = flow_data;
    }

    renderDiagram(flows);
    // saveDiagram();
    $("#edit_gp_obj").modal(\'hide\');
  }
  function deleteFlows(flow_data) {
    var key = null;
    var flow = flow_data[\'flowID\'];
    var flow_order = flow_data[\'flowOrder\'];

    for (var checker in flows[flow]) {
      if (flows[flow][checker][\'flowOrder\'] == flow_order) {
        key = checker;
        break;
      };
    }
    delete flows[flow][key];

    renderDiagram(flows);
    // saveDiagram();
    $("#edit_gp_obj").modal(\'hide\');
  }
  function suggestPathStr(flow_order) {
    return "Yes";
  }
  function newBox(parent_cam) {
    var flow = 1;
    editBox((Object.keys(flows[flow]).length + 1), parent_cam);
  }
  function editBox(flow_order, parent_cam=false) {
    var box_data = {};
    var flow = 1;
    for (var checker in flows[flow]) {
      if (flows[flow][checker][\'flowOrder\'] == flow_order) box_data = flows[flow][checker];
    }
    var isEdit = 0;
    if (Object.keys(box_data).length) {
      isEdit = 1;
    } else {
      console.log(flows[flow_id][parent_cam-1]);
      var pos_x = flows[flow_id][parent_cam-1][\'pos_x\'];
      var pos_y = (parseFloat(flows[flow_id][parent_cam-1][\'pos_y\']) + 60) + "px";
      var path_str = (flows[flow_id][parent_cam-1][\'object_type\'] == "condition") ? suggestPathStr(parent_cam-1) : "";
      box_data = {
        campaignID: campaign_id,
        flowID: flow,
        flowOrder: flow_order,
        object_type: "message",
        title: "",
        value: "",
        value_detail: "",
        delay: "0",
        delay_value: "hour",
        parent_cam: parent_cam,
        path_str: path_str,
        pos_x: pos_x,
        pos_y: pos_y,
      };
    }
    // console.log(box_data);
    //reset modal form
    $("#egp_modal_form").trigger("reset");
    $("#egp_title").attr(\'readonly\', false);
    $("#egp_object_type").attr(\'disabled\', false)
    $("#egp_delete_btn").attr(\'disabled\', false);
    $("#egp_path_str").attr(\'disabled\', false);
    $("#egp_start").val(0);

    //show principle items
    $("#egp_modal").removeClass(\'egp-show-start egp-show-message egp-show-condition\').addClass(\'egp-show-\' + box_data[\'object_type\']);
    //change modal title [Edit | Add]
    $("#egp_modal_title").text(\'Edit Object\');
    //change object type [Start | Message | Condition]
    $("#egp_object_type").val(box_data[\'object_type\']);
    if (isEdit) {
      $("#egp_object_type").attr(\'disabled\', true);
    }
    //change properities
    $("#egp_flowID").val(box_data[\'flowID\']);
    $("#egp_flowOrder").val(box_data[\'flowOrder\']);
    $("#egp_parent_cam").val(box_data[\'parent_cam\']);
    $("#egp_path_str").val(box_data[\'path_str\']);
    $("#egp_campaignID").val(box_data[\'campaignID\']);
    //change title
    $("#egp_title").val(box_data[\'title\']);
    if (box_data[\'object_type\'] == "start") {
      $("#egp_start").val(1);
      $("#egp_title").attr(\'readonly\', true);
      $("#egp_delete_btn").attr(\'disabled\', true);
    }
    if (box_data[\'flowOrder\'] == 2) {
      $("#egp_delete_btn").attr(\'disabled\', true);
    }
    //change value & value_detail
    $("#egp_value_" + box_data[\'object_type\']).val(box_data[\'value\']);
    $("#egp_value_detail_" + box_data[\'object_type\']).val(box_data[\'value_detail\']);
    //change delay & delay_value
    $("#egp_delay").val(box_data[\'delay\']);
    $("#egp_delay_value").val(box_data[\'delay_value\']);
    //change pos of new box
    $("#egp_pos_x").val(box_data[\'pos_x\']);
    $("#egp_pos_y").val(box_data[\'pos_y\']);

    //modal show
    $("#edit_gp_obj").modal(\'show\');
  }
  function saveBox() {
    var right = $("#egp_right").val();
    var object_type = $("#egp_start").val() == 1 ? "start" : $("#egp_object_type").val();

    var box_data = {
      campaignID:   $("#egp_campaignID").val(),
      flowID:       $("#egp_flowID").val(),
      flowOrder:    $("#egp_flowOrder").val(),
      object_type:  object_type,
      title:        $("#egp_title").val(),
      value:        $("#egp_value_" + object_type).val(),
      value_detail: $("#egp_value_detail_" + object_type).val(),
      delay:        $("#egp_delay").val(),
      delay_value:  $("#egp_delay_value").val(),
      parent_cam:   $("#egp_parent_cam").val(),
      path_str:     $("#egp_path_str").val(),
      pos_x:        $("#egp_pos_x").val(),
      pos_y:        $("#egp_pos_y").val(),
    };
    // console.log(box_data);
    editFlows(box_data);
  }
  function deleteBox() {
    var box_data = {
      flowOrder:    $("#egp_flowOrder").val(),
      flowID:       $("#egp_flowID").val(),
    };
    if (confirm(\'Do you want to delete all object below this object?\')) {
      deleteFlows(box_data);
    }
  }
  function getParam(name){
    if(name=(new RegExp(\'[?&]\'+encodeURIComponent(name)+\'=([^&]*)\')).exec(location.search))
        return decodeURIComponent(name[1]);
  }
  function check_condition_value_detail() {
    for (var checker in flows[flow_id]) {
      if (flows[flow_id][checker][\'object_type\'] == "condition") {
        var parent_fo = flows[flow_id][checker][\'flowOrder\'];
        var value_detail = "|";
        for (var yes_no in flows[flow_id]) {
          if (flows[flow_id][yes_no][\'parent_cam\'] == parent_fo) {
            value_detail_array = value_detail.split("|");
            if (flows[flow_id][yes_no][\'path_str\'] == "Yes") {
              value_detail_array[0] = flows[flow_id][yes_no][\'flowOrder\'];
              value_detail = value_detail_array.join("|");
            } else if (flows[flow_id][yes_no][\'path_str\'] == "No") {
              value_detail_array[1] = flows[flow_id][yes_no][\'flowOrder\'];
              value_detail = value_detail_array.join("|");
            }
          };
        }
        flows[flow_id][checker][\'value_detail\'] = value_detail;
        // console.log(flows[flow_id][checker][\'value_detail\']);
      };
    }
  }
  $(document).ready(function () {
    loadDiagram();

    $("#egp_object_type").change(function () {
      var egp_object_type = $("#egp_object_type").val();
      $("#egp_modal").removeClass(\'egp-show-start egp-show-message egp-show-condition\').addClass(\'egp-show-\' + egp_object_type);
    })
  })
</script>
';

require_once 'sections/footer.tpl.php';
 ?>
