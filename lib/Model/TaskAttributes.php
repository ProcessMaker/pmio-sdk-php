<?php
/**
 * TaskAttributes
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
 * TaskAttributes Class Doc Comment
 *
 * @category    Class */
/** 
 * @package     ProcessMaker\PMIO
 * @author      http://github.com/swagger-api/swagger-codegen
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class TaskAttributes implements ArrayAccess
{
    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'Task_attributes';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = array(
        'name' => 'string',
        'description' => 'string',
        'process_id' => 'string',
        'type' => 'string',
        'assign_type' => 'string',
        'priority_variable' => 'string',
        'assign_variable' => 'string',
        'group_variable' => 'string',
        'mi_instance_variable' => 'string',
        'mi_complete_variable' => 'string',
        'transfer_fly' => 'bool',
        'can_upload' => 'bool',
        'view_upload' => 'bool',
        'view_additional_documentation' => 'bool',
        'start' => 'bool',
        'send_last_email' => 'bool',
        'derivation_screen_tpl' => 'string',
        'selfservice_timeout' => 'int',
        'selfservice_time' => 'string',
        'selfservice_time_unit' => 'string',
        'selfservice_execution' => 'string',
        'last_assigned_user_id' => 'string',
        'script' => 'string',
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
        'process_id' => 'process_id',
        'type' => 'type',
        'assign_type' => 'assign_type',
        'priority_variable' => 'priority_variable',
        'assign_variable' => 'assign_variable',
        'group_variable' => 'group_variable',
        'mi_instance_variable' => 'mi_instance_variable',
        'mi_complete_variable' => 'mi_complete_variable',
        'transfer_fly' => 'transfer_fly',
        'can_upload' => 'can_upload',
        'view_upload' => 'view_upload',
        'view_additional_documentation' => 'view_additional_documentation',
        'start' => 'start',
        'send_last_email' => 'send_last_email',
        'derivation_screen_tpl' => 'derivation_screen_tpl',
        'selfservice_timeout' => 'selfservice_timeout',
        'selfservice_time' => 'selfservice_time',
        'selfservice_time_unit' => 'selfservice_time_unit',
        'selfservice_execution' => 'selfservice_execution',
        'last_assigned_user_id' => 'last_assigned_user_id',
        'script' => 'script',
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
        'process_id' => 'setProcessId',
        'type' => 'setType',
        'assign_type' => 'setAssignType',
        'priority_variable' => 'setPriorityVariable',
        'assign_variable' => 'setAssignVariable',
        'group_variable' => 'setGroupVariable',
        'mi_instance_variable' => 'setMiInstanceVariable',
        'mi_complete_variable' => 'setMiCompleteVariable',
        'transfer_fly' => 'setTransferFly',
        'can_upload' => 'setCanUpload',
        'view_upload' => 'setViewUpload',
        'view_additional_documentation' => 'setViewAdditionalDocumentation',
        'start' => 'setStart',
        'send_last_email' => 'setSendLastEmail',
        'derivation_screen_tpl' => 'setDerivationScreenTpl',
        'selfservice_timeout' => 'setSelfserviceTimeout',
        'selfservice_time' => 'setSelfserviceTime',
        'selfservice_time_unit' => 'setSelfserviceTimeUnit',
        'selfservice_execution' => 'setSelfserviceExecution',
        'last_assigned_user_id' => 'setLastAssignedUserId',
        'script' => 'setScript',
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
        'process_id' => 'getProcessId',
        'type' => 'getType',
        'assign_type' => 'getAssignType',
        'priority_variable' => 'getPriorityVariable',
        'assign_variable' => 'getAssignVariable',
        'group_variable' => 'getGroupVariable',
        'mi_instance_variable' => 'getMiInstanceVariable',
        'mi_complete_variable' => 'getMiCompleteVariable',
        'transfer_fly' => 'getTransferFly',
        'can_upload' => 'getCanUpload',
        'view_upload' => 'getViewUpload',
        'view_additional_documentation' => 'getViewAdditionalDocumentation',
        'start' => 'getStart',
        'send_last_email' => 'getSendLastEmail',
        'derivation_screen_tpl' => 'getDerivationScreenTpl',
        'selfservice_timeout' => 'getSelfserviceTimeout',
        'selfservice_time' => 'getSelfserviceTime',
        'selfservice_time_unit' => 'getSelfserviceTimeUnit',
        'selfservice_execution' => 'getSelfserviceExecution',
        'last_assigned_user_id' => 'getLastAssignedUserId',
        'script' => 'getScript',
        'created_at' => 'getCreatedAt',
        'updated_at' => 'getUpdatedAt'
    );

    public static function getters()
    {
        return self::$getters;
    }

    const TYPE_NORMAL = 'NORMAL';
    const TYPE_ADHOC = 'ADHOC';
    const TYPE_SUBPROCESS = 'SUBPROCESS';
    const TYPE_HIDDEN = 'HIDDEN';
    const TYPE_GATEWAYTOGATEWAY = 'GATEWAYTOGATEWAY';
    const TYPE_WEBENTRYEVENT = 'WEBENTRYEVENT';
    const TYPE_END_MESSAGE_EVENT = 'END-MESSAGE-EVENT';
    const TYPE_START_MESSAGE_EVENT = 'START-MESSAGE-EVENT';
    const TYPE_INTERMEDIATE_THROW_MESSAGE_EVENT = 'INTERMEDIATE-THROW-MESSAGE-EVENT';
    const TYPE_INTERMEDIATE_CATCH_MESSAGE_EVENT = 'INTERMEDIATE-CATCH-MESSAGE-EVENT';
    const TYPE_SCRIPT_TASK = 'SCRIPT-TASK';
    const TYPE_SERVICE_TASK = 'SERVICE-TASK';
    const TYPE_USER_TASK = 'USER-TASK';
    const TYPE_START_TIMER_EVENT = 'START-TIMER-EVENT';
    const TYPE_INTERMEDIATE_CATCH_TIMER_EVENT = 'INTERMEDIATE-CATCH-TIMER-EVENT';
    const TYPE_END_EMAIL_EVENT = 'END-EMAIL-EVENT';
    const TYPE_INTERMEDIATE_THROW_EMAIL_EVENT = 'INTERMEDIATE-THROW-EMAIL-EVENT';
    const ASSIGN_TYPE_CYCLIC = 'CYCLIC';
    const ASSIGN_TYPE_MANUAL = 'MANUAL';
    const ASSIGN_TYPE_EVALUATE = 'EVALUATE';
    const ASSIGN_TYPE_REPORT_TO = 'REPORT_TO';
    const ASSIGN_TYPE_SELF_SERVICE = 'SELF_SERVICE';
    const ASSIGN_TYPE_STATIC_MI = 'STATIC_MI';
    const ASSIGN_TYPE_CANCEL_MI = 'CANCEL_MI';
    const ASSIGN_TYPE_MULTIPLE_INSTANCE = 'MULTIPLE_INSTANCE';
    const ASSIGN_TYPE_MULTIPLE_INSTANCE_VALUE_BASED = 'MULTIPLE_INSTANCE_VALUE_BASED';
    

    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public function getTypeAllowableValues()
    {
        return [
            self::TYPE_NORMAL,
            self::TYPE_ADHOC,
            self::TYPE_SUBPROCESS,
            self::TYPE_HIDDEN,
            self::TYPE_GATEWAYTOGATEWAY,
            self::TYPE_WEBENTRYEVENT,
            self::TYPE_END_MESSAGE_EVENT,
            self::TYPE_START_MESSAGE_EVENT,
            self::TYPE_INTERMEDIATE_THROW_MESSAGE_EVENT,
            self::TYPE_INTERMEDIATE_CATCH_MESSAGE_EVENT,
            self::TYPE_SCRIPT_TASK,
            self::TYPE_SERVICE_TASK,
            self::TYPE_USER_TASK,
            self::TYPE_START_TIMER_EVENT,
            self::TYPE_INTERMEDIATE_CATCH_TIMER_EVENT,
            self::TYPE_END_EMAIL_EVENT,
            self::TYPE_INTERMEDIATE_THROW_EMAIL_EVENT,
        ];
    }
    
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public function getAssignTypeAllowableValues()
    {
        return [
            self::ASSIGN_TYPE_CYCLIC,
            self::ASSIGN_TYPE_MANUAL,
            self::ASSIGN_TYPE_EVALUATE,
            self::ASSIGN_TYPE_REPORT_TO,
            self::ASSIGN_TYPE_SELF_SERVICE,
            self::ASSIGN_TYPE_STATIC_MI,
            self::ASSIGN_TYPE_CANCEL_MI,
            self::ASSIGN_TYPE_MULTIPLE_INSTANCE,
            self::ASSIGN_TYPE_MULTIPLE_INSTANCE_VALUE_BASED,
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
        $this->container['process_id'] = isset($data['process_id']) ? $data['process_id'] : null;
        $this->container['type'] = isset($data['type']) ? $data['type'] : 'NORMAL';
        $this->container['assign_type'] = isset($data['assign_type']) ? $data['assign_type'] : 'CYCLIC';
        $this->container['priority_variable'] = isset($data['priority_variable']) ? $data['priority_variable'] : null;
        $this->container['assign_variable'] = isset($data['assign_variable']) ? $data['assign_variable'] : null;
        $this->container['group_variable'] = isset($data['group_variable']) ? $data['group_variable'] : null;
        $this->container['mi_instance_variable'] = isset($data['mi_instance_variable']) ? $data['mi_instance_variable'] : null;
        $this->container['mi_complete_variable'] = isset($data['mi_complete_variable']) ? $data['mi_complete_variable'] : null;
        $this->container['transfer_fly'] = isset($data['transfer_fly']) ? $data['transfer_fly'] : false;
        $this->container['can_upload'] = isset($data['can_upload']) ? $data['can_upload'] : false;
        $this->container['view_upload'] = isset($data['view_upload']) ? $data['view_upload'] : false;
        $this->container['view_additional_documentation'] = isset($data['view_additional_documentation']) ? $data['view_additional_documentation'] : false;
        $this->container['start'] = isset($data['start']) ? $data['start'] : false;
        $this->container['send_last_email'] = isset($data['send_last_email']) ? $data['send_last_email'] : true;
        $this->container['derivation_screen_tpl'] = isset($data['derivation_screen_tpl']) ? $data['derivation_screen_tpl'] : null;
        $this->container['selfservice_timeout'] = isset($data['selfservice_timeout']) ? $data['selfservice_timeout'] : null;
        $this->container['selfservice_time'] = isset($data['selfservice_time']) ? $data['selfservice_time'] : null;
        $this->container['selfservice_time_unit'] = isset($data['selfservice_time_unit']) ? $data['selfservice_time_unit'] : null;
        $this->container['selfservice_execution'] = isset($data['selfservice_execution']) ? $data['selfservice_execution'] : null;
        $this->container['last_assigned_user_id'] = isset($data['last_assigned_user_id']) ? $data['last_assigned_user_id'] : null;
        $this->container['script'] = isset($data['script']) ? $data['script'] : null;
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
        if ($this->container['process_id'] === null) {
            $invalid_properties[] = "'process_id' can't be null";
        }
        if ($this->container['type'] === null) {
            $invalid_properties[] = "'type' can't be null";
        }
        $allowed_values = array("NORMAL", "ADHOC", "SUBPROCESS", "HIDDEN", "GATEWAYTOGATEWAY", "WEBENTRYEVENT", "END-MESSAGE-EVENT", "START-MESSAGE-EVENT", "INTERMEDIATE-THROW-MESSAGE-EVENT", "INTERMEDIATE-CATCH-MESSAGE-EVENT", "SCRIPT-TASK", "SERVICE-TASK", "USER-TASK", "START-TIMER-EVENT", "INTERMEDIATE-CATCH-TIMER-EVENT", "END-EMAIL-EVENT", "INTERMEDIATE-THROW-EMAIL-EVENT");
        if (!in_array($this->container['type'], $allowed_values)) {
            $invalid_properties[] = "invalid value for 'type', must be one of #{allowed_values}.";
        }

        if ($this->container['assign_type'] === null) {
            $invalid_properties[] = "'assign_type' can't be null";
        }
        $allowed_values = array("CYCLIC", "MANUAL", "EVALUATE", "REPORT_TO", "SELF_SERVICE", "STATIC_MI", "CANCEL_MI", "MULTIPLE_INSTANCE", "MULTIPLE_INSTANCE_VALUE_BASED");
        if (!in_array($this->container['assign_type'], $allowed_values)) {
            $invalid_properties[] = "invalid value for 'assign_type', must be one of #{allowed_values}.";
        }

        if ($this->container['transfer_fly'] === null) {
            $invalid_properties[] = "'transfer_fly' can't be null";
        }
        if ($this->container['can_upload'] === null) {
            $invalid_properties[] = "'can_upload' can't be null";
        }
        if ($this->container['view_upload'] === null) {
            $invalid_properties[] = "'view_upload' can't be null";
        }
        if ($this->container['view_additional_documentation'] === null) {
            $invalid_properties[] = "'view_additional_documentation' can't be null";
        }
        if ($this->container['start'] === null) {
            $invalid_properties[] = "'start' can't be null";
        }
        if ($this->container['send_last_email'] === null) {
            $invalid_properties[] = "'send_last_email' can't be null";
        }
        if ($this->container['selfservice_timeout'] === null) {
            $invalid_properties[] = "'selfservice_timeout' can't be null";
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
        if ($this->container['process_id'] === null) {
            return false;
        }
        if ($this->container['type'] === null) {
            return false;
        }
        $allowed_values = array("NORMAL", "ADHOC", "SUBPROCESS", "HIDDEN", "GATEWAYTOGATEWAY", "WEBENTRYEVENT", "END-MESSAGE-EVENT", "START-MESSAGE-EVENT", "INTERMEDIATE-THROW-MESSAGE-EVENT", "INTERMEDIATE-CATCH-MESSAGE-EVENT", "SCRIPT-TASK", "SERVICE-TASK", "USER-TASK", "START-TIMER-EVENT", "INTERMEDIATE-CATCH-TIMER-EVENT", "END-EMAIL-EVENT", "INTERMEDIATE-THROW-EMAIL-EVENT");
        if (!in_array($this->container['type'], $allowed_values)) {
            return false;
        }
        if ($this->container['assign_type'] === null) {
            return false;
        }
        $allowed_values = array("CYCLIC", "MANUAL", "EVALUATE", "REPORT_TO", "SELF_SERVICE", "STATIC_MI", "CANCEL_MI", "MULTIPLE_INSTANCE", "MULTIPLE_INSTANCE_VALUE_BASED");
        if (!in_array($this->container['assign_type'], $allowed_values)) {
            return false;
        }
        if ($this->container['transfer_fly'] === null) {
            return false;
        }
        if ($this->container['can_upload'] === null) {
            return false;
        }
        if ($this->container['view_upload'] === null) {
            return false;
        }
        if ($this->container['view_additional_documentation'] === null) {
            return false;
        }
        if ($this->container['start'] === null) {
            return false;
        }
        if ($this->container['send_last_email'] === null) {
            return false;
        }
        if ($this->container['selfservice_timeout'] === null) {
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
     * Gets process_id
     * @return string
     */
    public function getProcessId()
    {
        return $this->container['process_id'];
    }

    /**
     * Sets process_id
     * @param string $process_id
     * @return $this
     */
    public function setProcessId($process_id)
    {
        $this->container['process_id'] = $process_id;

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
        $allowed_values = array('NORMAL', 'ADHOC', 'SUBPROCESS', 'HIDDEN', 'GATEWAYTOGATEWAY', 'WEBENTRYEVENT', 'END-MESSAGE-EVENT', 'START-MESSAGE-EVENT', 'INTERMEDIATE-THROW-MESSAGE-EVENT', 'INTERMEDIATE-CATCH-MESSAGE-EVENT', 'SCRIPT-TASK', 'SERVICE-TASK', 'USER-TASK', 'START-TIMER-EVENT', 'INTERMEDIATE-CATCH-TIMER-EVENT', 'END-EMAIL-EVENT', 'INTERMEDIATE-THROW-EMAIL-EVENT');
        if (!in_array($type, $allowed_values)) {
            throw new \InvalidArgumentException("Invalid value for 'type', must be one of 'NORMAL', 'ADHOC', 'SUBPROCESS', 'HIDDEN', 'GATEWAYTOGATEWAY', 'WEBENTRYEVENT', 'END-MESSAGE-EVENT', 'START-MESSAGE-EVENT', 'INTERMEDIATE-THROW-MESSAGE-EVENT', 'INTERMEDIATE-CATCH-MESSAGE-EVENT', 'SCRIPT-TASK', 'SERVICE-TASK', 'USER-TASK', 'START-TIMER-EVENT', 'INTERMEDIATE-CATCH-TIMER-EVENT', 'END-EMAIL-EVENT', 'INTERMEDIATE-THROW-EMAIL-EVENT'");
        }
        $this->container['type'] = $type;

        return $this;
    }

    /**
     * Gets assign_type
     * @return string
     */
    public function getAssignType()
    {
        return $this->container['assign_type'];
    }

    /**
     * Sets assign_type
     * @param string $assign_type
     * @return $this
     */
    public function setAssignType($assign_type)
    {
        $allowed_values = array('CYCLIC', 'MANUAL', 'EVALUATE', 'REPORT_TO', 'SELF_SERVICE', 'STATIC_MI', 'CANCEL_MI', 'MULTIPLE_INSTANCE', 'MULTIPLE_INSTANCE_VALUE_BASED');
        if (!in_array($assign_type, $allowed_values)) {
            throw new \InvalidArgumentException("Invalid value for 'assign_type', must be one of 'CYCLIC', 'MANUAL', 'EVALUATE', 'REPORT_TO', 'SELF_SERVICE', 'STATIC_MI', 'CANCEL_MI', 'MULTIPLE_INSTANCE', 'MULTIPLE_INSTANCE_VALUE_BASED'");
        }
        $this->container['assign_type'] = $assign_type;

        return $this;
    }

    /**
     * Gets priority_variable
     * @return string
     */
    public function getPriorityVariable()
    {
        return $this->container['priority_variable'];
    }

    /**
     * Sets priority_variable
     * @param string $priority_variable
     * @return $this
     */
    public function setPriorityVariable($priority_variable)
    {
        $this->container['priority_variable'] = $priority_variable;

        return $this;
    }

    /**
     * Gets assign_variable
     * @return string
     */
    public function getAssignVariable()
    {
        return $this->container['assign_variable'];
    }

    /**
     * Sets assign_variable
     * @param string $assign_variable
     * @return $this
     */
    public function setAssignVariable($assign_variable)
    {
        $this->container['assign_variable'] = $assign_variable;

        return $this;
    }

    /**
     * Gets group_variable
     * @return string
     */
    public function getGroupVariable()
    {
        return $this->container['group_variable'];
    }

    /**
     * Sets group_variable
     * @param string $group_variable
     * @return $this
     */
    public function setGroupVariable($group_variable)
    {
        $this->container['group_variable'] = $group_variable;

        return $this;
    }

    /**
     * Gets mi_instance_variable
     * @return string
     */
    public function getMiInstanceVariable()
    {
        return $this->container['mi_instance_variable'];
    }

    /**
     * Sets mi_instance_variable
     * @param string $mi_instance_variable
     * @return $this
     */
    public function setMiInstanceVariable($mi_instance_variable)
    {
        $this->container['mi_instance_variable'] = $mi_instance_variable;

        return $this;
    }

    /**
     * Gets mi_complete_variable
     * @return string
     */
    public function getMiCompleteVariable()
    {
        return $this->container['mi_complete_variable'];
    }

    /**
     * Sets mi_complete_variable
     * @param string $mi_complete_variable
     * @return $this
     */
    public function setMiCompleteVariable($mi_complete_variable)
    {
        $this->container['mi_complete_variable'] = $mi_complete_variable;

        return $this;
    }

    /**
     * Gets transfer_fly
     * @return bool
     */
    public function getTransferFly()
    {
        return $this->container['transfer_fly'];
    }

    /**
     * Sets transfer_fly
     * @param bool $transfer_fly
     * @return $this
     */
    public function setTransferFly($transfer_fly)
    {
        $this->container['transfer_fly'] = $transfer_fly;

        return $this;
    }

    /**
     * Gets can_upload
     * @return bool
     */
    public function getCanUpload()
    {
        return $this->container['can_upload'];
    }

    /**
     * Sets can_upload
     * @param bool $can_upload
     * @return $this
     */
    public function setCanUpload($can_upload)
    {
        $this->container['can_upload'] = $can_upload;

        return $this;
    }

    /**
     * Gets view_upload
     * @return bool
     */
    public function getViewUpload()
    {
        return $this->container['view_upload'];
    }

    /**
     * Sets view_upload
     * @param bool $view_upload
     * @return $this
     */
    public function setViewUpload($view_upload)
    {
        $this->container['view_upload'] = $view_upload;

        return $this;
    }

    /**
     * Gets view_additional_documentation
     * @return bool
     */
    public function getViewAdditionalDocumentation()
    {
        return $this->container['view_additional_documentation'];
    }

    /**
     * Sets view_additional_documentation
     * @param bool $view_additional_documentation
     * @return $this
     */
    public function setViewAdditionalDocumentation($view_additional_documentation)
    {
        $this->container['view_additional_documentation'] = $view_additional_documentation;

        return $this;
    }

    /**
     * Gets start
     * @return bool
     */
    public function getStart()
    {
        return $this->container['start'];
    }

    /**
     * Sets start
     * @param bool $start
     * @return $this
     */
    public function setStart($start)
    {
        $this->container['start'] = $start;

        return $this;
    }

    /**
     * Gets send_last_email
     * @return bool
     */
    public function getSendLastEmail()
    {
        return $this->container['send_last_email'];
    }

    /**
     * Sets send_last_email
     * @param bool $send_last_email
     * @return $this
     */
    public function setSendLastEmail($send_last_email)
    {
        $this->container['send_last_email'] = $send_last_email;

        return $this;
    }

    /**
     * Gets derivation_screen_tpl
     * @return string
     */
    public function getDerivationScreenTpl()
    {
        return $this->container['derivation_screen_tpl'];
    }

    /**
     * Sets derivation_screen_tpl
     * @param string $derivation_screen_tpl
     * @return $this
     */
    public function setDerivationScreenTpl($derivation_screen_tpl)
    {
        $this->container['derivation_screen_tpl'] = $derivation_screen_tpl;

        return $this;
    }

    /**
     * Gets selfservice_timeout
     * @return int
     */
    public function getSelfserviceTimeout()
    {
        return $this->container['selfservice_timeout'];
    }

    /**
     * Sets selfservice_timeout
     * @param int $selfservice_timeout
     * @return $this
     */
    public function setSelfserviceTimeout($selfservice_timeout)
    {
        $this->container['selfservice_timeout'] = $selfservice_timeout;

        return $this;
    }

    /**
     * Gets selfservice_time
     * @return string
     */
    public function getSelfserviceTime()
    {
        return $this->container['selfservice_time'];
    }

    /**
     * Sets selfservice_time
     * @param string $selfservice_time
     * @return $this
     */
    public function setSelfserviceTime($selfservice_time)
    {
        $this->container['selfservice_time'] = $selfservice_time;

        return $this;
    }

    /**
     * Gets selfservice_time_unit
     * @return string
     */
    public function getSelfserviceTimeUnit()
    {
        return $this->container['selfservice_time_unit'];
    }

    /**
     * Sets selfservice_time_unit
     * @param string $selfservice_time_unit
     * @return $this
     */
    public function setSelfserviceTimeUnit($selfservice_time_unit)
    {
        $this->container['selfservice_time_unit'] = $selfservice_time_unit;

        return $this;
    }

    /**
     * Gets selfservice_execution
     * @return string
     */
    public function getSelfserviceExecution()
    {
        return $this->container['selfservice_execution'];
    }

    /**
     * Sets selfservice_execution
     * @param string $selfservice_execution
     * @return $this
     */
    public function setSelfserviceExecution($selfservice_execution)
    {
        $this->container['selfservice_execution'] = $selfservice_execution;

        return $this;
    }

    /**
     * Gets last_assigned_user_id
     * @return string
     */
    public function getLastAssignedUserId()
    {
        return $this->container['last_assigned_user_id'];
    }

    /**
     * Sets last_assigned_user_id
     * @param string $last_assigned_user_id
     * @return $this
     */
    public function setLastAssignedUserId($last_assigned_user_id)
    {
        $this->container['last_assigned_user_id'] = $last_assigned_user_id;

        return $this;
    }

    /**
     * Gets script
     * @return string
     */
    public function getScript()
    {
        return $this->container['script'];
    }

    /**
     * Sets script
     * @param string $script
     * @return $this
     */
    public function setScript($script)
    {
        $this->container['script'] = $script;

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


