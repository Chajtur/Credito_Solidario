
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
</head>
<body>

    <!-- Esta solo es una prueba para el api -->

    <input type="text" name="" id="usuario">
    <input type="text" name="" id="password">
    <button id="btn">Loguearse</button>
    <script>

        $(document).ready(function(){

            $('#btn').click(function(){
                var obj = {
                    usuario: $('#usuario').val(),
                    password: $('#password').val()
                }
                $.ajax({
                    type: 'POST',
                    url: 'api.php',
                    data: 'object='+JSON.stringify(obj),
                    success: function(data){
                        console.log(data);
                    }
                });
            });

        });

    </script>
</body>
</html>