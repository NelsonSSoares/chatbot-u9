<?php
ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
# API: https://cep.awesomeapi.com.br/03590070
# Variáveis de resposta
# cep
# address_type (tipo)
# address_name (logradouro)
# address (tipo + logradouro)
# state (estado)
# district (bairro)
# city

# Classe que recupera os dados de CEP da API Awesome
class Cep
{
    private $data; # array para guardar os dados recuperados

    /**
     * @throws Exception
     */
    public function __construct($cep)
    {
        # faz a requisição a API
        $content = @file_get_contents("https://cep.awesomeapi.com.br/json/$cep");

        # verificar o conteúdo de retorno
        if (strpos($http_response_header[0], "200")) { # encontrou o servidor
            $obj_json = json_decode($content);
            $this->data = $obj_json;
        } else {
            throw new Exception("CEP [$cep] não localizado.");
        }
    }

    public function getAddress()
    {
        return $this->data->address;
    }

    public function getDistrict()
    {
        return $this->data->district;
    }


    public function getCity()
    {
        return $this->data->city;
    }

    public function getState()
    {
        return $this->data->state;
    }
}
