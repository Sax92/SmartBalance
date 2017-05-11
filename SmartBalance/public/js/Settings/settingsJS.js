var tableCategory; //tabella categorie di spesa
var tableVoci; //tab voci spesa
var tableDet;
var riga; //riga tabella

$(document).ready(function(){
    
    $('#colorCategory').colorpicker();
    $('#colorVoce').colorpicker();
    
//recupero categorie spesa
    tableCategory = $('#expenseCategory').DataTable({
       "language": {
            "url": "../JSON/Italian.json"
        },
        "processing": true,
        "serverSide": true,
        "ajax": "getCategory",
        "info": false,
        "columnDefs":[{
            "targets":1,
            "data": function ( row, type, val, meta ) {
                return codeToColor(row[1]);
            }
        },
        {
            "targets":2,
            "width":"5%",
            "orderable":false,
            "defaultContent":'<a data-toggle="modal" title="Elimina" class="delete" href="#deleteC"><i class="fa fa-trash fa-2x"></i></a>'
        }]
    });
    
//recupero voci spesa
    tableVoci = $('#expenseVoci').DataTable({
       "language": {
            "url": "../JSON/Italian.json"
        },
        "processing": true,
        "serverSide": true,
        "ajax": "getVoci",
        "info": false,
        "columnDefs":[{
            "targets":1,
            "data": function ( row, type, val, meta ) {
                return codeToColor(row[1]);
            }
        },{
            "targets":3,
            "width":"5%",
            "orderable":false,
            "defaultContent":'<a data-toggle="modal" title="Elimina" class="delete" href="#deleteV"><i class="fa fa-trash fa-2x"></i></a>'
        }]
    });
    
//recupero voci detrazioni    
    tableDet = $('#detrazioniNome').DataTable({
       "language": {
            "url": "../JSON/Italian.json"
        },
        "processing": true,
        "serverSide": true,
        "ajax": "getDet",
        "info": false,
        "columnDefs":[{
            "targets":1,
            "defaultContent":'<a data-toggle="modal" title="Elimina" class="delete" href="#deleteD"><i class="fa fa-trash fa-2x"></i></a>'
        }]
    });
    
});

//recupero riga categorie
$('#expenseCategory tbody').on('click','i', function(){
    riga = tableCategory.row( $(this).parents('tr') ).data();
});

//recupero riga voci
$('#expenseVoci tbody').on('click','i', function(){
    riga = tableVoci.row( $(this).parents('tr') ).data();
});

//recupero riga voci det
$('#detrazioniNome tbody').on('click','i', function(){
    riga = tableDet.row( $(this).parents('tr') ).data();
});

//elimino categoria
$('#deleteC .btn-danger').on('click', function(){
   $.post("deleteCategory", {
        categoria:riga[0]
    }, 
        function(data){
            if (data=='delete'){
                $('#deleteC').modal('hide');
                tableCategory.ajax.reload();
            }else{
                $('#deleteC').modal('hide');
                $('#deleteCError').modal();
            }
        }    
    ); 
});

//elimino voce
$('#deleteV .btn-danger').on('click', function(){
   $.post("deleteVoce", {
        voce:riga[0]
    }, 
        function(data){
            if (data=='delete'){
                $('#deleteV').modal('hide');
                tableVoci.ajax.reload();
            }else{
                $('#deleteV').modal('hide');
                $('#deleteVError').modal();
            }
        }    
    ); 
});

//elimino det
$('#deleteD .btn-danger').on('click', function(){
   $.post("deleteDetrazione", {
        nome:riga[0]
    }, 
        function(data){
            if (data=='delete'){
                $('#deleteD').modal('hide');
                tableDet.ajax.reload();
            }else{
                $('#deleteD').modal('hide');
                $('#deleteDError').modal();
            }
        }    
    ); 
});

//caricamento modal inserimento nuova categoria click aggiungi
$('#aggiungiC').on('click',function(){
    $('#addCategory .alert-danger').addClass('hide');
    document.getElementById('addFormC').reset();

});

