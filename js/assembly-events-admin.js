var editEvents = document.getElementsByClassName('ae_edit-event');
var insertForm = document.getElementById('insert-form');
var updateForm = document.getElementById('update-form');
var deleteForm = document.getElementById('delete-form');
var addRec = document.getElementById('ae_add-event');
var cancelForm = document.getElementsByClassName('cancel-form');
var deleteRecs = document.getElementsByClassName('ae_delete-record');
// var insertTitle = document.getElementById('insert_title'),
//     insertMonth = document.getElementById('insert_month'),
//     insertDay = document.getElementById('insert_day'),
//     insertYear = document.getElementById('insert_year'),
//     insertHour = document.getElementById('insert_hour'),
//     insertMin = document.getElementById('insert_minute'),
//     insertMer = document.getElementById('insert_meridian'),
//     insertLoc = document.getElementById('insert_location'),
//     insertLink = document.getElementById('insert_link');
var updateId = document.getElementById('update_id'),
    updateTitle = document.getElementById('update_title'),
    updateMonth = document.getElementById('update_month'),
    updateDay = document.getElementById('update_day'),
    updateYear = document.getElementById('update_year'),
    updateHour = document.getElementById('update_hour'),
    updateMin = document.getElementById('update_minute'),
    updateMer = document.getElementById('update_meridian'),
    updateLoc = document.getElementById('update_location'),
    updateLink = document.getElementById('update_link');
var deleteId = document.getElementById('delete_id'),
    deleteField = document.getElementById('delete-field');


/*********************\
 **[[Event Listeners]]**
 \*********************/
addRec.addEventListener('click', function () {
    insertForm.classList.add('open');
});
for (var i = 0; i < cancelForm.length; i++) {
    cancelForm[i].addEventListener('click', function (e) {
        e.preventDefault();
        this.parentNode.classList.remove('open');
    });
}
for (var i = 0; i < editEvents.length; i++) {
    editEvents[i].addEventListener('click', aeEditEvent);
}
for (var i = 0; i < deleteRecs.length; i++) {
    deleteRecs[i].addEventListener('click', aeDeleteEvent);
}

/***************\
 **[[Functions]]**
 \***************/
function aeEditEvent() {
    var n = this.parentNode.id;
    var o = eventObj[n];
    var d = new Date(o.event_date);
    updateForm.classList.add('open');
    updateId.value = o.event_id;
    console.log(o.event_id);
    updateTitle.value = o.event_title;
    updateMonth.value = buildDate(d, 'M').toString();
    updateDay.value = buildDate(d, 'd');
    updateYear.value = buildDate(d, 'y');
    updateHour.value = buildTime(d, 'h').toString();
    console.log(buildTime(d, 'h'));
    updateMin.value = buildTime(d, 'm');
    updateMer.value = buildTime(d, 'M');
    updateLoc.value = o.event_location;
    updateLink.value = o.event_link;
}

function aeDeleteEvent() {
    var n = this.parentNode.parentNode.id;
    var o = eventObj[n];
    deleteForm.classList.add('open');
    deleteId.value = o.event_id;
    deleteField.innerHTML = o.event_title;
    console.log(deleteId.value + "\t" + o.event_id + "\t" + o.event_title);
}

// for (var i = 0; i < eventObj.length; i++) {
//     var d = new Date(eventObj[i].event_date);
//     var date = buildDate(d);
//     var time = buildTime(d);
//     var title = eventObj[i].event_title;
//     var loc = eventObj[i].event_location;
//     var link = eventObj[i].event_link;
// }

function buildDate(d, datePart) {
    var year = d.getFullYear();
    var mon = monthName(d.getMonth());
    var day = addLeadingZeros(d.getDate());
    if (datePart == 'm') {
        return mon;
    } else if (datePart == 'M') {
        return monthNum(mon);
    } else if (datePart == 'd') {
        return day;
    }
    if (datePart == 'y') {
        return year;
    }
    return mon + " " + day + ", " + year;
}

function buildTime(d, timePart) {
    var mer = "am";
    var h = d.getHours();
    console.log(h);
    if (h > 12) {
        mer = "pm";
        h = h / 2;
    }
    var hour = addLeadingZeros(h);
    var min = addLeadingZeros(d.getMinutes());
    if (timePart == 'h') {
        return hour;
    } else if (timePart == 'm') {
        return min;
    } else if (timePart == 'M') {
        return mer;
    }
    return hour + ":" + min + " " + mer;
}

function monthName(m) {
    var month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];
    return month[m];
}

function monthNum(m) {
    var month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
    ];
    return addLeadingZeros(month.indexOf(m) + 1);
}

/**
 * Adds a leading zero to a number
 * @param num
 * @returns {*}
 */
function addLeadingZeros(num) {
    var val;
    if (num < 10) {
        val = "0" + num;
    } else {
        val = num;
    }
    return val;
}