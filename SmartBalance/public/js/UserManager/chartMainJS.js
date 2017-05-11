var mesi=new Array();

$(document).ready(function(){
//confronto entrate/uscite anno corrente
   $.post("chartCompare", {}, 
        function(data){
            if (data!='no'){
                datiG = JSON.parse(data);
                for (i=0; i<datiG.mesi.length; i++){
                    mesi.push(monthToString(datiG.mesi[i]));
                }

                var ctxCompare = $("#confronto");
                var graficoAnni = new Chart(ctxCompare, {
                    type: 'bar',
                    data: {
                        labels: mesi,
                        datasets: [{
                            label: 'Entrate €',
                            data: datiG.entrate,
                            backgroundColor: 'blue',
                            borderColor: 'darkblue',
                            borderWidth: 1
                        },{
                            label:'Uscite €',
                            data: datiG.uscite,
                            backgroundColor: 'red',
                            borderColor: 'darkred',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
                
            }
        }    
    );

//confronto entrate/uscite anno corrente
       $.post("chartCompareYears", {}, 
        function(data){
            if (data!='no'){
                datiG = JSON.parse(data);
                var ctxCompareYear = $("#confrontoAnni");
                var graficoConfrontoAnni = new Chart(ctxCompareYear, {
                    type: 'bar',
                    data: {
                        labels: datiG.anni,
                        datasets: [{
                            label: 'Entrate €',
                            data: datiG.entrate,
                            backgroundColor: 'blue',
                            borderColor: 'darkblue',
                            borderWidth: 1
                        },{
                            label:'Uscite €',
                            data: datiG.uscite,
                            backgroundColor: 'red',
                            borderColor: 'darkred',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
                
            }
        }    
    );
  
});


/*****funzioni utilità******/
function monthToString(numMese){
    switch(numMese){
        case '01':
            return 'Gennaio';
            break;
        case '02':
            return 'Febbraio';
            break;
        case '03':
            return 'Marzo';
            break;
        case '04':
            return 'Aprile';
            break;
        case '05':
            return 'Maggio';
            break;
        case '06':
            return 'Giugno';
            break;
        case '07':
            return 'Luglio';
            break;
        case '08':
            return 'Agosto';
            break;
        case '09':
            return 'Settembre';
            break;
        case '10':
            return 'Ottobre';
            break;
        case '11':
            return 'Novembre';
            break;
        case '12':
            return 'Dicembre';
            break;   
    }
}