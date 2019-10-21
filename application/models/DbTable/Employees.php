<?php

class Application_Model_DbTable_Employees extends Zend_Db_Table_Abstract
{

    protected $_name = 'employees';
    protected $_primary='id';

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
    public function edit($array=null)
    {
        if($array!=null){
            $dataArr = $this->_convertArrDB($array);
            $id = $dataArr['id'];
            $where = $this->getAdapter()->quoteInto('id=?', $id);

            unset($dataArr['id']);

            //Faz o update dos dados
            try{
                $this->update($dataArr,$where);
                return true;
            }catch (Exception $e){
                return $e->getMessage();
            }//try catch
        }//if array null

        return false;
    }//Edit

    //Remove register from DB
    public function remove($id)
    {
        $where = $this->getAdapter()->quoteInto('id=?', $id);

        //Remove o registro
        try{
            $this->delete($where);
            return true;
        }catch (Exception $e){
            return $e->getMessage();
        }//try catch
    }//Remove

    //Convert array to obj to DB
    private function _convertArrDB($array)
    {
        $return = array();

        $return['id'] = isset($array['id']) ? $array['id'] : null;
        $return['name'] = isset($array['name']) ? $array['name'] : null;
        $return['phone'] = isset($array['phone']) ? $array['phone'] : null;
        $return['cellphone'] = isset($array['cellphone']) ? $array['cellphone'] : null;
        $return['cpf'] = isset($array['cpf']) ? $array['cpf'] : null;
        $return['email'] = isset($array['email']) ? $array['email'] : null;
        $return['street'] = isset($array['street']) ? $array['street'] : null;
        $return['house_number'] = isset($array['houseNumber']) ? $array['houseNumber'] : null;
        $return['neighborhood'] = isset($array['neighborhood']) ? $array['neighborhood'] : null;
        $return['cep'] = isset($array['cep']) ? $array['cep'] : null;
        $return['city'] = isset($array['city']) ? $array['city'] : null;

        return $return;
    } //_convertArrObjDB

    //Convert DB data to Array Form
    public function _convertDBArr($obj)
    {
        $return = array();

        $return['id'] = isset($obj->id) ? $obj->id : null;
        $return['name'] = isset($obj->name) ? $obj->name : null;
        $return['phone'] = isset($obj->phone) ? $obj->phone : null;
        $return['cellphone'] = isset($obj->cellphone) ? $obj->cellphone : null;
        $return['cpf'] = isset($obj->cpf) ? $obj->cpf : null;
        $return['email'] = isset($obj->email) ? $obj->email : null;
        $return['street'] = isset($obj->street) ? $obj->street: null;
        $return['houseNumber'] = isset($obj->house_number) ? $obj->house_number : null;
        $return['neighborhood'] = isset($obj->neighborhood) ? $obj->neighborhood : null;
        $return['cep'] = isset($obj->cep) ? $obj->cep : null;
        $return['city'] = isset($obj->city) ? $obj->city : null;

        return $return;
    }//convert to array

}//class

