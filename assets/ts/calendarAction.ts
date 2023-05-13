import Calendar, { ISchedule } from "tui-calendar"; /* ES6 */
import "../../node_modules/tui-calendar/dist/tui-calendar.css";

// If you use the default popups, use this.
import "../../node_modules/tui-date-picker/dist/tui-date-picker.css";
import "../../node_modules/tui-time-picker/dist/tui-time-picker.css";

let jaune = "#edb20c";
let turquoise = "#18edb1";

// Get the modal
var modal = document.getElementById("myModal");
// Get the button that opens the modal
var addScheduleBtn = document.getElementById("addSchedule");
// Get the button that closes the modal
var closePopupBtn = document.getElementById("cancelModal");

var scheduleTitle = document.getElementById("calendar_titre");
var scheduleContent = document.getElementById("calendar_description");

var startChoiceMonth = document.getElementById("calendar_debut_date_month");
var startChoiceYear = document.getElementById("calendar_debut_date_year");
var startChoiceDay = document.getElementById("calendar_debut_date_day");
var startChoiceHour = document.getElementById("calendar_debut_time_hour");
var startChoiceMinute = document.getElementById("calendar_debut_time_minute");

var endChoiceMonth = document.getElementById("calendar_fin_date_month");
var endChoiceYear = document.getElementById("calendar_fin_date_year");
var endChoiceDay = document.getElementById("calendar_fin_date_day");
var endChoiceHour = document.getElementById("calendar_fin_time_hour");
var endChoiceMinute = document.getElementById("calendar_fin_time_minute");

var createBtn = document.getElementById("calendar_add");
var deleteBtn = document.getElementById("calendar_delete");
var updateBtn = document.getElementById("calendar_update");
var hiddenId = document.getElementById("calendar_id");

let calendarData = JSON.parse(
  (document.getElementById("calendarData") as HTMLElement).innerHTML
);
let userId = (
  document.getElementById("calendarData") as HTMLElement
).getAttribute("data-userId");

// When the user clicks on the button, open the modal
(addScheduleBtn as HTMLElement).onclick = function () {
  (modal as HTMLElement).style.display = "block";
  showCreateBtn(true);
};
// When the user clicks on <span> (x), close the modal
(closePopupBtn as HTMLElement).onclick = function () {
  (modal as HTMLElement).style.display = "none";
};
// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event: Event) {
  if (event.target == modal) {
    (modal as HTMLElement).style.display = "none";
  }
};

var calendar = new Calendar("#calendar", {
  useCreationPopup: false,
  useDetailPopup: true,
  defaultView: "month",
  taskView: true,
  template: {
    popupDetailDate: function (_isAllDay, start, end) {
      if (
        (start as Date).getDate() == (end as Date).getDate() &&
        (start as Date).getMonth() == (end as Date).getMonth()
      ) {
        return `de ${new Intl.DateTimeFormat("fr-FR", {
          timeStyle: "medium",
        }).format(start as Date)} à ${new Intl.DateTimeFormat("fr-FR", {
          timeStyle: "medium",
        }).format(end as Date)}`;
      } else {
        return `du ${new Intl.DateTimeFormat("fr-FR", {
          dateStyle: "medium",
          timeStyle: "short",
        }).format(start as Date)} au ${new Intl.DateTimeFormat("fr-FR", {
          dateStyle: "medium",
          timeStyle: "short",
        }).format(end as Date)}`;
      }
    },
  },
  month: {
    daynames: [
      "Dimanche",
      "Lundi",
      "Mardi",
      "Mercredi",
      "Jeudi",
      "Vendredi",
      "Samedi",
    ],
    visibleWeeksCount: 3,

    startDayOfWeek: 1, // monday
  },

  week: {
    daynames: [
      "Dimanche",
      "Lundi",
      "Mardi",
      "Mercredi",
      "Jeudi",
      "Vendredi",
      "Samedi",
    ],
    startDayOfWeek: 1,
  },
});
//calendar.today();

