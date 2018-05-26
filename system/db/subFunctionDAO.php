<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 16/03/2018
 * Time: 21:17
 */

require_once "db/conexao.php";
require_once "classes/subFunction.php";

class subFunctionDAO
{

    public function remover($subFunction) {
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM tb_subfunctions WHERE id_subfunction = :idSubFunction");
            $statement->bindValue(":idSubFunction", $subFunction->getIdSubFunction());
            if ($statement->execute()) {
                return "Registro foi excluído com êxito";
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function salvar($subfunction){
        global $pdo;

        try {

            if ($subfunction->getIdSubFunction() != "") {
                $statement = $pdo->prepare("UPDATE tb_subfunctions SET str_cod_subfunction = :codeSubFunction, str_name_subfunction = :nameSubFunction WHERE id_subfunction = :idSubFunction");
                $statement->bindValue(":idSubFunction", $subfunction->getIdSubFunction());
            } else {
                $statement = $pdo->prepare("INSERT INTO tb_subfunctions (str_cod_subfunction, str_name_subfunction) VALUES (:codeSubFunction, :nameSubFunction)");
            }
            $statement->bindValue(":codeSubFunction", $subfunction->getCodeSubFunction());
            $statement->bindValue(":nameSubFunction", $subfunction->getNameSubFunction());
            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "Dados cadastrados com sucesso!";

                } else {
                    return "Erro ao tentar efetivar cadastro";
                }
            } else {
                throw new PDOException("Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
    }

    public function atualizar($subfunction) {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_subfunction, str_cod_subfunction, str_name_subfunction FROM tb_subfunctions WHERE id_subfunction = :idSubFunction");
            $statement->bindValue(":idSubFunction", $subfunction->getIdSubFunction());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $subfunction->setIdSubFunction($rs->id_subfunction);
                $subfunction->setCodeSubFunction($rs->str_cod_subfunction);
                $subfunction->setNameSubFunction($rs->str_name_subfunction);
                return $subfunction;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function tabelaPaginada()
    {

        //carrega o banco
        global $pdo;

        //endereço atual da página
        $endereco = $_SERVER ['PHP_SELF'];

        /* Constantes de configuração */
        define('QTDE_REGISTROS', 10);
        define('RANGE_PAGINAS', 2);

        /* Recebe o número da página via parâmetro na URL */
        $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

        /* Calcula a linha inicial da consulta */
        $linha_inicial = ($pagina_atual - 1) * QTDE_REGISTROS;

        /* Instrução de consulta para paginação com MySQL */
        $sql = "SELECT id_subfunction, str_cod_subfunction, str_name_subfunction FROM tb_subfunctions LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_subfunctions";
        $statement = $pdo->prepare($sqlContador);
        $statement->execute();
        $valor = $statement->fetch(PDO::FETCH_OBJ);

        /* Idêntifica a primeira página */
        $primeira_pagina = 1;

        /* Cálcula qual será a última página */
        $ultima_pagina = ceil($valor->total_registros / QTDE_REGISTROS);

        /* Cálcula qual será a página anterior em relação a página atual em exibição */
        $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual - 1 : 0;

        /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */
        $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual + 1 : 0;

        /* Cálcula qual será a página inicial do nosso range */
        $range_inicial = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1;

        /* Cálcula qual será a página final do nosso range */
        $range_final = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina;

        /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */
        $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';

        /* Verifica se vai exibir o botão "Anterior" e "Último" */
        $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';

        if (!empty($dados)):
            echo "
     <table class='table table-striped table-bordered'>
     <thead>
       <tr class='active'>
        <th>Code</th>
        <th>Name</th>
        <th colspan='2'>Options</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $var):
                echo "<tr>
        <td>$var->str_cod_subfunction</td>
        <td>$var->str_name_subfunction</td>
        <td><a href='?act=upd&idSubFunction=$var->id_subfunction'><i class='ti-reload'></i></a></td>
        <td><a href='?act=del&idSubFunction=$var->id_subfunction'><i class='ti-close'></i></a></td>
       </tr>";
            endforeach;
            echo "
</tbody>
     </table>

     <div class='box-paginacao'>
       <a class='box-navegacao  $exibir_botao_inicio' href='$endereco?page=$primeira_pagina' title='Primeira Página'>Primeira</a>
       <a class='box-navegacao $exibir_botao_inicio' href='$endereco?page=$pagina_anterior' title='Página Anterior'>Anterior</a>
";

            /* Loop para montar a páginação central com os números */
            for ($i = $range_inicial; $i <= $range_final; $i++):
                $destaque = ($i == $pagina_atual) ? 'destaque' : '';
                echo "<a class='box-numero $destaque' href='$endereco?page=$i'>$i</a>";
            endfor;

            echo "<a class='box-navegacao $exibir_botao_final' href='$endereco?page=$proxima_pagina' title='Próxima Página'>Próxima</a>
       <a class='box-navegacao $exibir_botao_final' href='$endereco?page=$ultima_pagina' title='Última Página'>Último</a>
     </div>";
        else:
            echo "<p class='bg-danger'>Nenhum registro foi encontrado!</p>
     ";
        endif;

    }


}