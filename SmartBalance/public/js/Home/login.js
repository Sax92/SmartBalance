//funzione login al click del pulsante
$('#login').on('click',function(){
    //se i campi sono vuoti non eseguo
    if ( ($('#email').val()=='') || ($('#password').val()=='') ){
        $('.alert-danger').removeClass('hide');
        $('.alert-danger').text('Devi inserire tutti i campi!');
    }else{
        //effettuo chiamata ajax post
        $.post("login", {
                email: $('#email').val(),
                pwd: $('#password').val(),
                remember: ($('#remember').prop('checked'))? 1:0
            }, 
            function(data){
                if (data=='error'){
                    $('.alert-danger').removeClass('hide');
                    $('.alert-danger').text('email e/o password non sono corretti!');
                }else if(data=='success'){
                    window.location.assign('http://'+location.hostname+'/SmartBalance/public/userManager/');
                }
            }    
        );
    }
    
});


$("body").keyup(function(event){
    if(event.keyCode == 13){
        $("#login").click();
    }
});
