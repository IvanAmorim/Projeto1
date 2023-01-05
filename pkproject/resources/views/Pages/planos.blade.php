@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="text-center pt-5">
            <h2>Pacotes</h2>
            <p>Conheça todos os nossos pacotes e escolha o mais útil para si.</p>
            <h6>Os meus créditos: {{ $creditos }} créditos</h6>
        </div>

        <form action="/Pages/plano" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card-group mt-5">
                            
                        <div class="card">
                            <div class="card-body text-center">
                                <h4 class="card-title">Recarga</h4>
                                <h5> 5 </h5>
                                <p class="card-text">créditos</p>
                                <h6>10€</h6>
                                <button type="submit" class="btn btn-primary" name="tipo" value="5">Comprar</button>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body text-center">
                                <h4 class="card-title">Starter</h4>
                                <h5> 20 </h5>
                                <p class="card-text">créditos</p>
                                <h6>30€</h6>
                                <button type="submit" class="btn btn-primary" name="tipo" value="20">Comprar</button>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </div>
                        </div>
                        
                        <div class="card">
                            <div class="card-body text-center">
                                <h4 class="card-title">Pro</h4>
                                <h5> 50 </h5>
                                <p class="card-text">créditos</p>
                                <h6>60€</h6>
                                <button type="submit" class="btn btn-primary" name="tipo" value="50">Comprar</button>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection