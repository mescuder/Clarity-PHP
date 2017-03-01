<?php

namespace Clarity\Entity;

/**
 * Description of Researcher
 *
 * @author Mickael Escudero
 */
class Researcher
{
    
    /**
     *
     * @var string $clarityId
     */
    protected $clarityId;
    
    /**
     *
     * @var string $clarityUri
     */
    protected $clarityUri;
    
    /**
     *
     * @var string $email
     */
    protected $email;
    
    /**
     *
     * @var string $firstName
     */
    protected $firstName;
    
    /**
     *
     * @var string $labUri
     */
    protected $labUri;
    
    /**
     *
     * @var string $lastName
     */
    protected $lastName;
    
    /**
     *
     * @var bool $locked
     */
    protected $locked;
    
    /**
     *
     * @var string $phone
     */
    protected $phone;
    
    /**
     *
     * @var array $roles
     */
    protected $roles;
    
    /**
     *
     * @var string $username
     */
    protected $username;
    
    /**
     *
     * @var string $xml
     */
    protected $xml;
    
    public function __construct()
    {
        $this->roles = array();
    }
    
    public function xmlToResearcher()
    {
        $researcherElement = new \SimpleXMLElement($this->xml);
        $this->clarityUri = $researcherElement['uri']->__toString();
        $this->email = $researcherElement->email->__toString();
        $this->firstName = $researcherElement->{'first-name'}->__toString();
        $this->lastName = $researcherElement->{'last-name'}->__toString();
        $this->labUri = $researcherElement->lab['uri']->__toString();
        $this->phone = $researcherElement->phone->__toString();
        $this->username = $researcherElement->credentials->username->__toString();
        $this->locked = $researcherElement->credentials->{'account-locked'}->__toString();
        
        foreach ($researcherElement->xpath('//role') as $role) {
            $this->roles[] = $role['name']->__toString();
        }
    }
    
    /**
     * 
     * @param string $clarityId
     */
    public function setClarityId($clarityId)
    {
        $this->clarityId = $clarityId;
    }
    
    /**
     * 
     * @return string
     */
    public function getClarityId()
    {
        return $this->getClarityId();
    }
    
    /**
     * 
     * @param string $clarityUri
     */
    public function setClarityUri($clarityUri)
    {
        $this->clarityUri = $clarityUri;
    }
    
    /**
     * 
     * @return string
     */
    public function getClarityUri()
    {
        return $this->clarityUri;
    }
    
    /**
     * 
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    /**
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * 
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    
    /**
     * 
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    /**
     * 
     * @param string $labUri
     */
    public function setLabUri($labUri)
    {
        $this->labUri = $labUri;
    }
    
    /**
     * 
     * @return string
     */
    public function getLabUri()
    {
        return $this->labUri;
    }
    
    /**
     * 
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    
    /**
     * 
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * 
     * @param bool $locked
     */
    public function setLocked(bool $locked)
    {
        $this->locked = $locked;
    }
    
    /**
     * 
     * @return bool
     */
    public function getLocked()
    {
        return $this->locked;
    }
    
    /**
     * 
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
    
    /**
     * 
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * 
     * @param string $role
     */
    public function setRole($role)
    {
        $this->roles[] = $role;
    }
    
    /**
     * 
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        foreach ($roles as $role) {
            $this->setRole($role);
        }
    }
    
    /**
     * 
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }
    
    /**
     * 
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    /**
     * 
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * 
     * @param string $xml
     */
    public function setXml($xml)
    {
        $this->xml = $xml;
    }
    
    /**
     * 
     * @return string
     */
    public function getXml()
    {
        return $this->xml;
    }
    
}
