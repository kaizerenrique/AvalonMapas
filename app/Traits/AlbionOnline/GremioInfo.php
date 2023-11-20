<?php

namespace App\Traits\AlbionOnline;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

trait GremioInfo 
{
    /**
	* Esta función realiza una consulta a la Pagina del gameinfo.albiononline 
    * para buscar información de los gremios por nombre. 
	* 
	* @param string   $text	cadena de texto que contiene el nombre del gremio
	*
	* @return Retorna un array.
	*/	

    public function consultar($text)
	{
        try {
            $url = 'https://gameinfo.albiononline.com/api/gameinfo/search?q=';
			$response = Http::get($url.$text);

			$respuesta = $response->getBody()->getContents();// accedemos a el contenido			

            $respuesta = json_decode($respuesta); //convertimos en json	

			if (!empty($respuesta->guilds)) {
				return $respuesta->guilds;
			} else {
				return false;
			}	

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            //report($e);	 
	        return false;
        }
	}

    /**
	* Esta función realiza una consulta a la Pagina del gameinfo.albiononline 
    * para buscar información de los gremios por su id. 
	* 
	* @param string   $text	cadena de texto que contiene el ID
	*
	* @return Retorna un array.
	*/	

    public function consultargremio($text)
	{
        try {
            $url = 'https://gameinfo.albiononline.com/api/gameinfo/guilds/';
			$response = Http::get($url.$text.'/data');

			$respuesta = $response->getBody()->getContents();// accedemos a el contenido			

            $respuesta = json_decode($respuesta); //convertimos en json	
			
			return $respuesta;			

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            //report($e);	 
	        return false;
        }
	}
}