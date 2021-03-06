<style>
.b-span b { width: 135px; display: inline-block; }
</style>
<h2 class="versalete">Confirmar compra do jogo</h2>
<p>Confira as informações do seu jogo e verifique se as cartas combinadas estão corretas:</p>

<div class="lista-jogo-completo">
    <? $total = 0; ?>
    <table class='table-jogo'>
        <tr class='first-line'>
            <td colspan="5" style="text-align: left;" class='b-span'>
                <b>Produto:</b> Autoconsulta / Consulta Virtual<br/>
                <b>Leitura do Tarot:</b> Metodologia de Análise Taromantica<br/>
                <? /** @var Jogo_model $jogoCompleto */ ?>
                <b>Setor:</b> <?= $jogoCompleto->setorVida->nome_setor_vida ?><br/>
                <b>Acesso:</b> Leitura online<br/>
            </td>
        </tr>
        <tr class='first-line'>
            <td></td>
            <td>Arcano Maior</td>
            <td>Arcano Menor 1</td>
            <td>Arcano Menor 2</td>
            <td class="border-left">Valor</td>
        </tr>
        <? foreach ($jogoCompleto->combinacoes as $key => $jogo) : ?>
            <tr>
                <td>
                    <?=$jogo["casaCarta"]->nome_casa_carta?>
                </td>
                <td>
                    <img src="<?=base_url()?>assets/images/cartas/<?=$jogo["arcanoMaior"]->cod_carta?>.jpg" width="29" height="50">
                    <br/><?=$jogo["arcanoMaior"]->nome_carta?>
                </td>
                <td>
                    <img src="<?=base_url()?>assets/images/cartas/<?=$jogo["arcanoMenor1"]->cod_carta?>.jpg" width="29" height="50">
                    <br/><?=$jogo["arcanoMenor1"]->nome_carta?>
                </td>
                <td>
                    <img src="<?=base_url()?>assets/images/cartas/<?=$jogo["arcanoMenor2"]->cod_carta?>.jpg" width="29" height="50">
                    <br/><?=$jogo["arcanoMenor2"]->nome_carta?>
                </td>
                <td class="border-left">
                    <? if((@$jogo["comprado"] OR $jogo['casaCarta']->ja_comprada == true) AND $jogo['casaCarta']->custo > 0): ?>
                        Já comprado
                    <? else: ?>
                        <? if($jogo['casaCarta']->custo == 0): ?>
                            Grátis
                        <? else: ?>
                            R$ <?=moeda($jogo['casaCarta']->custo)?>
                        <? endif; ?>
                        <? $total += $jogo['casaCarta']->custo; ?>
                    <? endif; ?>
                </td>
            </tr>
        <? endforeach ?>
        <tr class="first-line">
            <td colspan="5">
                <h2 style="margin-top: 0; padding-bottom: 0;">Total:
                    <? if($jogoCompleto->custo == 0): ?>
                        Grátis
                    <? else: ?>
                        R$ <?=moeda($jogoCompleto->custo)?>
                    <? endif; ?>
                </h2>
            </td>
        </tr>
    </table>
</div>
<div>
    
</div>
<br/>
<? if($jogoCompleto->custo == 0): ?>
    <div>
        <br/><br/>
        <h2 class="versalete">Este jogo é gratuito. Clique para obter a leitura.</h2>
        <br/><br/>
        <a class="newBlueButton" href="<?=site_url()?>/compra/obterJogo" style="padding: 10px 60px">
            <span>Obter leitura completa</span>
        </a>
    </div>

