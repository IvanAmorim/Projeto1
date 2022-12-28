@extends('template')
@section('content')

    <div class="body">
        @foreach ($categories as $category)
            <div class="bannerservico">
                @section('titulo',$category->Name)
                <h1>{{ $category->Name }}</h1>
                <h2>{{ $category->Description }}</h2>

            </div>
        @endforeach
        <?php
        $count=0;
        
        foreach ($services as $service ){
            
            if($count % 2){

                echo ('<div class="column side right ">'); 
            }
            else {
                echo ('<div class="column side row left">');
            }
            echo ('<div class="examples">');
            echo ("<h3> $service->Name </h3>");
               
            foreach ($examples as $example){
                if ($example->ID_TypeService == $service->ID){
                    $route=route("job",['id'=>$example->ID]);
                    echo("<p><a href='$route'> $example->Name </a></p>");
                }
            }

            echo ('</div>');
            echo ('</div>');
            $count++;
        }
        ?>
        
    </div>    
@endsection