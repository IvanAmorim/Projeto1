<title>{{ $categoria }}</title>
@extends('layouts.app')
@section('links')
    <link href="{{ asset('css/ServiceTemplate.css') }}" rel="stylesheet">
@endsection
@section('content')
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
    
    @guest
        <div class="text-center mt-5 text-danger fw-bold">
            <h3>Para poder continuar faça 
            <a href="{{ route('login') }}">login</a> !!!</h3>
            
        </div>
    @else
    

    <div class="title center ">
        <h1>Plataforma digital de mediação de serviços pessoais!!!</h1>
        <?php echo("<img src='/images/$id.jpg' class='image'>") ?>
        
    </div>

    <div class="wrap">

        <form action="datainsert" method="post" enctype="multipart/form-data">
            @csrf
            <?php
            $i = 0;
            
                foreach ($perguntas as $pergunta) {
                    echo('<div class="card">
                            <div class="container1">');
                    echo("<h4>$pergunta->Pergunta</h4>");
                    
                    if($pergunta->tipo_resposta==2){
                        foreach ($respostas as $resposta) {
                            if($resposta->ID_pergunta == $pergunta->ID){
                                $resp="resposta".$i;
                                echo("<input class='resposta' type='radio' name='$resp' value=$resposta->ID>
                                        <label class='resposta' for='$resposta->ID'>$resposta->Resposta</label><br>");
                            
                            }
                        }
                        
                    }else{
                        $resp="resposta".$i;
                        echo("<input type='text' class='textbox' name='$resp'>");
                    }


                    $i++;
                    echo('</div>
                            </div>');
                }

            ?>   
            
            <div class="card">
                <div class="container1">
                    <h4>Tem mais informações que ainda não nos deu?</h4>
                    <textarea class='textarea' name='informacoes' placeholder=' Outros detalhes que queira mencionar?'></textarea>    
                </div>    
            </div>            
            
            
            <div class="card">
                <div class="container1">
                    <h4>Indique a sua localização</h4>
                    <h6>Concelho</h6>
                    <input type='text' class='textbox mb-3' name='Concelho' placeholder=' Ex.Viana do Castelo'>    
                    <h6>Lugar</h6>
                    <input type='text' class='textbox mb-3' name='Lugar' placeholder=' Ex.Av. do Atlântico 644'>    
                    <h6>Código postal</h6>
                    <input type='text' class='textbox' name='codPostal' placeholder=' ex. 4900'>    
                </div>    
            </div>   
            
            <div class="card">
                <div class="container1">
                    <h4>Como é que os especialistas podem entrar em contacto?</h4>
                    <h6>Email: </h6>
                    <input id="email" type="email" class="form-control textbox @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" >

                    <h4>Indique o seu Nome e Apelido </h4>
                    <input type='text' class='textbox' name='nomeApelido' placeholder=' Nome e Apelido'>    
                    <p>Nº Telemóvel</p>
                    <input type='text' class='textbox' name='tel' placeholder=' ex. 961254963'>    
                
                
                </div>    
            </div> 
        
            
            
            <div class="card">
                <div class="container1">
                    <button type="submit" class="button" name='id' value='{{ $id }}'> Enviar</button>
                </div>    
            </div>            
        </form>
    </div>
    @endguest
@endsection