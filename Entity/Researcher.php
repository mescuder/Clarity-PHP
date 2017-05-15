<?php

namespace Clarity\Entity;

use Clarity\Entity\ApiResource;

/**
 * Description of Researcher
 *
 * @author Mickael Escudero
 */
class Researcher extends ApiResource
{
    
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
     * @var string $initials
     */
    protected $initials;
    
    /**
     *
     * @var Lab
     */
    protected $lab;
    
    /**
     *
     * @var string $labId
     */
    protected $labId;
    
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
     * @var string $locked
     */
    protected $locked;
    
    /**
     *
     * @var string $password
     */
    protected $password;
    
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
    
    public function __construct()
    {
        parent::__construct();
        $this->locked = 'false';
        $this->roles = array();
    }
    
    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }
    
    public function researcherToXml()
    {
        $researcherElement = simplexml_load_file(__DIR__ . '/../XmlTemplate/researcher.xsd');
        
        $researcherElement['uri'] = $this->clarityUri;
        $researcherElement->{'first-name'} = $this->firstName;
        $researcherElement->{'last-name'} = $this->lastName;
        $researcherElement->email = $this->email;
        $researcherElement->lab['uri'] = $this->labUri;
        if (!empty($this->username)) {
            $credentialsElement = $researcherElement->addChild('credentials', null, '');
            $credentialsElement->addChild('username');
            $credentialsElement->addChild('password');
            $credentialsElement->addChild('account-locked');
            $researcherElement->credentials->username = $this->username;
            $researcherElement->credentials->password = $this->password;
            $researcherElement->credentials->{'account-locked'} = $this->locked;
        }
        $researcherElement->initials = $this->initials;
        foreach ($this->roles as $role) {
            $roleElement = $researcherElement->{'credentials'}->addChild('role');
            $roleElement->addAttribute('name', $role);
        }
        
        $this->xml = $researcherElement->asXML();
        $this->formatXml();
    }
    
    public function xmlToResearcher()
    {
        $researcherElement = new \SimpleXMLElement($this->xml);
        $this->clarityUri = $researcherElement['uri']->__toString();
        $this->email = $researcherElement->email->__toString();
        $this->firstName = $researcherElement->{'first-name'}->__toString();
        $this->lastName = $researcherElement->{'last-name'}->__toString();
        $this->labUri = $researcherElement->lab['uri']->__toString();
        $this->labId = $this->getClarityIdFromUri($this->labUri);
        $this->phone = $researcherElement->phone->__toString();
        if (!empty($researcherElement->credentials->username)) {
            $this->username = $researcherElement->credentials->username->__toString();
            $this->locked = $researcherElement->credentials->{'account-locked'}->__toString();
        }
        
        foreach ($researcherElement->xpath('//role') as $role) {
            $this->roles[] = $role['name']->__toString();
        }
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
     * @param string $initials
     */
    public function setInitials($initials)
    {
        $this->initials = $initials;
    }
    
    /**
     * 
     * @return string
     */
    public function getInitials()
    {
        return $this->initials;
    }
    
    /**
     * 
     * @param Lab $lab
     */
    public function setLab($lab)
    {
        $this->lab = $lab;
    }
    
    public function getLab()
    {
        return $this->lab;
    }
    
    /**
     * 
     * @param string $labId
     */
    public function setLabId($labId)
    {
        $this->labId = $labId;
    }
    
    /**
     * 
     * @return string
     */
    public function getLabId()
    {
        return $this->labId;
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
     * @param string $locked
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
    }
    
    /**
     * 
     * @return string
     */
    public function getLocked()
    {
        return $this->locked;
    }
    
    /**
     * 
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    /**
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
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
        if (empty($roles)) {
            $this->roles = array();
        }
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
    
}
