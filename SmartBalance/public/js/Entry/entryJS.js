var tableActiveEntrate;
var tableActiveEntrateArr;
var tableActiveEntrateIn;//tabella entrate da ricevere
var riga; //riga entrate da ricevere
var cont=0;
var detrazioni=new Array();
$(document).ready(function(){
    //recupero entrate in arrivo
    tableActiveEntrate = $('#activeEntrate').DataTable({
       "language": {
            "url": "../JSON/Italian.json"
        },
        "processing": true,
        "serverSide": true,
        "ajax": "getActiveEntrate",
        "info": false,
        "order": [[ 0, "desc" ]],
        "columnDefs":[{
            "targets":5,
            "width":"5%",
            "orderable": false,
            "defaultContent":'<a data-toggle="modal" title="Elimina" href="#delete"><i class="fa fa-trash fa-2x"></i></a>'
        },{
            "targets":4,
            "visible":false,
            "searchable": false
        }]
    });
    
    //recupero entrate insolute
    tableActiveEntrateIn = $('#activeEntrateIn').DataTable({
       "language": {
            "url": "../JSON/Italian.json"
        },
        "processing": true,
        "serverSide": true,
        "ajax": "getActiveEntrateIn",
        "info": false,
        "order": [[ 0, "desc" ]],
        "columnDefs": [{
            "targets": 5,
            "width":'7%',
            "data": null,
            "orderable": false,
            "defaultContent": '<a data-toggle="modal" title="Pagata" href="#modalPagato"><i class="fa fa-check-circle fa-2x"></i></a> <a data-toggle="modal" class="del" title="Elimina" href="#delete"><i class="fa fa-trash fa-2x"></i></a>'
        },
         {
            "targets": 4,
            "visible": false,
            "searchable": false
        }],                     

    });
     
     //recupero entrate arrivate
    tableActiveEntrateArr = $('#activeEntrateArr').DataTable({
       "language": {
            "url": "../JSON/Italian.json"
        },
        "processing": true,
        "serverSide": true,
        "ajax": "getActiveEntrateArr",
        "autoWidth":false,
        "info": false,
        "order": [[ 0, "desc" ]], 
    });
    
});

//recupero riga riga
$('#activeEntrateIn tbody').on('click','i', function(){
    riga = tableActiveEntrateIn.row($(this).parents('tr') ).data();
});

//recupero riga entrate in arrivo
$('#activeEntrate tbody').on('click','i', function(){
    riga = tableActiveEntrate.row($(this).parents('tr') ).data();
});

//elimino entrata
$('#delete .btn-danger').on('click', function(){
   $.post("deleteEntry", {
        idEntrata:riga[4]
    }, 
        function(data){
        console.log(data);
            if (data=='delete'){
                $('#delete').modal('hide');
                tableActiveEntrate.ajax.reload();
                tableActiveEntrateIn.ajax.reload();
            }
        }    
    ); 
});

//funzione per il click del tasto si nella modalPagato
$('#modalPagato .btn-success').on('click', function(){
   $.post("pagato", {
        idEntrata:riga[4]
    }, 
        function(data){
            if (data=='pagatoOK')
                tableActiveEntrateIn.ajax.reload();
                tableActiveEntrateArr.ajax.reload();
            }
            
    ); 
});


//Caricamento modal inserimento nuova entrata 
$('#aggiungi').on('click',function(){
    $('#aggModal .alert-danger').addClass('hide');
    $('#detrazioni .detrazione').remove();
    document.getElementById('addForm').reset();
    $('#idCliente').html('');
    var today=new Date();
    var giorno=traduciGiorno(today.getDate());
    var mese=traduciMese(today.getMonth());
    var anno=today.getFullYear().toString();
    var dataHtml=anno+"-"+mese+"-"+giorno;
    $('#dRegistrazione').val(dataHtml);
    
});

//aggiungo entrata
$('#aggModal .btn-primary').on('click',function(){
    var x=0;
    var y=1;
    //controllo inserimento dati
    if(($('#nome').val()=='') || ($('#dRegistrazione').val()=='') || ($('#dPagamento').val()=='') || ($('#importo').val()=='') || ($('#idCliente').val()=='') ){
        $('#aggModal .alert-danger').removeClass('hide');
        $('#aggModal .alert-danger').html('<strong>Attenzione!</strong> Inserire tutti i campi!');
    }else{
        $('#detrazioni select').each(function(){
            detrazioni[x]={"voce":""+$(this).val()+"", "valore":$('#value'+y).val()};
            x++;
            y++;
        });
        
        $.post("aggEntrataP",{
            nome:$('#nome').val(),
            dRegistrazione:$('#dRegistrazione').val(),
            dPagamento:$('#dPagamento').val(),
            importo:$('#importo').val(),
            idCliente:$('#idCliente').val(),
            detrazioni:(JSON.stringify(detrazioni)) ? JSON.stringify(detrazioni):0
        },
        function(data){
            console.log(data);
            if(data=='success'){
                $('#aggModal').modal('hide');
                tableActiveEntrate.ajax.reload();
                tableActiveEntrateIn.ajax.reload();
            }else if (data=='errorData'){
                $('#aggModal .alert-danger').removeClass('hide');
                $('#aggModal .alert-danger').html('<strong>Attenzione!</strong> Inserire due date valide!');
            }
        });
    }
    
});

//funzione per ricerca cliente
$('#cerca').on('keyup',function(){ 
    $.post("searchC",{
        nominativo:$('#cerca').val()
    },
    function(data){
        if(data!="false"){
            $('#idCliente').html(data);    
        }
    });
});

$('#detrazioni .btn-warning').on('click', function(){
    cont++;
    $('#detrazioni').append('<div class="form-group detrazione">'
                            +'<div class="col-sm-2"></div>'
                            +'<div class="col-sm-4">'
                                +'<select id="spesa'+cont+'" class="form-control"></select>'
                            +'</div>'
                            +'<div class="col-sm-3">'
                                +'<input type="number" min="0.01" step="0.01" class="form-control gg" placeholder="importo" id="value'+cont+'">'
                            +'</div>'
                         +'</div>');
    
    $.post("getAllVociSpesa",{},
    function(data){
        if(data!="false"){
            $('#spesa'+cont).html(data);  
        }
    });
});


//funzione per traduzione corretta numero giorno corrente
function traduciGiorno(giorno){
    if (giorno < 10){
        return "0"+giorno.toString();
    }else{
        return giorno.toString();
    }
}

//funzione per traduzione corretta numero mese corrente
function traduciMese(mese){
    switch (mese){
        case 0:
            return "01";
            break;
        case 1:
            return "02";
            break;
        case 2:
            return "03";
            break;
        case 3:
            return "04";
            break;
        case 4:
            return "05";
            break;
        case 5:
            return "06";
            break;
        case 6:
            return "07";
            break;
        case 7:
            return "08";
            break;
        case 8:
            return "09";
            break;
        case 9:
            return "10";
            break;
        case 10:
            return "11";
            break;
        case 11:
            return "12";
            break;     
    }
}