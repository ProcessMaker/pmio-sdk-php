<?php
/**
 * ProcessAttributes
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

namespace ProcessMaker\PMIO\Model;

use \ArrayAccess;

/**
 * ProcessAttributes Class Doc Comment
 *
 * @category    Class */
/** 
 * @package     ProcessMaker\PMIO
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class ProcessAttributes implements ArrayAccess
{
    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'Process_attributes';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = array(
        'name' => 'string',
        'description' => 'string',
        'parent_process_id' => 'string',
        'status' => 'string',
        'duration_by' => 'string',
        'type' => 'string',
        'assignment' => 'bool',
        'design_access' => 'string',
        'show_map' => 'bool',
        'show_message' => 'bool',
        'show_delegate' => 'bool',
        'show_dynaform' => 'bool',
        'category_id' => 'string',
        'sub_category_id' => 'string',
        'create_user_id' => 'string',
        'debug' => 'bool',
        'dynaform_summary_id' => 'string',
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
        'name' => 'name',
        'description' => 'description',
        'parent_process_id' => 'parent_process_id',
        'status' => 'status',
        'duration_by' => 'duration_by',
        'type' => 'type',
        'assignment' => 'assignment',
        'design_access' => 'design_access',
        'show_map' => 'show_map',
        'show_message' => 'show_message',
        'show_delegate' => 'show_delegate',
        'show_dynaform' => 'show_dynaform',
        'category_id' => 'category_id',
        'sub_category_id' => 'sub_category_id',
        'create_user_id' => 'create_user_id',
        'debug' => 'debug',
        'dynaform_summary_id' => 'dynaform_summary_id',
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
        'name' => 'setName',
        'description' => 'setDescription',
        'parent_process_id' => 'setParentProcessId',
        'status' => 'setStatus',
        'duration_by' => 'setDurationBy',
        'type' => 'setType',
        'assignment' => 'setAssignment',
        'design_access' => 'setDesignAccess',
        'show_map' => 'setShowMap',
        'show_message' => 'setShowMessage',
        'show_delegate' => 'setShowDelegate',
        'show_dynaform' => 'setShowDynaform',
        'category_id' => 'setCategoryId',
        'sub_category_id' => 'setSubCategoryId',
        'create_user_id' => 'setCreateUserId',
        'debug' => 'setDebug',
        'dynaform_summary_id' => 'setDynaformSummaryId',
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
        'name' => 'getName',
        'description' => 'getDescription',
        'parent_process_id' => 'getParentProcessId',
        'status' => 'getStatus',
        'duration_by' => 'getDurationBy',
        'type' => 'getType',
        'assignment' => 'getAssignment',
        'design_access' => 'getDesignAccess',
        'show_map' => 'getShowMap',
        'show_message' => 'getShowMessage',
        'show_delegate' => 'getShowDelegate',
        'show_dynaform' => 'getShowDynaform',
        'category_id' => 'getCategoryId',
        'sub_category_id' => 'getSubCategoryId',
        'create_user_id' => 'getCreateUserId',
        'debug' => 'getDebug',
        'dynaform_summary_id' => 'getDynaformSummaryId',
        'created_at' => 'getCreatedAt',
        'updated_at' => 'getUpdatedAt'
    );

    public static function getters()
    {
        return self::$getters;
    }

    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    const STATUS_DISABLED = 'DISABLED';
    const DURATION_BY_WORKING_DAYS = 'WORKING_DAYS';
    const DURATION_BY_CALENDAR_DAYS = 'CALENDAR_DAYS';
    const TYPE_NORMAL = 'NORMAL';
    const TYPE_SUB_PROCESS = 'SUB_PROCESS';
    const DESIGN_ACCESS_PUBLIC = 'PUBLIC';
    const DESIGN_ACCESS_PRIVATE = 'PRIVATE';
    

    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public function getStatusAllowableValues()
    {
        return [
            self::STATUS_ACTIVE,
            self::STATUS_INACTIVE,
            self::STATUS_DISABLED,
        ];
    }
    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public function getDurationByAllowableValues()
    {
        return [
            self::DURATION_BY_WORKING_DAYS,
            self::DURATION_BY_CALENDAR_DAYS,
        ];
    }
    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public function getTypeAllowableValues()
    {
        return [
            self::TYPE_NORMAL,
            self::TYPE_SUB_PROCESS,
        ];
    }
    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public function getDesignAccessAllowableValues()
    {
        return [
            self::DESIGN_ACCESS_PUBLIC,
            self::DESIGN_ACCESS_PRIVATE,
        ];
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
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['description'] = isset($data['description']) ? $data['description'] : null;
        $this->container['parent_process_id'] = isset($data['parent_process_id']) ? $data['parent_process_id'] : null;
        $this->container['status'] = isset($data['status']) ? $data['status'] : 'ACTIVE';
        $this->container['duration_by'] = isset($data['duration_by']) ? $data['duration_by'] : 'WORKING_DAYS';
        $this->container['type'] = isset($data['type']) ? $data['type'] : 'NORMAL';
        $this->container['assignment'] = isset($data['assignment']) ? $data['assignment'] : false;
        $this->container['design_access'] = isset($data['design_access']) ? $data['design_access'] : 'PUBLIC';
        $this->container['show_map'] = isset($data['show_map']) ? $data['show_map'] : true;
        $this->container['show_message'] = isset($data['show_message']) ? $data['show_message'] : true;
        $this->container['show_delegate'] = isset($data['show_delegate']) ? $data['show_delegate'] : true;
        $this->container['show_dynaform'] = isset($data['show_dynaform']) ? $data['show_dynaform'] : false;
        $this->container['category_id'] = isset($data['category_id']) ? $data['category_id'] : null;
        $this->container['sub_category_id'] = isset($data['sub_category_id']) ? $data['sub_category_id'] : null;
        $this->container['create_user_id'] = isset($data['create_user_id']) ? $data['create_user_id'] : null;
        $this->container['debug'] = isset($data['debug']) ? $data['debug'] : false;
        $this->container['dynaform_summary_id'] = isset($data['dynaform_summary_id']) ? $data['dynaform_summary_id'] : null;
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
        if ($this->container['name'] === null) {
            $invalid_properties[] = "'name' can't be null";
        }
        if ($this->container['status'] === null) {
            $invalid_properties[] = "'status' can't be null";
        }
        $allowed_values = array("ACTIVE", "INACTIVE", "DISABLED");
        if (!in_array($this->container['status'], $allowed_values)) {
            $invalid_properties[] = "invalid value for 'status', must be one of #{allowed_values}.";
        }

        if ($this->container['duration_by'] === null) {
            $invalid_properties[] = "'duration_by' can't be null";
        }
        $allowed_values = array("WORKING_DAYS", "CALENDAR_DAYS");
        if (!in_array($this->container['duration_by'], $allowed_values)) {
            $invalid_properties[] = "invalid value for 'duration_by', must be one of #{allowed_values}.";
        }

        if ($this->container['type'] === null) {
            $invalid_properties[] = "'type' can't be null";
        }
        $allowed_values = array("NORMAL", "SUB_PROCESS");
        if (!in_array($this->container['type'], $allowed_values)) {
            $invalid_properties[] = "invalid value for 'type', must be one of #{allowed_values}.";
        }

        if ($this->container['design_access'] === null) {
            $invalid_properties[] = "'design_access' can't be null";
        }
        $allowed_values = array("PUBLIC", "PRIVATE");
        if (!in_array($this->container['design_access'], $allowed_values)) {
            $invalid_properties[] = "invalid value for 'design_access', must be one of #{allowed_values}.";
        }

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
        if ($this->container['name'] === null) {
            return false;
        }
        if ($this->container['status'] === null) {
            return false;
        }
        $allowed_values = array("ACTIVE", "INACTIVE", "DISABLED");
        if (!in_array($this->container['status'], $allowed_values)) {
            return false;
        }
        if ($this->container['duration_by'] === null) {
            return false;
        }
        $allowed_values = array("WORKING_DAYS", "CALENDAR_DAYS");
        if (!in_array($this->container['duration_by'], $allowed_values)) {
            return false;
        }
        if ($this->container['type'] === null) {
            return false;
        }
        $allowed_values = array("NORMAL", "SUB_PROCESS");
        if (!in_array($this->container['type'], $allowed_values)) {
            return false;
        }
        if ($this->container['design_access'] === null) {
            return false;
        }
        $allowed_values = array("PUBLIC", "PRIVATE");
        if (!in_array($this->container['design_access'], $allowed_values)) {
            return false;
        }
        return true;
    }


    /**
     * Gets name
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets description
     * @return string
     */
    public function getDescription()
    {
        return $this->container['description'];
    }

    /**
     * Sets description
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->container['description'] = $description;

        return $this;
    }

    /**
     * Gets parent_process_id
     * @return string
     */
    public function getParentProcessId()
    {
        return $this->container['parent_process_id'];
    }

    /**
     * Sets parent_process_id
     * @param string $parent_process_id
     * @return $this
     */
    public function setParentProcessId($parent_process_id)
    {
        $this->container['parent_process_id'] = $parent_process_id;

        return $this;
    }

    /**
     * Gets status
     * @return string
     */
    public function getStatus()
    {
        return $this->container['status'];
    }

    /**
     * Sets status
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $allowed_values = array('ACTIVE', 'INACTIVE', 'DISABLED');
        if (!in_array($status, $allowed_values)) {
            throw new \InvalidArgumentException("Invalid value for 'status', must be one of 'ACTIVE', 'INACTIVE', 'DISABLED'");
        }
        $this->container['status'] = $status;

        return $this;
    }

    /**
     * Gets duration_by
     * @return string
     */
    public function getDurationBy()
    {
        return $this->container['duration_by'];
    }

    /**
     * Sets duration_by
     * @param string $duration_by
     * @return $this
     */
    public function setDurationBy($duration_by)
    {
        $allowed_values = array('WORKING_DAYS', 'CALENDAR_DAYS');
        if (!in_array($duration_by, $allowed_values)) {
            throw new \InvalidArgumentException("Invalid value for 'duration_by', must be one of 'WORKING_DAYS', 'CALENDAR_DAYS'");
        }
        $this->container['duration_by'] = $duration_by;

        return $this;
    }

    /**
     * Gets type
     * @return string
     */
    public function getType()
    {
        return $this->container['type'];
    }

    /**
     * Sets type
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $allowed_values = array('NORMAL', 'SUB_PROCESS');
        if (!in_array($type, $allowed_values)) {
            throw new \InvalidArgumentException("Invalid value for 'type', must be one of 'NORMAL', 'SUB_PROCESS'");
        }
        $this->container['type'] = $type;

        return $this;
    }

    /**
     * Gets assignment
     * @return bool
     */
    public function getAssignment()
    {
        return $this->container['assignment'];
    }

    /**
     * Sets assignment
     * @param bool $assignment
     * @return $this
     */
    public function setAssignment($assignment)
    {
        $this->container['assignment'] = $assignment;

        return $this;
    }

    /**
     * Gets design_access
     * @return string
     */
    public function getDesignAccess()
    {
        return $this->container['design_access'];
    }

    /**
     * Sets design_access
     * @param string $design_access
     * @return $this
     */
    public function setDesignAccess($design_access)
    {
        $allowed_values = array('PUBLIC', 'PRIVATE');
        if (!in_array($design_access, $allowed_values)) {
            throw new \InvalidArgumentException("Invalid value for 'design_access', must be one of 'PUBLIC', 'PRIVATE'");
        }
        $this->container['design_access'] = $design_access;

        return $this;
    }

    /**
     * Gets show_map
     * @return bool
     */
    public function getShowMap()
    {
        return $this->container['show_map'];
    }

    /**
     * Sets show_map
     * @param bool $show_map
     * @return $this
     */
    public function setShowMap($show_map)
    {
        $this->container['show_map'] = $show_map;

        return $this;
    }

    /**
     * Gets show_message
     * @return bool
     */
    public function getShowMessage()
    {
        return $this->container['show_message'];
    }

    /**
     * Sets show_message
     * @param bool $show_message
     * @return $this
     */
    public function setShowMessage($show_message)
    {
        $this->container['show_message'] = $show_message;

        return $this;
    }

    /**
     * Gets show_delegate
     * @return bool
     */
    public function getShowDelegate()
    {
        return $this->container['show_delegate'];
    }

    /**
     * Sets show_delegate
     * @param bool $show_delegate
     * @return $this
     */
    public function setShowDelegate($show_delegate)
    {
        $this->container['show_delegate'] = $show_delegate;

        return $this;
    }

    /**
     * Gets show_dynaform
     * @return bool
     */
    public function getShowDynaform()
    {
        return $this->container['show_dynaform'];
    }

    /**
     * Sets show_dynaform
     * @param bool $show_dynaform
     * @return $this
     */
    public function setShowDynaform($show_dynaform)
    {
        $this->container['show_dynaform'] = $show_dynaform;

        return $this;
    }

    /**
     * Gets category_id
     * @return string
     */
    public function getCategoryId()
    {
        return $this->container['category_id'];
    }

    /**
     * Sets category_id
     * @param string $category_id
     * @return $this
     */
    public function setCategoryId($category_id)
    {
        $this->container['category_id'] = $category_id;

        return $this;
    }

    /**
     * Gets sub_category_id
     * @return string
     */
    public function getSubCategoryId()
    {
        return $this->container['sub_category_id'];
    }

    /**
     * Sets sub_category_id
     * @param string $sub_category_id
     * @return $this
     */
    public function setSubCategoryId($sub_category_id)
    {
        $this->container['sub_category_id'] = $sub_category_id;

        return $this;
    }

    /**
     * Gets create_user_id
     * @return string
     */
    public function getCreateUserId()
    {
        return $this->container['create_user_id'];
    }

    /**
     * Sets create_user_id
     * @param string $create_user_id
     * @return $this
     */
    public function setCreateUserId($create_user_id)
    {
        $this->container['create_user_id'] = $create_user_id;

        return $this;
    }

    /**
     * Gets debug
     * @return bool
     */
    public function getDebug()
    {
        return $this->container['debug'];
    }

    /**
     * Sets debug
     * @param bool $debug
     * @return $this
     */
    public function setDebug($debug)
    {
        $this->container['debug'] = $debug;

        return $this;
    }

    /**
     * Gets dynaform_summary_id
     * @return string
     */
    public function getDynaformSummaryId()
    {
        return $this->container['dynaform_summary_id'];
    }

    /**
     * Sets dynaform_summary_id
     * @param string $dynaform_summary_id
     * @return $this
     */
    public function setDynaformSummaryId($dynaform_summary_id)
    {
        $this->container['dynaform_summary_id'] = $dynaform_summary_id;

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


