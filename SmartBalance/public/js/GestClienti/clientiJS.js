var tableClienti;
var riga;
$(document).ready(function(){
//recupero clienti
    tableClienti = $('#activeClienti').DataTable({
       "language": {
            "url": "../JSON/Italian.json"
        },
        "processing": true,
        "serverSide": true,
        "ajax": "getClienti",
        "info": false,
        "columnDefs":[{
            "targets":5,
            "visible":false
        },
        {
            "targets":6,
            "width":"10%",
            "orderable":false,
            "defaultContent":'<a data-toggle="modal" title="Vai alla scheda" class="info"><i class="fa fa-info-circle fa-2x"></i></a> <a data-toggle="modal" title="Modifica" class="edit" href=#editModal><i class="fa fa-cog fa-2x"></i></a> <a data-toggle="modal" title="Rimuovi" class="delete" href="#modalElimina"><i class="fa fa-trash fa-2x"></i></a>'
        }]
    });
    
});

//recupero riga riga
$('#activeClienti tbody').on('click','i', function(){
    riga = tableClienti.row($(this).parents('tr') ).data();
});

//funzione per il click del tasto si nella modalElimina
$('#modalElimina .btn-danger').on('click', function(){
   $.post("eliminaC", {
        idCliente:riga[5]
    }, 
        function(data){
            if (data=='eliminatoOK'){
                tableClienti.ajax.reload();
            }     
    }); 
});

$('#activeClienti tbody ').on('click','.info', function(){
    $.post("inviaID",{
        idCliente:riga[5]
    },
        function(data){
            if (data=='success'){
                window.location.assign('http://'+location.hostname+'/SmartBalance/public/gestClienti/schedaCliente');
            }
    });
});

//Caricamento modal inserimento nuovo cliente
$('#aggiungi').on('click',function(){
    $('#aggModal .alert-danger').addClass('hide');
    document.getElementById('addForm').reset();
});

//aggiungo cliente
$('#aggModal .btn-primary').on('click',function(){
    //controllo inserimento dati
    if(($('#rsociale').val()=="") || ($('#codCliente').val()=="") ){
        $('#aggModal .alert-danger').removeClass('hide');
        $('#aggModal .alert-danger').html('<strong>Attenzione!</strong> Inserire ragione sociale e/o codice cliente!');
    }else{
        $.post("aggCliente",{
            codCliente:$('#codCliente').val(),
            rsociale:$("#rsociale").val(),
            citta:$("#citta").val(),
            indirizzo:$("#indirizzo").val(),
            provincia:$("#provincia").val(),
            comune:$("#comune").val(),
            cap:$("#cap").val(),
            telefono:$("#telefono").val(),
            piva:$("#piva").val(),
            cf:$("#cf").val()
        },
        function(data){
            if(data=='success'){
                $("#aggModal").modal('hide');
                tableClienti.ajax.reload();
            }
        });  
    }    
});

//modifica cliente
$('#editModal .btn-primary').on('click',function(){
    //controllo inserimento dati
    if(($('#rsocialeM').val()=="") || ($('#codClienteM').val()=="") ){
        $('#editModal .alert-danger').removeClass('hide');
        $('#editModal .alert-danger').html('<strong>Attenzione!</strong> Inserire ragione sociale e/o codice cliente!');
    }else{
        $.post("modCliente",{
            idC: riga[5],
            codCliente:$('#codClienteM').val(),
            rsociale:$("#rsocialeM").val(),
            citta:$("#cittaM").val(),
            indirizzo:$("#indirizzoM").val(),
            provincia:$("#provinciaM").val(),
            comune:$("#comuneM").val(),
            cap:$("#capM").val(),
            telefono:$("#telefonoM").val(),
            piva:$("#pivaM").val(),
            cf:$("#cfM").val()
        },
        function(data){
            if(data=='success'){
                $("#editModal").modal('hide');
                tableClienti.ajax.reload();
            }
        });  
    }    
});

$('#activeClienti tbody ').on('click','.edit', function(){
    $.post("loadCliente",{
            idC: riga[5]
        },
        function(data){
            cliente = JSON.parse(data);
            $('#codClienteM').val(cliente.codCliente);
            $("#rsocialeM").val(cliente.ragSociale);
            $("#cittaM").val(cliente.citta);
            $("#indirizzoM").val(cliente.indirizzo);
            $("#provinciaM").val(cliente.provincia);
            $("#comuneM").val(cliente.comune);
            $("#capM").val(cliente.CAP);
            $("#telefonoM").val(cliente.telefono);
            $("#pivaM").val(cliente.pIva);
            $("#cfM").val(cliente.CF);
        });  
});