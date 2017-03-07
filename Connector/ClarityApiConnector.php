<?php

namespace Clarity\Connector;

/**
 * Description of ClarityConnector
 *
 * @author Mickael Escudero
 */
class ClarityApiConnector
{

    /**
     *
     * @var string $baseUrl
     */
    protected $baseUrl;
    
    /**
     *
     * @var resource
     */
    protected $curlHandle;

    /**
     * 
     * @param string $instance
     */
    public function __construct($instance)
    {
        $credentials = yaml_parse_file('Config/clarity_api_credentials.yml');
        $username = $credentials['username'];
        $password = $credentials['password'];

        $config = yaml_parse_file('Config/clarity_parameters.yml');
        $this->baseUrl = $config['URL'][$instance];

        $this->curlHandle = curl_init();
        curl_setopt($this->curlHandle, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($this->curlHandle, CURLOPT_USERPWD, $username . ':' . $password);
    }

    public function __destruct()
    {
        curl_close($this->curlHandle);
    }

    /**
     * 
     * @param string $path
     * @return string
     */
    public function getResource($path)
    {
        $url = $this->baseUrl . '/' . $path;
        curl_setopt($this->curlHandle, CURLOPT_URL, $url);
        curl_setopt($this->curlHandle, CURLOPT_HTTPGET, TRUE);
        return curl_exec($this->curlHandle);
    }

    /**
     * 
     * @param string $endpoint
     * @param string $data
     * @return string
     */
    public function postResource($endpoint, $data)
    {
        $url = $this->baseUrl . '/' . $endpoint;
        curl_setopt($this->curlHandle, CURLOPT_URL, $url);
        curl_setopt($this->curlHandle, CURLOPT_POST, TRUE);
        curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, $data);
        return curl_exec($this->curlHandle);
    }

    /**
     * 
     * @return string
     */
    public function putResource($endpoint, $data, $id)
    {
        $putData = tmpfile();
        fwrite($putData, $data);
        fseek($putData, 0);
        $url = $this->baseUrl . '/' . $endpoint . '/' . $id;
        curl_setopt($this->curlHandle, CURLOPT_URL, $url);
        curl_setopt($this->curlHandle, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($this->curlHandle, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($this->curlHandle, CURLOPT_POSTFIELDS, $data);
        return curl_exec($this->curlHandle);
    }

    /**
     * 
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * 
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * 
     * @param resource $curlHandle
     */
    public function setCurlHandle(resource $curlHandle)
    {
        $this->curlHandle = $curlHandle;
    }

    /**
     * 
     * @return resource
     */
    public function getCurlHandle()
    {
        return $this->curlHandle;
    }

}
