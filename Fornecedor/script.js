function removerCliente(id){
    $.ajax({
        type: 'post',
        url: '../route.php?route=removerCliente',
        data: ({
            id
        }),
        success: data=>{
            if(data){
                $('#cliente_id_'+id).remove()
            }else{
                alert('Falha ao tentar remover o cliente.')
            }
        },
        erro: erro=>{
            console.log(erro)
        }
    })
}

function adicionarCliente(){
    let cnpj = $('#cnpj').val();
    if(cnpj==''){
        return
    }
    $.ajax({
        type: 'post',
        url: '../route.php?route=adicionarCliente',
        dataType: 'json',
        data: ({
            cnpj
        }),
        success: data=>{
            if(data=='noCliente'){
                $('#noCliente').removeAttr('hidden')
            }else{
                $('#noCliente').attr('hidden')
                let row = ` <tr id="cliente_id_${data['id']}">
                                <td onclick="buscarCotacoes(${data['id']})">
                                    ${data['company_name']}
                                </td>
                                <td onclick="buscarCotacoes(${data['id']})">
                                    CNPJ: ${data['cnpj']}
                                </td>
                                <td onclick="removerCliente(${data['id']})">
                                    <i class="far fa-trash-alt"></i>
                                </td>
                            </tr>`
                $('#table-clientes').prepend(row)
                $('#cnpj').val('')
            }
        },
        error: erro =>{
            $('#noCliente').removeAttr('hidden')
            console.log(erro)
        }
    })
}

function buscarCotacoes(cliente_id){
    $.ajax({
        type: 'get',
        url: '../route.php?route=buscarCotacoesCliente',
        dataType: 'json',
        data: ({
            cliente_id
        }),
        success: data=>{
            console.log(data)
            $('#table-cliente-cotacao').html('')
            data.forEach(element => {
                let row = `<tr onclick="abrirCotacao(${element['pedido']},cliente_id)">
                                <td>
                                    ${element['pedido']}
                                </td>
                                <td>
                                    ${element['descricao']}
                                </td>
                            </tr>`
                $('#table-cliente-cotacao').append(row)
            });
        },
        error: erro=>{
            console.log(erro)
        }
    })

    $('#cotacoes').removeAttr('hidden')
    $('#cliente_company').html('Supermercado correia')
}

function abrirCotacao(pedido_id,cliente_id){
    console.log(pedido_id,cliente_id)
}