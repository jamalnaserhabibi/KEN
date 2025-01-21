function thetime()   {
    let today = new Date();
    let hour1 = today.getHours();
    let minute1 = today.getMinutes();
    let second1 = today.getSeconds();
    var hour,minute,second
    if(hour1<10){
        hour="0"+today.getHours();
    }
    else{
        hour=today.getHours();
    }
    if(minute1<10){
        minute="0"+today.getMinutes();
    }
    else{
        minute=today.getMinutes();
    }
    if(second1<10){
        second="0"+today.getSeconds();
    }
    else{
        second=today.getSeconds();
    }
         return (hour + ":" + minute +":" +second);
    }
function thedate()   {
        let today = new Date();
        let day = today.getDate();
        let month = today.getMonth()+1;
        let year = today.getFullYear();
             return (day + "/" + month +"/" + year);
}
