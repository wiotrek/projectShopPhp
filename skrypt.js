


$(document).ready(function () {

    let mainBool = true;

    $(".logging").click(function () {
        if (mainBool) {
            //hide a selector main
            $("main").hide();
            $(".registerFailed").hide();
            $(".hideRegister").hide();
            mainBool = false;

            $('.logging').text("Jednak nie chce sie logowac");

            //adding a new main div
            let mainLogging = $("<div class='mainLogging'><form class='LoggingForm' action='logging.php' method='post'><table class='tableLogging'></table></form></div>");
            $('body').append(mainLogging);

            //creating table for form
            const tableLoggingLogin = $("<tr><td><p>Podaj swoj login</p></td><td><input class='login' type='text' name='login'/></td></tr>");
            const tableLoggingPass = $("<tr><td><p>Podaj swoje haslo</p></td><td><input class='pass' type='password' name='pass'/></td></tr>");
            const tableLoggingSubmit = $("<tr><td></td><td><button class='LoggingSend'>OK</button></td></tr>");
            const LoggingErrorMessage = $("<tr><td></td><td>Podaj login lub haslo</td></tr>");
            $('table').append(tableLoggingLogin);
            $('tr').after(tableLoggingPass, tableLoggingSubmit, LoggingErrorMessage);


            $(LoggingErrorMessage).hide();


            $(".LoggingSend").click(function () {
                var login = $('.login').val();
                var password = $('.pass').val();

                if (login == '' || password == '') {
                    $(LoggingErrorMessage).show();
                    return false;
                } else {
                    $(LoggingErrorMessage).hide();
                }
            });

        } else {
            $("main").show();
            $(".hideRegister").show();
            mainBool = true;

            // change name button
            $('.logging').text("logowanie");

            //deleting a new div
            $('.mainLogging').detach();

        }
    });

    $("button.registerButton").click(function(){
        if(mainBool){
            $("main").hide();
            $(".hideLogging").hide();
            $(".registerFailed").hide();
            $(".registerButton").text("Jednak mam");

            mainBool = false;


            //adding a new main div
            let mainRegister = $("<div class='mainRegister'><form class='RegisterForm' action='register.php' method='post'><table class='tableRegister'></table></form></div>");
            $('body').append(mainRegister);

            //creating table for form
            const tableRegisterLogin = $("<tr><td><p>Login:&nbsp</p></td><td><input class='login' type='text' name='login'/></td></tr>");
            const tableRegisterName = $("<tr><td><p>Imie: &nbsp</p></td><td><input class='name' type='text' name='name'/></td></tr>");
            const tableRegisterSurname = $("<tr><td><p>Nazwisko: &nbsp</p></td><td><input class='surname' type='text' name='surname'/></td></tr>");
            
            const tableRegisterPass = $("<tr><td><p>Haslo: &nbsp</p></td><td><input class='pass' type='password' name='pass'/></td></tr>");
            const tableRegisterPassCheck = $("<tr><td><p>Powtorz Haslo: &nbsp</p></td><td><input class='passCheck' type='password'/></td></tr>");

            const tableRegisterSubmit = $("<tr><td></td><td><button class='registerSend'>Rejestruj!</button></td></tr>");
            const RegisterErrorMessage = $("<tr><td></td><td>Uzupelnij brakujace pole</td></tr>");
            $('table').append(tableRegisterLogin);
            $('tr').after(tableRegisterName, tableRegisterSurname, tableRegisterPass, tableRegisterPassCheck, tableRegisterSubmit, RegisterErrorMessage);


            $(RegisterErrorMessage).hide();

            $(".registerSend").click(function () {
                var login = $('.login').val();
                var name = $('.name').val();
                var surname = $('.surname').val();
                var password = $('.pass').val();
                var passwordCheck = $('.passCheck').val();
                
                $(RegisterErrorMessage).text("Uzupelnij brakujace");
                $(RegisterErrorMessage).hide();

                if (login == ''  || name == '' || surname == '' || password == '' || passwordCheck == '') {
                    $(RegisterErrorMessage).show();
                    return false;
                } else {
                    if( password == passwordCheck){
                        if(password.length > 6 ){
                            $(RegisterErrorMessage).hide();
                        }else{
                            $(RegisterErrorMessage).text("Haslo musi miec minimum 6 znakow");
                            $(RegisterErrorMessage).show();
                            return false;
                        }     
                    }else{
                        $(RegisterErrorMessage).text("Hasla sie roznia!");
                        $(RegisterErrorMessage).show();
                        return false;
                    }      
                }
            });


        }else{
            $("main").show();
            $(".hideLogging").show();
            $(".registerButton").text("Rejestracja");

            mainBool = true;

            //deleting a new div
            $('.mainRegister').detach();
        }
        



    });

    $('button.pluseOrder').click(function (e) {
        e.preventDefault();
        $countOrderValue = $('input.countOrder').attr('value');
        $countOrderValue = parseInt($countOrderValue) + 1; 
        $('input.countOrder').attr('value', $countOrderValue);
    });


    $('button.minuseOrder').click(function (e) {
        e.preventDefault();
        $countOrderValue = $('input.countOrder').attr('value');
        $countOrderValue = parseInt($countOrderValue) - 1; 
        if($countOrderValue < 1)
            $('input.countOrder').attr('value', 0);
        else
            $('input.countOrder').attr('value', $countOrderValue);
    });

});
