function voltar() {
    window.location.href = "./index.php"
}

function removeItemDaVisualizacao(linha) {
    $('#' + linha).remove()
}

function definirValores() {
    let lista = []
    $('#table-body tr input').each(function(index, element) {
        if(element.value > 0){
            lista[index] = {
                id_prod:(element.id).substring(8),
                valor: element.value
            }
        }
    })
    $.ajax({
        type: 'post',
        url: 'definir_valores.php',
        data: {dado:lista},
        success: data =>{
            alert('Pedido atualizado com sucesso!')
            window.location.href = 'index.php?pedido=success'
        },
        error: erro=>{alert(erro)}                
    })
}