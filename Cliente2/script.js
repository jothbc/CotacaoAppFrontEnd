$(document).ready(()=>{
    $.ajax({
        type: 'get',
        url: 'carregar_lista_pedido_cliente.php',
        dataType: 'json',
        success: data=>{
            data.forEach(element => {
                $('#table_pedido').append('<tr class="data-table" id="'+(element['id'])+'"> <td>'+(element['descricao'])+'</td> <td onclick="removerItemDaCotacao('+(element['id'])+')"> <i class="fas fa-trash-alt"></i></td> </tr>')
            });
        },
        error: erro=>{
            console.log(erro)
        }
    })
    
})

function buscarProduto(){
    $.ajax({
        type: 'get',
        url: 'get_produtos.php',
        dataType: 'json',
        data: {dado:$('#produto_descricao').val()},
        success: data=>{
            $('#table_result').html('')
            
            if($('#produto_descricao').val()!=''){
                for (let index = 0; index < data.length ; index++) {
                    const element = data[index];
                    $('#table_result').append('<tr class="data-table"> <td>'+element['descricao'] + '</td> <td onclick="inserirItem('+element['id']+')"><i class="fas fa-arrow-right"></i></td> </tr>')
                }
            }
            if($('#produto_descricao').val()!='' && $('#produto_descricao').val().length>5){
                $('#table_result').append(`<tr class="data-table"> <td>${$('#produto_descricao').val()}</td> <td onclick="novoItem('${ $('#produto_descricao').val() }')"><i class="fas fa-plus"></i></td> </tr>`)
            }
        },
        error: erro=>{
            $('#table_result').html(`<p class="text-danger">${erro}</p>`)
        }

    })
}

function inserirItem(item_id) {
    $.ajax({
        type:'post',
        url: 'adicionar_item_cotacao.php',
        dataType: 'json',
        data: {item_id},
        success: data=>{
           $('#table_pedido').append('<tr class="data-table" id="'+(data.id)+'"> <td>'+(data.descricao)+'</td> <td onclick="removerItemDaCotacao('+(data.id)+')"> <i class="fas fa-trash-alt"></i></td> </tr>')
           $('#table_result').html('')
        },
        error: erro=>{
           alert('ERRO: '+erro)
        }
    })
}

function removerItemDaCotacao(id_item_cotacao) {
    $.ajax({
        type: 'post',
        url: 'remover_item_cotacao.php',
        data: {id_item_cotacao},
        success: data=>{
            if(data==1){
                $('#'+id_item_cotacao).remove()
            }
        },
        error: erro=>{
            alert(erro)
        }
    })
}

function novoItem(novo) {
    $.ajax({
        type:'post',
        url: 'adicionar_item_cotacao.php',
        dataType: 'json',
        data: {novo},
        success: data=>{
           $('#table_pedido').append('<tr class="data-table" id="'+(data.id)+'"> <td>'+(data.descricao)+'</td> <td onclick="removerItemDaCotacao('+(data.id)+')"> <i class="fas fa-trash-alt"></i></td> </tr>')
           $('#table_result').html('')
        },
        error: erro=>{
           alert('ERRO: '+erro)
        }
    })
}

function inverterStatus() {
    $.ajax({
        type:'post',
        url: 'alterar_status_pedido.php',
        success: data=>{
           $('#btn_status_pedido').html(data==0?'Aberto':'Fechado')
        },
        error: erro=>{
           alert('ERRO: '+erro)
        }
    })
}