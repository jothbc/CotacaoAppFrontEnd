function removerCliente(id) {
    $.ajax({
        type: 'post',
        url: '../route.php?route=removerCliente',
        data: ({
            id
        }),
        success: data => {
            if (data) {
                $('#cliente_id_' + id).remove()
            } else {
                alert('Falha ao tentar remover o cliente.')
            }
        },
        erro: erro => {
            console.log(erro)
        }
    })
}

function procurarCliente() {
    let desc = $('input#empresa').val()
    $('#busca_cliente').html('')
    if (desc != '') {
        $.ajax({
            type: 'get',
            url: '../route.php?route=procurarCliente',
            dataType: 'json',
            data: ({
                desc
            }),
            success: data => {
                data.forEach(element => {
                    let item = `  <div class="box-perfil mt-2">
                                    ${element['company_name']}
                                    <br>
                                    CNPJ: ${element['cnpj']}
                                    <div style="position: relative; float: right;" class="add_cliente" onclick="adicionarCliente(${element['id']})">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                </div>`
                    $('#busca_cliente').append(item)
                });
            },
            error: erro => {
                console.log('erro', erro)
            }
        })
    }
}

function adicionarCliente(cliente_id) {
    $('#busca_cliente').html('')
    $('input#empresa').val('')
    $.ajax({
        type: 'post',
        url: '../route.php?route=adicionarCliente',
        dataType: 'json',
        data: ({
            cliente_id
        }),
        success: data => {
            console.log(data)
            if (data != 'noCliente' && data != 'exist') {
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
            }
        },
        error: erro => {
            console.log(erro)
        }
    })
}

function buscarCotacoes(cliente_id) {
    $.ajax({
        type: 'get',
        url: '../route.php?route=buscarCotacoesCliente',
        dataType: 'json',
        data: ({
            cliente_id
        }),
        success: data => {
            $('#table-cliente-cotacao').html('')
            $('#cotacoes').fadeOut(0,()=>{
                data.forEach(element => {
                    let row = `<tr onclick="abrirCotacao(${element['pedido']},${cliente_id},${element['status']})">
                                    <td>
                                        ${element['pedido']}
                                    </td>
                                    <td>
                                        ${element['descricao']}
                                    </td>
                                </tr>`
                    $('#table-cliente-cotacao').append(row)
                });
                $('#cotacoes').fadeIn('slow')
                $('#cotacoes').removeAttr('hidden')
            })
        },
        error: erro => {
            console.log(erro)
        }
    })

}

function abrirCotacao(pedido_id, cliente_id, status) {
    if (status == '1') {
        window.location.href = `cotacao_cliente.php?pedido=${pedido_id}&cliente=${cliente_id}`
    } else if (status == '0') {
        window.location.href = `cotacao_cliente_finalizado.php?pedido=${pedido_id}&cliente=${cliente_id}`
    }
}

function enviarPrecos(cliente_id, pedido_id) {
    let lista = []
    $('tbody tr td input').each(function (index, element) {
        let id_produto = this.id
        let valor = this.value
        if (valor != '') {
            lista.push({ id_produto, valor })
        }
    })
    $('div.progress').removeAttr('hidden')
    $.ajax({
        type: 'post',
        url: '../route.php?route=enviarPrecos',
        data: ({
            lista,
            cliente_id,
            pedido_id
        }),
        success: data => {
            if (data == 'success') {
                $('tbody tr td input').addClass('is-valid')
                $('.redirect div').removeAttr('hidden')
                setTimeout(() => {
                    window.location.href = 'index.php'
                }, 3000);
            } else {
                $('tbody tr td input').addClass('is-invalid')
            }
            $('div.progress').attr('hidden', true)
        },
        error: erro => {
            alert(erro)
            $('div.progress').attr('hidden', true)
            console.log(erro)
        }
    })

}