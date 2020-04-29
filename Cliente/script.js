function novoPedido(){
    $.ajax({
        type: 'get',
        url: '../route.php?route=novoPedido',
        data:({}),
        success: data=>{
            if(data!=-1){
                window.location.href = 'editar_pedido.php?pedido='+data;
            }else{
                alert('erro');
            }
        },
        error: erro=>{
            alert('erro');
        }
    })
}
function editarPedido(pedido){
    window.location.href = 'editar_pedido.php?pedido='+pedido;
}
function removerPedido(pedido){
    $.ajax({
        type: 'post',
        url: '../route.php?route=removerPedido',
        data: ({
            pedido
        }),
        success: data=>{
            if(data=='true'){
                $('#pedido_'+pedido).remove();
            }else{
                alert('erro');
            }
        },
        error: erro=>{
            console.log(erro)
        }
    })
}
function visualizarPedido(pedido){
    window.location.href = 'visualizar_pedido.php?pedido='+pedido;
}
function removerItemPedido(index_id_produto){
    $.ajax({
        type: 'post',
        url: '../route.php?route=removerItemPedido',
        data: ({
            id: index_id_produto
        }),
        success: data=>{
            if(data=='true'){
                $('#item_'+index_id_produto).remove();
            }else{
                alert('erro');
            }
        },
        error: erro=>{
            console.log(erro)
        }
    })
}
function adicionarItemPedido(id_produto,pedido,descricao){

    $('td#'+id_produto+pedido).html('<i class="fas fa-spinner"></i>')
    $.ajax({
        type: 'post',
        url: '../route.php?route=adicionarItemPedido',
        data: ({
            id_produto,
            pedido
        }),
        success: data=>{
            if(data != '0'){
                let item = `<tr id="item_${data}">
                                <td>
                                    ${descricao}
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input id="pret_${data}" class="form-control" type="text" value="" placeholder="Pretenção">
                                        <button class="btn btn-primary" onclick="addPretencao(${data})"><i class="fas fa-arrow-right"></i></button>
                                    </div>
                                </td>
                                <td onclick="removerItemPedido(${data})">
                                    <i class="far fa-trash-alt"></i>
                                </td>
                            </tr>` 
                $('#tabela-itens').append(item)
                $('td#'+id_produto+pedido).html('<i class="fas fa-cart-plus"></i>')
            }else{
                alert('Algo deu errado, atualize a página e confira se o item foi incluso.')
            }
        },
        error: erro=>{
            console.log(erro)
        }
    })
}
function buscarProduto(){
    let descricao = $('#busca-descricao').val()

    if(descricao == ''){
        return
    }

    let pedido = $('i.perfil-contador').text()
    $.ajax({
        type: 'get',
        url: '../route.php?route=buscarProduto',
        dataType: 'json',
        data: ({
            descricao,
            pedido
        }),
        success: data=>{
            $('#table-busca').html('')
            data.forEach(element => {
                let item = `<tr>
                                <td>
                                    ${element['descricao']}
                                </td>
                                <td onclick="adicionarItemPedido( ${element['id']} , ${pedido} , '${element['descricao']}' )" id="${element['id']}${pedido}">
                                    <i class="fas fa-cart-plus"></i>
                                </td>
                            </tr>`
                $('#table-busca').append(item)
           });
        },
        error: erro=>{
            console.log(erro)
        }
    })
}
function limparCampos(){
    $('#table-busca').html('')
    $('#busca-descricao').val('')
}
function inverterStatus(cliente_id,pedido_id){
    $.ajax({
        type: 'post',
        url: '../route.php?route=inverterStatus',
        data: ({
            cliente_id,
            pedido_id
        }),
        success: data=>{
            if(data){
                $('#btn-status').text($('#btn-status').text() == 'Abrir' ? 'Fechar':'Abrir')
            }else{
                alert(data)
            }
        },
        error: erro=>{
            console.log(erro)
        }
    })
}
function aprovarDesaprovar(fornecedor_id,cliente_id,pedido_id,produto_id){
    let btn_status = $('#btn-status').text()
    if(btn_status.trim() == 'Fechar'){
        inverterStatus(cliente_id,pedido_id)
        alert('Cotação fechada automáticamente.')
    }

    $.ajax({
        type: 'post',
        url: '../route.php?route=aprovarDesaprovar',
        data: ({
            fornecedor_id,
            cliente_id,
            pedido_id,
            produto_id
        }),
        success: data=>{
            if(data=='fail'){
                alert('Algo deu errado.')
            }
            if(data){
                $(`div#forn_${fornecedor_id}_item_${produto_id}`).toggleClass('active')

                let input =  `<div class="input-group" id="input_forn_${fornecedor_id}_item_${produto_id}">
                                <input id="obs_text_forn_${fornecedor_id}_item_${produto_id}" 
                                        type="text" 
                                        placeholder="Obs" 
                                        class="form-control"
                                        style="height: 20px">
                                <div class="pl-2 pr-2 mr-2 bg-primary" 
                                    onclick="incluirObs(${fornecedor_id},${cliente_id},${pedido_id},${produto_id})">
                                        <i class="fas fa-arrow-right"></i>
                                </div>
                            </div>`
                
                if($('#forn_'+fornecedor_id+'_item_'+produto_id).hasClass('active')){
                    $('#ext_forn_'+fornecedor_id+'_item_'+produto_id).append(input)
                    $('#forn_'+fornecedor_id+'_item_'+produto_id+' div span.span-link').html('Reprovar')
                    $.ajax({
                        type: 'get',
                        url: '../route.php?route=getObs',
                        data: ({
                            fornecedor_id,
                            cliente_id,
                            pedido_id,
                            produto_id
                        }),
                        success: data2=>{
                            if(data2!='NA'){
                                $(`#obs_text_forn_${fornecedor_id}_item_${produto_id}`).attr('value',data2)
                            }
                        },
                        error: erro2=>{
                            console.log(erro2)
                        }
                    })
                }else{
                    $(`#input_forn_${fornecedor_id}_item_${produto_id}`).remove();
                    $('#forn_'+fornecedor_id+'_item_'+produto_id+' div span.span-link').html('Aprovar')
                }
            }
        },
        error: erro=>{
            console.log(erro)
        }
    })
}
function incluirObs(fornecedor_id,cliente_id,pedido_id,produto_id){
    let obs = $('#obs_text_forn_'+fornecedor_id+'_item_'+produto_id).val();
    $.ajax({
        type: 'post',
        url: '../route.php?route=incluirObs',
        data: ({
            fornecedor_id,
            cliente_id,
            pedido_id,
            produto_id,
            obs
        }),
        success: data=>{
            if(data=='fail'){
                alert('Algo deu errado.')
                $('#obs_text_forn_'+fornecedor_id+'_item_'+produto_id).addClass('is-invalid')
            }
            if(data){
                $('#obs_text_forn_'+fornecedor_id+'_item_'+produto_id).addClass('is-valid')
            }
        },
        error: erro=>{
            console.log(erro)
        }
    })
}

function addPretencao(produto_index){
    let pedido = $('i.perfil-contador').text()
    let pretencao = $('#pret_'+produto_index).val()

    $.ajax({
        type: 'post',
        url: '../route.php?route=addPretencao',
        data: ({ produto_index, pedido, pretencao }),
        success: data=>{
            if(data=='success'){
                $('#pret_'+produto_index).addClass('is-valid')
            }else{
                $('#pret_'+produto_index).addClass('is-invalid')
            }
        },
        error: erro=>{
            console.log(erro)
            $('#pret_'+produto_index).addClass('is-invalid')
        }
    })
}