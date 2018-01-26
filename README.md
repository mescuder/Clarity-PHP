# Clarity-PHP
PHP code to use the Clarity LIMS API

## Description
This code should make it easier to use the Clarity API, 
which is based on retrieving or submitting XML with HTTP requests. 
Here the idea is to get the XML and use it to create an object corresponding 
to a resource. Modifying an object is easier than to manipulate XML data. 
Then when the object has the right values for its properties, 
change it back to XML ready to be submitted with the API. 
A new object can also be created to submit a new resource to Clarity. 
And because this code is PHP, it should be easy to integrate with PHP-based 
websites, built with the Symfony framework for instance. 
Initially meant to be use from the command line.

## Table of Contents

* [Code structure](#code-structure)
* [Installation](#installation)
* [Usage](#usage)
* [Contributing](#contributing)
* [Credits](#credits)
* [License](#license)

## Code structure

Here's a breakdown of what each folder contains and the general idea behind 
the classes. 

* **autoload.php** contains the code to autoload the classes
* **Config** contains various YAML files with configuration values needed to 
connect to the Clarity API for instance
* **Connector** contains a class that handles the connection to the 
Clarity API and executes the actual HTTP requests with the PHP cURL functions.
* **Entity** contains classes that represent the various resources that can be 
retrieved from Clarity with the API, for instance a project or a sample. 
* **EntityFormatter** contains classes that take an Entity and format the 
information in a given format (e.g. XML, CSV, YAML, etc.).
* **EntityRepository** contains classes that prepare API requests and 
send them to a Connector in order to retrieve or submit a resource.
* **Tests** contains small scripts that are used to test the code as it is 
being developped.
* **XmlTemplate** contains an XML template for each resource. Each template 
can be loaded into an instance of the corresponding class and easily 
modified with the values of the object's properties to avoid having to write 
the whole XML file from scratch.

## Installation

After downloading a release or cloning the repo, rename the file 
"Config/clarity_api_credentials.yml.dist" into 
"Config/clarity_api_credentials.yml" and fill it in with your Clarity 
credentials. Make sure this file is not readable by others.

## Usage

Examples:

php Clarity-PHP/Scripts/projectFinder.php --project-id ESC452

php Clarity-PHP/Scripts/sampleFinder.php --sample-id ESC452A1

## Contributing

## Credits

## License

GNU General Public License v3.0
