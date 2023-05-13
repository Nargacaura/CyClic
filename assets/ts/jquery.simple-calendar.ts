import jQuery from "jquery";

// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
(function ($, _window, _document, _undefined) {
  "use strict";

  // Create the defaults once
  var pluginName = "simpleCalendar",
    defaults = {
      months: [
        "january",
        "february",
        "march",
        "april",
        "may",
        "june",
        "july",
        "august",
        "september",
        "october",
        "november",
        "december",
      ], //string of months starting from january
      days: [
        "sunday",
        "monday",
        "tuesday",
        "wednesday",
        "thursday",
        "friday",
        "saturday",
      ], //string of days starting from sunday
      displayYear: true, // display year in header
      fixedStartDay: true, // Week begin always by monday or by day set by number 0 = sunday, 7 = saturday, false = month always begin by first day of the month
      displayEvent: true, // display existing event
      disableEventDetails: false, // disable showing event details
      disableEmptyDetails: false, // disable showing empty date details
      events: [], // List of event
      onInit: function (_calendar: any) {}, // Callback after first initialization
      onMonthChange: function (_month: any, _year: any) {}, // Callback on month change
      onDateSelect: function (_date: any, _events: any) {}, // Callback on date selection
      onEventSelect: function () {}, // Callback fired when an event is selected     - see $(this).data('event')
      onEventCreate: function (_$el: any) {}, // Callback fired when an HTML event is created - see $(this).data('event')
      onDayCreate: function (_$el: any, _d: any, _m: any, _y: any) {}, // Callback fired when an HTML day is created   - see $(this).data('today'), .data('todayEvents')
    };

  // The actual plugin constructor
  class Plugin {
    constructor(element: any, options: any) {
      (this as any).element = element;
      (this as any).settings = $.extend({}, defaults, options);
      (this as any)._defaults = defaults;
      (this as any)._name = pluginName;
      (this as any).currentDate = new Date();
      (this as any).init();
    }
  }

  // Avoid Plugin.prototype conflicts
  $.extend(Plugin.prototype, {
    init: function () {
      var container = $(this.element);
      var todayDate = this.currentDate;

      var calendar = $('<div class="calendar"></div>');
      var header = $(
        `<header><h2 class="month"></h2><a class="simple-calendar-btn btn-prev" href="#"></a><a class="simple-calendar-btn btn-next" href="#"></a></header>`
      );

      this.updateHeader(todayDate, header);
      calendar.append(header);

      this.buildCalendar(todayDate, calendar);
      container.append(calendar);

      this.bindEvents();
      this.settings.onInit(this);
    },

    //Update the current month header
    updateHeader: function (
      date: { getMonth: () => string | number; getFullYear: () => string },
      header: {
        find: (arg0: string) => {
          (): any;
          new (): any;
          html: { (arg0: any): void; new (): any };
        };
      }
    ) {
      var monthText = this.settings.months[date.getMonth()];
      monthText += this.settings.displayYear
        ? ' <div class="year">' + date.getFullYear()
        : "</div>";
      header.find(".month").html(monthText);
    },

    //Build calendar of a month from date
    buildCalendar: function (
      fromDate: { getFullYear: () => any; getMonth: () => number },
      calendar: {
        find: (arg0: string) => {
          (): any;
          new (): any;
          remove: { (): void; new (): any };
        };
        append: (arg0: JQuery<HTMLElement>) => void;
      }
    ) {
      var plugin = this;

      calendar.find("table").remove();

      var body = $("<table></table>");
      var thead = $("<thead></thead>");
      var tbody = $("<tbody></tbody>");

      //setting current year and month
      var y = fromDate.getFullYear(),
        m = fromDate.getMonth();

      //first day of the month
      var firstDay = new Date(y, m, 1);
      //last day of the month
      var lastDay = new Date(y, m + 1, 0);
      // Start day of weeks
      var startDayOfWeek = firstDay.getDay();

      if (this.settings.fixedStartDay !== false) {
        // Backward compatibility
        startDayOfWeek =
          this.settings.fixedStartDay === true
            ? 1
            : this.settings.fixedStartDay;

        // If first day of month is different of startDayOfWeek
        while (firstDay.getDay() !== startDayOfWeek) {
          firstDay.setDate(firstDay.getDate() - 1);
        }
        // If last day of month is different of startDayOfWeek + 7
        while (lastDay.getDay() !== (startDayOfWeek + 6) % 7) {
          lastDay.setDate(lastDay.getDate() + 1);
        }
      }

      //Header day in a week ( (x to x + 7) % 7 to start the week by monday if x = 1)
      for (var i = startDayOfWeek; i < startDayOfWeek + 7; i++) {
        thead.append(
          $(`<td>${this.settings.days[i % 7].substring(0, 3)}</td>`)
        );
      }

      //For firstDay to lastDay
      for (var day = firstDay; day <= lastDay; day.setDate(day.getDate())) {
        var tr = $("<tr></tr>");
        //For each row
        for (var i = 0; i < 7; i++) {
          var td = $(
            '<td><div class="day" data-date="' +
              day.toISOString() +
              '">' +
              day.getDate() +
              "</div></td>"
          );

          var $day = td.find(".day");

          //if today is this day
          if (day.toDateString() === new Date().toDateString()) {
            $day.addClass("today");
          }

          //if day is not in this month
          if (day.getMonth() != fromDate.getMonth()) {
            $day.addClass("wrong-month");
          }

          // filter today's events
          var todayEvents = plugin.getDateEvents(day);

          if (todayEvents.length && plugin.settings.displayEvent) {
            $day.addClass(
              plugin.settings.disableEventDetails
                ? "has-event disabled"
                : "has-event"
            );
          } else {
            $day.addClass(
              plugin.settings.disableEmptyDetails ? "disabled" : ""
            );
          }

          // associate some data available from the onDayCreate callback
          $day.data("todayEvents", todayEvents);

          // simplify further customization
          this.settings.onDayCreate($day, day.getDate(), m, y);

          tr.append(td);
          day.setDate(day.getDate() + 1);
        }
        tbody.append(tr);
      }

      body.append(thead);
      body.append(tbody);

      var eventContainer = $(
        '<div class="event-container"><div class="close"></div><div class="event-wrapper"></div></div>'
      );

      calendar.append(body);
      calendar.append(eventContainer);
    },
    changeMonth: function (value: any) {
      this.currentDate.setMonth(this.currentDate.getMonth() + value, 1);
      this.buildCalendar(this.currentDate, $(this.element).find(".calendar"));
      this.updateHeader(
        this.currentDate,
        $(this.element).find(".calendar header")
      );
      this.settings.onMonthChange(
        this.currentDate.getMonth(),
        this.currentDate.getFullYear()
      );
    },
    //Init global events listeners
    bindEvents: function () {
      var plugin = this;

      //Remove previously created events
      $(plugin.element).off();

      //Click previous month
      $(plugin.element).on("click", ".btn-prev", function (e) {
        plugin.changeMonth(-1);
        e.preventDefault();
      });

      //Click next month
      $(plugin.element).on("click", ".btn-next", function (e) {
        plugin.changeMonth(1);
        e.preventDefault();
      });

      //Binding day event
      $(plugin.element).on("click", ".day", function (e) {
        var date = new Date($(this).data("date"));
        var events = plugin.getDateEvents(date);
        if (!$(this).hasClass("disabled")) {
          plugin.fillUp(e.pageX, e.pageY);
          plugin.displayEvents(events);
        }
        plugin.settings.onDateSelect(date, events);
      });

      //Binding event container close
      $(plugin.element).on("click", ".event-container .close", function (e) {
        plugin.empty(e.pageX, e.pageY);
      });
    },
    displayEvents: function (events: any[]) {
      var plugin = this;
      var container = $(this.element).find(".event-wrapper");

      events.forEach(function (event: any) {
        var startDate = new Date(event.startDate);
        var endDate = new Date(event.endDate);
        var $event = $(
          `<div class="event"> <div class="event-hour">${startDate.getHours()}:${
            startDate.getMinutes() < 10 ? "0" : ""
          }${startDate.getMinutes()}</div> <div class="event-date">${plugin.formatDateEvent(
            startDate,
            endDate
          )}</div> <div class="event-summary">${event.summary}</div></div>`
        );

        $event.data("event", event);
        $event.on("click", plugin.settings.onEventSelect);

        // simplify further customization
        plugin.settings.onEventCreate($event);

        container.append($event);
      });
    },
    addEvent: function (newEvent: any) {
      var plugin = this;
      // add the new event to events list
      plugin.settings.events = [...plugin.settings.events, newEvent];
      this.buildCalendar(this.currentDate, $(this.element).find(".calendar"));
    },
    setEvents: function (newEvents: any) {
      var plugin = this;
      // add the new event to events list
      plugin.settings.events = newEvents;
      this.buildCalendar(this.currentDate, $(this.element).find(".calendar"));
    },
    //Small effect to fillup a container
    fillUp: function (x: number, y: number) {
      var plugin = this;
      var elem = $(plugin.element);
      var elemOffset = elem.offset();

      var filler = $('<div class="filler" style=""></div>');
      filler.css("left", x - (elemOffset as JQueryCoordinates).left);
      filler.css("top", y - (elemOffset as JQueryCoordinates).top);

      elem.find(".calendar").append(filler);

      filler.animate(
        {
          width: "300%",
          height: "300%",
        },
        500,
        function () {
          elem.find(".event-container").show();
          filler.hide();
        }
      );
    },
    //Small effect to empty a container
    empty: function (_x: any, _y: any) {
      var plugin = this;
      var elem = $(plugin.element);

      var filler = elem.find(".filler");
      filler.css("width", "300%");
      filler.css("height", "300%");

      filler.show();

      elem.find(".event-container").hide().find(".event").remove();

      filler.animate(
        {
          width: "0%",
          height: "0%",
        },
        500,
        function () {
          filler.remove();
        }
      );
    },
    getDateEvents: function (d: string | number | Date) {
      var plugin = this;
      return plugin.settings.events.filter(function (event: {
        startDate: string | number | Date;
        endDate: string | number | Date;
      }) {
        return plugin.isDayBetween(
          new Date(d),
          new Date(event.startDate),
          new Date(event.endDate)
        );
      });
    },
    isDayBetween: function (d: Date, dStart: Date, dEnd: Date) {
      dStart.setHours(0, 0, 0);
      dEnd.setHours(23, 59, 59, 999);
      d.setHours(12, 0, 0);

      return dStart <= d && d <= dEnd;
    },
    formatDateEvent: function (
      dateStart: {
        getDay: () => string | number;
        getDate: () => string;
        getMonth: () => string | number;
      },
      dateEnd: { getDate: () => string; getMonth: () => string | number }
    ) {
      var formatted = `${
        this.settings.days[dateStart.getDay()]
      } - ${dateStart.getDate()} ${this.settings.months[
        dateStart.getMonth()
      ].substring(0, 3)}`;

      if (dateEnd.getDate() !== dateStart.getDate()) {
        formatted += ` to ${dateEnd.getDate()} ${this.settings.months[
          dateEnd.getMonth()
        ].substring(0, 3)}`;
      }
      return formatted;
    },
  });

  // A really lightweight plugin wrapper around the constructor,
  // preventing against multiple instantiations
  $.fn[pluginName] = function (options: any) {
    return this.each(function () {
      if (!$.data(this, `plugin_${pluginName}`)) {
        $.data(this, `plugin_${pluginName}`, new Plugin(this, options));
      }
    });
  };
})(jQuery, window, document);
