function checkDay(){
    
    var toDay = new Date();
       
    var dayOfWeek = toDay.getDay();
  
   
    var day = toDay.getDate();
    var month = toDay.getMonth()+1;
    var year = toDay.getFullYear();
    
    if(day<10){
        day = "0"+day;
    }
    
    if(month<10){
        month="0"+month;
    }
        
    var fullDate = year+"-"+month+"-"+day;    
    

    document.getElementById("date"+dayOfWeek).innerHTML=fullDate;
    document.getElementById("dayOfWeek").innerHTML=dayOfWeek;
}


