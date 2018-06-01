<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 16/03/2018
 * Time: 21:17
 */

require_once "db/conexao.php";
require_once "classes/payment.php";

class paymentDAO
{

    public function remover($payment) {
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM tb_payments WHERE id_payment = :idPayment");
            $statement->bindValue(":idPayment", $payment->getIdPayment());
            if ($statement->execute()) {
                return "Registro foi excluído com êxito";
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function totalPagamentos()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT DISTINCT SUM(db_value) FROM tb_payments");
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_COLUMN);
                return $rs;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function salvar($payment){
        global $pdo;

        try {

            if ($payment->getIdPayment() != "") {
                $statement = $pdo->prepare("UPDATE tb_payments SET tb_city_id_city = :idCity, tb_functions_id_function = :idFunction, tb_subfunctions_id_subfunction = :idSubfunction, 
                tb_program_id_program = :idProgram, tb_action_id_action = :idAction, tb_beneficiaries_id_beneficiaries = :idBeneficiary, tb_source_id_source = :idSource, tb_files_id_file = :idFile, db_value = :dbValue WHERE id_payment = :idPayment");
                $statement->bindValue(":idPayment", $payment->getIdPayment());
            } else {
                $statement = $pdo->prepare("INSERT INTO tb_payments (tb_city_id_city, tb_functions_id_function, tb_subfunctions_id_subfunction, tb_program_id_program, tb_action_id_action, tb_beneficiaries_id_beneficiaries, tb_source_id_source, tb_files_id_file, db_value) VALUES (:idCity, :idFunction, :idSubfunction, :idProgram, :idAction, :idBeneficiary, :idSource, :idFile, :dbValue)");
            }
            $statement->bindValue(":idCity", $payment->getCity());
            $statement->bindValue(":idFunction", $payment->getFunction());
            $statement->bindValue(":idSubfunction", $payment->getSubfunction());
            $statement->bindValue(":idProgram", $payment->getProgram());
            $statement->bindValue(":idAction", $payment->getAction());
            $statement->bindValue(":idBeneficiary", $payment->getBeneficiary());
            $statement->bindValue(":idSource", $payment->getSource());
            $statement->bindValue(":idFile", $payment->getFile());
            $statement->bindValue(":dbValue", $payment->getValue());
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

    public function atualizar($payment) {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_payment, tb_city_id_city, tb_functions_id_function, tb_subfunctions_id_subfunction,
            tb_program_id_program, tb_action_id_action, tb_beneficiaries_id_beneficiaries, tb_source_id_source, tb_files_id_file, db_value FROM tb_payments WHERE id_payment = :idPayment");
            $statement->bindValue(":idPayment", $payment->getIdPayment());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $payment->setIdPayment($rs->id_payment);
                $payment->setCity($rs->tb_city_id_city);
                $payment->setFunction($rs->tb_functions_id_function);
                $payment->setSubfunction($rs->tb_subfunctions_id_subfunction);
                $payment->setProgram($rs->tb_program_id_program);
                $payment->setAction($rs->tb_action_id_action);
                $payment->setBeneficiary($rs->tb_beneficiaries_id_beneficiaries);
                $payment->setSource($rs->tb_source_id_source);
                $payment->setFile($rs->tb_files_id_file);
                $payment->setValue($rs->db_value);
                return $payment;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

//    public function listarActionsPorCodigo($codigo) {
//        global $pdo;
//        try {
//            $statement = $pdo->prepare("SELECT id_action, str_cod_action, str_name_action FROM tb_action WHERE str_cod_action = :codigoAction");
//            $statement->bindValue(":codigoAction", $codigo);
//            if ($statement->execute()) {
//                $rs = $statement->fetchAll(PDO::FETCH_OBJ);
//                return $rs;
//            } else {
//                throw new PDOException("Erro: Não foi possível executar a declaração sql");
//            }
//        } catch (PDOException $erro) {
//            return "Erro: " . $erro->getMessage();
//        }
//    }

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
        $sql = "SELECT id_payment, tb_city_id_city, tb_functions_id_function, tb_subfunctions_id_subfunction,
            tb_program_id_program, tb_action_id_action, tb_beneficiaries_id_beneficiaries, tb_source_id_source, tb_files_id_file, db_value FROM tb_payments LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_payments";
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
        <th>City</th>
        <th>Function</th>
        <th>Subfunction</th>
        <th>Program</th>
        <th>Action</th>
        <th>Beneficiary</th>
        <th>Source</th>
        <th>File</th>
        <th>Value</th>
        <th colspan='2'>Options</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $var):
                echo "<tr>
        <td>$var->tb_city_id_city</td>
        <td>$var->tb_functions_id_function</td>
        <td>$var->tb_subfunctions_id_subfunction</td>
        <td>$var->tb_program_id_program</td>
        <td>$var->tb_action_id_action</td>
        <td>$var->tb_beneficiaries_id_beneficiaries</td>
        <td>$var->tb_source_id_source</td>
        <td>$var->tb_files_id_file</td>
        <td>$var->db_value</td>
        <td><a href='?act=upd&idPayment=$var->id_payment'><i class='ti-reload'></i></a></td>
        <td><a href='?act=del&idPayment=$var->id_payment'><i class='ti-close'></i></a></td>
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