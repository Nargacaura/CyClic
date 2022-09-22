
import Calendar from 'tui-calendar'; /* ES6 */
import "../../node_modules/tui-calendar/dist/tui-calendar.css";

// If you use the default popups, use this.
import '../../node_modules/tui-date-picker/dist/tui-date-picker.css';
import '../../node_modules/tui-time-picker/dist/tui-time-picker.css';


let jaune = "#edb20c";
let turquoise = "#18edb1";
let bleu = "#1844ed";
let orange = "#ee7c01";
let rouge = "#ed3f0c";

// Get the modal
var modal = document.getElementById("myModal");
// Get the button that opens the modal
var addScheduleBtn = document.getElementById("addSchedule");
// Get the button that closes the modal
var closePopupBtn = document.getElementById("cancelModal");

// var toggleHelp = document.getElementById("helpBtn");
// var helpContent = document.getElementById("calendarHelp");


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
var updateBtn= document.getElementById("calendar_update");
var hiddenId = document.getElementById("calendar_id");


let calendarData = JSON.parse(document.getElementById("calendarData").innerHTML);
let userId = document.getElementById("calendarData").getAttribute("data-userId");


// When the user clicks on the button, open the modal
addScheduleBtn.onclick = function() {
  modal.style.display = "block";
  showCreateBtn(true);
}
// When the user clicks on <span> (x), close the modal
closePopupBtn.onclick = function() {
  modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
} 
// toggleHelp.onclick = function() {
//     helpContent.hidden = !helpContent.hidden;
// }

var calendar = new Calendar('#calendar', {
    
    useCreationPopup: false,
    useDetailPopup: true,
    defaultView: 'month',
    taskView: true,
    template: {
        popupDetailDate: function(isAllDay, start, end) {
            if(start.getDate() == end.getDate() && start.getMonth() == end.getMonth()){
                return "de " +  new Intl.DateTimeFormat('fr-FR', { timeStyle: 'medium' }).format(start)
                        + " à " +  new Intl.DateTimeFormat('fr-FR', { timeStyle: 'medium' }).format(end);
            }
            else{
                return "du " +  new Intl.DateTimeFormat('fr-FR', { dateStyle: 'medium', timeStyle: 'short' }).format(start)
                        + " au " +  new Intl.DateTimeFormat('fr-FR', { dateStyle: 'medium', timeStyle: 'short' }).format(end);
            }
        },
    },
    month: {
        daynames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi' ],
        visibleWeeksCount: 3,
        
        startDayOfWeek: 1, // monday
    },
    
    week: {
        daynames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi' ],
        startDayOfWeek: 1
    }
});
//calendar.today();


let schedules = [];
let startDate;
let endDate;

if(typeof calendarData === "string" ){
    calendarData = JSON.parse(calendarData);
}
if(typeof calendarData === "object" ){
    calendarData.forEach(element => {
        startDate = new Date(element.debut);
        endDate = new Date(element.fin);
        schedules.push({
            id: element.id,
            calendarId: '1',
            title: element.titre,
            body: element.description,
            category: 'time',
            start: startDate,
            end: endDate,
            isReadOnly: true,
            bgColor: userId == element.detenteur_id ? turquoise : jaune,
            borderColor : userId == element.detenteur_id ? turquoise : jaune
        });
    });
    
    calendar.createSchedules(schedules);    

}

var lastClickSchedule;
calendar.on('clickSchedule', function(event) {
    var schedule = event.schedule;
    if (lastClickSchedule) {
        if(schedule.bgColor === turquoise && lastClickSchedule == schedule){
            showCreateBtn(false);
            scheduleTitle.value = schedule.title;
            scheduleContent.value = schedule.body;
            hiddenId.value = schedule.id;

            startChoiceDay.selectedIndex    = schedule.start.getDate();
            startChoiceMonth.selectedIndex  = schedule.start.getMonth();
            startChoiceYear.selectedIndex   = schedule.start.getFullYear() - new Date().getFullYear;
            startChoiceHour.selectedIndex   = schedule.start.getHours();
            startChoiceMinute.selectedIndex = schedule.start.getMinutes();
        
            endChoiceDay.selectedIndex      = schedule.end.getDate();
            endChoiceMonth.selectedIndex    = schedule.end.getMonth();
            endChoiceYear.selectedIndex     = schedule.end.getFullYear() - new Date().getFullYear;
            endChoiceHour.selectedIndex     = schedule.end.getHours();
            endChoiceMinute.selectedIndex   = schedule.end.getMinutes();
            modal.style.display = "block";
        }
        else{
            // unfocus previous schedule
            calendar.updateSchedule(lastClickSchedule.id, lastClickSchedule.calendarId, {
                isFocused: false
            });
        }
    }

    // focus the schedule
    calendar.updateSchedule(schedule.id, schedule.calendarId, {
        isFocused: true
    });

    lastClickSchedule = schedule;

    // open detail view
});


calendar.on('beforeCreateSchedule', function(event) {
    var startTime = event.start;

    startChoiceDay.selectedIndex = startTime._date.getDate() - 1;
    startChoiceMonth.selectedIndex = startTime._date.getMonth();
    startChoiceYear.selectedIndex = startTime._date.getFullYear() - new Date().getFullYear;
    startChoiceHour.selectedIndex =  17;

    endChoiceDay.selectedIndex = startChoiceDay.selectedIndex;
    endChoiceMonth.selectedIndex = startChoiceMonth.selectedIndex;
    endChoiceYear.selectedIndex = startChoiceYear.selectedIndex;
    endChoiceHour.selectedIndex = startChoiceHour.selectedIndex + 2;

    modal.style.display = "block";
    showCreateBtn(true);
    event.guide.clearGuideElement();
});
function showCreateBtn(bool) {
    createBtn.hidden = !bool;
    deleteBtn.hidden = bool;
    updateBtn.hidden = bool;
}

// update on drop
// calendar.on('beforeUpdateSchedule', function(event) {
//     var schedule = event.schedule;
//     var changes = event.changes;

//     calendar.updateSchedule(schedule.id, schedule.calendarId, changes);
// });
