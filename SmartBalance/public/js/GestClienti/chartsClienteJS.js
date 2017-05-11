var datiG;
var anni=new Array();
var mesi=new Array();
var value=new Array();
var valueMesi=new Array();

/****************GRAFICI SPESE**********************/
$(document).ready(function(){
/******************USCITE ANNI********************/
    $.post("chartClienteAnni", {}, 
        function(data){
            if (data=='no'){
                anni.push('non ci sono dati');
                value.push(0);
            }else{
                datiG = JSON.parse(data);
                for (var i=0; i<datiG.length; i++){
                    anni.push(datiG[i].anno);
                    value.push(datiG[i].totale);
                }
                    var ctxAnni = $("#gClienteAnni");
                    var graficoAnni = new Chart(ctxAnni, {
                        type: 'bar',
                        data: {
                            labels: anni,
                            datasets: [{
                                label: 'Totale',
                                data: value,
                                backgroundColor: 'blue',
                                borderColor: 'darkblue',
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
    
    
/*****************USCITE MESI******************/
    $.post("chartClienteMesi", {}, 
        function(data){
            if (data=='no'){
                mesi.push('non ci sono dati');
                valueMesi.push(0);
            }else{
                datiG = JSON.parse(data);
                for (var i=0; i<datiG.length; i++){
                    mesi.push(monthToString(datiG[i].mese));
                    valueMesi.push(datiG[i].tot);
                }
                    var ctxMesi = $("#gClienteMesi");
                    var graficoMesi = new Chart(ctxMesi, {
                        type: 'bar',
                        data: {
                            labels: mesi,
                            datasets: [{
                                label: 'Totale',
                                data: valueMesi,
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
        case '1':
            return 'Gennaio';
            break;
        case '2':
            return 'Febbraio';
            break;
        case '3':
            return 'Marzo';
            break;
        case '4':
            return 'Aprile';
            break;
        case '5':
            return 'Maggio';
            break;
        case '6':
            return 'Giugno';
            break;
        case '7':
            return 'Luglio';
            break;
        case '8':
            return 'Agosto';
            break;
        case '9':
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