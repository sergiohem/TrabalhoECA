<?php
/**
 * Created by PhpStorm.
 * User: aluno
 * Date: 16/03/2018
 * Time: 21:17
 */

require_once("../db/conexao.php");

class reportDAO
{
    private $currentDate;

    /**
     * reportDAO constructor.
     */
    public function __construct()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $this->currentDate = date('d/m/Y H:i:s')."hs";
    }

    public function listarBeneficiariosOrdemAlfabetica()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT str_nis, str_name_person FROM tb_beneficiaries ORDER BY str_name_person LIMIT 20");
            if ($statement->execute()) {
                $rs = $statement->fetchAll(PDO::FETCH_OBJ);

                $html = '<h2>BENEFICIARIES ORDER BY NAME</h2>
<br />
<p>Report generation date: '.$this->currentDate.'hs</p>
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
                $html = '<h2>BENEFICIARIES AND THEIR CITIES</h2>
<br />
<p>Report generation date: '.$this->currentDate.'</p>
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

    public function listarPagamentos(){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT 
    benef.str_nis, benef.str_name_person, city.str_name_city, st.str_uf, func.str_name_function, subfunc.str_name_subfunction, prog.str_name_program,
    act.str_name_action, sour.str_origin, fi.str_name_file, pay.db_value
FROM
    tb_payments AS pay
		JOIN
	tb_city as city ON pay.tb_city_id_city = city.id_city
		JOIN
	tb_functions as func ON pay.tb_functions_id_function = func.id_function
		JOIN
	tb_subfunctions as subfunc ON pay.tb_subfunctions_id_subfunction = subfunc.id_subfunction
		JOIN
	tb_program as prog ON pay.tb_program_id_program = prog.id_program
        JOIN
    tb_action AS act ON pay.tb_action_id_action = act.id_action
		JOIN
	tb_beneficiaries as benef ON pay.tb_beneficiaries_id_beneficiaries = benef.id_beneficiaries
		JOIN
	tb_source as sour ON pay.tb_source_id_source = sour.id_source
		JOIN
	tb_files as fi ON pay.tb_files_id_file = fi.id_file
		JOIN
	tb_state as st ON city.tb_state_id_state = st.id_state
		LIMIT 20");

            if ($statement->execute()) {
                $rs = $statement->fetchAll(PDO::FETCH_OBJ);
                $html = '<h2>PAYMENTS</h2>
<br />
<p>Report generation date: '.$this->currentDate.'</p>
<br />
<table class="table table-striped" border="1">
     <thead>
       <tr>
        <th style="font-weight: bold; text-align: center;">NIS</th>
        <th style="font-weight: bold; text-align: center;">Beneficiary</th>
        <th style="font-weight: bold; text-align: center;">City</th>
        <th style="font-weight: bold; text-align: center;">Function</th>
        <th style="font-weight: bold; text-align: center;">Subfunction</th>
        <th style="font-weight: bold; text-align: center;">Program</th>
        <th style="font-weight: bold; text-align: center;">Action</th>
        <th style="font-weight: bold; text-align: center;">Source (origin)</th>
        <th style="font-weight: bold; text-align: center;">File</th>
        <th style="font-weight: bold; text-align: center;">Value</th>
       </tr>
       <br/>
     </thead>
     <tbody>';

                foreach ($rs as $payment) {
                    $html .= '<tr>
<td>'.$payment->str_nis.'</td>
<td>'.$payment->str_name_person.'</td>
<td>'.$payment->str_name_city.' - '.$payment->str_uf.'</td>
<td>'.$payment->str_name_function.'</td>
<td>'.$payment->str_name_subfunction.'</td>
<td>'.$payment->str_name_program.'</td>
<td>'.$payment->str_name_action.'</td>
<td>'.$payment->str_origin.'</td>
<td>'.$payment->str_name_file.'</td>
<td>'.$payment->db_value.'</td>
</tr>';
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

    public function report4(){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT 
    city.str_name_city,
    st.str_uf,
    COUNT(pay.id_payment) AS beneficiaries_count,
    SUM(pay.db_value) AS total_payments
FROM
    tb_city AS city
        JOIN
    tb_state AS st ON city.tb_state_id_state = st.id_state
        JOIN
    tb_payments AS pay ON city.id_city = pay.tb_city_id_city
        JOIN
    tb_beneficiaries AS ben ON pay.tb_beneficiaries_id_beneficiaries = ben.id_beneficiaries
GROUP BY city.id_city
ORDER BY SUM(pay.db_value) DESC
LIMIT 20");

            if ($statement->execute()) {
                $rs = $statement->fetchAll(PDO::FETCH_OBJ);
                $html = '<h2>PAYMENTS</h2>
<br />
<p>Report generation date: '.$this->currentDate.'</p>
<br />
<table class="table table-striped" border="1">
     <thead>
       <tr>
        <th style="font-weight: bold; text-align: center;">City</th>
        <th style="font-weight: bold; text-align: center;">Number of beneficiaries</th>
        <th style="font-weight: bold; text-align: center;">Total value of payments</th>
       </tr>
       <br/>
     </thead>
     <tbody>';

                foreach ($rs as $payment) {
                    $html .= '<tr>
<td>'.$payment->str_name_city.' - '.$payment->str_uf.'</td>
<td>'.$payment->beneficiaries_count.'</td>
<td>'.$payment->total_payments.'</td>
</tr>';
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

    public function report5(){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT 
    ben.str_nis, ben.str_name_person, COUNT(pay.id_payment) as payments_number
FROM
    tb_payments AS pay
        JOIN
    tb_beneficiaries AS ben ON pay.tb_beneficiaries_id_beneficiaries = ben.id_beneficiaries
GROUP BY pay.id_payment
LIMIT 20");

            if ($statement->execute()) {
                $rs = $statement->fetchAll(PDO::FETCH_OBJ);
                $html = '<h2>PAYMENTS</h2>
<br />
<p>Report generation date: '.$this->currentDate.'</p>
<br />
<table class="table table-striped" border="1">
     <thead>
       <tr>
        <th style="font-weight: bold; text-align: center;">NIS</th>
        <th style="font-weight: bold; text-align: center;">Beneficiary</th>
        <th style="font-weight: bold; text-align: center;">Total of payments</th>
       </tr>
       <br/>
     </thead>
     <tbody>';

                foreach ($rs as $payment) {
                    $html .= '<tr>
<td>'.$payment->str_nis.'</td>
<td>'.$payment->str_name_person.'</td>
<td>'.$payment->payments_number.'</td>
</tr>';
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

    public function report6(){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT 
    reg.str_name_region, SUM(pay.db_value) AS totalValuePayments
FROM
    tb_payments AS pay
        JOIN
    tb_city AS city ON pay.tb_city_id_city = city.id_city
        JOIN
    tb_state AS st ON city.tb_state_id_state = st.id_state
        JOIN
    tb_region AS reg ON st.tb_region_id_region = reg.id_region
GROUP BY reg.id_region
ORDER BY reg.str_name_region");

            if ($statement->execute()) {
                $rs = $statement->fetchAll(PDO::FETCH_OBJ);
                $html = '<h2>PAYMENTS</h2>
<br />
<p>Report generation date: '.$this->currentDate.'</p>
<br />
<table class="table table-striped" border="1">
     <thead>
       <tr>
        <th style="font-weight: bold; text-align: center;">Region</th>
        <th style="font-weight: bold; text-align: center;">Total value of payments</th>
       </tr>
       <br/>
     </thead>
     <tbody>';

                foreach ($rs as $payment) {
                    $html .= '<tr>
<td>'.$payment->str_name_region.'</td>
<td>'.$payment->totalValuePayments.'</td>
</tr>';
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

    public function report7(){
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT 
    st.str_name, SUM(pay.db_value) AS totalValuePayments
FROM
    tb_payments AS pay
        JOIN
    tb_city AS city ON pay.tb_city_id_city = city.id_city
        JOIN
    tb_state AS st ON city.tb_state_id_state = st.id_state
GROUP BY st.id_state
ORDER BY st.str_name");

            if ($statement->execute()) {
                $rs = $statement->fetchAll(PDO::FETCH_OBJ);
                $html = '<h2>PAYMENTS</h2>
<br />
<p>Report generation date: '.$this->currentDate.'</p>
<br />
<table class="table table-striped" border="1">
     <thead>
       <tr>
        <th style="font-weight: bold; text-align: center;">State</th>
        <th style="font-weight: bold; text-align: center;">Total value of payments</th>
       </tr>
       <br/>
     </thead>
     <tbody>';

                foreach ($rs as $payment) {
                    $html .= '<tr>
<td>'.$payment->str_name.'</td>
<td>'.$payment->totalValuePayments.'</td>
</tr>';
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
}