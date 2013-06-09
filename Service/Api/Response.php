<?php
namespace Ql4b\Bundle\GeocodeBundle\Service\Api;

class Response Extends \SimpleXMLElement
{
    const STATUS_OK 				= 'OK'; // indicates that no errors occurred; the address was successfully parsed and at least one geocode was returned.
    const STATUS_ZERO_RESULTS 		= 'ZERO_RESULTS'; // indicates that the geocode was successful but returned no results. This may occur if the geocode was passed a non-existent address or a latlng in a remote location.
    const STATUS_OVER_QUERY_LIMIT 	= 'OVER_QUERY_LIMIT'; // indicates that you are over your quota.
    const STATUS_REQUEST_DENIED 	= 'REQUEST_DENIED'; // indicates that your request was denied, generally because of lack of a sensor parameter.
    const STATUS_INVALID_REQUEST 	= 'INVALID_REQUEST'; // generally indicates that the query (address or latlng) is missing.
    
    /**
     * @var string
     */
    private $status;
    
    /**
     * @var \SimpleXMLElement
     */
    private $result;
    
    /**
     * @var boolean
     */
    private $ambiguous;
    
    
}
