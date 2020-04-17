<?php
    
    require_once "../../app_cotacao/Conexao/JDBC.php";
    require_once "../../app_cotacao/Produto/Produto.model.php";
    require_once "../../app_cotacao/Produto/Produto.Service.php";

    if(isset($_GET['dado'])){

        $exp = explode(' ',trim($_GET['dado']));

        $list_prioritaria=[];
        $lista=[];
        $merge =[];
        $conexao = new Conexao();
        $produto = new Produto();
        $service = new ProdutoService($produto, $conexao);
        foreach($exp as $index=>$str){
            $produto->__set('descricao', $str);
            $lista[$index] = $service->read('descricao');
            $merge = array_merge($merge,$lista[$index]);
        }
       
        for($i=0;$i< count($merge); $i++){
            $count = 1;
            $id_temp = $merge[$i]['id'];

            for($x = $i+1 ; $x<count($merge) ; $x++){
                if($merge[$x]['id'] == $id_temp){
                    $count++;
                }
            }

            if($count == count($lista)){
                array_push($list_prioritaria,$merge[$i]);
            }
        }
        echo json_encode($list_prioritaria);
    }
?>
