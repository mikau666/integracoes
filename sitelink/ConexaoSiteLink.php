<?php

    class ConexaoSitelink {

        // Propriedades referentes a conexão
        private $url = 'https://api.smdservers.net/CCWs_3.5/CallCenterWs.asmx?WSDL';
        private $dados_conexao = [ 'sCorpCode' => 'CCTST',
                                   'sLocationCode' => 'Demo',
                                   'sCorpUserName' => 'Administrator:::YOUR_API_KEY_HERE',
                                   'sCorpPassword' => 'Demo'];

        // Propriedade do objeto SOAP
        private $obj_soap = null;

        // Propriedade que armazena erros retornados pela SiteLink
        private $erros = array();

        // Propriedades referentes a LEADS
        private $dados_lead = array();
        private $obj_lead = false;

        function __construct(){

            $this->obj_soap = new SoapClient($this->url);
        }

        // Definir o Lead
        public function setLead($lead = null){

            if($lead == null){
                return false;
            }

            $this->dados_lead = $lead;
            return true;
        }

        // Enviar o lead para o SiteLink
        public function sendLead(){

            try{
                $this->obj_lead = $this->obj_soap->LeadGeneration(array_merge($this->dados_conexao , $this->dados_lead));
            } catch (Exception $e){
                $this->erros[] = $e->getMessage();
                return false;
            }
            return true;
        }

        // Confirmar se o Lead foi recebido com sucesso
        public function checkLead(){

            if(!$this->obj_lead){
                return false;
            }

            try{
                $retorno = $this->obj_lead->LeadGenerationResult;
            } catch (Exception $e){
                $this->erros[] = $e->getMessage();
                return false;
            }

            return $retorno;
        }
    }