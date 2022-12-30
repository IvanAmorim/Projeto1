@extends('layouts.app')

@section('content')

    <div class="container p-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center row-gap-3">
                    <div class="card-header">
                        <h3>Insira uma das respostas - {{ $pergunta }}</h3>
                    </div>
                    
                    <form action="respostas" method="post" enctype="multipart/form-data">
                        @csrf
                        <h5>Indique indique a resposta</h5>
                        <input type="text" name="resposta" style="width:40%" required>      
                        <br>                 
                            
                        <button type="submit" class="btn btn-secondary mt-3" name="mais" value="3">Adicionar mais</button>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Concluido</button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Perguntas</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                Deseja adicionar mais perguntas
                                </div>
                                <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary" name="mais" value="2">Não</button>
                                <button type="submit" class="btn btn-primary" name="mais" value="1">Sim</button>
                                </div>
                            </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection 
