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

                    <p class="reg_input_title" >Name</p>
                    <div class="login_modal_form_relative">
                        <input required class="reg_input input_login" type="text" name="name">
                    </div>
                    <p class="reg_input_title" >Surname</p>
                    <div class="login_modal_form_relative">
                        <input required class="reg_input input_login" type="text" name="surname">
                    </div>
                    <p class="reg_input_title" >Email</p>
                    <div class="login_modal_form_relative">
                        <input required class="reg_input input_login" type="email" name="email">
                    </div>
                    <p class="reg_input_title " >Пароль</p>
                    <div class="login_modal_form_relative">
                        <input required class="reg_input input_pass" id="login_modal-password-input" type="password" name="password">
                    </div>
                    <br/><br/>
                    <button id="register_form_modal-submit_button" class="button_pink button_pink_background "  type="submit">Зарегистрироваться</button>

            </form>
            <button id="getData" class="button_pink button_pink_background " token onclick="getData(this)">Получить данные</button>
        
        </div>
        <script>

    let token = null;
	document.getElementById("login_modal_form").addEventListener("submit",function (event){
        event.preventDefault();
        document.getElementById("register_form_modal-submit_button").setAttribute("disabled",true);
    //    document.getElementById("login_modal_error").innerHTML = '';
        let formDataPost = new FormData(document.getElementById("login_modal_form"));
        let xhr = new XMLHttpRequest();
        xhr.open("POST", 'https://d434-46-56-217-34.ngrok-free.app/api/register');
        xhr.send(formDataPost);

        xhr.onload = async function (){
            document.getElementById("register_form_modal-submit_button").removeAttribute("disabled");
            const responseLoad = await xhr.response;

            const response = JSON.parse(responseLoad);
            console.log("response = ", response);
            if(response.status === 'success'){
                token = response.token
                document.getElementById("getData").setAttribute("token", `${token}`);
                // if(response.redirect){
                //     window.location.href = response.redirect;
                // }
            }
        }

        xhr.onerror = function (error) {
            console.log(error,"error");
        }
    })

    function getData(el){
        const token =  document.getElementById("getData").getAttribute("token");
      //  console.log("response = ", response);
        if (token){

            let xhr = new XMLHttpRequest();
            

            xhr.open("GET", "{{route('getData')}}");
            xhr.setRequestHeader('AUTH-TOKEN', token);
            xhr.send();

            xhr.onload = async function (){
             //   document.getElementById("register_form_modal-submit_button").removeAttribute("disabled");
                const responseLoad = await xhr.response;

                const response = JSON.parse(responseLoad);
                console.log("response = ", response);
                if(response.status === 200){
                    // if(response.redirect){
                    //     window.location.href = response.redirect;
                    // }
                }else if (response.status === 401){
                // document.getElementById("login_modal_error").innerHTML = response.message;
                }
            }

            xhr.onerror = function (error) {
                console.log(error,"error");
            }
        }
        
    }


    

</script>
    </body>
</html>
