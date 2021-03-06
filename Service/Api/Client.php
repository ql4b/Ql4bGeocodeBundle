<?php
namespace Ql4b\Bundle\GeocodeBundle\Service\Api;

use Zend\Http\Client as HttpClient;
use Zend\Http\Response as HttpResponse;
use Zend\Http\Client\Exception as HttpException;

/**
 * 
 * Google Geocoding API (V2) Client
 * 
 * @link http://code.google.com/apis/maps/documentation/geocoding/
 *
 */
class Client
{
    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var string
     */
    private $key;

    /**
     * @var language
     */
    private $language;
    
    /**
     * @var string
     */
    private $outputFormat = 'xml';
    
    /**
     * @var HttpClient
     */
    private static $httpClient;
    
    /**
     * @param string $endpoint
     */
    public function __construct($endpoint, $key, $language)
    {
        $this->endpoint = $endpoint;
        $this->key = $key;
        $this->language = $language;
    }
    
    
    /**
     * @param string $address
     * @param string $region
     * @param string $language
     * @param string $components
     */
    public function lookup($address, $region = null, $language = null, $components = null)
    {
        $params = array (
			'address' => $address
        );
        
        if (null!==$region)
            $params['region'] = $region;
        	
        if (null!==$language)
            $params['language'] = $language;
        else
            $params['language'] = $this->language;

        
        if (null!==$components)
            $params['components'] = $components;
        
        return $this->makeRequest($params);
        
    }

    /**
     * @param string $latLong
     */
    public function reverseLookup($latLong)
    {
        $response = $this->makeRequest(array('latlong' => $latLong));
        return $response;
    }
    
    /**
     * @param array $params
     */
    private function makeRequest(array $params = array())
    {
        $uri = $this->endpoint . '/' . $this->outputFormat;
        
        $client = self::getHttpClient();
        $client->setUri($uri);
        
        if (!isset($params['sensor']))
            $params['sensor'] = 'false';

        $params['key'] = $this->key;
        
        $client->setParameterGet($params);
        
        try {
        
            $response = $client->send();
            return new Response($response);
        
        } catch (HttpException\RuntimeException $e){
        
            throw new Exception($e->getMessage(), null, $e);
        }
        
        
        
    }
    
    /**
     * @return HttpClient
     */
    private static function getHttpClient(){
    
        if (!isset(self::$httpClient)){
            self::$httpClient = new HttpClient();
        }
    
        return self::$httpClient;
    
    }
}