<? else: ?>
    <? /** @var Pedido_model $pedido */ ?>
    <? if(is_null($pedido) == false): ?>
        <input type="hidden" id="cod_pedido" value="<?= $pedido->cod ?>" />
        <h2 class="versalete">Dados do seu pedido</h2>
        <table class="table">
            <tr>
                <th>Cod.</th>
                <th>Data</th>
                <th>Status</th>
            </tr>
            <tr>
                <td><?= $pedido->cod ?></td>
                <td><?= mysql_to_br($pedido->data) ?></td>
                <td><?= $pedido->statusAmigavel ?></td>
            </tr>
        </table>
    <? endif; ?>

    <? /** @var Jogo_model $jogoCompleto */ ?>
    <? if($jogoCompleto->jaComprado == true): ?>
        <div>
            <br/><br/>
            <h2 class="versalete">Obrigado! Seu pedido está pago e liberado para leitura.</h2>
            <br/><br/>
            <a class="newBlueButton" href="<?=site_url()?>/compra/obterJogo" style="padding: 10px 60px">
                <span>Obter leitura completa</span>
            </a>
        </div>
    <? else: ?>
        <h2 class="versalete">Escolha a sua forma de pagamento</h2>
        <p>Ao clicar no botão comprar, você confirma estar ciente dos regulamentos e termos do site. </p>
        <br/>
        <div class="tMargin20 clearfix">
            <? if(Auth::isLoggedIn()): ?>
                <a class="newBlueButton buy" style="padding: 10px 60px">
                    <span>Comprar</span>
                </a>
            <? else: ?>
                <a class="newBlueButton" style="padding: 10px 60px" href="<?= site_url() ?>/compra/cadastro">
                    <span>Comprar</span>
                </a>
            <? endif ?>
            <h3 class="carregando hidden">CARREGANDO...</h3>
            <br/><br/><br/>

            <div class="clearfix">
                <div class="error-container" style="display: none;">
                    <?= $this->load->view('error_box', array(
                        'errorMsg' => 'A compra não foi concluída com êxito. Por favor, clique novamente em comprar para continuar.'
                    )) ?>
                </div>
            </div>

            <br/><br/>
            <p>Sua compra está protegida por: </p>
            <img src="<?= base_url() ?>/assets/images/pagseguro.jpg" width="222"/>
        </div>
    <? endif; ?>
    <div>
        <br/>
        <br/>
        <p class="red">Importante!</p>
        <p class='justify'>
            <b>Conteúdo:</b> Voce está adquirindo a versão 1.0. <a target="_blank" href="http://www.taromancia.com.br/index.php/atividades-recentes/">Clique aqui e acompanhe as atualizações.</a><br/><br/>
            <b>Direitos:</b> Este serviço está disponível somente para acesso online. Não autorizamos a cópia ou a disseminação nem de senha nem de conteúdo na internet. Leia os termos de Uso. Caso você tenha visto o nosso conteúdo em outro site, cópia ou quaisquer forma de distribuição deste conteúdo não hesite em denunciar e entre em contato com o nosso departamento jurídico pelo e-mail: <a href='mailto:juridico@taromancia.com.br'>juridico@taromancia.com.br</a>
        </p>
    </div>
<? endif; ?>

<script type="text/javascript">
$("document").ready(function(){
    $("a.buy").click(function(evt)
    {
        evt.preventDefault();

        trocaCarregando();

        // oculta o erro
        $('.error-container').hide();

        $.ajax({
            type: "POST",
            url: "<?=site_url()?>"+"/pedido/gerarPagSeguro",
            success : successPagSeguro,
            error : errorPagSeguro
        })


    });
});

function trocaCarregando()
{
    if($('a.buy').is(":visible"))
    {
        $('a.buy').hide();
        $('.carregando').show();
    }else{
        $('a.buy').show();
        $('.carregando').hide();
    }
}

function successPagSeguro(data)
{
    try{
        var retorno = $.parseJSON(data);
    }catch (exception)
    {
        alert('ERROR: NAO FOI POSSIVEL RECEBER O RETORNO DO PAGSEGURO');
        return false;
    }

    // obtem o codigo pra checkout
    var checkoutCode = retorno.code;

    // abre o lightbox
    PagSeguroLightbox({
        code: checkoutCode
    }, {
        success : successPagSeguroLightbox,
        abort : abortPagSeguroLightbox
    });

    // tira o carregando
    trocaCarregando();
}

function errorPagSeguro()
{
    alert('erro');
}

function successPagSeguroLightbox(pagSeguroTransactionCode)
{
    var $body = $("body");

    var codPedido = $body.find('#cod_pedido').val();

    $.ajax({
        type: "POST",
        url: "<?=site_url()?>"+"/pedido/pagSeguroSalvarTransactionCode",
        data : { codPedido : codPedido, pagSeguroTransactionCode : pagSeguroTransactionCode },
        success : successSaveTransactionCode,
        error : errorSaveTransactionCode
    });
}

function successSaveTransactionCode(data)
{
    // recarrega a pagina
    location.href = SITE_URL + '/compra/jogo/confirm';
}

function errorSaveTransactionCode()
{
    alert('erro');
}

function abortPagSeguroLightbox()
{
    // mostra a msg de erro
    $('.error-container').show();
}

</script>
<?php if (ENVIROMENT_PAGSEGURO == "sandbox") : ?>
    <!--Para integração em ambiente de testes no Sandbox use este link-->
    <script
            type="text/javascript"
            src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js">
    </script>
<?php else : ?>
    <!--Para integração em ambiente de produção use este link-->
    <script
            type="text/javascript"
            src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js">
    </script>
<?php endif; ?>