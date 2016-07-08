function checkDay(){
    
    var toDay = new Date();
            
    var day = toDay.getDate();
    var month = toDay.getMonth();
    var year = toDay.getFullYear();
            
    var dayOfWeek = toDay.getDay();
    
    var hour = toDay.getHours();
    
    
    
    if(dayOfWeek==1){
        document.getElementById("date1").innerHTML = day+"/"+(month%13)+"/"+year;
        

    }
      if(dayOfWeek==2){
        document.getElementById("date2").innerHTML = day+"/"+(month%13)+"/"+year;
       

    }
      if(dayOfWeek==3){
        document.getElementById("date3").innerHTML = day+"/"+(month%13)+"/"+year;
       

    }
      if(dayOfWeek==4){
        document.getElementById("date4").innerHTML = day+"/"+(month%13)+"/"+year;
       

    }
      if(dayOfWeek==5){
        document.getElementById("date5").innerHTML = day+"/"+(month%13)+"/"+year;
       
       
    }
      if(dayOfWeek==6){
        document.getElementById("date6").innerHTML = day+"/"+(month%13)+"/"+year;
       

    }
    
    
    if(dayOfWeek==7){
        document.getElementById("date7").innerHTML = day+"/"+(month%13)+"/"+year;
       
       
    }
 


////////////////////////
//godziny wstawiane do tabeli
    
    var change;
    var pom=0;
    var pom2 = 1;
    var start;
    
    if(hour==0 || hour==6 || hour==19){
        
        for(i=0; i<14; i++){
           change = hour+i;
           if(change>=24){
                change=0;
            }
            document.getElementById("hour"+i).innerHTML = change;
            
            
          }

    } else {
        start = hour-13;
        
        if(start<0){
            start = start*(-1);
        }
        
        if(start==0){
            start=1;
        }
        
        for(i=start; i<14; i++){
            change = hour + pom;
            if(change>=24){
                change=0;
            }
            document.getElementById("hour"+i).innerHTML = change;
            pom++;
       }
        
        for(i=start-1; i>=0; i--){
            change = hour-pom2;
             if(change<0){
                change=23;
            }
            document.getElementById("hour"+i).innerHTML = change;
            pom2++;
        }
    }
    
  
}

