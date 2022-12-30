@extends('layouts.app')
@section('content')



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Os meus pedidos</div>

                    <table class="table table-striped">
                        <tr>
                            <td>Tipo</td>
                            <td>Serviço</td>
                            <td>Informações</td>
                        </tr>
                        
                        @foreach ($results as $result )
                            <tr>
                                <td>{{ $result->NameType}}</td>
                                <td>{{ $result->NameService}}</td>
                                <td>{{ $result->userID}}</td>
                            </tr>
                        @endforeach
                    
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

