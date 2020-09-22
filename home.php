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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js"></script>    <title>Query Executator</title>
    <style>
        #query {
            height: 300px;
            font-size: 18px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark mb-2">
        <a class="navbar-brand text-center" href="#">Query Executator</a>
    </nav>
    <div class="container-fluid">

        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h5> <i class="fa fa-database"></i> &nbsp; Bancos de Dados
                        </h5>                   
                    </div>
                    <div class="card-body">
                        <button class="btn btn-primary float-right" id="select-gestao"><span class="fa fa-check-square-o"></span>&nbsp; SELECIONAR BASES DO GESTÃO</button>
                        <ul class="list-unstyled"> 
                            <?php foreach ($dataBases as $banco): ?>
                            <li style="zoom: 1.2">
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header"><h5>  <i class="fa fa-code"></i>&nbsp;Consulta</h5></div>
                            <div class="card-body">
                                <div id="query">SELECT * from clientes;</div>
                                <button type="button" class="btn btn-primary float-right mt-4 btn-executar"> <i class="fa fa-play" aria-hidden="true"></i> Executar Query</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-2">
                        <div class="card">
                            <div class="card-header"><h5>  <i class="fa fa-code"></i>&nbsp;Retorno</h5></div>
                            <div class="card-body">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab-result" role="tablist"></div>
                                </nav>
                                <div class="tab-content" id="nav-tab-content-result">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <script type="text/javascript">
        var sql = ace.edit("query");
        sql.session.setMode("ace/mode/mysql");

        $('#select-gestao').on('click', () => {
            $("input[id^='opmes_']").prop( "checked", true );;
        });

        $('.btn-executar').on('click', event => {
            event.preventDefault();
            if($('.databases:checked').length == 0){
                alert("Você deve selecionar ao menos um banco de dados");
                return false;
            }
            $('.btn-executar').html(`<i class="fa fa-spin fa-spinner" aria-hidden="true"></i> Executando`);
            $('.query-result').removeClass('fa-check');
            $('.query-result').removeClass('fa-times');
            let databases = [];
            $('.databases:checked').each((index, element) => {
                let database = $(element).val();
                databases.push(database);
                let elementStatus = $(element).parent().find('.query-result');
                elementStatus.removeClass('d-none');
                elementStatus.addClass('fa-spinner');
                elementStatus.addClass('fa-spin');
            });

            $.ajax({
                type: 'POST',
                url: './executar.php',
                data: {
                    databases: databases,
                    query: sql.getValue()
                },
                success: function (data){
                    if (data.retorno) {
                        let dbStatus = data.dbstatus;
                        let mensagem = data.mensagem;
                        $("#nav-tab-result").empty();
                        $("#nav-tab-content-result").empty();
                        let flagFirstDb = true;
                        for (let db in dbStatus) {
                            let elementStatus = $("#"+db).parent().find('.query-result');  

                            if (dbStatus[db] == true) {
                                elementStatus.addClass('fa-check');
                            } else {
                                elementStatus.addClass('fa-times');
                            }

                            elementStatus.removeClass('fa-spinner');
                            elementStatus.removeClass('fa-spin');
                            
                            let cabecalho = ``;
                            let conteudo = ``;
                            let result = mensagem[db];
                            if (dbStatus[db] == true) {
                                if (result.length == 0) {
                                    cabecalho = `<tr><th>Resultado</th></tr>`
                                    conteudo = `<strong class="text-primary"> Nenhum dado retornado </strong>`;
                                    conteudo = `<tr><td>${conteudo}</td></tr>`;
                                } else {
                                    let flagCabecalho = false;
                                    for (let dado of result) {
                                        let conteudoLinha = ``;
                                        let cabecalhoLinha = ``;
                                        for (let campo in dado) {
                                            conteudoLinha += `<td style="white-space: nowrap;">${dado[campo]}</td>`;
                                            if (flagCabecalho == false) {
                                                cabecalhoLinha += `<th style="white-space: nowrap;">${campo}</th>`;
                                            }
                                        }
                                        if (flagCabecalho == false) {
                                            cabecalho += `<tr>${cabecalhoLinha}</tr>`;
                                        }
                                        flagCabecalho = true;
                                        conteudo += `<tr>${conteudoLinha}</tr>`
                                    }
                                }                           
                            } else {
                                cabecalho = `<tr><th>Resultado</th></tr>`
                                conteudo = `<strong class="text-danger">Error: </strong> ${result[0]}`;
                                conteudo = `<tr><td>${conteudo}</td></tr>`;
                            }
                            
                            let statusIcon = `<span class="fa query-result fa-check"></span>`;
                            if (dbStatus[db] == false) {
                                statusIcon = `<span class="fa query-result fa-times"></span>`;
                            }

                            let classActivetab = "";
                            let classActiveContent = "";
                            if (flagFirstDb) {
                                classActivetab = "active";
                                classActiveContent = "show active";
                                flagFirstDb = false;
                            }

                            $('#nav-tab-result').append(`<a class="nav-item nav-link ${classActivetab}" id="nav-${db}-tab" data-toggle="tab" href="#nav-${db}" role="tab" aria-controls="nav-${db}" aria-selected="true">${db}&nbsp;${statusIcon}<a>`);
                            $('#nav-tab-content-result').append(`<div class="tab-pane fade ${classActiveContent}" id="nav-${db}" role="tabpanel" aria-labelledby="nav-${db}-tab">
                                <div style="max-height: 800px; overflow: auto;">
                                    <table class="table table-hover table-bordered" >
                                        <thead>
                                            ${cabecalho}
                                        </thead>
                                        <tbody>
                                            ${conteudo}
                                        </tbody>
                                    </table>
                                </div>
                            </div>`);
                        }                        
                    } else {
                        alert("ocorreu um problema durante a execução, recarrege a página e tente novamente.");
                    }
                    setTimeout(() => {
                        $('.btn-executar').html(`<i class="fa fa-play" aria-hidden="true"></i> Executar Query`);
                    }, 100);
                }
            });
            
        });
        
    </script>
</body>
</html>