//aggiungo categoria
$('#addCategory .btn-primary').on('click',function(){
   //controllo inserimento dati
    if ($('#categoriaAdd').val()==''){
        $('#addCategory .alert-danger').removeClass('hide');
        $('#addCategory .alert-danger').html('<strong>Attenzione!</strong> Inserire tutti i campi!');
    }else{
        $.post("addCategory", {
            coloreC:$('#colorCategory').colorpicker('getValue'),
            categoria:$('#categoriaAdd').val(),
        }, 
            function(data){
                if (data=='success'){
                    $('#addCategory').modal('hide');
                    tableCategory.ajax.reload();
                }else if (data=='errorData'){
                    $('#addCategory .alert-danger').removeClass('hide');
                    $('#addCategory .alert-danger').html('<strong>Attenzione!</strong> Inserimento fallito!');     
                }
            }    
        );  
    } 
});

//caricamento modal inserimento nuova voce click aggiungi
$('#aggiungiV').on('click',function(){
    $('#addVoce .alert-danger').addClass('hide');
    document.getElementById('addFormV').reset();
    //recupero categorie spesa
    $.post("getExpenseCategory", {}, 
        function(data){
            $('#categoriaV').html(data);
        }    
    );
    
});

//aggiungo voce
$('#addVoce .btn-primary').on('click',function(){
   //controllo inserimento dati
    if ($('#voceAdd').val()==''){
        $('#addVoce .alert-danger').removeClass('hide');
        $('#addVoce .alert-danger').html('<strong>Attenzione!</strong> Inserire tutti i campi!');
    }else{
        $.post("addVoce", {
            coloreV:$('#colorVoce').colorpicker('getValue'),
            categoria:$('#categoriaV').val(),
            voce:$('#voceAdd').val()
        }, 
            function(data){
                if (data=='success'){
                    $('#addVoce').modal('hide');
                    tableVoci.ajax.reload();
                }else if (data=='errorData'){
                    $('#addVoce .alert-danger').removeClass('hide');
                    $('#addVoce .alert-danger').html('<strong>Attenzione!</strong> Inserimento fallito!');     
                }
            }    
        );  
    } 
});

//caricamento modal inserimento nuova det click aggiungi
$('#aggiungiD').on('click',function(){
    $('#addDet .alert-danger').addClass('hide');
    document.getElementById('addFormD').reset();

});

//aggiungo voce det
$('#addDet .btn-primary').on('click',function(){
   //controllo inserimento dati
    if ($('#detAdd').val()==''){
        $('#addDet .alert-danger').removeClass('hide');
        $('#addDet .alert-danger').html('<strong>Attenzione!</strong> Inserire un nome valido!');
    }else{
        $.post("addDet", {
            nomeDet: $('#detAdd').val()
        }, 
            function(data){
            console.log(data);
                if (data=='success'){
                    $('#addDet').modal('hide');
                    tableDet.ajax.reload();
                }else if (data=='errorData'){
                    $('#addDet .alert-danger').removeClass('hide');
                    $('#addDet .alert-danger').html('<strong>Attenzione!</strong> Inserimento fallito!');     
                }
            }    
        );  
    } 
});

/****************BACKUP********************/
//caricamento modal inserimento nuova voce click aggiungi
$('#backup').on('click',function(){
    //richiamo funzione backup
    $.post("backupDB", {}, 
        function(data){
			if (data=='success'){
				$('#messageB').removeClass('hide');
				$('#messageB').addClass('alert-success');
				$('#messageB').removeClass('alert-danger');
				$('#messageB').text('Salvataggio dati riuscito!');
			}else{
				$('#messageB').removeClass('hide');
				$('#messageB').removeClass('alert-success');
				$('#messageB').addClass('alert-danger');
				$('#messageB').text('Salvataggio dati non riuscito!');
			}
            
        }    
    );
    
});

/**************************FUNZIONI UTILITÀ***********************/
function codeToColor(code){
    return '<canvas width="50" height="25" style="background-color:'+code+';"></canvas>';
}