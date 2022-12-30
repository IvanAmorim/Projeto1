@extends('layouts.app')

@section('content')

    <div class="container p-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center row-gap-3">
                    <div class="card-header">
                        <h3>Inserir serviço</h3>
                    </div>
                    
                    <form action="servico" method="post" enctype="multipart/form-data">
                        @csrf
                        <?php
                            echo("<h5>Indique o tipo de categoria</h5>");
                            foreach ($servicos as $servico) {
                                echo("<input class='resposta' type='radio' name='categoria' value=$servico->ID>
                                            <label class='resposta' for='$servico->ID'>$servico->Name</label><br>");

                            }
                            echo("<h5 class='pt-3'>Indique o nome do serviço</h5>");
                            echo("<input type='text' name='nome'>");
                            
                            
                        ?>
       

                        
                            
                        <input type="submit" class="btn btn-primary"> 

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection 