let schedules: ISchedule[] = [];
let startDate: Date;
let endDate: Date;

if (typeof calendarData === "string") {
  calendarData = JSON.parse(calendarData);
}
if (typeof calendarData === "object") {
  calendarData.forEach(
    (element: {
      debut: string | number | Date;
      fin: string | number | Date;
      id: any;
      titre: any;
      description: any;
      detenteur_id: string | null;
    }) => {
      startDate = new Date(element.debut);
      endDate = new Date(element.fin);
      schedules.push({
        id: element.id,
        calendarId: "1",
        title: element.titre,
        body: element.description,
        category: "time",
        start: startDate,
        end: endDate,
        isReadOnly: true,
        bgColor: userId == element.detenteur_id ? turquoise : jaune,
        borderColor: userId == element.detenteur_id ? turquoise : jaune,
      });
    }
  );

  calendar.createSchedules(schedules);
}

var lastClickSchedule: { id: string; calendarId: string };

calendar.on("clickSchedule", function (event: any) {
  var schedule = event.schedule;
  if (lastClickSchedule) {
    if (schedule.bgColor === turquoise && lastClickSchedule == schedule) {
      showCreateBtn(false);
      (scheduleTitle as HTMLInputElement).value = schedule.title;
      (scheduleContent as HTMLInputElement).value = schedule.body;
      (hiddenId as HTMLInputElement).value = schedule.id;

      (startChoiceDay as any).selectedIndex = schedule.start.getDate();
      (startChoiceMonth as any).selectedIndex = schedule.start.getMonth();
      (startChoiceYear as any).selectedIndex =
        schedule.start.getFullYear() - new Date().getFullYear();
      (startChoiceHour as any).selectedIndex = schedule.start.getHours();
      (startChoiceMinute as any).selectedIndex = schedule.start.getMinutes();

      (endChoiceDay as any).selectedIndex = schedule.end.getDate();
      (endChoiceMonth as any).selectedIndex = schedule.end.getMonth();
      (endChoiceYear as any).selectedIndex =
        schedule.end.getFullYear() - new Date().getFullYear();
      (endChoiceHour as any).selectedIndex = schedule.end.getHours();
      (endChoiceMinute as any).selectedIndex = schedule.end.getMinutes();
      (modal as HTMLElement).style.display = "block";
    } else {
      // unfocus previous schedule
      calendar.updateSchedule(
        lastClickSchedule.id,
        lastClickSchedule.calendarId,
        {
          isFocused: false,
        }
      );
    }
  }

  // focus the schedule
  calendar.updateSchedule(schedule.id, schedule.calendarId, {
    isFocused: true,
  });

  lastClickSchedule = schedule;

  // open detail view
});

calendar.on("beforeCreateSchedule", function (event) {
  var startTime = event.start;

  (startChoiceDay as any).selectedIndex = startTime._date.getDate() - 1;
  (startChoiceMonth as any).selectedIndex = startTime._date.getMonth();
  (startChoiceYear as any).selectedIndex =
    startTime._date.getFullYear() - new Date().getFullYear();
  (startChoiceHour as any).selectedIndex = 17;

  (endChoiceDay as any).selectedIndex = (startChoiceDay as any).selectedIndex;
  (endChoiceMonth as any).selectedIndex = (
    startChoiceMonth as any
  ).selectedIndex;
  (endChoiceYear as any).selectedIndex = (startChoiceYear as any).selectedIndex;
  (endChoiceHour as any).selectedIndex =
    (startChoiceHour as any).selectedIndex + 2;

  (modal as HTMLElement).style.display = "block";
  showCreateBtn(true);
  event.guide.clearGuideElement();
});
function showCreateBtn(bool: boolean) {
  (createBtn as HTMLElement).hidden = !bool;
  (deleteBtn as HTMLElement).hidden = bool;
  (updateBtn as HTMLElement).hidden = bool;
}
