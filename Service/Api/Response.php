<?php
namespace Ql4b\Bundle\GeocodeBundle\Service\Api;

use Zend\Http\Response as HttpResponse;

class Response
{
    const STATUS_OK 				= 'OK'; // indicates that no errors occurred; the address was successfully parsed and at least one geocode was returned.
    const STATUS_ZERO_RESULTS 		= 'ZERO_RESULTS'; // indicates that the geocode was successful but returned no results. This may occur if the geocode was passed a non-existent address or a latlng in a remote location.
    const STATUS_OVER_QUERY_LIMIT 	= 'OVER_QUERY_LIMIT'; // indicates that you are over your quota.
    const STATUS_REQUEST_DENIED 	= 'REQUEST_DENIED'; // indicates that your request was denied, generally because of lack of a sensor parameter.
    const STATUS_INVALID_REQUEST 	= 'INVALID_REQUEST'; // generally indicates that the query (address or latlng) is missing.
    const STATUS_HTTP_ERROR         = 'HTTP_ERROR';
    const STATUS_PARSING_ERROR      = 'PARSING_ERROR';
    
    
    
    /**
     * @var string
     */
    private $status;
    
    /**
     * @var \SimpleXMLElement
     */
    private $data;
    
    /**
     * @var boolean
     */
    private $ambiguous;
    
    /**
     * @param HttpResponse $response
     */
    public function __construct(HttpResponse $response)
    {
        if ($response->getStatusCode() !== HttpResponse::STATUS_CODE_200){
            $this->status = self::STATUS_HTTP_ERROR;
            return;
        }
        
        $content = $response->getContent();
        
        try {
            
            $xml = new \SimpleXMLElement($content);
            
            $this->status = (string) $xml->status;
            
            if (count($xml->result) > 1)
                $this->ambiguous = true;
            else
                $this->ambiguous = false;
            
            $this->data = $xml;
            
        } catch (\Exception $e){
            
            $this->status = self::STATUS_PARSING_ERROR;
            return; 
        }
        
    }
    
    /**
     * @return boolean
     */
    public function isValid(){
    
        if ($this->status == self::STATUS_OK)
        return true;
        	
        return false;
    }
    
    /**
     * Get Resposne Status
     */
    public function getStatus(){
    
        return $this->status;
    }
    
    /**
     * @return mixed Array|\SimpleXMLElement
     */
    public function getResults()
    {
        $results = $this->data->xpath('result');
        
        if (count($results) === 1)
            $results = array_shift($result);
        
        return $results;
    }
    
    
}
