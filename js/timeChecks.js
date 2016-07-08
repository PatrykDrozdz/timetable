function checkDay(){
    
    var toDay = new Date();
            
    var day = toDay.getDate();
    var month = toDay.getMonth();
    var year = toDay.getFullYear();
            
    var dayOfWeek = toDay.getDay();
    
    var hour = toDay.getHours();
    
    var startDay;
    
    var endDay;
    var beginWeek;
    
    
    if(dayOfWeek==1){
        document.getElementById("data1").innerHTML = day+"/"+((month%13))+"/"+year;
        var pom1=1;
        for(i=1; i<8; i++){
            
       
                
                if(month<7 && month!=1 && month%2==0){
                     document.getElementById("data"+i).innerHTML = (day+pom1)%31+"/"+
                             ((month%13)+1)+"/"+year;
                 }
                 else if(month<7 && month!=1 && month%2!=0){
                      document.getElementById("data"+i).innerHTML = (day+pom1)%31+"/"+
                             ((month%13)+1)+"/"+year;
                 }
                else if(month>=7 && month!=1 && month%2!=0){
                     document.getElementById("data"+i).innerHTML = (day+pom1)%31+"/"+
                             ((month%13)+1)+"/"+year;
                 }
                 else if(month>=7 && month!=1 && month%2==0){
                     document.getElementById("data"+i).innerHTML = (day+pom1)+"/"+
                             ((month%13)+1)+"/"+year;
                 }
                 
                 if(month==2) {
                     if((year%4 && year%100!=0) || year%400==0){
                         document.getElementById("data"+i).innerHTML = (day+pom1)%30+"/"+
                             ((month%13)+1)+"/"+year;
                     } else {
                          document.getElementById("data"+i).innerHTML = (day+pom1)%29+"/"+
                             ((month%13)+1)+"/"+year;
                     }
                 }
                 pom1++;
              
            
        }

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

