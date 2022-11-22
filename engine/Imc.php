<?php
class Imc
{
    private $data;

    public function __construct($sexo, $peso, $altura, $idioma)
    {
        #$url = 'https://apianos90.edsonmelo1.repl.co';
        $url = 'https://api-micro.joaolucassilva.repl.co';

        $content = @file_get_contents("$url/imc/$sexo/$peso/$altura/$idioma");
        $this->data = json_decode($content);
    }

    public function getData()
    {
        return $this->data;
    }
}
