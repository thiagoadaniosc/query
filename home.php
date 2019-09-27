<?php require_once 'bootstrap.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="vendor/components/jquery/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-dark navbar-expand-lg bg-dark mb-2">
        <a class="navbar-brand text-center" href="#">Query Executator</a>

        </nav>
        <div class="row">
            <div class="col-4">
                <h5>Bancos</h5>
                <ul> 
                    <?php foreach ($dataBases as $banco): ?>
                    <li>
                        <input type="checkbox" name="<?= $banco ?>" value="<?= $banco?>" id="<?= $banco ?>"> 
                        <label for="<?= $banco; ?>"><?= $banco; ?></label>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-8">
                <h5>Query</h5>
                <textarea name="" id="" cols="30" rows="10" class="w-100 form-control shadow"></textarea>
                <button class="btn btn-primary float-right mt-1">Executar Query</button>
            </div>
        </div>


    </div>
</body>
</html>