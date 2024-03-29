<?php

class EmployeesController extends Zend_Controller_Action {

    /** 
     * @var Zend_Log
     */
    private $logger;

    //Variabels Internas
    public $_exception;
    public $_modelEmployees;

    public function init()
    {
        $this->logger = Zend_Registry::get('logger');

        //Setting variables
        $this->_modelEmployees = new Application_Model_DbTable_Employees();
        $this->_exception = '';
    }

    public function indexAction()
    {
        //List all registers
        $lista = $this->_modelEmployees->fetchAll();

        $this->view->lista=$lista;
    }

    //Inert new employee register
    public function createAction()
    {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/forms/employees.ini', 'create');
        $form = new Application_Form_Employees($config);
        $this->view->form = $form;

        //Add elements in DB
        if($this->_request->isPost()){
            $valida=$this->validateData($this->_request);

            if(is_bool($valida) & $valida==true) {
                $this->redirect('/employees');
            }else{
                $this->view->error=$this->_exception;
                $this->view->form = $form->populate($this->_request->getParams());
            }
        }//if post form
    }//create action

    //Update some employee register
    public function editAction()
    {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/forms/employees.ini', 'edit');
        $form = new Application_Form_Employees($config);

        //Verificando o "id" do employee e caso nao exista ou seja nulo redireciona para tela inicial do employees.
        $idEmployee = $this->_request->getParam('id');

        if(empty($idEmployee) || $idEmployee==null){
            $this->redirect('/employees');
        }//if id employees

        //Recupera os dados do registro.
        $dadosEmployee = $this->_modelEmployees->find($idEmployee)->current();

        //Verifica se os registros existem e se retornar nulo redireciona para a tela inidial do employee
        if($dadosEmployee==null){
            $this->redirect('/employees');
        }else{
            //Faz os tratamentos para realizar o update
            $arrayDados = $this->_modelEmployees->_convertDBArr($dadosEmployee);

            //Update elements in DB
            if($this->_request->isPost()){
                $valida=$this->validateData($this->_request,'edit');
                if(is_bool($valida) & $valida==true) {
                    $this->redirect('/employees');
                }else{
                    $form->populate($this->_request->getParams());
                    $this->view->error=$this->_exception;
                }
            }//if post form
        }//if / else dadosRegistro employee
        $this->view->form=$form;
    }//update


    //Remove Register
    public function deleteAction()
    {
        //Verificando o "id" do employee e caso nao exista ou seja nulo redireciona para tela inicial do employees.
        $idEmployee = $this->_request->getParam('id');

        if(empty($idEmployee) || $idEmployee==null){
            $this->redirect('/employees');
        }//if id employees

        //Recupera os dados do registro.
        $dadosEmployee = $this->_modelEmployees->find($idEmployee)->current();

        //Verifica se os registros existem e se retornar nulo redireciona para a tela inidial do employee
        if($dadosEmployee!=null) {
            $this->_modelEmployees->remove($dadosEmployee->id);
        }
        $this->redirect('/employees');
    }//delete

    //Validate Data
    private function validateData(Zend_Controller_Request_Http $request, $typeForm=null)
    {
        //valida Númeds
        $digitValidate = new Zend_Validate_Digits();
        //Valida caracteres (palavras
        $alphaValidate = new Zend_Validate_Alpha(array('allowWhiteSpace' => true));
        //Validador de Letras e Números
        $numberValidate = new Zend_Validate_Alnum();

        //Validate houseNumber
        if(!$digitValidate->isValid($request->houseNumber)){
            $this->_exception='O número da casa não é válido!';
            return $digitValidate;
        }//if validate houseNumber

        //Validate CEP - Especific Validate
        $cepValidate = new Zend_Validate();
        $cepValidate->addValidator(
            new Zend_Validate_StringLength(
                array('min' => 6,
                      'max' => 8)
            )
        )->addValidator($digitValidate);
        if(!$cepValidate->isValid($request->cep)){
            $this->_exception='O número do CEP não é válido!';
            return $cepValidate;
        }//if validate CEP

        //Update Register
        if(strtolower($typeForm)=='edit'){
            //Validate id to update
            if(!$digitValidate->isValid($request->id)){
                $this->_exception='O id do registro não é válido!';
                return $digitValidate;
            }//if validate houseNumber

            $return = $this->_modelEmployees->edit($request->getParams());
            if(is_string($return)){
                $this->_exception = $return;
                return [$this->_exception];
            }else{
                return $return;
            }
        }else{
            //Insert
            $return = $this->_modelEmployees->insere($request->getParams());
            if(is_string($return)){
                $this->_exception = $return;
                return [$this->_exception];
            }else{
                return $return;
            }
        }//if / else insert or edit
    }//function ValidateData

}//class