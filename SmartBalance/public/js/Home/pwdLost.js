$('#updatePassword').click(function(){
    $.ajax({       
            url     : "resetPassword",
            type    : "post",
            data    : {
                email:$('#emailLost').val(),
                pwdnew:$('#pwdNew').val(),
                pwdconf:$('#pwdConfirm').val()
            },
            success : function (data){
                console.log(data);
               switch(data){
                   case "vuota":
                       $('#messageLost').html("Devi inserire tutti i campi");
                       $('#messageLost').show();
                       break;
                    case "notEqual":
                       $('#messageLost').html("Le due password non corrispondono");
                       $('#messageLost').show();
                       break;
                    case "notPresent":
                       $('#messageLost').html("Devi inserire un email valida!");
                       $('#messageLost').show();
                       break;
                    case "ok":
                       $('#messageLost').html("AGGIORNAMENTO RIUSCITO!");
                       $('#messageLost').show();
                       setTimeout(function(){ location.reload();  window.location.assign("index"); }, 2000);
                       break;
                }
            },
            error : function (request, status, error) {
                alert("jQuery AJAX request error:".error);
            }
        }); 
});