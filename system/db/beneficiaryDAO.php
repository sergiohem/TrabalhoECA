<?php
/**
 * Created by PhpStorm.
 * User: lucas 3
 * Date: 25/05/2018
 * Time: 14:12
 */

require_once("../db/conexao.php");
require_once("../classes/beneficiary.php");

class beneficiaryDAO
{
    public function remover($beneficiary)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM tb_beneficiaries WHERE id_beneficiaries = :id");
            $statement->bindValue(":id", $beneficiary->getIdBeneficiary());
            if ($statement->execute()) {
                return "Registro foi excluído com êxito";
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function salvar($beneficiary)
    {
        global $pdo;

        try {

            if ($beneficiary->getIdBeneficiary() != "") {
                $statement = $pdo->prepare("UPDATE tb_beneficiaries SET str_nis = :nis, str_name_person = :namePerson WHERE id_beneficiaries = :id;");
                $statement->bindValue(":id", $beneficiary->getIdBeneficiary());
            } else {
                $statement = $pdo->prepare("INSERT INTO tb_beneficiaries (str_nis, str_name_person) VALUES (:nis, :namePerson)");
            }
            $statement->bindValue(":nis", $beneficiary->getNis());
            $statement->bindValue(":namePerson", $beneficiary->getNamePerson());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    echo "Dados cadastrados com sucesso!";

                } else {
                    echo "Erro ao tentar efetivar cadastro";
                }
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            echo "Erro: " . $erro->getMessage();
        }
    }

    public function atualizar($beneficiary)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_beneficiaries, str_nis, str_name_person FROM tb_beneficiaries WHERE id_beneficiaries = :id");
            $statement->bindValue(":id", $beneficiary->getIdBeneficiary());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $beneficiary->setIdBeneficiary($rs->id_beneficiaries);
                $beneficiary->setNis($rs->str_nis);
                $beneficiary->setNamePerson($rs->str_name_person);
                return $beneficiary;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function listarBeneficiariosOrdemAlfabetica()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT str_nis, str_name_person FROM tb_beneficiaries ORDER BY str_name_person LIMIT 20");
            if ($statement->execute()) {
                $rs = $statement->fetchAll(PDO::FETCH_OBJ);
                date_default_timezone_set('America/Sao_Paulo');
                $html = '<h2>BENEFICIARIES ORDER BY NAME</h2>
<br />
<p>Report generation date: '.date('d/m/Y h:i:s').'hs</p>
<br />
<table class="table table-striped" border="1">
     <thead>
       <tr>
        <th style="font-weight: bold; text-align: center;">NIS</th>
        <th style="font-weight: bold; text-align: center;">Name</th>
       </tr>
       <br/>
     </thead>
     <tbody>';

                foreach ($rs as $benef) {
                    $html .= '<tr><td>'.$benef->str_nis.'</td><td>'.$benef->str_name_person.'</td></tr>';
                }

                $html .= '</tbody>
     </table>
';
                return $html;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function listarBeneficiariosESuasCidades()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT 
    ben.str_nis, ben.str_name_person, city.str_name_city, city.str_cod_siafi_city, state.str_uf
FROM
    tb_payments AS pay
        JOIN
    tb_beneficiaries AS ben ON pay.tb_beneficiaries_id_beneficiaries = ben.id_beneficiaries
        JOIN
    tb_city AS city ON pay.tb_city_id_city = city.id_city
        JOIN
    tb_state AS state ON city.tb_state_id_state = state.id_state
ORDER BY city.str_name_city, ben.str_name_person LIMIT 20");

            if ($statement->execute()) {
                $rs = $statement->fetchAll(PDO::FETCH_OBJ);
                date_default_timezone_set('America/Sao_Paulo');
                $html = '<h2>BENEFICIARIES AND THEIR CITIES</h2>
<br />
<p>Report generation date: '.date('d/m/Y H:i:s', time()).'</p>
<br />
<table class="table table-striped" border="1">
     <thead>
       <tr>
        <th style="font-weight: bold; text-align: center;">NIS</th>
        <th style="font-weight: bold; text-align: center;">Beneficiary</th>
        <th style="font-weight: bold; text-align: center;">City</th>
        <th style="font-weight: bold; text-align: center;">State city</th>
        <th style="font-weight: bold; text-align: center;">Siafi city</th>
       </tr>
       <br/>
     </thead>
     <tbody>';

                foreach ($rs as $benef) {
                    $html .= '<tr><td>'.$benef->str_nis.'</td><td>'.$benef->str_name_person.'</td><td>'.$benef->str_name_city.'</td><td>'.$benef->str_uf.'</td><td>'.$benef->str_cod_siafi_city.'</td></tr>';
                }

                $html .= '</tbody>
     </table>
';
                return $html;
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
        $sql = "SELECT id_beneficiaries, str_nis, str_name_person FROM tb_beneficiaries LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_beneficiaries";
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
        <th>NIS</th>
        <th>Nome</th>
        <th colspan='2'>Opções</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $var):
                echo "<tr>
        <td>$var->str_nis</td>
        <td>$var->str_name_person</td>
        <td><a href='?act=upd&id=$var->id_beneficiaries'><i class='ti-reload'></i></a></td>
        <td><a href='?act=del&id=$var->id_beneficiaries'><i class='ti-close'></i></a></td>
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