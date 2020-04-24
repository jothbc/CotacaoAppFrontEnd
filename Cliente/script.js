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
                                <td onclick="removerItemPedido(${data})">
                                    <i class="far fa-trash-alt"></i>
                                </td>
                            </tr>` 
                $('#tabela-itens').append(item)
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
                                <td onclick="adicionarItemPedido(${element['id']},${pedido}, '${element['descricao']}')">
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