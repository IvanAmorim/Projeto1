@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header ">Pesquisar pedidos</div>
                        <div>
                            <form action="prestadores" method="GET">
                            <select class="block-header w-50 text-center ">
                                <?php
                                echo("<option>--Selecione um tipo de servico--</option>");
                                $servico="";
                                foreach ($results as $result){
                                    if($result->Name!=$servico){
                                        echo("<option value=' {{ $result->Name }} '> $result->Name </option>");
                                        $servico=$result->Name;
                                    }    
                                }
                                
                                ?>
                            </select>
                            <button type="submit" class="btn btn-primary">Procurar</button>
                        </form>

                        </div>

                    <table class="table table-striped">
                        @foreach ($results as $result )
                            <tr>
                                <div class="card w-auto mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title ">{{ $result->Nome }}</h5>
                                        <p class="card-text">{{ $result->Name }}</p>
                                        <p class="card-text fw-light">{{ $result->CodPostal }},{{ $result->Lugar }}({{ $result->Concelho }})</p>
                                        <a href="#" class="btn btn-primary">Ver detalhes</a>
                                    </div>
                                    </div>
                            </tr>     
                        @endforeach
                        
                        
                       
                    
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection