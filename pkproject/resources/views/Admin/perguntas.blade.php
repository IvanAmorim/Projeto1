@extends('layouts.app')

@section('content')



    <div class="container p-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card row-gap-3 " >
                    <div class="card-header text-center">
                        <h3>Inserir Perguntas - {{ $name }}</h3>
                    </div>
                    
                    <form action="perguntas" method="post" class="was-validated ps-3" enctype="multipart/form-data">
                        @csrf
                        <h5>Indique a pergunta</h5>
                        <input type="text" name="pergunta" style="width: 50%;" required> 
                        <h5 class="pt-3">Indique o tipo de resposta</h5>
                        <button type="submit" class="btn btn-primary" name="tipo" value="3">Escolha multipla</button>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Texto</button>
                        
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
                                <button type="submit" class="btn btn-secondary" name="tipo" value="2">Não</button>
                                <button type="submit" class="btn btn-primary" name="tipo" value="1">Sim</button>
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
