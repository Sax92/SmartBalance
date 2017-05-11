/********aggiornamento dati*********/
$('#edit').click(function(){
	$('#editUser').removeClass('hide');
	$('#profileUser').addClass('hide');
	$('#edit').addClass('hide');
	$('#update').removeClass('hide');
})


$('#update').click(function(){
    if (($('#emailU').val().trim().indexOf('@')==-1) || ($('#nomeU').val().trim()=='') || ($('#cognomeU').val().trim()=='')){
        $('#errorModal').modal();
    }else{
        $.ajax({       
        url     : "updateUser",
        type    : "post",
        data    : {
            nome:$('#nomeU').val().trim(),
            cognome:$('#cognomeU').val().trim(),
            email:$('#emailU').val().trim(),
            comune:$('#comuneU').val().trim(),
            indirizzo:$('#indirizzoU').val().trim(),
            citta:$('#cittaU').val().trim(),
            provincia:$('#provinciaU').val().trim(),
            cap:$('#capU').val().trim(),
            telefono:$('#telefonoU').val().trim(),
            cellulare:$('#cellulareU').val().trim(),
            pIva:$('#pIvaU').val().trim(),
            cf:$('#cfU').val().trim()
        },
        success : function (data){
            console.log(data);
            if (data=="true"){
                $('#userUpdated').removeClass('hide');
                setTimeout(function(){ location.reload();  $("#dvloader").hide(); }, 2000);
            }else{
                $('#userErrorUpdate').removeClass('hide');
            }
        },
        error : function (request, status, error) {
            alert("jQuery AJAX request error:".error);
        }
    });
    }
	
})

$('#photo').click(function(){
    $('#photo').addClass('hide');
    $('#confirm').removeClass('hide');
    $('#upload').removeClass('hide');
})
