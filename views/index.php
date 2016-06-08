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
            <h1 class="page-header">Aplicativo</h1>

            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <div class="form-group">
                        <label for="iptCnpj">CNPJ:</label>
                        <input type="text" id="iptCnpj" class="form-control" placeholder="CNPJ" value="31804115000243">
                        <small class="help-block hide"></small>
                    </div>
                    <button type="button" id="btnConsultar" class="btn btn-primary">Consultar</button>
                </div>
            </div>

            <hr>
            
            <div id="retornoConsulta" class="well well-sm hide"></div>
        </div>
        <script>
            UTF8 = {
                encode: function(s){
                    for(var c, i = -1, l = (s = s.split("")).length, o = String.fromCharCode; ++i < l;
                        s[i] = (c = s[i].charCodeAt(0)) >= 127 ? o(0xc0 | (c >>> 6)) + o(0x80 | (c & 0x3f)) : s[i]
                    );
                    return s.join("");
                },
                decode: function(s){
                    for(var a, b, i = -1, l = (s = s.split("")).length, o = String.fromCharCode, c = "charCodeAt"; ++i < l;
                        ((a = s[i][c](0)) & 0x80) &&
                        (s[i] = (a & 0xfc) == 0xc0 && ((b = s[i + 1][c](0)) & 0xc0) == 0x80 ?
                            o(((a & 0x03) << 6) + (b & 0x3f)) : o(128), s[++i] = "")
                    );
                    return s.join("");
                }
            };

            $(function() {
                $('#btnConsultar').on('click', function(e) {
                    e.preventDefault();

                    var $cnpj = $('#iptCnpj');
                    var $retornoConsulta = $('#retornoConsulta');
                    $cnpj.parent().removeClass('has-error').find('.help-block').addClass('hide').html('');
                    $retornoConsulta.addClass('hide').html('');

                    if ($.trim($cnpj.val()) == '') {
                        $cnpj.parent().addClass('has-error').find('.help-block').removeClass('hide').html('Campo obrigatório');
                    } else {
                        $.ajax({
                            url: 'HTTP://devphpsolucoes.com.br/uplexis/restclient/api',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                cnpj: $cnpj.val()
                            },
                            success: function(retorno) {
                                if (retorno.sucesso == 0) {
                                    $cnpj.parent().addClass('has-error').find('.help-block').removeClass('hide').html('CNPJ não encontrado');
                                } else {
                                    var html_parse = retorno.body;
                                    var html_parse = UTF8.encode(html_parse);
                                    var html_parse = $('<textarea />').html(html_parse).text();
                                    var html_parse = UTF8.encode(html_parse);
                                    var $obj_html = $(html_parse).find('#conteudo');
                                    $retornoConsulta.removeClass('hide').html($obj_html.html());
                                }
                            }
                        });
                    }
                }).trigger('click');
            });
        </script>
    </body>
</html>