

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>

        </style>
    </head>
    <body class="antialiased">
        <div  id="login_modal">
       
            <form id="login_modal_form">
                {!! csrf_field() !!}

                    <p class="reg_input_title" >Email</p>
                    <div class="login_modal_form_relative">
                        <input required class="reg_input input_login" type="email" name="email">
                    </div>
                    <p class="reg_input_title " >Пароль</p>
                    <div class="login_modal_form_relative">
                        <input required class="reg_input input_pass" id="login_modal-password-input" type="password" name="password">
                    </div>
                    <br/><br/>
                    <button id="login_form_modal-submit_button" class="button_pink button_pink_background "  type="submit">Войти</button>

            </form>
           
        
        </div>
        <script>


	document.getElementById("login_modal_form").addEventListener("submit",function (event){
        event.preventDefault();
        document.getElementById("login_form_modal-submit_button").setAttribute("disabled",true);
    //    document.getElementById("login_modal_error").innerHTML = '';
        let formDataPost = new FormData(document.getElementById("login_modal_form"));
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "{{route('login')}}");
        xhr.send(formDataPost);

        xhr.onload = async function (){
            document.getElementById("login_form_modal-submit_button").removeAttribute("disabled");
            const responseLoad = await xhr.response;

            const response = JSON.parse(responseLoad);
            console.log("response = ", response);
            if(response.status === 200){
                if(response.redirect){
                    window.location.href = response.redirect;
                }
            }else if (response.status === 401){
               // document.getElementById("login_modal_error").innerHTML = response.message;
            }
        }

        xhr.onerror = function (error) {
            document.getElementById("login_form_modal-submit_button").removeAttribute("disabled");
            console.log(error,"error");
        }
    })


    

</script>
    </body>
</html>
