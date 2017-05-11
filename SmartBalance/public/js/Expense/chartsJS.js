var datiG;
var anni=new Array();
var mesi=new Array();
var categorie=new Array();
var coloreCategorie=new Array();
var value=new Array();
var valueMesi=new Array();
var valueCategorie=new Array();
var voce=new Array();
var valueVoce=new Array();
var coloreVoce=new Array();
var anniIncidCat=new Array();
var valueIncidCat=new Array();
var dataIncidCat;
var anniIncidVoci=new Array();
var valueIncidVoci=new Array();
var dataIncidVoci;
/****************GRAFICI SPESE**********************/
$(document).ready(function(){
/******************USCITE ANNI********************/
    $.post("chartExpenseYear", {}, 
        function(data){
            if (data=='no'){
                anni.push('non ci sono dati');
                value.push(0);
            }else{
                datiG = JSON.parse(data);
                for (var i=0; i<datiG.length; i++){
                    anni.push(datiG[i].anno);
                    value.push(datiG[i].totaleSpesa);
                }
            }
        }    
    );
    var ctxAnni = $("#grafSpeseAnni");
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
    
    
/*****************USCITE MESI******************/
    $.post("chartExpenseMonth", {}, 
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
            }   
        }    
    );
    var ctxMesi = $("#grafSpeseMesi");
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

/**********CIAMBELLA PER CATEGORIA***********/
    $.post("chartExpenseCategory", {}, 
        function(data){
            if (data=='no'){
                categorie.push('no dati');
                valueCategorie.push(0);
                coloreCategorie.push('#FFF');
            }else{
               datiG = JSON.parse(data);
                for (var i=0; i<datiG.length; i++){
                    categorie.push(datiG[i].categoria);
                    valueCategorie.push(datiG[i].incidenza);
                    coloreCategorie.push(datiG[i].colore);
                } 
            }    
        }    
    );
    var ctxIncidenzaCategoria = $('#grafCategoria');
    var grafCategoria = new Chart(ctxIncidenzaCategoria, {
    type: 'doughnut',
    data: {
        labels: categorie,
        datasets: [{
            data: valueCategorie,
            backgroundColor: coloreCategorie,
        }]
    }   
});
    
/**********CIAMBELLA PER SINGOLA VOCE***********/
    $.post("chartExpenseName", {}, 
        function(data){
            if (data=='no'){
                voce.push('no dati');
                valueVoce.push(0);
            }else{
                datiG = JSON.parse(data);
                for (var i=0; i<datiG.length; i++){
                    voce.push(datiG[i].voce);
                    valueVoce.push(datiG[i].incidenza);
                    coloreVoce.push(datiG[i].colore);
                }
            }
            
        }    
    );
    var ctxIncidenzaVoce = $('#grafVoce');
    var grafVoce = new Chart(ctxIncidenzaVoce, {
    type: 'doughnut',
    data: {
        labels: voce,
        datasets: [{
            data: valueVoce,
            backgroundColor: coloreVoce,
        }]
    }   
});
    
/***********LINEE NEGLI ANNI PER OGNI CATEGORIA*************/
    $.post("chartLineExpenseCat", {}, 
        function(data){
            datiG = JSON.parse(data);
            for (var i=datiG.anni.length-1; i>=0; i--){
                anniIncidCat.push(datiG.anni[i]);
            }
            var flag=0;
            for (var i=0; i<datiG.categorie.length; i++){
                var y=0;
                var temp=new Array();
                for (var x=datiG.valori[datiG.categorie[i]].length-1; x>=0; x--){
                    temp[y]=datiG.valori[datiG.categorie[i]][x];
                    valueIncidCat[datiG.categorie[i]]=temp;
                    y++;
                }
                var temp2=new Array(); 
                if (flag==0){
                    dataIncidCat=[{'label':'% '+datiG.categorie[i],'backgroundColor':datiG.colori[i],'borderColor':datiG.colori[i],'fill':false,'pointRadius':10,'pointHoverRadius':20,'data':valueIncidCat[datiG.categorie[i]]}];
                    flag++;
                }else{
                    temp2=[{'label':'% '+datiG.categorie[i],'backgroundColor':datiG.colori[i],'borderColor':datiG.colori[i],'fill':false,'pointRadius':10,'pointHoverRadius':20,'data':valueIncidCat[datiG.categorie[i]]}];
                    dataIncidCat = dataIncidCat.concat(temp2);
                }
            }
            var ctxIncidenzaLineeCat = $('#lineeCat');    
            var lineCategoria = new Chart(ctxIncidenzaLineeCat, {
                type: 'line',
                data: {
                    labels:anniIncidCat,
                    datasets:dataIncidCat
                }
            });
        }    
    );
    
/***********LINEE NEGLI ANNI PER OGNI SINGOLA VOCE*************/
    $.post("chartLineExpenseVoce", {}, 
        function(data){
            datiG = JSON.parse(data);
            for (var i=datiG.anni.length-1; i>=0; i--){
                anniIncidVoci.push(datiG.anni[i]);
            }
            var flag=0;
            for (var i=0; i<datiG.voci.length; i++){
                var y=0;
                var temp=new Array();
                for (var x=datiG.valori[datiG.voci[i]].length-1; x>=0; x--){
                    temp[y]=datiG.valori[datiG.voci[i]][x];
                    valueIncidVoci[datiG.voci[i]]=temp;
                    y++;
                }
                var temp2=new Array(); 
                if (flag==0){
                    dataIncidVoci=[{'label':'% '+datiG.voci[i],'backgroundColor':datiG.colori[i],'borderColor':datiG.colori[i],'fill':false,'pointRadius':10,'pointHoverRadius':20,'data':valueIncidVoci[datiG.voci[i]]}];
                    flag++;
                }else{
                    temp2=[{'label':'% '+datiG.voci[i],'backgroundColor':datiG.colori[i],'borderColor':datiG.colori[i],'fill':false,'pointRadius':10,'pointHoverRadius':20,'data':valueIncidVoci[datiG.voci[i]]}];
                    dataIncidVoci = dataIncidVoci.concat(temp2);
                }
            }
            var ctxIncidenzaLineeVoci = $('#lineeVoci');    
            var lineVoci = new Chart(ctxIncidenzaLineeVoci, {
                type: 'line',
                data: {
                    labels:anniIncidVoci,
                    datasets:dataIncidVoci
                }
            });
        }    
    );
  
    
    //fine document ready
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
