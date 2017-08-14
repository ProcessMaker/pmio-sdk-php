<?php
/**
 * ObjectSerializer
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
 * # Introduction  This ProcessMaker I/O API provides access to a BPMN 2.0 compliant workflow engine API that is designed to be used as a microservice to support enterprise cloud applications. The current Alpha 1.0 version supports most of the descriptive class of the BPMN 2.0 specification.  You can use your favorite HTTP/REST library for your programming language to use PMIO API or you can use one of our SDKs: Language | GitHub Link | Download Link --- | --- | --- JAVA | [JAVA SDK](https://github.com/ProcessMaker/pmio-sdk-java) | [Download JAVA SDK](https://github.com/ProcessMaker/pmio-sdk-java/archive/master.zip) PHP | [PHP SDK](https://github.com/ProcessMaker/pmio-sdk-php) | [Download PHP SDK](https://github.com/ProcessMaker/pmio-sdk-php/archive/master.zip) Python | [Python](https://github.com/ProcessMaker/pmio-sdk-python) | [Download Python SDK](https://github.com/ProcessMaker/pmio-sdk-python/archive/master.zip) # How to create a new user  Use [addUser](#operation/addUser) API call to create a User. Oauth client and its `client_id` will be returned back along with the User details  ## Retrieving client_secret You may retrieve `client_secret` for the User via [findOauthClientById](#operation/findOauthClientById) API call  ## Getting authorization key  With both the `client_id` and `client_secret` you may use a password grant to retrieve `access_token` and `refresh_token`. You will need to pass the username and password as part of the operation. ### PHP Sample to retrieve Oauth tokens    This code will return access_token and refresh_token to perform Oauth authorization for specific user.  ```php  $args_for_bob = [  'grant_type' => 'password',  'client_id' => $bobCredentials->getData()->getId(),  'client_secret' => $bobCredentials->getData()->getAttributes()->getSecret(),  'username' => $bobAttr->getUsername(),  'password' => $bobAttr->getPassword() ];  print_r(getCredentials($args_for_bob, $host));  /_**  * @param array $args Oauth request data  * @param string $host API HOST  * @return mixed  *_/ function getCredentials($args, $host)  {  $ch = curl_init();  curl_setopt($ch, CURLOPT_URL, \"https://$host/oauth/access_token\");  curl_setopt($ch, CURLOPT_POST, 1);  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  $serverResponse = json_decode(curl_exec($ch));  curl_close($ch);  return $serverResponse; }  ```  Here you will get `access_token` and `refresh_token` to perform Oauth authorization for specific user. # How to import BPMN file  The following API call will allow you to import BPMN file: [importBpmnFile](#operation/importBpmnFile). Resulting variable $process will contain an array of created Process(es) objects. # How to create and launch a new Process  Use [addProcess](#operation/addProcess) API call to create a new Process. As result you will get `process_id`, which can be used to add objects to the Process.  ## How to assign User to a Group  You may want to delegate Tasks not just to a User, but a Group of Users.  Use [addUsersToGroup](#operation/addUsersToGroup) API call to add some Users to a Group.  ## How to add objects to a Process  Also we should add objects to our process, such as Start event and End event. (use [addEvent](#operation/addEvent) API call to add these), and at least one Task object (use [addTask](#operation/addTask) API call).  ## How to add flows between process objects  All objects in a Process need to be joined by SEQUENTIAL Flows. Use [addFlow](#operation/addFlow) API call to connect the objects with each other.  ## How to delegate Group of Users to a Task  When you have `process_id`, `task_id` and `group_id` you can assign a Group as delegate for a User Task with the following API method: [AddGroupsToTask](#operation/addGroupsToTask).  ## How to run process  To run process we just need to trigger Start event object by using [eventTrigger](#operation/eventTrigger) API call. Just pass `process_id`, Start Event `event_id`, and an input data we need for the Process as Data model attributes. Content of Data Model can be associative array keys and values.  As result, our engine creates Process instance with status **RUNNING**. To get all Process Instances belonging to Process you can retrieve using [findInstances](#operation/findInstances) API call. ## Example with using the Exclusive gateways  ![Example #1](php-sdk-usage/images/exclusive_gateway_1endevent.png \"Example #1\")  **Process** has **Exclusive** and **Inclusive** gateways and one **End event**.  First of all create **Process** and fill it with objects.  ### Create **Process**  ```php /_** @var ProcessAttributes $processAttr *_/ $processAttr = new ProcessAttributes(); $processAttr->setStatus('ACTIVE'); $processAttr->setName('Example process'); $processAttr->setDurationBy('WORKING_DAYS'); $processAttr->setType('NORMAL'); $processAttr->setDesignAccess('PUBLIC'); /_** @var ProcessItem $result *_/ $process = $apiInstance->addProcess(new ProcessCreateItem(         [             'data' => new Process(['attributes' => $processAttr])         ]    ) );  ```  ### Create **Start event**  ![Start event](php-sdk-usage/images/start_event.png \"Start event\")  ```php /_** @var EventCreateItem $eventAttr *_/ $eventAttr = new EventAttributes(); $eventAttr->setName('Start event'); $eventAttr->setType('START'); $eventAttr->setProcessId($process->getData()->getId()); $eventAttr->setDefinition('MESSAGE'); /_** @var EventItem $startEvent *_/ $startEvent = $apiInstance->addEvent(     $process->getData()->getId(),     new EventCreateItem(         [            'data' => new Event(['attributes' => $eventAttr])         ]     ) );  ```  ### Create **End event**  ![End event](php-sdk-usage/images/end_event.png \"End event\")  ```php /_** @var EventCreateItem $eventAttr *_/ $eventAttr = new EventAttributes(); $eventAttr->setName('End event'); $eventAttr->setType('END'); $eventAttr->setProcessId($process->getData()->getId()); $eventAttr->setDefinition('MESSAGE'); /_** @var EventItem $endEvent *_/ $endEvent = $apiInstance->addEvent(     $process->getData()->getId(),     new EventCreateItem(         [             'data' => new Event(['attributes' => $eventAttr])         ]     ) );  ```  ### Create two script tasks Code snippet below creates two script tasks, which do simple things, just to add 2 types of variables to our **Data model** during running **Process**  ![First direction script task](php-sdk-usage/images/first_direction_task.png \"First direction script task\")   ```php /_** @var TaskAttributes $taskAttr *_/ $taskAttr = new TaskAttributes(); $taskAttr->setName('First direction'); $taskAttr->setType('SCRIPT-TASK'); $taskAttr->setProcessId($process->getData()->getId()); $taskAttr->setAssignType('CYCLIC'); $taskAttr->setScript('$aData[\\'First_Direction\\'] = 1;'); /_** @var TaskItem $result *_/ $firstDirectTask = $apiInstance->addTask(     $process->getData()->getId(),     new TaskCreateItem(        [            'data' => new Task(['attributes' => $taskAttr])        ]     ) ); ```  ![Second direction script task](php-sdk-usage/images/second_direction_task.png \"Second direction script task\")  ```php /_** @var TaskAttributes $taskAttr *_/ $taskAttr = new TaskAttributes(); $taskAttr->setName('Second direction'); $taskAttr->setType('SCRIPT-TASK'); $taskAttr->setProcessId($process->getData()->getId()); $taskAttr->setAssignType('CYCLIC'); $taskAttr->setScript('$aData[\\'Second_Direction\\'] = 2;');  /_** @var TaskItem $result *_/ $secondDirectTask = $apiInstance->addTask(     $process->getData()->getId(),     new TaskCreateItem(         [             'data' => new Task(['attributes' => $taskAttr])         ]     ) );  ```  ### Create two types of gateways: Exclusive and Inclusive.  ![Exclusive gateway](php-sdk-usage/images/exclusive_gateway.png \"Exclusive gateway\")   ```php /_** @var GatewayAttributes $gatewayAttr *_/ $gatewayAttr = new GatewayAttributes(); $gatewayAttr->setName('Exclusive gateway'); $gatewayAttr->setType('EXCLUSIVE'); $gatewayAttr->setDirection('DIVERGENT'); $gatewayAttr->setProcessId($process->getData()->getId());  /_** @var GatewayItem $exclusiveGateway *_/ $exclusiveGateway = $apiInstance->addGateway(     $process->getData()->getId(),     new GatewayCreateItem(         [             'data' => new Gateway(['attributes' => $gatewayAttr])         ]     ) );  ```  ![Inclusive gateway](php-sdk-usage/images/exclusive_gateway.png \"Exclusive gateway\")  ```php /_** @var GatewayAttributes $gatewayAttr *_/ $gatewayAttr = new GatewayAttributes(); $gatewayAttr->setName('Exclusive gateway'); $gatewayAttr->setType('EXCLUSIVE'); $gatewayAttr->setDirection('CONVERGENT'); $gatewayAttr->setProcessId($process->getData()->getId()); /_** @var GatewayItem $inclusiveGateway *_/ $inclusiveGateway = $apiInstance->addGateway(     $process->getData()->getId(),     new GatewayCreateItem(         [            'data' => new Gateway(['attributes' => $gatewayAttr])         ]     ) );  ``` ### Create SEQUENTIAL flows between objects   ![SEQUENTIAL Flow](php-sdk-usage/images/flow.png \"SEQUENTIAL Flow\")  ```php /_** @var FlowAttributes $flowAttr *_/ $flowAttr= new FlowAttributes(); $flowAttr->setName('Flow StartEvent with Exclusive Gateway'); $flowAttr->setType('SEQUENTIAL'); $flowAttr->setProcessId($process->getData()->getId()); $flowAttr->setFromObjectId($startEvent->getData()->getId()); $flowAttr->setFromObjectType($startEvent->getData()->getType()); $flowAttr->setToObjectId($exclusiveGateway->getData()->getId()); $flowAttr->setToObjectType($exclusiveGateway->getData()->getType()); $apiInstance->addFlow(         $process->getData()->getId(),         new FlowCreateItem([             'data' => new Flow(['attributes' => $flowAttr])         ])     );  /_** @var FlowAttributes $flowAttr *_/ $flowAttr= new FlowAttributes(); $flowAttr->setName('Flow FirstDirection with Inclusive Gateway'); $flowAttr->setType('SEQUENTIAL'); $flowAttr->setProcessId($process->getData()->getId()); $flowAttr->setFromObjectId($firstDirectTask->getData()->getId()); $flowAttr->setFromObjectType($firstDirectTask->getData()->getType()); $flowAttr->setToObjectId($inclusiveGateway->getData()->getId()); $flowAttr->setToObjectType($inclusiveGateway->getData()->getType()); $apiInstance->addFlow(         $process->getData()->getId(),         new FlowCreateItem([             'data' => new Flow(['attributes' => $flowAttr])         ])     );  /_** @var FlowAttributes $flowAttr *_/ $flowAttr= new FlowAttributes(); $flowAttr->setName('Flow SecondDirection with Inclusive Gateway'); $flowAttr->setType('SEQUENTIAL'); $flowAttr->setProcessId($process->getData()->getId()); $flowAttr->setFromObjectId($secondDirectTask->getData()->getId()); $flowAttr->setFromObjectType($secondDirectTask->getData()->getType()); $flowAttr->setToObjectId($inclusiveGateway->getData()->getId()); $flowAttr->setToObjectType($inclusiveGateway->getData()->getType()); $apiInstance->addFlow(         $process->getData()->getId(),         new FlowCreateItem([            'data' => new Flow(['attributes' => $flowAttr])         ])     );  /_** @var FlowAttributes $flowAttr *_/ $flowAttr= new FlowAttributes(); $flowAttr->setName('Flow Inclusive Gateway with end Event'); $flowAttr->setType('SEQUENTIAL'); $flowAttr->setProcessId($process->getData()->getId()); $flowAttr->setFromObjectId($inclusiveGateway->getData()->getId()); $flowAttr->setFromObjectType($inclusiveGateway->getData()->getType()); $flowAttr->setToObjectId($endEvent->getData()->getId()); $flowAttr->setToObjectType($endEvent->getData()->getType()); $apiInstance->addFlow(        $process->getData()->getId(),        new FlowCreateItem([             'data' => new Flow(['attributes' => $flowAttr])        ])    );  ```  ### Create two SEQUENTIAL flows with conditions  ![SEQUENTIAL Flow with condition](php-sdk-usage/images/conditional_flow1.png \"SEQUENTIAL Flow with condition\")  ```php  /_** @var FlowAttributes $flowAttr *_/ $flowAttr= new FlowAttributes(); $flowAttr->setName('Flow Exclusive Gateway with First direction'); $flowAttr->setType('SEQUENTIAL'); $flowAttr->setProcessId($process->getData()->getId()); $flowAttr->setFromObjectId($exclusiveGateway->getData()->getId()); $flowAttr->setFromObjectType($exclusiveGateway->getData()->getType()); $flowAttr->setToObjectId($firstDirectTask->getData()->getId()); $flowAttr->setToObjectType($firstDirectTask->getData()->getType()); $flowAttr->setCondition('direction=1'); $apiInstance->addFlow(        $process->getData()->getId(),        new FlowCreateItem([             'data' => new Flow(['attributes' => $flowAttr])        ])    );  ```  ![SEQUENTIAL Flow with condition](php-sdk-usage/images/conditional_flow2.png \"SEQUENTIAL Flow with condition\")   ```php /_** @var FlowAttributes $flowAttr *_/ $flowAttr= new FlowAttributes(); $flowAttr->setName('Flow Exclusive Gateway with Second direction'); $flowAttr->setType('SEQUENTIAL'); $flowAttr->setProcessId($process->getData()->getId()); $flowAttr->setFromObjectId($exclusiveGateway->getData()->getId()); $flowAttr->setFromObjectType($exclusiveGateway->getData()->getType()); $flowAttr->setToObjectId($secondDirectTask->getData()->getId()); $flowAttr->setToObjectType($secondDirectTask->getData()->getType()); $flowAttr->setCondition('direction=2'); $apiInstance->addFlow(         $process->getData()->getId(),         new FlowCreateItem([             'data' => new Flow(['attributes' => $flowAttr])         ])     );  ```  ### Run Process with random data - `['direction' => rand(1,2)]` in  Data model  ```php /_** @var array $arrayContent *_/ $arrayContent = ['direction' => rand(1,2)]; /_** @var DataModelAttributes $dataModelAttr *_/ $dataModelAttr = new DataModelAttributes(); $dataModelAttr->setContent(json_encode($arrayContent)); /_** @var DataModelItem $result *_/ $result = $apiInstance->eventTrigger(     $process->getData()->getId(),     $startEvent->getData()->getId(),     new TriggerEventCreateItem(         [             'data' => new DataModel(['attributes' => $dataModelAttr])         ]     ) );  ```  As result engine will run **Process** and creates **Process instance** and lead it through **Process** and finishes with status **COMPLETE**, which can be retrieved: ```php /_** @var InstanceCollection $instances *_/ $instances = $apiInstance->findInstances($process->getData()->getId());  ``` Direction of our **Process instance** will be showed in **Data model** :  ```php $apiInstance->findDataModel(             $process->getData()->getId(),             $instances->getData()[0]->getId()         );  ``` Inside **Data model** you can find array with `['First_Direction'] = 1` or  `['Second_Direction'] = 2` depending on data, that have been passed to **Start event** trigger.  # Cross-Origin Resource Sharing Processmaker I/O API features Cross-Origin Resource Sharing (CORS) implemented in compliance with  [W3C spec](https://www.w3.org/TR/cors/). And that allows cross-domain communication from the browser. All responses have a wildcard same-origin which makes them completely public and accessible to everyone, including any code on any site. # Authentication Processmaker I/O API use the OAuth 2.0 protocol to give your app authorized access.  OAuth is an open standard that provides client apps with secure delegated access to server resources on behalf of a resource owner. It does this by allowing access tokens to be issued to third-party clients by an authorization server, with the approval of the resource owner. The client then uses the access token to access the protected resources hosted by the resource server. The user's privacy is protected # Extensions  ## InputOutput  #### Description  This extension lets you use different types of parameters for the chosen BPMN element.  #### BPMN XML  ```yaml &lt;bpmn:extensionElements&gt;   &lt;pmio:inputOutput&gt;     &lt;pmio:inputParameter name=\"channel\"&gt;@{user_name}&lt;/pmio:inputParameter&gt;     &lt;pmio:inputParameter name=\"token\"&gt;{bot_token}&lt;/pmio:inputParameter&gt;     &lt;pmio:outputParameter name=\"username\" /&gt;   &lt;/pmio:inputOutput&gt; &lt;/bpmn:extensionElements&gt; ```  #### Parameters  InputParameter name   outputParameter name  #### Elements  Start Event   intermediateCatchEvent   intermediateThrowEvent   ## Connector  #### Description  This is set of configurations for the connectors.  #### BPMN XML  ```yaml &lt;bpmn:extensionElements&gt;   &lt;pmio:connector&gt;  &lt;pmio:connectorId&gt;CorrelationKeys&lt;/pmio:connectorId&gt;   &lt;/pmio:connector&gt; &lt;/bpmn:extensionElements&gt; ```  #### Parameters  InputParameter name   outputParameter name  #### Elements  Start Event   ## Field  #### Description  This extension lets you inject string value to the fields of the delegated classes.  #### BPMN XML  ```yaml &lt;bpmn:extensionElements&gt;   &lt;pmio:field name=\"AppNumber\"&gt;     &lt;pmio:string&gt;@{AppNumber}&lt;/pmio:string&gt;   &lt;/pmio:field&gt; &lt;/bpmn:extensionElements&gt; ```  #### Parameters  Field name   String  #### Elements  intermediateThrowEvent   ## Properties  #### Description  A list of properties and values that can be interpreted by the engine without any restriction.  #### BPMN XML  ```yaml &lt;bpmn:extensionElements&gt;   &lt;pmio:properties&gt;     &lt;pmio:property /&gt;   &lt;/pmio:properties&gt; &lt;/bpmn:extensionElements&gt; ```  #### Parameters  Property   #### Elements  Start Event  <!-- ReDoc-Inject: <security-definitions> -->
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

namespace ProcessMaker\PMIO;

/**
 * ObjectSerializer Class Doc Comment
 *
 * @category Class
 * @package  ProcessMaker\PMIO
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class ObjectSerializer
{

    /**
     * Serialize data
     *
     * @param mixed $data the data to serialize
     *
     * @return string serialized form of $data
     */
    public static function sanitizeForSerialization($data)
    {
        if (is_scalar($data) || null === $data) {
            return $data;
        } elseif ($data instanceof \DateTime) {
            return $data->format(\DateTime::ATOM);
        } elseif (is_array($data)) {
            foreach ($data as $property => $value) {
                $data[$property] = self::sanitizeForSerialization($value);
            }
            return $data;
        } elseif (is_object($data)) {
            $values = array();
            foreach (array_keys($data::swaggerTypes()) as $property) {
                $getter = $data::getters()[$property];
                if ($data->$getter() !== null) {
                    $values[$data::attributeMap()[$property]] = self::sanitizeForSerialization($data->$getter());
                }
            }
            return (object)$values;
        } else {
            return (string)$data;
        }
    }

    /**
     * Sanitize filename by removing path.
     * e.g. ../../sun.gif becomes sun.gif
     *
     * @param string $filename filename to be sanitized
     *
     * @return string the sanitized filename
     */
    public function sanitizeFilename($filename)
    {
        if (preg_match("/.*[\/\\\\](.*)$/", $filename, $match)) {
            return $match[1];
        } else {
            return $filename;
        }
    }

    /**
     * Take value and turn it into a string suitable for inclusion in
     * the path, by url-encoding.
     *
     * @param string $value a string which will be part of the path
     *
     * @return string the serialized object
     */
    public function toPathValue($value)
    {
        return rawurlencode($this->toString($value));
    }

    /**
     * Take value and turn it into a string suitable for inclusion in
     * the query, by imploding comma-separated if it's an object.
     * If it's a string, pass through unchanged. It will be url-encoded
     * later.
     *
     * @param object $object an object to be serialized to a string
     *
     * @return string the serialized object
     */
    public function toQueryValue($object)
    {
        if (is_array($object)) {
            return implode(',', $object);
        } else {
            return $this->toString($object);
        }
    }

    /**
     * Take value and turn it into a string suitable for inclusion in
     * the header. If it's a string, pass through unchanged
     * If it's a datetime object, format it in ISO8601
     *
     * @param string $value a string which will be part of the header
     *
     * @return string the header string
     */
    public function toHeaderValue($value)
    {
        return $this->toString($value);
    }

    /**
     * Take value and turn it into a string suitable for inclusion in
     * the http body (form parameter). If it's a string, pass through unchanged
     * If it's a datetime object, format it in ISO8601
     *
     * @param string $value the value of the form parameter
     *
     * @return string the form string
     */
    public function toFormValue($value)
    {
        if ($value instanceof \SplFileObject) {
            return $value->getRealPath();
        } else {
            return $this->toString($value);
        }
    }

    /**
     * Take value and turn it into a string suitable for inclusion in
     * the parameter. If it's a string, pass through unchanged
     * If it's a datetime object, format it in ISO8601
     *
     * @param string $value the value of the parameter
     *
     * @return string the header string
     */
    public function toString($value)
    {
        if ($value instanceof \DateTime) { // datetime in ISO8601 format
            return $value->format(\DateTime::ATOM);
        } else {
            return $value;
        }
    }

    /**
     * Serialize an array to a string.
     *
     * @param array  $collection       collection to serialize to a string
     * @param string $collectionFormat the format use for serialization (csv,
     * ssv, tsv, pipes, multi)
     *
     * @return string
     */
    public function serializeCollection(array $collection, $collectionFormat, $allowCollectionFormatMulti = false)
    {
        if ($allowCollectionFormatMulti && ('multi' === $collectionFormat)) {
            // http_build_query() almost does the job for us. We just
            // need to fix the result of multidimensional arrays.
            return preg_replace('/%5B[0-9]+%5D=/', '=', http_build_query($collection, '', '&'));
        }
        switch ($collectionFormat) {
            case 'pipes':
                return implode('|', $collection);

            case 'tsv':
                return implode("\t", $collection);

            case 'ssv':
                return implode(' ', $collection);

            case 'csv':
                // Deliberate fall through. CSV is default format.
            default:
                return implode(',', $collection);
        }
    }

    /**
     * Deserialize a JSON string into an object
     *
     * @param mixed  $data          object or primitive to be deserialized
     * @param string $class         class name is passed as a string
     * @param string $httpHeaders   HTTP headers
     * @param string $discriminator discriminator if polymorphism is used
     *
     * @return object an instance of $class
     */
    public static function deserialize($data, $class, $httpHeaders = null, $discriminator = null)
    {
        if (null === $data) {
            return null;
        } elseif (substr($class, 0, 4) === 'map[') { // for associative array e.g. map[string,int]
            $inner = substr($class, 4, -1);
            $deserialized = array();
            if (strrpos($inner, ",") !== false) {
                $subClass_array = explode(',', $inner, 2);
                $subClass = $subClass_array[1];
                foreach ($data as $key => $value) {
                    $deserialized[$key] = self::deserialize($value, $subClass, null, $discriminator);
                }
            }
            return $deserialized;
        } elseif (strcasecmp(substr($class, -2), '[]') == 0) {
            $subClass = substr($class, 0, -2);
            $values = array();
            foreach ($data as $key => $value) {
                $values[] = self::deserialize($value, $subClass, null, $discriminator);
            }
            return $values;
        } elseif ($class === 'object') {
            settype($data, 'array');
            return $data;
        } elseif ($class === '\DateTime') {
            // Some API's return an invalid, empty string as a
            // date-time property. DateTime::__construct() will return
            // the current time for empty input which is probably not
            // what is meant. The invalid empty string is probably to
            // be interpreted as a missing field/value. Let's handle
            // this graceful.
            if (!empty($data)) {
                return new \DateTime($data);
            } else {
                return null;
            }
        } elseif (in_array($class, array('void', 'bool', 'string', 'double', 'byte', 'mixed', 'integer', 'float', 'int', 'DateTime', 'number', 'boolean', 'object'))) {
            settype($data, $class);
            return $data;
        } elseif ($class === '\SplFileObject') {
            // determine file name
            if (array_key_exists('Content-Disposition', $httpHeaders) &&
                preg_match('/inline; filename=[\'"]?([^\'"\s]+)[\'"]?$/i', $httpHeaders['Content-Disposition'], $match)) {
                $filename = Configuration::getDefaultConfiguration()->getTempFolderPath() . sanitizeFilename($match[1]);
            } else {
                $filename = tempnam(Configuration::getDefaultConfiguration()->getTempFolderPath(), '');
            }
            $deserialized = new \SplFileObject($filename, "w");
            $byte_written = $deserialized->fwrite($data);
 
            if (Configuration::getDefaultConfiguration()->getDebug()) {
                error_log("[DEBUG] Written $byte_written byte to $filename. Please move the file to a proper folder or delete the temp file after processing.".PHP_EOL, 3, Configuration::getDefaultConfiguration()->getDebugFile());
            }

            return $deserialized;
        } else {
            // If a discriminator is defined and points to a valid subclass, use it.
            if (!empty($discriminator) && isset($data->{$discriminator}) && is_string($data->{$discriminator})) {
                $subclass = '\ProcessMaker\PMIO\Model\\' . $data->{$discriminator};
                if (is_subclass_of($subclass, $class)) {
                    $class = $subclass;
                }
            }
            $instance = new $class();
            foreach ($instance::swaggerTypes() as $property => $type) {
                $propertySetter = $instance::setters()[$property];

                if (!isset($propertySetter) || !isset($data->{$instance::attributeMap()[$property]})) {
                    continue;
                }

                $propertyValue = $data->{$instance::attributeMap()[$property]};
                if (isset($propertyValue)) {
                    $instance->$propertySetter(self::deserialize($propertyValue, $type, null, $discriminator));
                }
            }
            return $instance;
        }
    }
}
