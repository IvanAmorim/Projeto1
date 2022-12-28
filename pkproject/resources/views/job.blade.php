<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/css/job.css" rel="stylesheet"> 
    <link href="{{ asset('css/ServiceTemplate.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    


    <title>{{ $categoria }}</title>
</head>
<body>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        @if (Session::has('success'))
            toastr.options = 
            {
                "closeButton":true,
                "progressBar"
            }
            toastr.success("{{ session('success') }}")
            
        @endif
  
@if ($errors->any())
    toastr.error("Por favor preencha todos os campos", "Erro")
@endif
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/4388aefc94.js" crossorigin="anonymous"></script>

    
    <div class="title center ">
        <h1>Plataforma digital de mediação de serviços pessoais!!!</h1>
<?php echo("<img src='/images/$categoria.jpg' class='image'>") ?>
        
    </div>




    <div class="wrap">

        <form action="datainsert" method="post" enctype="multipart/form-data">
            @csrf
            <?php
            $count = 0;
            
                foreach ($perguntas as $pergunta) {
                    echo('<div class="card">
                            <div class="container">');
                    echo("<h4>$pergunta->Pergunta</h4>");
                    switch ($count) {
                        case '0':
                            $resp="resposta1";
                            break;
                        case '1':
                            $resp="resposta2";
                            break;
                        case '2':
                            $resp="resposta3";
                            break;
                        case '3':
                            $resp="resposta4";
                            break;
                        case '4':
                            $resp="resposta5";
                            break;
                    }
                    $count++;
                    foreach ($respostas as $resposta) {
                        if($resposta->ID_pergunta == $pergunta->ID)
                       
                            echo("<input class='resposta' type='radio' name='$resp' value=$resposta>
                                    <label class='resposta' for='$resposta->ID'>$resposta->Resposta</label><br>");

                    }

                    echo('</div>
                            </div>');
                }

            ?>   
            
            <div class="card">
                <div class="container">
                    <h4>Tem mais informações que ainda não nos deu?</h4>
                    <textarea class='textarea' name='informacoes' placeholder=' Outros detalhes que queira mencionar?'></textarea>    
                </div>    
            </div>            
            
            
            <div class="card">
                <div class="container">
                    <h4>Indique o seu codigo postal</h4>
                    <h6>Usamos o código postal para encontrar os melhores especialistas perto de si.</h6>
                    <input type='text' class='textbox' name='codPostal' placeholder=' Código Postal (ex. 1000-001)'>    
                </div>    
            </div>   
            
            <div class="card">
                <div class="container">
                    <h4>Como é que os especialistas podem entrar em contacto?</h4>
                    <h6>Email: </h6>
                    <input type='text' class='textbox' name='email' placeholder=' Email'>    
                    <h4>Indique o seu Nome e Apelido </h4>
                    <input type='text' class='textbox' name='nomeApelido' placeholder=' Nome e Apelido'>    
                    <p>Nº Telemóvel</p>
                    <input type='text' class='textbox' name='tel' placeholder=' ex. 961254963'>    
                
                
                </div>    
            </div> 
        
            
            
            <div class="card">
                <div class="container">
                    <input type="submit" class="button"> 
                </div>    
            </div>            
        </form>
    </div>
</body>
</html>
  