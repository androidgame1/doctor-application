<script>
//
$(document).ready(function () {
    !function ($) {
        "use strict";
        var CalendarApp = function () {
            this.$body = $("body")
            this.$calendar = $('#calendar'),
                    this.$event = ('#calendar-events div.calendar-events'),
                    this.$categoryForm = $('#add-new-event form'),
                    this.$extEvents = $('#calendar-events'),
                    this.$modal = $('#my-event'),
                    this.$saveCategoryBtn = $('.save-category'),
                    this.$calendarObj = null
        };
        /* on drop */
        CalendarApp.prototype.onDrop = function (eventObj, date) {
            var $this = this;
            // retrieve the dropped element's stored Event Object
            var originalEventObject = eventObj.data('eventObject');
            var $categoryClass = eventObj.attr('data-class');
            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);
            // assign it the date that was reported
            copiedEventObject.start = date;
            if ($categoryClass)
                copiedEventObject['className'] = [$categoryClass];
            // render the event on the calendar
            $this.$calendar.fullCalendar('renderEvent', copiedEventObject, true);
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                eventObj.remove();
            }
        },
                /* on click on event */
                CalendarApp.prototype.onEventClick = function (calEvent, jsEvent, view) {
                    var $this = this;
                    var form = $("<form></form>");
                    form.append("<label>Change event name</label>");
                    form.append("<div class='input-group'><input class='form-control' type=text value='" + calEvent.title + "' /><span class='input-group-btn'><button type='submit' class='btn btn-success waves-effect waves-light'><i class='fa fa-check'></i> Save</button></span></div>");
                    $this.$modal.modal({
                        backdrop: 'static'
                    });
                    $this.$modal.find('.delete-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.delete-event').unbind('click').click(function () {
                        $this.$calendarObj.fullCalendar('removeEvents', function (ev) {
                            return (ev._id == calEvent._id);
                        });
                        $this.$modal.modal('hide');
                    });
                    $this.$modal.find('form').on('submit', function () {
                        calEvent.title = form.find("input[type=text]").val();
                        $this.$calendarObj.fullCalendar('updateEvent', calEvent);
                        $this.$modal.modal('hide');
                        return false;
                    });
                },
                /* on select */
                CalendarApp.prototype.onSelect = function (start, end, allDay) {
                    var $this = this;
                    $this.$modal.modal({
                        backdrop: 'static'
                    });
                    var form = $("<form></form>");
                    form.append("<div class='row'></div>");
                    form.find(".row")
                            .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Event Name</label><input class='form-control' placeholder='Insert Event Name' type='text' name='title'/></div></div>")
                            .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Category</label><select class='form-control' name='category'></select></div></div>")
                            .find("select[name='category']")
                            .append("<option value='bg-danger'>Danger</option>")
                            .append("<option value='bg-success'>Success</option>")
                            .append("<option value='bg-purple'>Purple</option>")
                            .append("<option value='bg-primary'>Primary</option>")
                            .append("<option value='bg-pink'>Pink</option>")
                            .append("<option value='bg-info'>Info</option>")
                            .append("<option value='bg-warning'>Warning</option></div></div>");
                    $this.$modal.find('.delete-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').click(function () {
                        form.submit();
                    });
                    $this.$modal.find('form').on('submit', function () {
                        var title = form.find("input[name='title']").val();
                        var beginning = form.find("input[name='beginning']").val();
                        var ending = form.find("input[name='ending']").val();
                        var categoryClass = form.find("select[name='category'] option:checked").val();
                        if (title !== null && title.length != 0) {
                            $this.$calendarObj.fullCalendar('renderEvent', {
                                title: title,
                                start: start,
                                end: end,
                                allDay: false,
                                className: categoryClass
                            }, true);
                            $this.$modal.modal('hide');
                        } else {
                            alert('You have to give a title to your event');
                        }
                        return false;
                    });
                    $this.$calendarObj.fullCalendar('unselect');
                },
                CalendarApp.prototype.enableDrag = function () {
                    //init events
                    $(this.$event).each(function () {
                        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                        // it doesn't need to have a start or end
                        var eventObject = {
                            title: $.trim($(this).text()) // use the element's text as the event title
                        };
                        // store the Event Object in the DOM element so we can get to it later
                        $(this).data('eventObject', eventObject);
                        // make the event draggable using jQuery UI
                        $(this).draggable({
                            zIndex: 999,
                            revert: true, // will cause the event to go back to its
                            revertDuration: 0  //  original position after the drag
                        });
                    });
                }
        /* Initializing */
        CalendarApp.prototype.init = function () {
            this.enableDrag();
            /*  Initialize the calendar  */
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var form = '';
            var today = new Date($.now());
            var $this = this;
            $this.$calendarObj = $this.$calendar.fullCalendar({
                lang: 'fr',
                slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
                minTime: "09:00:00",
                maxTime: "19:00:00",
                defaultView: 'agendaWeek',
                locale: 'fr',
                defaultDate: moment(),
//                timeFormat: 'hh(:mm)' ,
                handleWindowResize: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                }, buttonText: {
                    // today: 'Aujourd\'hui',
                    // month: 'Mois',
                    // week: 'Semaine',
                    // day: 'Jour',
                    // list: 'Liste',
                }, allDayText: 'Jours',
				


                events: function(start, end, timezone, callback) {
					let url = ""
					@if(auth()->user()->is_administrator)
						url = "{{route('administrator.appointments','calendar')}}";
					@elseif(auth()->user()->is_secretary)
						url = "{{route('secretary.appointments','calendar')}}";
					@endif
					$.ajax({
						url: url,
						data: {},
						success: function(data) {
							let appointments = data.appointments
							let events = [];
                            appointments.forEach(appointment => {
                                let data_url_edit = ""
                                let data_url_update = ""
                                let data_url_drop_or_resize = ""
                                @if(auth()->user()->is_administrator)
                                    data_url_edit = "{{route('administrator.appointment.edit','id')}}".replace('id',appointment.id);
                                    data_url_update = "{{route('administrator.appointment.update','id')}}".replace('id',appointment.id);
                                    data_url_drop_or_resize = "{{route('administrator.appointment.drop_or_resize','id')}}".replace('id',appointment.id);
                                @elseif(auth()->user()->is_secretary)
                                    data_url_edit = "{{route('secretary.appointment.edit','id')}}".replace('id',appointment.id);
                                    data_url_update = "{{route('secretary.appointment.update','id')}}".replace('id',appointment.id);
                                    data_url_drop_or_resize = "{{route('secretary.appointment.drop_or_resize','id')}}".replace('id',appointment.id);
                                @endif
                                events.push({
                                    id: appointment.id,
									title: appointment.patient.fullname,
                                    remark: appointment.remark,
                                    color: appointment.status.color,
                                    secretary:appointment.secretary,
									start: appointment.start_date,
                                    end: appointment.end_date,
                                    data_url_edit:data_url_edit,
                                    data_url_update:data_url_update,
                                    data_url_drop_or_resize:data_url_drop_or_resize
								});
                                
                                
                                
                            });
							callback(events);
						},error: function(xhr, ajaxOptions, thrownError) {
                            console.log(xhr)
                            console.log(ajaxOptions)
                            console.log(thrownError)
                        }
					});
				},

                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                eventLimit: true, // allow "more" link when too many events
                selectable: true,
                drop: function (date) {
                    $this.onDrop($(this), date);
                },
                select: function (start, end, allDay) {
					$("input[name='start_date']").val(moment(start).format('YYYY-MM-DD HH:mm:ss'))
					$("input[name='end_date']").val(moment(end).format('YYYY-MM-DD HH:mm:ss'))
                    $("#div-create-new-appointment.modal").modal()
                },
                eventClick: function (event) {
                    let id = event.id
                    let data_url_edit = event.data_url_edit
                    let data_url_update = event.data_url_update
                    $.ajax({
                        method:'get',
                        url:data_url_edit,
                        data:{},
                        success:function(data){
                            let icon = data.icon
                            let appointment = data.appointment
                            if(icon == 'success'){
                                $("select[name='patient_id']").val(appointment.patient_id)
                                $("select[name='status_id']").val(appointment.status_id)
                                $("input[name='start_date']").val(appointment.start_date)
                                $("input[name='end_date']").val(appointment.end_date)
                                $("textarea[name='remark']").val(appointment.remark)
                                $("#form-edit-old-appointment").attr('action',data_url_update)
                                let path = "{{route('administrator.patient.show','value')}}".replace('value',appointment.patient.id)
                                $(".btn-appointments-target").attr('href',path+'#patient_appointments')
                                $(".btn-quotes-target").attr('href',path+'#patient_quotes')
                                $(".btn-activities-target").attr('href',path+'#patient_activities')
                                $(".btn-sale-invoices-target").attr('href',path+'#patient_sale_invoices')
                                $("#div-edit-old-appointment").modal()
                            }else{
                                console.log("There is a problem in appointment edition !")
                            }
                        },error: function(xhr, ajaxOptions, thrownError) {
                            console.log(xhr)
                            console.log(ajaxOptions)
                            console.log(thrownError)
                        }
                    })
                }, eventDrop: function (event){
                    let id = event.id
                    let start_date = moment(event.start).format('YYYY-MM-DD HH:mm:ss')
                    let end_date = moment(event.end).format('YYYY-MM-DD HH:mm:ss')
                    let data_url_drop_or_resize = event.data_url_drop_or_resize
                    let data_url_edit = event.data_url_edit
                    let _method = "post"
                    let _token = $("meta[name='csrf-token']").attr('content')
                    @if(auth()->user()->is_secretary)
                        let secretary_id = "{{auth()->user()->id}}"
                        if([undefined,null,""].includes(event.secretary) || event.secretary.id != secretary_id){
                            return;
                        }
                    @endif
                    $.ajax({
                        type:'post',
                        url:data_url_drop_or_resize,
                        data:{_token:_token,_method:_method,start_date:start_date,end_date:end_date},
                        success:function(data){
                            let icon = data.icon
                            let message = data.message
                            if(icon == "success" || icon == "warning" || icon == "error"){
                                console.log(message)
                            }else {
                                console.log("The is a problem")
                            }
                        },error: function(xhr, ajaxOptions, thrownError) {
                            console.log(xhr)
                            console.log(ajaxOptions)
                            console.log(thrownError)
                        }
                    })
                },
                eventResize: function (event)
                {
                    let id = event.id
                    let start_date = moment(event.start).format('YYYY-MM-DD HH:mm:ss')
                    let end_date = moment(event.end).format('YYYY-MM-DD HH:mm:ss')
                    let data_url_drop_or_resize = event.data_url_drop_or_resize
                    let data_url_edit = event.data_url_edit
                    let _method = "post"
                    let _token = $("meta[name='csrf-token']").attr('content')
                    @if(auth()->user()->is_secretary)
                        let secretary_id = "{{auth()->user()->id}}"
                        if([undefined,null,""].includes(event.secretary) || event.secretary.id != secretary_id){
                            return;
                        }
                    @endif
                    $.ajax({
                        type:'post',
                        url:data_url_drop_or_resize,
                        data:{_token:_token,_method:_method,start_date:start_date,end_date:end_date},
                        success:function(data){
                            let icon = data.icon
                            let message = data.message
                            if(icon == "success" || icon == "warning" || icon == "error"){
                                console.log(message)
                            }else {
                                console.log("The is a problem")
                            }
                        },error: function(xhr, ajaxOptions, thrownError) {
                            console.log(xhr)
                            console.log(ajaxOptions)
                            console.log(thrownError)
                        }
                    })
                },
                eventMouseover: function(calEvent, jsEvent) {
                    let secretary = ""
                    let remark = ""
                    let message = ""
                    @if(auth()->user()->is_administrator)
                        if(![undefined,null,""].includes(calEvent.secretary)){
                            secretary ='<p class="m-0 p-0"><span class="text-success">{{__("messages.secretary")}}</span> : '+ calEvent.secretary.fullname + '</p>'
                        }
                    @elseif(auth()->user()->is_secretary)
                        let secretary_id = "{{auth()->user()->id}}"
                        if(![undefined,null,""].includes(calEvent.secretary) && calEvent.secretary.id == secretary_id){
                            secretary ='<p class="m-0 p-0"><span class="text-success">{{__("messages.secretary")}}</span> : {{__("messages.me")}}</p>'
                            message = '<p class="text-success mt-2">{{__("messages.you_can_edit_this_appointment")}}</p>'
                        }else{
                            message = '<p class="text-danger mt-2">{{__("messages.you_can_not_edit_this_appointment")}}</p>'
                        }
                    @endif
                    if(![undefined,null,""].includes(calEvent.remark)){
                        remark='<p class="m-0 p-0"><span class="text-success">{{__("messages.remark")}}</span> : '+ calEvent.remark + '</p>'
                    }
                    var tooltip = '<div class="tooltipevent">' +
                    secretary+
                    '<p class="m-0 p-0"><span class="text-success">{{__("messages.patient")}}</span> : '+ calEvent.title + '</p>'+
                    remark+
                    message+
                    '</div>';
                    var $tooltip = $(tooltip).appendTo('body');

                    $(this).mouseover(function(e) {
                        $(this).css('z-index', 10000);
                        $tooltip.fadeIn('500');
                        $tooltip.fadeTo('10', 1.9);
                    }).mousemove(function(e) {
                        $tooltip.css('top', e.pageY + 10);
                        $tooltip.css('left', e.pageX + 20);
                    });
                },

                eventMouseout: function(calEvent, jsEvent) {
                    $(this).css('z-index', 8);
                    $('.tooltipevent').remove();
                }
            });
            //on new event
            this.$saveCategoryBtn.on('click', function () {
                var categoryName = $this.$categoryForm.find("input[name='category-name']").val();
                var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();
                if (categoryName !== null && categoryName.length != 0) {
                    $this.$extEvents.append('<div class="calendar-events" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="fa fa-circle text-' + categoryColor + '"></i>' + categoryName + '</div>')
                    $this.enableDrag();
                }

            });
        },
                //init CalendarApp
                $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp

    }(window.jQuery),
//initializing CalendarApp
            function ($) {
                "use strict";
                $.CalendarApp.init()
            }(window.jQuery);
})
</script>