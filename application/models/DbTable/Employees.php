<?php

class Application_Model_DbTable_Employees extends Zend_Db_Table_Abstract
{

    protected $_name = 'employees';

    //Insert Data into DB
    public function insere($array=null)
    {
        if($array!=null){
            $dataObj = $this->_convertArrDB($array);
            //try Insert in DB
            try{
                $this->insert($dataObj);
                return true;
            }catch (Exception $e){

                return $e->getMessage();
            }//try catch
        }//if array null
        return false;
    }//Insere

    //Edit Data into DB
    public function edit($array){

    }//Edit

    //Convert array to obj to DB
    private function _convertArrDB($array)
    {
        $obj = array();

        $obj['id'] = isset($array['id']) ? $array['id'] : null;
        $obj['name'] = isset($array['name']) ? $array['name'] : null;
        $obj['phone'] = isset($array['phone']) ? $array['phone'] : null;
        $obj['cellphone'] = isset($array['cellphone']) ? $array['cellphone'] : null;
        $obj['cpf'] = isset($array['cpf']) ? $array['cpf'] : null;
        $obj['email'] = isset($array['email']) ? $array['email'] : null;
        $obj['street'] = isset($array['street']) ? $array['street'] : null;
        $obj['house_number'] = isset($array['houseNumber']) ? $array['houseNumber'] : null;
        $obj['neighborhood'] = isset($array['neighborhood']) ? $array['neighborhood'] : null;
        $obj['cep'] = isset($array['cep']) ? $array['cep'] : null;
        $obj['city'] = isset($array['city']) ? $array['city'] : null;

        return $obj;
    } //_convertArrObjDB

}//class

