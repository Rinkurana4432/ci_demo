  <style type="text/css">
    p, body, td { font-family: Tahoma, Arial, Helvetica, sans-serif; font-size: 10pt; }
    body { padding: 0px; margin: 0px; background-color: #ffffff; }
    a { color: #1155a3; }
    .space { margin: 10px 0px 10px 0px; }
    .header { background: #003267; background: linear-gradient(to right, #011329 0%, #00639e 44%, #011329 100%); padding: 20px 10px; color: white; box-shadow: 0px 0px 10px 5px rgba(0, 0, 0, 0.75); }
    .header a { color: white; }
    .header h1 a { text-decoration: none; }
    .header h1 { padding: 0px; margin: 0px; }
    .main { padding: 10px; margin-top: 10px; }
	.scheduler_default_corner div:nth-of-type(2) {
    display: none !important;
}
.scheduler_default_corner div:nth-of-type(4) {
    display: none !important;
}
.modal-body-content {
    min-height: 500px;
}
 .scheduler_default_main .scheduler_default_cell.scheduler_default_cellparent {
            background-color: #f0f0f0;
        }
/* context menu icons */
.icon:before {
    position: absolute;
    margin-left: 0px;
    margin-top: 3px;
    width: 14px;
    height: 14px;
    content: '';
}

.icon-blue:before { background-color: #1155cc; }
.icon-green:before { background-color: #6aa84f; }
.icon-yellow:before { background-color: #f1c232; }
.icon-red:before { background-color: #cc0000; }
  </style>
<?php $shift_start_column = array_column($Company_shift, 'shift_start');

array_multisort($shift_start_column, SORT_ASC, $Company_shift);

foreach($Company_shift as $shift){
	$total_shift[] = $shift['shift_name'];	
	$shift_start[] = minutes($shift['shift_start']);	
	$shift_end[] = minutes($shift['shift_end']);
	$week_off=json_decode($shift['week_off']);
	//$day_no = date('w', strtotime($week_off[0])); //returns 'Sun';
	$day_no[] = getDay($week_off);
}

//pre($shift_start);pre($shift_end);
$shiftcount=0; $shiftcount = count($total_shift);
if($shiftcount>0){
	$noOfhours = 24/$shiftcount;
}
$workOrdersIds =json_decode($production_report->workorder_ids,true);
$start_date = $production_report->month.'-01';
$m= date('m',strtotime($start_date));
$y= date('Y',strtotime($start_date));
$number = cal_days_in_month(CAL_GREGORIAN, $m, $y); // 31
//echo $number;die;
?>

  <!-- daypilot -->
<div class="x_content" >
	<div class="main">
		<div id="dp"></div>
	</div>
</div>
<script>
var myarray = [];
var result = [];

var dp = new DayPilot.Scheduler("dp", {
    eventHeight: 40,
    cellWidth: 70,
    // startDate: DayPilot.Date.today().firstDayOfWeek(),
    // days: 7,
    scale: "Manual",
    cellDuration: 8,
    timeline: getTimeline(),
    timeHeaders: [{
        groupBy: "Month"
    }, {
        groupBy: "Day"
    }, {
        groupBy: "Cell"
    }],
    treeEnabled: true,
    treePreventParentUsage: true,
    linkBottomMargin: 20,
    jointEventsMove: false,
    jointEventsResize: false,
    onBeforeTimeHeaderRender: function(args) {
        if (args.header.level === 1) {
            var dayOfWeek = args.header.start.getDayOfWeek();

        }

        if (args.header.level === 2) {
            var start = args.header.start;
            $.each(result, function(i, val) {
                //console.log(val);
                for (var prop in val) {
                    if (val[prop] == start) {
                        args.header.html = val['html'];
                        for (var day in val['weekOff']) {
                            var dayOfWeek = start.getDayOfWeek();
                            //console.log(dayOfWeek);
                            if (dayOfWeek == day) {

                                args.header.backColor = "#d0d0d0";
                                args.header.cssClass = "weekend_header";
                            }
                        }
                    }
                }

            });

        }
    },
    onBeforeResHeaderRender: function(args) {
        if (args.resource.children && args.resource.children.length > 0) {
            // args.resource.eventHeight = 30;
        }
    },
    onTimeRangeSelected: function(args) {
        DayPilot.Modal.prompt("Create a new job:", "Job").then(function(modal) {
            var dp = args.control;
            dp.clearSelection();
            if (!modal.result) {
                return;
            }
            var params = {
                start: args.start.toString(),
                end: args.end.toString(),
                text: modal.result,
                resource: args.resource
            };
            $.ajax({
                type: 'POST',
                url: 'backend_events_create.php',
                data: JSON.stringify(params),
                success: function(data) {
                    var list = data.events;
                    list.forEach(function(data) {
                        var e = dp.events.find(data.id);
                        if (e) {
                            e.data.text = text;
                            dp.events.update(e);
                        } else {
                            dp.events.add(new DayPilot.Event(data));
                        }
                    });
                    dp.message("Job created");
                },
                contentType: "application/json",
                dataType: 'json'
            });
        });
    },
    onEventMove: function(args) {
        if (args.areaData === "event-copy") {
            args.preventDefault();

            var params = {
                start: args.newStart.toString(),
                end: args.newEnd.toString(),
                text: args.e.text(),
                resource: args.newResource,
                link: {
                    from: args.e.id()
                }
            };
            $.ajax({
                type: 'POST',
                url: 'backend_events_create.php',
                data: JSON.stringify(params),
                success: function(data) {
                    var list = data.events;
                    list.forEach(function(data) {
                        var e = dp.events.find(data.id);
                        if (e) {
                            e.data.hasNext = data.hasNext;
                            dp.events.update(e);
                        } else {
                            dp.events.add(new DayPilot.Event(data));
                            dp.links.add({
                                from: args.e.id(),
                                to: data.id
                            });
                        }
                    });

                    dp.message("Job created");
                },
                contentType: "application/json",
                dataType: 'json'
            });

        } else {
            var params = {
                id: args.e.id(),
                start: args.newStart.toString(),
                end: args.newEnd.toString(),
                resource: args.newResource
            };
            $.ajax({
                type: 'POST',
                url: 'backend_events_move.php',
                data: JSON.stringify(params),
                success: function(data) {
                    dp.message("Job moved");
                },
                contentType: "application/json",
                dataType: 'json'
            });
        }

    },
    onEventResize: function(args) {
        var params = {
            id: args.e.id(),
            start: args.newStart.toString(),
            end: args.newEnd.toString(),
            resource: args.e.resource()
        };
        $.ajax({
            type: 'POST',
            url: 'backend_events_move.php',
            data: JSON.stringify(params),
            success: function(data) {
                dp.message("Job resized");
            },
            contentType: "application/json",
            dataType: 'json'
        });
    },
    onBeforeEventRender: function(args) {
        args.data.barColor = args.data.color;
        var duration = new DayPilot.Duration(args.data.start, args.data.end);
        //  args.data.html = "<div><b>" + args.data.text + "</b><br>" + duration.toString("h") + " hours</div>";
        args.data.html = "<div><b>" + args.data.text + "</b><br></div>";

        if (args.data.hasNext) {
            return;
        }
        args.data.areas = [{
            right: 2,
            bottom: 2,
            width: 16,
            height: 16,
            backColor: "#fff",
            style: "box-sizing: border-box; border-radius: 7px; padding-left: 3px; border: 1px solid #ccc;font-size: 14px;line-height: 14px;color: #999;",
            html: "&raquo;",
            toolTip: "Drag to schedule next step",
            action: "Move",
            data: "event-copy"
        }];
    },
    onBeforeRowHeaderRender: function(args) {
        var duration = args.row.events.totalDuration();
        var str;
        if (duration.totalDays() >= 1) {
            str = Math.floor(duration.totalHours()) + ":" + duration.toString("mm");
        } else {
            str = duration.toString("H:mm");
        }

        if (args.row.columns[1]) {
            args.row.columns[1].html = str + " hours";
        }
    },
    onEventMoving: function(args) {
        if (args.areaData && args.areaData === "event-copy") {
            args.link = {
                from: args.e,
                color: "#666"
            };
            args.start = args.end.addHours(-1);
            if (args.e.end() > args.start) {
                args.allowed = false;
                args.link.color = "red";
            }
        }
    },
    onEventClick: function(args) {
        DayPilot.Modal.prompt("Task name:", args.e.text()).then(function(modal) {
            if (!modal.result) {
                return;
            }
            var text = modal.result;
            var params = {
                join: args.e.data.join,
                text: text
            };
            $.ajax({
                type: 'POST',
                url: 'backend_events_settext.php',
                data: JSON.stringify(params),
                success: function(data) {
                    var list = data.events;
                    list.forEach(function(data) {
                        var e = dp.events.find(data.id);
                        if (e) {
                            e.data.text = text;
                            dp.events.update(e);
                        }
                    });
                    dp.message("Text updated");
                },
                contentType: "application/json",
                dataType: 'json'
            });
        });
    },
    contextMenu: new DayPilot.Menu({
        items: [{
                text: "Delete",
                onClick: function(args) {
                    var params = {
                        id: args.source.id(),
                    };
                    $.ajax({
                        type: 'POST',
                        url: 'backend_events_delete.php',
                        data: JSON.stringify(params),
                        success: function(data) {
                            data.deleted.forEach(function(id) {
                                dp.events.removeById(id);
                            });
                            data.updated.forEach(function(data) {
                                var e = dp.events.find(data.id);
                                if (e) {
                                    e.data.hasNext = data.hasNext;
                                    dp.events.update(e);
                                }
                            });

                            dp.message("Job deleted");
                        },
                        contentType: "application/json",
                        dataType: 'json'
                    });

                }
            },
            {
                text: "-"
            },
            {
                text: "Blue",
                icon: "icon icon-blue",
                color: "#1155cc",
                onClick: function(args) {
                    updateColor(args.source, args.item.color);
                }
            },
            {
                text: "Green",
                icon: "icon icon-green",
                color: "#6aa84f",
                onClick: function(args) {
                    updateColor(args.source, args.item.color);
                }
            },
            {
                text: "Yellow",
                icon: "icon icon-yellow",
                color: "#f1c232",
                onClick: function(args) {
                    updateColor(args.source, args.item.color);
                }
            },
            {
                text: "Red",
                icon: "icon icon-red",
                color: "#cc0000",
                onClick: function(args) {
                    updateColor(args.source, args.item.color);
                }
            }
        ]
    })
});
dp.init();
dp.rowHeaderColumns = [{
        title: "Machine",
        width: 100
    },
    {
        title: "Total",
        width: 100
    }
];
dp.rows.load(site_url + 'production/backend_resources/<?php echo $production_report->id; ?>');
dp.events.load(site_url + 'production/loadEvents/<?php echo $production_report->id; ?>/');
//  dp.links.load("backend_links.php");

function updateColor(e, color) {
    var params = {
        join: e.data.join,
        color: color
    };
    $.ajax({
        type: 'POST',
        url: 'backend_events_setcolor.php',
        data: JSON.stringify(params),
        success: function(data) {
            var list = data.events;
            list.forEach(function(data) {
                var e = dp.events.find(data.id);
                if (e) {
                    e.data.color = color;
                    dp.events.update(e);
                }
            });
            dp.message("Color updated");
        },
        contentType: "application/json",
        dataType: 'json'
    });
}

function getTimeline() {
    var days = <?php echo $number ?> ;
    // var days = 2;
    var report_date = new DayPilot.Date("<?php echo $start_date ?>");
    report_date.toString("M/d/yyyy HH:mm")
    var firstDayOfMonth = DayPilot.Date(report_date).firstDayOfMonth();

    //  dp.timeline = [];

    for (var i = 0; i < days; i++) {
        var day = firstDayOfMonth.addDays(i);
        var shiftcount = <?php  echo $shiftcount; ?> ;
        var noOfhours = <?php  echo $noOfhours; ?> ;
        var start_time = 0;
        var end_time = noOfhours;
        var shift_name = {};
        var shift_name = <?php  echo json_encode($total_shift); ?> ;
        var shift_start = <?php  echo json_encode($shift_start); ?> ;
        var shift_end = <?php  echo json_encode($shift_end); ?> ;
        var day_no = <?php  echo json_encode($day_no); ?> ;
        for (var j = 0; j < shiftcount; j++) {
            result.push({
                start: day.addMinutes(shift_start[j]),
                end: day.addMinutes(shift_end[j]),
                text: shift_name[j],
                html: shift_name[j],
                weekOff: day_no[j]
            });
            start_time = end_time;
            end_time = end_time + noOfhours;
        }

    }
    //console.log(result);
    return result;
}
</script>