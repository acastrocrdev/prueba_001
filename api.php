<?php
/**
 *
 * API de pruebas
 *
 * @category API
 * @package Prueba para Jorge emilio Morales
 * @version 1.0
 * @author Hernan Castro <alberto87.cr@gmail.com>
 * @copyright Copyright (c) 2020, Hernan Alberto Castro Paniagua <alberto87.cr@gmail.com>
 *
 */

class api
{
    private $mysqli;
    private $SERVER_DB;
    private $USER;
    private $PASS;
    private $DATABASE;

    public function __construct()
    {
        $this->SERVER_DB    = 'localhost';
        $this->USER         = 'root';
        $this->PASS         = '';
        $this->DATABASE     = 'test_001';
    }

    private function set_conn()
    {
        $this->mysqli = new mysqli(
            $this->SERVER_DB,
            $this->USER,
            $this->PASS,
            $this->DATABASE
        );
        if ($this->mysqli->connect_error) {
            die('Error : (' . $this->mysqli->connect_errno . ') ' . $this->mysqli->connect_error);
        }
    }

    private function exec_query($query, $retID = false)
    {
        try {
            if (FALSE) :
                echo "\n" . $query . "\n";
            endif;
            $this->set_conn();
            mysqli_set_charset($this->mysqli, 'utf8');
            $results = $this->mysqli->query($query);
            if ($this->mysqli->errno > 0) :
                return array(
                    'msg'     => $this->mysqli->error,
                    'estado' => $this->mysqli->errno,
                    'origin' => "mysqli"
                );
            endif;
            $res_id = $this->mysqli->insert_id;
            $this->mysqli->close();
            unset($this->mysqli);
            if ($retID) :
                return $res_id;
            else :
                if ($results->num_rows <= 1) :
                    return $results->fetch_assoc();
                else :
                    $arrRet = array();
                    while ($row = $results->fetch_assoc()) :
                        $arrRet[] = $row;
                    endwhile;
                    return $arrRet;
                endif;
            endif;
        } catch (Exception $e) {
            echo "Error in api->exec_query: ";
            var_dump($e);
            throw $e;
        }
    }

    public function get_products_rows()
    {
        $table_prods = $this->exec_query('SELECT * FROM productos;');
        $table_html = '';
        foreach ($table_prods as $prod) :
            $table_html .=
                '<tr data-row_product="' . $prod['idRecepDocumentosDeta'] . '">' .
                '   <th data-nat="' . $prod['naturalezaProducto'] . '" scope="row">' . (($prod['naturalezaProducto'] == '0' ? 'Bien' : 'Servicio')) . '</th>' .
                '   <td class="code">' . $prod['CodigoComercial'] . '</td>' .
                '   <td class="uni">' . $prod['UnidadMedida'] . '</td>' .
                '   <td class="uni_com">' . $prod['UnidadMedidaComercial'] . '</td>' .
                '   <td class="detail">' . $prod['Detalle'] . '</td>' .
                '   <td class="amount">' . $prod['PrecioUnitario'] . '</td>' .
                '   <td class="imp">' . $prod['ImpuestoTarifa'] . '</td>' .
                '</tr>';
        endforeach;
        return $table_html;
    }

    public function get_products_units()
    {
        $units = $this->exec_query('SELECT UnidadMedida FROM productos GROUP BY UnidadMedida;');
        $options_html = '';
        foreach ($units as $unit) :
            $options_html .=
                '<option value="' . $unit['UnidadMedida'] . '">' . $unit['UnidadMedida'] . '</option>';
        endforeach;
        return $options_html;
    }

    public function update_product($id, $nat, $uni, $det, $amo)
    {
        try {
            $sql = "UPDATE productos SET naturalezaProducto='" . $nat . "', UnidadMedida='" . $uni . "', Detalle='" . $det . "', PrecioUnitario=" . $amo . " WHERE idRecepDocumentosDeta = " . $id . ";";
            $this->exec_query($sql, true);
            $ret = array(
                'status' => 1
            );
            return json_encode($ret, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {
            $ret = array(
                'status' => 0
            );
            return json_encode($ret, JSON_UNESCAPED_UNICODE);
        }
    }
}

if (isset($_POST['action'])) :
    $api = new api();
    switch ($_POST['action']):
        case 'save_prod':
            header('Content-Type: application/json');
            $id = $_POST['id'];
            $nat = $_POST['nat'];
            $uni = $_POST['uni'];
            $det = $_POST['det'];
            $amo = $_POST['amo'];
            echo $api->update_product($id, $nat, $uni, $det, $amo);
            break;
    endswitch;
endif;
