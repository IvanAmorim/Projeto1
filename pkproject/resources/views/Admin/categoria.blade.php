@extends('layouts.app')

@section('content')
    

    <div class="container p-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center row-gap-3">
                    <div class="card-header">
                        <h3>Inserir categoria</h3>
                    </div>
                    
                    <form action="categoria" method="post" enctype="multipart/form-data">
                        @csrf
                        <?php
                            echo("<h5>Indique o tipo de categoria</h5>");
                            foreach ($categorias as $categoria) {
                                echo("<input class='resposta' type='radio' name='categoria' value=$categoria->ID>
                                            <label class='resposta' for='$categoria->ID'>$categoria->Name</label><br>");

                            }
                        ?>

                        <h5 class="pt-3">Indique o nome da categoria</h5>
                        <input type="text" name="nome">
                        <input type="submit" class="btn btn-primary"> 

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection