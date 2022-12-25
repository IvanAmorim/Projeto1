<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/css/ServiceTemplate.css" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
    
    <title>Serviço</title>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/4388aefc94.js" crossorigin="anonymous"></script>

    <div class="title center">
        <h1>Plataforma digital de mediação de serviços pessoais!!!</h1>

        <div class="search-container center">
            <form action="/action_page.php">
              <input type="text" placeholder="Procure um serviço " name="search" class="search">
              <button type="submit" class="button">Procurar</button>
              
            </form>
        </div>
    </div>
    <div class="body">
        @foreach ($categories as $category)
            <div class="bannerservico">
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
                    if ($example->ID_TypeService == $service->ID)
                        echo ("<p>$example->Name </p>");
                    
                    
            }
            echo ('</div>');
            echo ('</div>');
            echo ('</div>');
            $count++;
        }
        ?>
    </div>    
</body>
</html>