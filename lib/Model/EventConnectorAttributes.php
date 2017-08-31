<?php
/**
 * EventConnectorAttributes
 *
 * PHP version 5
 *
 * @category Class
 * @package  ProcessMaker\PMIO
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * ProcessMaker API
 *
 * This ProcessMaker I/O API provides access to a BPMN 2.0 compliant workflow engine API that is designed to be used as a microservice to support enterprise cloud applications. The current Alpha 1.0 version supports most of the descriptive classes of the BPMN 2.0 specification.
 *
 * OpenAPI spec version: 1.0.0
 * Contact: support@processmaker.io
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace ProcessMaker\PMIO\Model;

use \ArrayAccess;

/**
 * EventConnectorAttributes Class Doc Comment
 *
 * @category    Class */
/** 
 * @package     ProcessMaker\PMIO
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class EventConnectorAttributes implements ArrayAccess
{
    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'EventConnector_attributes';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = array(
        'event_id' => 'int',
        'connector_class' => 'string',
        'input_parameters' => 'string',
        'output_parameters' => 'string',
        'async_before' => 'bool',
        'created_at' => 'string',
        'updated_at' => 'string'
    );

    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = array(
        'event_id' => 'event_id',
        'connector_class' => 'connector_class',
        'input_parameters' => 'input_parameters',
        'output_parameters' => 'output_parameters',
        'async_before' => 'async_before',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at'
    );

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = array(
        'event_id' => 'setEventId',
        'connector_class' => 'setConnectorClass',
        'input_parameters' => 'setInputParameters',
        'output_parameters' => 'setOutputParameters',
        'async_before' => 'setAsyncBefore',
        'created_at' => 'setCreatedAt',
        'updated_at' => 'setUpdatedAt'
    );

    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = array(
        'event_id' => 'getEventId',
        'connector_class' => 'getConnectorClass',
        'input_parameters' => 'getInputParameters',
        'output_parameters' => 'getOutputParameters',
        'async_before' => 'getAsyncBefore',
        'created_at' => 'getCreatedAt',
        'updated_at' => 'getUpdatedAt'
    );

    public static function getters()
    {
        return self::$getters;
    }

    

    

    /**
     * Associative array for storing property values
     * @var mixed[]
     */
    protected $container = array();

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initalizing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['event_id'] = isset($data['event_id']) ? $data['event_id'] : null;
        $this->container['connector_class'] = isset($data['connector_class']) ? $data['connector_class'] : 'CorrelationKeys';
        $this->container['input_parameters'] = isset($data['input_parameters']) ? $data['input_parameters'] : '[]';
        $this->container['output_parameters'] = isset($data['output_parameters']) ? $data['output_parameters'] : '[]';
        $this->container['async_before'] = isset($data['async_before']) ? $data['async_before'] : null;
        $this->container['created_at'] = isset($data['created_at']) ? $data['created_at'] : null;
        $this->container['updated_at'] = isset($data['updated_at']) ? $data['updated_at'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = array();
        return $invalid_properties;
    }

    /**
     * validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properteis are valid
     */
    public function valid()
    {
        return true;
    }


    /**
     * Gets event_id
     * @return int
     */
    public function getEventId()
    {
        return $this->container['event_id'];
    }

    /**
     * Sets event_id
     * @param int $event_id
     * @return $this
     */
    public function setEventId($event_id)
    {
        $this->container['event_id'] = $event_id;

        return $this;
    }

    /**
     * Gets connector_class
     * @return string
     */
    public function getConnectorClass()
    {
        return $this->container['connector_class'];
    }

    /**
     * Sets connector_class
     * @param string $connector_class
     * @return $this
     */
    public function setConnectorClass($connector_class)
    {
        $this->container['connector_class'] = $connector_class;

        return $this;
    }

    /**
     * Gets input_parameters
     * @return string
     */
    public function getInputParameters()
    {
        return $this->container['input_parameters'];
    }

    /**
     * Sets input_parameters
     * @param string $input_parameters
     * @return $this
     */
    public function setInputParameters($input_parameters)
    {
        $this->container['input_parameters'] = $input_parameters;

        return $this;
    }

    /**
     * Gets output_parameters
     * @return string
     */
    public function getOutputParameters()
    {
        return $this->container['output_parameters'];
    }

    /**
     * Sets output_parameters
     * @param string $output_parameters
     * @return $this
     */
    public function setOutputParameters($output_parameters)
    {
        $this->container['output_parameters'] = $output_parameters;

        return $this;
    }

    /**
     * Gets async_before
     * @return bool
     */
    public function getAsyncBefore()
    {
        return $this->container['async_before'];
    }

    /**
     * Sets async_before
     * @param bool $async_before
     * @return $this
     */
    public function setAsyncBefore($async_before)
    {
        $this->container['async_before'] = $async_before;

        return $this;
    }

    /**
     * Gets created_at
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->container['created_at'];
    }

    /**
     * Sets created_at
     * @param string $created_at
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->container['created_at'] = $created_at;

        return $this;
    }

    /**
     * Gets updated_at
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->container['updated_at'];
    }

    /**
     * Sets updated_at
     * @param string $updated_at
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->container['updated_at'] = $updated_at;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     * @param  integer $offset Offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     * @param  integer $offset Offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(\ProcessMaker\PMIO\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }

        return json_encode(\ProcessMaker\PMIO\ObjectSerializer::sanitizeForSerialization($this));
    }
}


