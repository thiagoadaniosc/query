<?php require_once 'bootstrap.php' ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <script src="vendor/components/jquery/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.3/js/tether.min.js"></script>
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <title>Query Executator</title>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-dark navbar-expand-lg bg-dark mb-2">
        <a class="navbar-brand text-center" href="#">Query Executator</a>

        </nav>
        <form>
        <div class="row">
           
            <div class="col-4">
                <div class="card">
                    <div class="card-header"><h5> <i class="fa fa-database"></i> &nbsp; Bancos de Dados</h5></div>
                    <div class="card-body">
                        <ul class="list-unstyled"> 
                            <?php foreach ($dataBases as $banco): ?>
                            <li>
                                <input type="checkbox" name="databases[]" class="databases" value="<?= $banco?>" id="<?= $banco ?>"> 
                                <label for="<?= $banco; ?>"><?= $banco; ?></label>
                                <span class="fa fa-spin fa-spinner query-result d-none"></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header"><h5>  <i class="fa fa-code"></i>  Query</h5></div>
                    <div class="card-body">
                        <textarea name="query" id="query" cols="30" rows="10" class="w-100 form-control"></textarea>
                    </div>
                </div>
                <button type="button" class="btn btn-primary float-right mt-1 btn-executar"> <i class="fa fa-play" aria-hidden="true"></i> Executar Query</button>

            </div>
            <div class="col-lg-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Retorno</th>
                        </tr>
                    </thead>
                    <tbody id="result">
                    </tbody>
                </table>
            </div>
        </div>
        </form>



    </div>
    <script>
        $('.btn-executar').on('click', event => {
            event.preventDefault();
            if($('.databases:checked').length == 0){
                alert("Você deve selecionar ao menos um banco de dados");
                return false;
            }
            $('.databases:checked').each((index, element) => {
                let database = $(element).val();
                let elementStatus = $(element).parent().find('.query-result');
                elementStatus.removeClass('d-none');
                $.ajax({
                    type: 'POST',
                    url: './executar.php',
                    data: {
                        databases: [database],
                        query: $('#query').val()
                    },
                    success: function (data){
                        if (data.retorno) {
                            $('#result').append(`
                                <tr>
                                    <td>${data.mensagem[0]}</td>
                                </tr>
                            `);
                            elementStatus.addClass('fa-check');
                            elementStatus.removeClass('fa-spinner');
                            elementStatus.removeClass('fa-spin');
                            
                        } else {
                            elementStatus.addClass('fa-times');
                            elementStatus.removeClass('fa-spinner');
                            elementStatus.removeClass('fa-spin');
                        }
                    }
                });
            });
        });
        
    </script>
</body>
</html>