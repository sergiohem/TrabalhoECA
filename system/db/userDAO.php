<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 12/04/2018
 * Time: 20:15
 */

require_once "conexao.php";
require_once "classes/user.php";

class userDAO
{
    public function remover($user)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("DELETE FROM tb_user WHERE id_user = :id");
            $statement->bindValue(":id", $user->getIdUser());
            if ($statement->execute()) {
                return "Registo foi excluído com êxito";
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function salvar($user)
    {
        global $pdo;
        try {
            if ($user->getIdUser() != "") {
                $statement = $pdo->prepare("UPDATE tb_user SET str_name =:name, str_username = :username, str_password =:password, str_type =:type_user, str_email =:email, rec_Password =:recPwd WHERE id_user = :id;");
                $statement->bindValue(":id", $user->getIdUser());
            } else {
                $statement = $pdo->prepare("INSERT INTO tb_user (str_name, str_username, str_password, str_type, str_email, rec_Password) VALUES (:name, :username, :password, :type_user, :email, :recPwd)");
            }
            $statement->bindValue(":name", $user->getName());
            $statement->bindValue(":username", $user->getUsername());
            $statement->bindValue(":password", $user->getPassword());
            $statement->bindValue(":type_user", $user->getType());
            $statement->bindValue(":email", $user->getEmail());
            $statement->bindValue(":recPwd", $user->getRecPassword());

            if ($statement->execute()) {
                if ($statement->rowCount() > 0) {
                    return "Dados cadastrados com sucesso!";
                } else {
                    return "Erro ao tentar efetivar cadastro";
                }
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function atualizar($user)
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_user, str_name, str_username, str_password, str_type, str_email, rec_Password FROM tb_user WHERE id_user = :id");
            $statement->bindValue(":id", $user->getIdUser());
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $user->setIdUser($rs->id_user);
                $user->setName($rs->str_name);
                $user->setUsername($rs->str_username);
                $user->setPassword($rs->str_password);
                $user->setType($rs->str_type);
                $user->setEmail($rs->str_email);
                $user->setRecPassword($rs->rec_Password);
                return $user;
            } else {
                throw new PDOException("Erro: Não foi possível executar a declaração sql");
            }
        } catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }


    public function buscarPorUsernameEEmail($username, $email){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT id_user, str_name, str_username, str_password, str_type, str_email, rec_Password FROM tb_user WHERE str_username = :username AND str_email = :email");
            $statement->bindValue(":username", $username);
            $statement->bindValue(":email", $email);
            if ($statement->execute()) {
                $rs = $statement->fetch(PDO::FETCH_OBJ);
                $user = new user($rs->id_user, $rs->str_name, $rs->str_username, $rs->str_password, $rs->str_type, $rs->str_email, $rs->rec_Password);
                return $user;
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
        $sql = "SELECT id_user, str_name, str_username, str_password, str_type, str_email, rec_Password FROM tb_user LIMIT {$linha_inicial}, " . QTDE_REGISTROS;
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $dados = $statement->fetchAll(PDO::FETCH_OBJ);

        /* Conta quantos registos existem na tabela */
        $sqlContador = "SELECT COUNT(*) AS total_registros FROM tb_user";
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
        <th>Username</th>
        <th>Type</th>
        <th>E-mail</th>
        <th>Rec. Password</th>
        <th colspan='2'>Actions</th>
       </tr>
     </thead>
     <tbody>";
            foreach ($dados as $var):
                echo "<tr>
        <td>$var->id_user</td>
        <td>$var->str_name</td>
        <td>$var->str_username</td>
        <td>$var->str_type</td>
        <td>$var->str_email</td>
        <td>$var->rec_Password</td>
        <td><a href='?act=upd&idUser=$var->id_user'><i class='ti-reload'></i></a></td>
        <td><a href='?act=del&idUser=$var->id_user'><i class='ti-close'></i></a></td>
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