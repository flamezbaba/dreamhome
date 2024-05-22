const disableScroll = () => {
    document.body.style.cssText = ";overflow: hidden;height:100%; width: 100%;";
};

const enableScroll = () => {
    document.body.style.cssText = null;
};

function convertDateTime(date) {
    const d = new Date(Date.parse(date));

    const y = d.getFullYear();
    const m = d.getMonth() + 1;
    const dd = d.getDate();
    const h = d.getHours();
    const i = d.getMinutes();

    return `${y}-${m}-${dd} ${h}:${i}:00`;
}

function convertDate(date) {
    const d = new Date(Date.parse(date));

    const y = d.getFullYear();
    const m = d.getMonth() + 1;
    const dd = d.getDate();

    return `${y}-${m}-${dd} 00:00:00`;
}

function convertTime(date) {
    const d = new Date(Date.parse(date));

    const h = d.getHours();
    const i = d.getMinutes();

    return `${h}:${i}:00`;
}

function calcHrs(start, end){
    const aa = start.toString().substring(0, 2);
    const bb = end.toString().substring(0, 2);

    var gg = parseInt(aa) - parseInt(bb);
    if(gg < 0){
        gg = gg * -1;
    }

    return gg;
}



export default {
    disableScroll,
    enableScroll,
    convertDateTime,
    convertDate,
    convertTime,calcHrs
};
