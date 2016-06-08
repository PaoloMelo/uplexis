<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <title>Aplicativo</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="<?php echo LIB;?>bootstrap-3.3.6-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo LIB;?>bootstrap-3.3.6-dist/css/bootstrap-theme.min.css">
        <script src="<?php echo LIB;?>jquery-1.12.4.min.js"></script>
        <script src="<?php echo LIB;?>bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">

        <nav role="navigation" class="navbar navbar-default">
        
            <div class="navbar-header">
                <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">                    
                    <span class="sr-only">Navegação Responsiva</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                
                </button>                
                <a href="#" class="navbar-brand">Uplexis</a>                
            </div>
            
            <div id="navbarCollapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo PATH;?>home/index">Aplicativo</a></li>
                    <li class="active"><a href="<?php echo PATH;?>relatorios/consultas-efetuadas">Relatório</a></li>
                </ul>
            </div>
        
        </nav>

            <h1 class="page-header">Consultas Efetuadas</h1>

            <div id="list" class="row">
             
                <div class="table-responsive col-md-12">
                    <table class="table table-striped" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>CNPJ</th>
                                <th class="actions">Ações</th>
                             </tr>
                        </thead>
                        <tbody>
                            <div id="retornoConsulta" class="well well-sm hide"></div>
                            <?php
                            $q = 0;
                            while($q < count($dados)){
                                ?>
                                <tr>
                                    <td><?php echo $dados[$q]["id"];?></td>
                                    <td><?php echo $dados[$q]["cnpj"];?></td>
                                    <td class="actions">
                                        <a class="btn btn-success btn-xs" name="vis" id="<?php echo $dados[$q]["id"];?>" href="#">Visualizar</a>
                                        <a class="btn btn-danger btn-xs" id="mod" href="#" data-toggle="modal" data-target="#delete-modal" data-id="<?php echo $dados[$q]["id"];?>">Excluir</a>
                                    </td>
                                </tr>
                                <?php
                                $q++;
                            }
                            ?>
             
                        </tbody>
                     </table>
             
                 </div>
             </div> <!-- /#list -->

            <!-- Modal -->
            <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="modalLabel">Excluir Item</h4>
                        </div>
                        <div class="modal-body">Deseja realmente excluir este item? </div>
                        <div class="modal-footer">
                            <button type="button" id="sim" class="btn btn-primary">Sim</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">N&atilde;o</button>
                            <form method="post" action="<?php echo PATH;?>restclient/excluir" name="formex" id="formex">
                                <input type="text" name="value" id="value" value="">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script>
            $(function() {

                $('table').on('click', '#mod', function(e) {
                    //alert($(this).attr("data-id"));
                    $('#value').val($(this).attr("data-id"));
                });

                $('button').on('click', function(e) {
                    if ($(this).attr('id') == "sim") {
                        $('#formex').submit();
                    }else{
                        alert()
                        $id = $(this).attr('id')
                        $('#retornoConsulta'+$id).removeClass('hide').html($obj_html.html());
                    }
                    
                });

            });
        </script>
    </body>
</html>