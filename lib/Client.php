<?php
/**
 * Client
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

use \ProcessMaker\PMIO\Configuration;
use \ProcessMaker\PMIO\ApiClient;
use \ProcessMaker\PMIO\ApiException;
use \ProcessMaker\PMIO\ObjectSerializer;

/**
 * Client Class Doc Comment
 *
 * @category Class
 * @package  ProcessMaker\PMIO
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class Client
{

    /**
     * API Client
     *
     * @var \ProcessMaker\PMIO\ApiClient instance of the ApiClient
     */
    protected $apiClient;

    /**
     * Constructor
     *
     * @param \ProcessMaker\PMIO\ApiClient|null $apiClient The api client to use
     */
    public function __construct(\ProcessMaker\PMIO\ApiClient $apiClient = null)
    {
        if ($apiClient == null) {
            $apiClient = new ApiClient();
            $apiClient->getConfig()->setHost('https://CHANGEME.api.processmaker.io/api/v1');
        }

        $this->apiClient = $apiClient;
    }

    /**
     * Get API client
     *
     * @return \ProcessMaker\PMIO\ApiClient get the API client
     */
    public function getApiClient()
    {
        return $this->apiClient;
    }

    /**
     * Set the API client
     *
     * @param \ProcessMaker\PMIO\ApiClient $apiClient set the API client
     *
     * @return Client
     */
    public function setApiClient(\ProcessMaker\PMIO\ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
    }

    /**
     * Operation addEvent
     *
     * 
     *
     * @param string $process_id ID of the process related to the event (required)
     * @param \ProcessMaker\PMIO\Model\EventCreateItem $event_create_item JSON API response with the Event object to add (required)
     * @return \ProcessMaker\PMIO\Model\EventItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addEvent($process_id, $event_create_item)
    {
        list($response) = $this->addEventWithHttpInfo($process_id, $event_create_item);
        return $response;
    }

    /**
     * Operation addEventWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of the process related to the event (required)
     * @param \ProcessMaker\PMIO\Model\EventCreateItem $event_create_item JSON API response with the Event object to add (required)
     * @return Array of \ProcessMaker\PMIO\Model\EventItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addEventWithHttpInfo($process_id, $event_create_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling addEvent');
        }
        // verify the required parameter 'event_create_item' is set
        if ($event_create_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $event_create_item when calling addEvent');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/events";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($event_create_item)) {
            $_tempBody = $event_create_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\EventItem',
                '/processes/{process_id}/events'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\EventItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\EventItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation addEventConnector
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $event_id ID of Event to fetch (required)
     * @param \ProcessMaker\PMIO\Model\EventConnectorCreateItem $event_connector_create_item JSON API with the EventConnector object to add (required)
     * @return \ProcessMaker\PMIO\Model\EventConnector1
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addEventConnector($process_id, $event_id, $event_connector_create_item)
    {
        list($response) = $this->addEventConnectorWithHttpInfo($process_id, $event_id, $event_connector_create_item);
        return $response;
    }

    /**
     * Operation addEventConnectorWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $event_id ID of Event to fetch (required)
     * @param \ProcessMaker\PMIO\Model\EventConnectorCreateItem $event_connector_create_item JSON API with the EventConnector object to add (required)
     * @return Array of \ProcessMaker\PMIO\Model\EventConnector1, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addEventConnectorWithHttpInfo($process_id, $event_id, $event_connector_create_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling addEventConnector');
        }
        // verify the required parameter 'event_id' is set
        if ($event_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $event_id when calling addEventConnector');
        }
        // verify the required parameter 'event_connector_create_item' is set
        if ($event_connector_create_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $event_connector_create_item when calling addEventConnector');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/events/{event_id}/connectors";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($event_id !== null) {
            $resourcePath = str_replace(
                "{" . "event_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($event_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($event_connector_create_item)) {
            $_tempBody = $event_connector_create_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\EventConnector1',
                '/processes/{process_id}/events/{event_id}/connectors'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\EventConnector1', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\EventConnector1', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation addFlow
     *
     * 
     *
     * @param string $process_id ID of the process related to the flow (required)
     * @param \ProcessMaker\PMIO\Model\FlowCreateItem $flow_create_item JSON API response with the Flow object to add (required)
     * @return \ProcessMaker\PMIO\Model\FlowItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addFlow($process_id, $flow_create_item)
    {
        list($response) = $this->addFlowWithHttpInfo($process_id, $flow_create_item);
        return $response;
    }

    /**
     * Operation addFlowWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of the process related to the flow (required)
     * @param \ProcessMaker\PMIO\Model\FlowCreateItem $flow_create_item JSON API response with the Flow object to add (required)
     * @return Array of \ProcessMaker\PMIO\Model\FlowItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addFlowWithHttpInfo($process_id, $flow_create_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling addFlow');
        }
        // verify the required parameter 'flow_create_item' is set
        if ($flow_create_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $flow_create_item when calling addFlow');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/flows";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($flow_create_item)) {
            $_tempBody = $flow_create_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\FlowItem',
                '/processes/{process_id}/flows'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\FlowItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\FlowItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation addGateway
     *
     * 
     *
     * @param string $process_id ID of the process related to the gateway (required)
     * @param \ProcessMaker\PMIO\Model\GatewayCreateItem $gateway_create_item JSON API response with the gateway object to add (required)
     * @return \ProcessMaker\PMIO\Model\GatewayItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addGateway($process_id, $gateway_create_item)
    {
        list($response) = $this->addGatewayWithHttpInfo($process_id, $gateway_create_item);
        return $response;
    }

    /**
     * Operation addGatewayWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of the process related to the gateway (required)
     * @param \ProcessMaker\PMIO\Model\GatewayCreateItem $gateway_create_item JSON API response with the gateway object to add (required)
     * @return Array of \ProcessMaker\PMIO\Model\GatewayItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addGatewayWithHttpInfo($process_id, $gateway_create_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling addGateway');
        }
        // verify the required parameter 'gateway_create_item' is set
        if ($gateway_create_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $gateway_create_item when calling addGateway');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/gateways";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($gateway_create_item)) {
            $_tempBody = $gateway_create_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\GatewayItem',
                '/processes/{process_id}/gateways'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\GatewayItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\GatewayItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation addGroup
     *
     * 
     *
     * @param \ProcessMaker\PMIO\Model\GroupCreateItem $group_create_item JSON API with the Group object to add (required)
     * @return \ProcessMaker\PMIO\Model\GroupItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addGroup($group_create_item)
    {
        list($response) = $this->addGroupWithHttpInfo($group_create_item);
        return $response;
    }

    /**
     * Operation addGroupWithHttpInfo
     *
     * 
     *
     * @param \ProcessMaker\PMIO\Model\GroupCreateItem $group_create_item JSON API with the Group object to add (required)
     * @return Array of \ProcessMaker\PMIO\Model\GroupItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addGroupWithHttpInfo($group_create_item)
    {
        // verify the required parameter 'group_create_item' is set
        if ($group_create_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $group_create_item when calling addGroup');
        }
        // parse inputs
        $resourcePath = "/groups";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($group_create_item)) {
            $_tempBody = $group_create_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\GroupItem',
                '/groups'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\GroupItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\GroupItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation addGroupsToTask
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $task_id ID of task to be modified (required)
     * @param \ProcessMaker\PMIO\Model\TaskAddGroupsItem $task_add_groups_item JSON API with Groups ID&#39;s to add (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addGroupsToTask($process_id, $task_id, $task_add_groups_item)
    {
        list($response) = $this->addGroupsToTaskWithHttpInfo($process_id, $task_id, $task_add_groups_item);
        return $response;
    }

    /**
     * Operation addGroupsToTaskWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $task_id ID of task to be modified (required)
     * @param \ProcessMaker\PMIO\Model\TaskAddGroupsItem $task_add_groups_item JSON API with Groups ID&#39;s to add (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addGroupsToTaskWithHttpInfo($process_id, $task_id, $task_add_groups_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling addGroupsToTask');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling addGroupsToTask');
        }
        // verify the required parameter 'task_add_groups_item' is set
        if ($task_add_groups_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_add_groups_item when calling addGroupsToTask');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}/groups";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($task_add_groups_item)) {
            $_tempBody = $task_add_groups_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PUT',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/processes/{process_id}/tasks/{task_id}/groups'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 422:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation addInputOutput
     *
     * 
     *
     * @param string $process_id Process ID related to Input/Output object (required)
     * @param string $task_id Task instance ID related to Input/Output object (required)
     * @param \ProcessMaker\PMIO\Model\InputOutputCreateItem $input_output_create_item Create and add a new Input/Output object with JSON API (required)
     * @return \ProcessMaker\PMIO\Model\InputOutputItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addInputOutput($process_id, $task_id, $input_output_create_item)
    {
        list($response) = $this->addInputOutputWithHttpInfo($process_id, $task_id, $input_output_create_item);
        return $response;
    }

    /**
     * Operation addInputOutputWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID related to Input/Output object (required)
     * @param string $task_id Task instance ID related to Input/Output object (required)
     * @param \ProcessMaker\PMIO\Model\InputOutputCreateItem $input_output_create_item Create and add a new Input/Output object with JSON API (required)
     * @return Array of \ProcessMaker\PMIO\Model\InputOutputItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addInputOutputWithHttpInfo($process_id, $task_id, $input_output_create_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling addInputOutput');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling addInputOutput');
        }
        // verify the required parameter 'input_output_create_item' is set
        if ($input_output_create_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $input_output_create_item when calling addInputOutput');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}/inputoutput";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($input_output_create_item)) {
            $_tempBody = $input_output_create_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\InputOutputItem',
                '/processes/{process_id}/tasks/{task_id}/inputoutput'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\InputOutputItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\InputOutputItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation addInstance
     *
     * 
     *
     * @param string $process_id Process ID related to the Instance (required)
     * @param \ProcessMaker\PMIO\Model\InstanceCreateItem $instance_create_item JSON API response with the Instance object to add (required)
     * @return \ProcessMaker\PMIO\Model\InstanceItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addInstance($process_id, $instance_create_item)
    {
        list($response) = $this->addInstanceWithHttpInfo($process_id, $instance_create_item);
        return $response;
    }

    /**
     * Operation addInstanceWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID related to the Instance (required)
     * @param \ProcessMaker\PMIO\Model\InstanceCreateItem $instance_create_item JSON API response with the Instance object to add (required)
     * @return Array of \ProcessMaker\PMIO\Model\InstanceItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addInstanceWithHttpInfo($process_id, $instance_create_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling addInstance');
        }
        // verify the required parameter 'instance_create_item' is set
        if ($instance_create_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $instance_create_item when calling addInstance');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/instances";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($instance_create_item)) {
            $_tempBody = $instance_create_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\InstanceItem',
                '/processes/{process_id}/instances'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\InstanceItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\InstanceItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation addOauthClient
     *
     * 
     *
     * @param string $user_id ID of the user related to the Oauth client (required)
     * @param \ProcessMaker\PMIO\Model\OauthClientCreateItem $oauth_client_create_item JSON API with the Oauth Client object to add (required)
     * @return \ProcessMaker\PMIO\Model\OauthClientItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addOauthClient($user_id, $oauth_client_create_item)
    {
        list($response) = $this->addOauthClientWithHttpInfo($user_id, $oauth_client_create_item);
        return $response;
    }

    /**
     * Operation addOauthClientWithHttpInfo
     *
     * 
     *
     * @param string $user_id ID of the user related to the Oauth client (required)
     * @param \ProcessMaker\PMIO\Model\OauthClientCreateItem $oauth_client_create_item JSON API with the Oauth Client object to add (required)
     * @return Array of \ProcessMaker\PMIO\Model\OauthClientItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addOauthClientWithHttpInfo($user_id, $oauth_client_create_item)
    {
        // verify the required parameter 'user_id' is set
        if ($user_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $user_id when calling addOauthClient');
        }
        // verify the required parameter 'oauth_client_create_item' is set
        if ($oauth_client_create_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $oauth_client_create_item when calling addOauthClient');
        }
        // parse inputs
        $resourcePath = "/users/{user_id}/clients";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($user_id !== null) {
            $resourcePath = str_replace(
                "{" . "user_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($user_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($oauth_client_create_item)) {
            $_tempBody = $oauth_client_create_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\OauthClientItem',
                '/users/{user_id}/clients'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\OauthClientItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\OauthClientItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation addProcess
     *
     * 
     *
     * @param \ProcessMaker\PMIO\Model\ProcessCreateItem $process_create_item JSON API response with the Process object to add (required)
     * @return \ProcessMaker\PMIO\Model\ProcessItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addProcess($process_create_item)
    {
        list($response) = $this->addProcessWithHttpInfo($process_create_item);
        return $response;
    }

    /**
     * Operation addProcessWithHttpInfo
     *
     * 
     *
     * @param \ProcessMaker\PMIO\Model\ProcessCreateItem $process_create_item JSON API response with the Process object to add (required)
     * @return Array of \ProcessMaker\PMIO\Model\ProcessItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addProcessWithHttpInfo($process_create_item)
    {
        // verify the required parameter 'process_create_item' is set
        if ($process_create_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_create_item when calling addProcess');
        }
        // parse inputs
        $resourcePath = "/processes";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($process_create_item)) {
            $_tempBody = $process_create_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ProcessItem',
                '/processes'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ProcessItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ProcessItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation addTask
     *
     * 
     *
     * @param string $process_id Process ID related to the task (required)
     * @param \ProcessMaker\PMIO\Model\TaskCreateItem $task_create_item JSON API with the Task object to add (required)
     * @return \ProcessMaker\PMIO\Model\TaskItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addTask($process_id, $task_create_item)
    {
        list($response) = $this->addTaskWithHttpInfo($process_id, $task_create_item);
        return $response;
    }

    /**
     * Operation addTaskWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID related to the task (required)
     * @param \ProcessMaker\PMIO\Model\TaskCreateItem $task_create_item JSON API with the Task object to add (required)
     * @return Array of \ProcessMaker\PMIO\Model\TaskItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addTaskWithHttpInfo($process_id, $task_create_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling addTask');
        }
        // verify the required parameter 'task_create_item' is set
        if ($task_create_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_create_item when calling addTask');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($task_create_item)) {
            $_tempBody = $task_create_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\TaskItem',
                '/processes/{process_id}/tasks'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\TaskItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\TaskItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation addTaskConnector
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $task_id ID of Task to fetch (required)
     * @param \ProcessMaker\PMIO\Model\TaskConnectorCreateItem $task_connector_create_item JSON API with the TaskConnector object to add (required)
     * @return \ProcessMaker\PMIO\Model\TaskConnector1
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addTaskConnector($process_id, $task_id, $task_connector_create_item)
    {
        list($response) = $this->addTaskConnectorWithHttpInfo($process_id, $task_id, $task_connector_create_item);
        return $response;
    }

    /**
     * Operation addTaskConnectorWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $task_id ID of Task to fetch (required)
     * @param \ProcessMaker\PMIO\Model\TaskConnectorCreateItem $task_connector_create_item JSON API with the TaskConnector object to add (required)
     * @return Array of \ProcessMaker\PMIO\Model\TaskConnector1, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addTaskConnectorWithHttpInfo($process_id, $task_id, $task_connector_create_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling addTaskConnector');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling addTaskConnector');
        }
        // verify the required parameter 'task_connector_create_item' is set
        if ($task_connector_create_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_connector_create_item when calling addTaskConnector');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}/connectors";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($task_connector_create_item)) {
            $_tempBody = $task_connector_create_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\TaskConnector1',
                '/processes/{process_id}/tasks/{task_id}/connectors'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\TaskConnector1', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\TaskConnector1', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation addUser
     *
     * 
     *
     * @param \ProcessMaker\PMIO\Model\UserCreateItem $user_create_item JSON API with the User object to add (required)
     * @return \ProcessMaker\PMIO\Model\UserItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addUser($user_create_item)
    {
        list($response) = $this->addUserWithHttpInfo($user_create_item);
        return $response;
    }

    /**
     * Operation addUserWithHttpInfo
     *
     * 
     *
     * @param \ProcessMaker\PMIO\Model\UserCreateItem $user_create_item JSON API with the User object to add (required)
     * @return Array of \ProcessMaker\PMIO\Model\UserItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addUserWithHttpInfo($user_create_item)
    {
        // verify the required parameter 'user_create_item' is set
        if ($user_create_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $user_create_item when calling addUser');
        }
        // parse inputs
        $resourcePath = "/users";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($user_create_item)) {
            $_tempBody = $user_create_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\UserItem',
                '/users'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\UserItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\UserItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation addUsersToGroup
     *
     * 
     *
     * @param string $id ID of group to be modified (required)
     * @param \ProcessMaker\PMIO\Model\GroupAddUsersItem $group_add_users_item JSON API response with array of users ID&#39;s (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addUsersToGroup($id, $group_add_users_item)
    {
        list($response) = $this->addUsersToGroupWithHttpInfo($id, $group_add_users_item);
        return $response;
    }

    /**
     * Operation addUsersToGroupWithHttpInfo
     *
     * 
     *
     * @param string $id ID of group to be modified (required)
     * @param \ProcessMaker\PMIO\Model\GroupAddUsersItem $group_add_users_item JSON API response with array of users ID&#39;s (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function addUsersToGroupWithHttpInfo($id, $group_add_users_item)
    {
        // verify the required parameter 'id' is set
        if ($id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $id when calling addUsersToGroup');
        }
        // verify the required parameter 'group_add_users_item' is set
        if ($group_add_users_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $group_add_users_item when calling addUsersToGroup');
        }
        // parse inputs
        $resourcePath = "/groups/{id}/users";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                "{" . "id" . "}",
                $this->apiClient->getSerializer()->toPathValue($id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($group_add_users_item)) {
            $_tempBody = $group_add_users_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PUT',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/groups/{id}/users'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 422:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation deleteEvent
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $event_id ID of event to delete (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteEvent($process_id, $event_id)
    {
        list($response) = $this->deleteEventWithHttpInfo($process_id, $event_id);
        return $response;
    }

    /**
     * Operation deleteEventWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $event_id ID of event to delete (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteEventWithHttpInfo($process_id, $event_id)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling deleteEvent');
        }
        // verify the required parameter 'event_id' is set
        if ($event_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $event_id when calling deleteEvent');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/events/{event_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($event_id !== null) {
            $resourcePath = str_replace(
                "{" . "event_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($event_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/processes/{process_id}/events/{event_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation deleteEventConnector
     *
     * 
     *
     * @param string $process_id ID of of Process item (required)
     * @param string $event_id ID of item to fetch (required)
     * @param string $connector_id ID of EventConnector to fetch (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteEventConnector($process_id, $event_id, $connector_id)
    {
        list($response) = $this->deleteEventConnectorWithHttpInfo($process_id, $event_id, $connector_id);
        return $response;
    }

    /**
     * Operation deleteEventConnectorWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of of Process item (required)
     * @param string $event_id ID of item to fetch (required)
     * @param string $connector_id ID of EventConnector to fetch (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteEventConnectorWithHttpInfo($process_id, $event_id, $connector_id)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling deleteEventConnector');
        }
        // verify the required parameter 'event_id' is set
        if ($event_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $event_id when calling deleteEventConnector');
        }
        // verify the required parameter 'connector_id' is set
        if ($connector_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $connector_id when calling deleteEventConnector');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/events/{event_id}/connectors/{connector_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($event_id !== null) {
            $resourcePath = str_replace(
                "{" . "event_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($event_id),
                $resourcePath
            );
        }
        // path params
        if ($connector_id !== null) {
            $resourcePath = str_replace(
                "{" . "connector_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($connector_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/processes/{process_id}/events/{event_id}/connectors/{connector_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation deleteFlow
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $flow_id ID of flow to delete (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteFlow($process_id, $flow_id)
    {
        list($response) = $this->deleteFlowWithHttpInfo($process_id, $flow_id);
        return $response;
    }

    /**
     * Operation deleteFlowWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $flow_id ID of flow to delete (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteFlowWithHttpInfo($process_id, $flow_id)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling deleteFlow');
        }
        // verify the required parameter 'flow_id' is set
        if ($flow_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $flow_id when calling deleteFlow');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/flows/{flow_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($flow_id !== null) {
            $resourcePath = str_replace(
                "{" . "flow_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($flow_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/processes/{process_id}/flows/{flow_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation deleteGateway
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $gateway_id ID of Process to delete (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteGateway($process_id, $gateway_id)
    {
        list($response) = $this->deleteGatewayWithHttpInfo($process_id, $gateway_id);
        return $response;
    }

    /**
     * Operation deleteGatewayWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $gateway_id ID of Process to delete (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteGatewayWithHttpInfo($process_id, $gateway_id)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling deleteGateway');
        }
        // verify the required parameter 'gateway_id' is set
        if ($gateway_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $gateway_id when calling deleteGateway');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/gateways/{gateway_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($gateway_id !== null) {
            $resourcePath = str_replace(
                "{" . "gateway_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($gateway_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/processes/{process_id}/gateways/{gateway_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation deleteGroup
     *
     * 
     *
     * @param string $id ID of group to delete (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteGroup($id)
    {
        list($response) = $this->deleteGroupWithHttpInfo($id);
        return $response;
    }

    /**
     * Operation deleteGroupWithHttpInfo
     *
     * 
     *
     * @param string $id ID of group to delete (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteGroupWithHttpInfo($id)
    {
        // verify the required parameter 'id' is set
        if ($id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $id when calling deleteGroup');
        }
        // parse inputs
        $resourcePath = "/groups/{id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                "{" . "id" . "}",
                $this->apiClient->getSerializer()->toPathValue($id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/groups/{id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation deleteInputOutput
     *
     * 
     *
     * @param string $process_id Process ID related to the Input/Output object (required)
     * @param string $task_id Task instance ID related to Input/Output object (required)
     * @param string $inputoutput_uid Input/Output ID to fetch (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteInputOutput($process_id, $task_id, $inputoutput_uid)
    {
        list($response) = $this->deleteInputOutputWithHttpInfo($process_id, $task_id, $inputoutput_uid);
        return $response;
    }

    /**
     * Operation deleteInputOutputWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID related to the Input/Output object (required)
     * @param string $task_id Task instance ID related to Input/Output object (required)
     * @param string $inputoutput_uid Input/Output ID to fetch (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteInputOutputWithHttpInfo($process_id, $task_id, $inputoutput_uid)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling deleteInputOutput');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling deleteInputOutput');
        }
        // verify the required parameter 'inputoutput_uid' is set
        if ($inputoutput_uid === null) {
            throw new \InvalidArgumentException('Missing the required parameter $inputoutput_uid when calling deleteInputOutput');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // path params
        if ($inputoutput_uid !== null) {
            $resourcePath = str_replace(
                "{" . "inputoutput_uid" . "}",
                $this->apiClient->getSerializer()->toPathValue($inputoutput_uid),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation deleteInstance
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $instance_id ID of instance to delete (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteInstance($process_id, $instance_id)
    {
        list($response) = $this->deleteInstanceWithHttpInfo($process_id, $instance_id);
        return $response;
    }

    /**
     * Operation deleteInstanceWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $instance_id ID of instance to delete (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteInstanceWithHttpInfo($process_id, $instance_id)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling deleteInstance');
        }
        // verify the required parameter 'instance_id' is set
        if ($instance_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $instance_id when calling deleteInstance');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/instances/{instance_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($instance_id !== null) {
            $resourcePath = str_replace(
                "{" . "instance_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($instance_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/processes/{process_id}/instances/{instance_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation deleteOauthClient
     *
     * 
     *
     * @param string $user_id User ID (required)
     * @param string $client_id ID of Oauth client to delete (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteOauthClient($user_id, $client_id)
    {
        list($response) = $this->deleteOauthClientWithHttpInfo($user_id, $client_id);
        return $response;
    }

    /**
     * Operation deleteOauthClientWithHttpInfo
     *
     * 
     *
     * @param string $user_id User ID (required)
     * @param string $client_id ID of Oauth client to delete (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteOauthClientWithHttpInfo($user_id, $client_id)
    {
        // verify the required parameter 'user_id' is set
        if ($user_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $user_id when calling deleteOauthClient');
        }
        // verify the required parameter 'client_id' is set
        if ($client_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $client_id when calling deleteOauthClient');
        }
        // parse inputs
        $resourcePath = "/users/{user_id}/clients/{client_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($user_id !== null) {
            $resourcePath = str_replace(
                "{" . "user_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($user_id),
                $resourcePath
            );
        }
        // path params
        if ($client_id !== null) {
            $resourcePath = str_replace(
                "{" . "client_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($client_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/users/{user_id}/clients/{client_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation deleteProcess
     *
     * 
     *
     * @param string $id Process ID to delete (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteProcess($id)
    {
        list($response) = $this->deleteProcessWithHttpInfo($id);
        return $response;
    }

    /**
     * Operation deleteProcessWithHttpInfo
     *
     * 
     *
     * @param string $id Process ID to delete (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteProcessWithHttpInfo($id)
    {
        // verify the required parameter 'id' is set
        if ($id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $id when calling deleteProcess');
        }
        // parse inputs
        $resourcePath = "/processes/{id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                "{" . "id" . "}",
                $this->apiClient->getSerializer()->toPathValue($id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/processes/{id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation deleteTask
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $task_id ID of task to delete (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteTask($process_id, $task_id)
    {
        list($response) = $this->deleteTaskWithHttpInfo($process_id, $task_id);
        return $response;
    }

    /**
     * Operation deleteTaskWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $task_id ID of task to delete (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteTaskWithHttpInfo($process_id, $task_id)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling deleteTask');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling deleteTask');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/processes/{process_id}/tasks/{task_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation deleteTaskConnector
     *
     * 
     *
     * @param string $process_id ID of Process item to fetch (required)
     * @param string $task_id ID of Task item to fetch (required)
     * @param string $connector_id ID of TaskConnector to fetch (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteTaskConnector($process_id, $task_id, $connector_id)
    {
        list($response) = $this->deleteTaskConnectorWithHttpInfo($process_id, $task_id, $connector_id);
        return $response;
    }

    /**
     * Operation deleteTaskConnectorWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of Process item to fetch (required)
     * @param string $task_id ID of Task item to fetch (required)
     * @param string $connector_id ID of TaskConnector to fetch (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteTaskConnectorWithHttpInfo($process_id, $task_id, $connector_id)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling deleteTaskConnector');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling deleteTaskConnector');
        }
        // verify the required parameter 'connector_id' is set
        if ($connector_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $connector_id when calling deleteTaskConnector');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}/connectors/{connector_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // path params
        if ($connector_id !== null) {
            $resourcePath = str_replace(
                "{" . "connector_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($connector_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/processes/{process_id}/tasks/{task_id}/connectors/{connector_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation deleteUser
     *
     * 
     *
     * @param string $id ID of user to delete (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteUser($id)
    {
        list($response) = $this->deleteUserWithHttpInfo($id);
        return $response;
    }

    /**
     * Operation deleteUserWithHttpInfo
     *
     * 
     *
     * @param string $id ID of user to delete (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function deleteUserWithHttpInfo($id)
    {
        // verify the required parameter 'id' is set
        if ($id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $id when calling deleteUser');
        }
        // parse inputs
        $resourcePath = "/users/{id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                "{" . "id" . "}",
                $this->apiClient->getSerializer()->toPathValue($id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/users/{id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation eventTrigger
     *
     * 
     *
     * @param string $process_id Process ID related to the event (required)
     * @param string $event_id ID of event to trigger (required)
     * @param \ProcessMaker\PMIO\Model\TriggerEventCreateItem $trigger_event_create_item Json with some parameters (required)
     * @return \ProcessMaker\PMIO\Model\DataModelItem1
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function eventTrigger($process_id, $event_id, $trigger_event_create_item)
    {
        list($response) = $this->eventTriggerWithHttpInfo($process_id, $event_id, $trigger_event_create_item);
        return $response;
    }

    /**
     * Operation eventTriggerWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID related to the event (required)
     * @param string $event_id ID of event to trigger (required)
     * @param \ProcessMaker\PMIO\Model\TriggerEventCreateItem $trigger_event_create_item Json with some parameters (required)
     * @return Array of \ProcessMaker\PMIO\Model\DataModelItem1, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function eventTriggerWithHttpInfo($process_id, $event_id, $trigger_event_create_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling eventTrigger');
        }
        // verify the required parameter 'event_id' is set
        if ($event_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $event_id when calling eventTrigger');
        }
        // verify the required parameter 'trigger_event_create_item' is set
        if ($trigger_event_create_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $trigger_event_create_item when calling eventTrigger');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/events/{event_id}/trigger";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($event_id !== null) {
            $resourcePath = str_replace(
                "{" . "event_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($event_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($trigger_event_create_item)) {
            $_tempBody = $trigger_event_create_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\DataModelItem1',
                '/processes/{process_id}/events/{event_id}/trigger'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\DataModelItem1', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\DataModelItem1', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation eventWebhook
     *
     * 
     *
     * @param string $process_id Process ID related to the event (required)
     * @param string $event_id ID of event to trigger (required)
     * @param string $trigger_body Freeform JSON structure, it will be passed to newly created DataModel (required)
     * @return string
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function eventWebhook($process_id, $event_id, $trigger_body)
    {
        list($response) = $this->eventWebhookWithHttpInfo($process_id, $event_id, $trigger_body);
        return $response;
    }

    /**
     * Operation eventWebhookWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID related to the event (required)
     * @param string $event_id ID of event to trigger (required)
     * @param string $trigger_body Freeform JSON structure, it will be passed to newly created DataModel (required)
     * @return Array of string, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function eventWebhookWithHttpInfo($process_id, $event_id, $trigger_body)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling eventWebhook');
        }
        // verify the required parameter 'event_id' is set
        if ($event_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $event_id when calling eventWebhook');
        }
        // verify the required parameter 'trigger_body' is set
        if ($trigger_body === null) {
            throw new \InvalidArgumentException('Missing the required parameter $trigger_body when calling eventWebhook');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/events/{event_id}/webhook";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($event_id !== null) {
            $resourcePath = str_replace(
                "{" . "event_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($event_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($trigger_body)) {
            $_tempBody = $trigger_body;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                'string',
                '/processes/{process_id}/events/{event_id}/webhook'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, 'string', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), 'string', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findByFieldInsideDataModel
     *
     * 
     *
     * @param string $process_id ID of process to return (required)
     * @param string $search_param Key and value of searched field in Datamodel (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\DataModelCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findByFieldInsideDataModel($process_id, $search_param, $page = null, $per_page = null)
    {
        list($response) = $this->findByFieldInsideDataModelWithHttpInfo($process_id, $search_param, $page, $per_page);
        return $response;
    }

    /**
     * Operation findByFieldInsideDataModelWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of process to return (required)
     * @param string $search_param Key and value of searched field in Datamodel (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\DataModelCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findByFieldInsideDataModelWithHttpInfo($process_id, $search_param, $page = null, $per_page = null)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findByFieldInsideDataModel');
        }
        // verify the required parameter 'search_param' is set
        if ($search_param === null) {
            throw new \InvalidArgumentException('Missing the required parameter $search_param when calling findByFieldInsideDataModel');
        }
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findByFieldInsideDataModel, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findByFieldInsideDataModel, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findByFieldInsideDataModel, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/processes/{process_id}/datamodels/search/{search_param}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($search_param !== null) {
            $resourcePath = str_replace(
                "{" . "search_param" . "}",
                $this->apiClient->getSerializer()->toPathValue($search_param),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\DataModelCollection',
                '/processes/{process_id}/datamodels/search/{search_param}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\DataModelCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\DataModelCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findDataModel
     *
     * 
     *
     * @param string $process_id ID of process to return (required)
     * @param string $instance_id ID of instance to return (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\DataModelItem1
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findDataModel($process_id, $instance_id, $page = null, $per_page = null)
    {
        list($response) = $this->findDataModelWithHttpInfo($process_id, $instance_id, $page, $per_page);
        return $response;
    }

    /**
     * Operation findDataModelWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of process to return (required)
     * @param string $instance_id ID of instance to return (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\DataModelItem1, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findDataModelWithHttpInfo($process_id, $instance_id, $page = null, $per_page = null)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findDataModel');
        }
        // verify the required parameter 'instance_id' is set
        if ($instance_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $instance_id when calling findDataModel');
        }
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findDataModel, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findDataModel, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findDataModel, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/processes/{process_id}/instances/{instance_id}/datamodel";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($instance_id !== null) {
            $resourcePath = str_replace(
                "{" . "instance_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($instance_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\DataModelItem1',
                '/processes/{process_id}/instances/{instance_id}/datamodel'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\DataModelItem1', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\DataModelItem1', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findEventById
     *
     * 
     *
     * @param string $process_id ID of process to return (required)
     * @param string $event_id ID of event to return (required)
     * @return \ProcessMaker\PMIO\Model\EventItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findEventById($process_id, $event_id)
    {
        list($response) = $this->findEventByIdWithHttpInfo($process_id, $event_id);
        return $response;
    }

    /**
     * Operation findEventByIdWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of process to return (required)
     * @param string $event_id ID of event to return (required)
     * @return Array of \ProcessMaker\PMIO\Model\EventItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findEventByIdWithHttpInfo($process_id, $event_id)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findEventById');
        }
        // verify the required parameter 'event_id' is set
        if ($event_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $event_id when calling findEventById');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/events/{event_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($event_id !== null) {
            $resourcePath = str_replace(
                "{" . "event_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($event_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\EventItem',
                '/processes/{process_id}/events/{event_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\EventItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\EventItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findEventConnectorById
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $event_id ID of Event to fetch (required)
     * @param string $connector_id ID of EventConnector to fetch (required)
     * @return \ProcessMaker\PMIO\Model\EventConnector1
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findEventConnectorById($process_id, $event_id, $connector_id)
    {
        list($response) = $this->findEventConnectorByIdWithHttpInfo($process_id, $event_id, $connector_id);
        return $response;
    }

    /**
     * Operation findEventConnectorByIdWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $event_id ID of Event to fetch (required)
     * @param string $connector_id ID of EventConnector to fetch (required)
     * @return Array of \ProcessMaker\PMIO\Model\EventConnector1, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findEventConnectorByIdWithHttpInfo($process_id, $event_id, $connector_id)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findEventConnectorById');
        }
        // verify the required parameter 'event_id' is set
        if ($event_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $event_id when calling findEventConnectorById');
        }
        // verify the required parameter 'connector_id' is set
        if ($connector_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $connector_id when calling findEventConnectorById');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/events/{event_id}/connectors/{connector_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($event_id !== null) {
            $resourcePath = str_replace(
                "{" . "event_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($event_id),
                $resourcePath
            );
        }
        // path params
        if ($connector_id !== null) {
            $resourcePath = str_replace(
                "{" . "connector_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($connector_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\EventConnector1',
                '/processes/{process_id}/events/{event_id}/connectors/{connector_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\EventConnector1', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\EventConnector1', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findEventConnectors
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $event_id ID of Task to fetch (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\EventConnectorsCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findEventConnectors($process_id, $event_id, $page = null, $per_page = null)
    {
        list($response) = $this->findEventConnectorsWithHttpInfo($process_id, $event_id, $page, $per_page);
        return $response;
    }

    /**
     * Operation findEventConnectorsWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $event_id ID of Task to fetch (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\EventConnectorsCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findEventConnectorsWithHttpInfo($process_id, $event_id, $page = null, $per_page = null)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findEventConnectors');
        }
        // verify the required parameter 'event_id' is set
        if ($event_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $event_id when calling findEventConnectors');
        }
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findEventConnectors, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findEventConnectors, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findEventConnectors, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/processes/{process_id}/events/{event_id}/connectors";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($event_id !== null) {
            $resourcePath = str_replace(
                "{" . "event_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($event_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\EventConnectorsCollection',
                '/processes/{process_id}/events/{event_id}/connectors'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\EventConnectorsCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\EventConnectorsCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findEvents
     *
     * 
     *
     * @param string $process_id ID of process related to the event (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\EventCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findEvents($process_id, $page = null, $per_page = null)
    {
        list($response) = $this->findEventsWithHttpInfo($process_id, $page, $per_page);
        return $response;
    }

    /**
     * Operation findEventsWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of process related to the event (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\EventCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findEventsWithHttpInfo($process_id, $page = null, $per_page = null)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findEvents');
        }
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findEvents, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findEvents, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findEvents, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/processes/{process_id}/events";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\EventCollection',
                '/processes/{process_id}/events'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\EventCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\EventCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findFlowById
     *
     * 
     *
     * @param string $process_id ID of process to return (required)
     * @param string $flow_id ID of flow to return (required)
     * @return \ProcessMaker\PMIO\Model\FlowItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findFlowById($process_id, $flow_id)
    {
        list($response) = $this->findFlowByIdWithHttpInfo($process_id, $flow_id);
        return $response;
    }

    /**
     * Operation findFlowByIdWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of process to return (required)
     * @param string $flow_id ID of flow to return (required)
     * @return Array of \ProcessMaker\PMIO\Model\FlowItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findFlowByIdWithHttpInfo($process_id, $flow_id)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findFlowById');
        }
        // verify the required parameter 'flow_id' is set
        if ($flow_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $flow_id when calling findFlowById');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/flows/{flow_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($flow_id !== null) {
            $resourcePath = str_replace(
                "{" . "flow_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($flow_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\FlowItem',
                '/processes/{process_id}/flows/{flow_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\FlowItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\FlowItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findFlows
     *
     * 
     *
     * @param string $process_id ID of process related to the flow (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\FlowCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findFlows($process_id, $page = null, $per_page = null)
    {
        list($response) = $this->findFlowsWithHttpInfo($process_id, $page, $per_page);
        return $response;
    }

    /**
     * Operation findFlowsWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of process related to the flow (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\FlowCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findFlowsWithHttpInfo($process_id, $page = null, $per_page = null)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findFlows');
        }
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findFlows, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findFlows, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findFlows, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/processes/{process_id}/flows";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\FlowCollection',
                '/processes/{process_id}/flows'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\FlowCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\FlowCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findGatewayById
     *
     * 
     *
     * @param string $process_id ID of process to return (required)
     * @param string $gateway_id ID of gateway to return (required)
     * @return \ProcessMaker\PMIO\Model\GatewayItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findGatewayById($process_id, $gateway_id)
    {
        list($response) = $this->findGatewayByIdWithHttpInfo($process_id, $gateway_id);
        return $response;
    }

    /**
     * Operation findGatewayByIdWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of process to return (required)
     * @param string $gateway_id ID of gateway to return (required)
     * @return Array of \ProcessMaker\PMIO\Model\GatewayItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findGatewayByIdWithHttpInfo($process_id, $gateway_id)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findGatewayById');
        }
        // verify the required parameter 'gateway_id' is set
        if ($gateway_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $gateway_id when calling findGatewayById');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/gateways/{gateway_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($gateway_id !== null) {
            $resourcePath = str_replace(
                "{" . "gateway_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($gateway_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\GatewayItem',
                '/processes/{process_id}/gateways/{gateway_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\GatewayItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\GatewayItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findGateways
     *
     * 
     *
     * @param string $process_id ID of process related to the gateway (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\GatewayCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findGateways($process_id, $page = null, $per_page = null)
    {
        list($response) = $this->findGatewaysWithHttpInfo($process_id, $page, $per_page);
        return $response;
    }

    /**
     * Operation findGatewaysWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of process related to the gateway (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\GatewayCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findGatewaysWithHttpInfo($process_id, $page = null, $per_page = null)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findGateways');
        }
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findGateways, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findGateways, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findGateways, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/processes/{process_id}/gateways";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\GatewayCollection',
                '/processes/{process_id}/gateways'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\GatewayCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\GatewayCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findGroupById
     *
     * 
     *
     * @param string $id ID of group to return (required)
     * @return \ProcessMaker\PMIO\Model\GroupItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findGroupById($id)
    {
        list($response) = $this->findGroupByIdWithHttpInfo($id);
        return $response;
    }

    /**
     * Operation findGroupByIdWithHttpInfo
     *
     * 
     *
     * @param string $id ID of group to return (required)
     * @return Array of \ProcessMaker\PMIO\Model\GroupItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findGroupByIdWithHttpInfo($id)
    {
        // verify the required parameter 'id' is set
        if ($id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $id when calling findGroupById');
        }
        // parse inputs
        $resourcePath = "/groups/{id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                "{" . "id" . "}",
                $this->apiClient->getSerializer()->toPathValue($id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\GroupItem',
                '/groups/{id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\GroupItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\GroupItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findGroups
     *
     * 
     *
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\GroupCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findGroups($page = null, $per_page = null)
    {
        list($response) = $this->findGroupsWithHttpInfo($page, $per_page);
        return $response;
    }

    /**
     * Operation findGroupsWithHttpInfo
     *
     * 
     *
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\GroupCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findGroupsWithHttpInfo($page = null, $per_page = null)
    {
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findGroups, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findGroups, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findGroups, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/groups";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\GroupCollection',
                '/groups'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\GroupCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\GroupCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findInputOutputById
     *
     * 
     *
     * @param string $process_id Process ID related to the Input/Output object (required)
     * @param string $task_id Task instance ID related to the Input/Output object (required)
     * @param string $inputoutput_uid ID of Input/Output to return (required)
     * @return \ProcessMaker\PMIO\Model\InputOutputItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findInputOutputById($process_id, $task_id, $inputoutput_uid)
    {
        list($response) = $this->findInputOutputByIdWithHttpInfo($process_id, $task_id, $inputoutput_uid);
        return $response;
    }

    /**
     * Operation findInputOutputByIdWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID related to the Input/Output object (required)
     * @param string $task_id Task instance ID related to the Input/Output object (required)
     * @param string $inputoutput_uid ID of Input/Output to return (required)
     * @return Array of \ProcessMaker\PMIO\Model\InputOutputItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findInputOutputByIdWithHttpInfo($process_id, $task_id, $inputoutput_uid)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findInputOutputById');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling findInputOutputById');
        }
        // verify the required parameter 'inputoutput_uid' is set
        if ($inputoutput_uid === null) {
            throw new \InvalidArgumentException('Missing the required parameter $inputoutput_uid when calling findInputOutputById');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // path params
        if ($inputoutput_uid !== null) {
            $resourcePath = str_replace(
                "{" . "inputoutput_uid" . "}",
                $this->apiClient->getSerializer()->toPathValue($inputoutput_uid),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\InputOutputItem',
                '/processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\InputOutputItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\InputOutputItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findInputOutputs
     *
     * 
     *
     * @param string $process_id Process ID related to Input/Output object (required)
     * @param string $task_id Task instance ID related to Input/Output object (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\InputOutputCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findInputOutputs($process_id, $task_id, $page = null, $per_page = null)
    {
        list($response) = $this->findInputOutputsWithHttpInfo($process_id, $task_id, $page, $per_page);
        return $response;
    }

    /**
     * Operation findInputOutputsWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID related to Input/Output object (required)
     * @param string $task_id Task instance ID related to Input/Output object (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\InputOutputCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findInputOutputsWithHttpInfo($process_id, $task_id, $page = null, $per_page = null)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findInputOutputs');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling findInputOutputs');
        }
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findInputOutputs, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findInputOutputs, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findInputOutputs, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}/inputoutput";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\InputOutputCollection',
                '/processes/{process_id}/tasks/{task_id}/inputoutput'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\InputOutputCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\InputOutputCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findInstanceById
     *
     * 
     *
     * @param string $process_id ID of process to return (required)
     * @param string $instance_id ID of instance to return (required)
     * @return \ProcessMaker\PMIO\Model\InstanceItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findInstanceById($process_id, $instance_id)
    {
        list($response) = $this->findInstanceByIdWithHttpInfo($process_id, $instance_id);
        return $response;
    }

    /**
     * Operation findInstanceByIdWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of process to return (required)
     * @param string $instance_id ID of instance to return (required)
     * @return Array of \ProcessMaker\PMIO\Model\InstanceItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findInstanceByIdWithHttpInfo($process_id, $instance_id)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findInstanceById');
        }
        // verify the required parameter 'instance_id' is set
        if ($instance_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $instance_id when calling findInstanceById');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/instances/{instance_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($instance_id !== null) {
            $resourcePath = str_replace(
                "{" . "instance_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($instance_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\InstanceItem',
                '/processes/{process_id}/instances/{instance_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\InstanceItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\InstanceItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findInstances
     *
     * 
     *
     * @param string $process_id Process ID related to the instances (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\InstanceCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findInstances($process_id, $page = null, $per_page = null)
    {
        list($response) = $this->findInstancesWithHttpInfo($process_id, $page, $per_page);
        return $response;
    }

    /**
     * Operation findInstancesWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID related to the instances (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\InstanceCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findInstancesWithHttpInfo($process_id, $page = null, $per_page = null)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findInstances');
        }
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findInstances, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findInstances, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findInstances, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/processes/{process_id}/instances";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\InstanceCollection',
                '/processes/{process_id}/instances'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\InstanceCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\InstanceCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findOauthClientById
     *
     * 
     *
     * @param string $user_id ID of user to retrieve (required)
     * @param string $client_id ID of Oauth client to retrieve (required)
     * @return \ProcessMaker\PMIO\Model\OauthClientItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findOauthClientById($user_id, $client_id)
    {
        list($response) = $this->findOauthClientByIdWithHttpInfo($user_id, $client_id);
        return $response;
    }

    /**
     * Operation findOauthClientByIdWithHttpInfo
     *
     * 
     *
     * @param string $user_id ID of user to retrieve (required)
     * @param string $client_id ID of Oauth client to retrieve (required)
     * @return Array of \ProcessMaker\PMIO\Model\OauthClientItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findOauthClientByIdWithHttpInfo($user_id, $client_id)
    {
        // verify the required parameter 'user_id' is set
        if ($user_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $user_id when calling findOauthClientById');
        }
        // verify the required parameter 'client_id' is set
        if ($client_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $client_id when calling findOauthClientById');
        }
        // parse inputs
        $resourcePath = "/users/{user_id}/clients/{client_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($user_id !== null) {
            $resourcePath = str_replace(
                "{" . "user_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($user_id),
                $resourcePath
            );
        }
        // path params
        if ($client_id !== null) {
            $resourcePath = str_replace(
                "{" . "client_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($client_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\OauthClientItem',
                '/users/{user_id}/clients/{client_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\OauthClientItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\OauthClientItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findOauthClients
     *
     * 
     *
     * @param string $user_id User ID related to the Oauth clients (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\OauthClientCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findOauthClients($user_id, $page = null, $per_page = null)
    {
        list($response) = $this->findOauthClientsWithHttpInfo($user_id, $page, $per_page);
        return $response;
    }

    /**
     * Operation findOauthClientsWithHttpInfo
     *
     * 
     *
     * @param string $user_id User ID related to the Oauth clients (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\OauthClientCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findOauthClientsWithHttpInfo($user_id, $page = null, $per_page = null)
    {
        // verify the required parameter 'user_id' is set
        if ($user_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $user_id when calling findOauthClients');
        }
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findOauthClients, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findOauthClients, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findOauthClients, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/users/{user_id}/clients";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // path params
        if ($user_id !== null) {
            $resourcePath = str_replace(
                "{" . "user_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($user_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\OauthClientCollection',
                '/users/{user_id}/clients'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\OauthClientCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\OauthClientCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findProcessById
     *
     * 
     *
     * @param string $id ID of process to return (required)
     * @return \ProcessMaker\PMIO\Model\ProcessItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findProcessById($id)
    {
        list($response) = $this->findProcessByIdWithHttpInfo($id);
        return $response;
    }

    /**
     * Operation findProcessByIdWithHttpInfo
     *
     * 
     *
     * @param string $id ID of process to return (required)
     * @return Array of \ProcessMaker\PMIO\Model\ProcessItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findProcessByIdWithHttpInfo($id)
    {
        // verify the required parameter 'id' is set
        if ($id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $id when calling findProcessById');
        }
        // parse inputs
        $resourcePath = "/processes/{id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                "{" . "id" . "}",
                $this->apiClient->getSerializer()->toPathValue($id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ProcessItem',
                '/processes/{id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ProcessItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ProcessItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findProcesses
     *
     * 
     *
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\ProcessCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findProcesses($page = null, $per_page = null)
    {
        list($response) = $this->findProcessesWithHttpInfo($page, $per_page);
        return $response;
    }

    /**
     * Operation findProcessesWithHttpInfo
     *
     * 
     *
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\ProcessCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findProcessesWithHttpInfo($page = null, $per_page = null)
    {
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findProcesses, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findProcesses, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findProcesses, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/processes";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ProcessCollection',
                '/processes'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ProcessCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ProcessCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findTaskById
     *
     * 
     *
     * @param string $process_id ID of process to return (required)
     * @param string $task_id ID of task to return (required)
     * @return \ProcessMaker\PMIO\Model\TaskItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskById($process_id, $task_id)
    {
        list($response) = $this->findTaskByIdWithHttpInfo($process_id, $task_id);
        return $response;
    }

    /**
     * Operation findTaskByIdWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of process to return (required)
     * @param string $task_id ID of task to return (required)
     * @return Array of \ProcessMaker\PMIO\Model\TaskItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskByIdWithHttpInfo($process_id, $task_id)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findTaskById');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling findTaskById');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\TaskItem',
                '/processes/{process_id}/tasks/{task_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\TaskItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\TaskItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findTaskConnectorById
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $task_id ID of Task to fetch (required)
     * @param string $connector_id ID of TaskConnector to fetch (required)
     * @return \ProcessMaker\PMIO\Model\TaskConnector1
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskConnectorById($process_id, $task_id, $connector_id)
    {
        list($response) = $this->findTaskConnectorByIdWithHttpInfo($process_id, $task_id, $connector_id);
        return $response;
    }

    /**
     * Operation findTaskConnectorByIdWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $task_id ID of Task to fetch (required)
     * @param string $connector_id ID of TaskConnector to fetch (required)
     * @return Array of \ProcessMaker\PMIO\Model\TaskConnector1, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskConnectorByIdWithHttpInfo($process_id, $task_id, $connector_id)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findTaskConnectorById');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling findTaskConnectorById');
        }
        // verify the required parameter 'connector_id' is set
        if ($connector_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $connector_id when calling findTaskConnectorById');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}/connectors/{connector_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // path params
        if ($connector_id !== null) {
            $resourcePath = str_replace(
                "{" . "connector_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($connector_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\TaskConnector1',
                '/processes/{process_id}/tasks/{task_id}/connectors/{connector_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\TaskConnector1', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\TaskConnector1', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findTaskConnectors
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $task_id ID of Task to fetch (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\TaskConnectorsCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskConnectors($process_id, $task_id, $page = null, $per_page = null)
    {
        list($response) = $this->findTaskConnectorsWithHttpInfo($process_id, $task_id, $page, $per_page);
        return $response;
    }

    /**
     * Operation findTaskConnectorsWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $task_id ID of Task to fetch (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\TaskConnectorsCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskConnectorsWithHttpInfo($process_id, $task_id, $page = null, $per_page = null)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findTaskConnectors');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling findTaskConnectors');
        }
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findTaskConnectors, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findTaskConnectors, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findTaskConnectors, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}/connectors";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\TaskConnectorsCollection',
                '/processes/{process_id}/tasks/{task_id}/connectors'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\TaskConnectorsCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\TaskConnectorsCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findTaskInstanceById
     *
     * 
     *
     * @param string $task_instance_id ID of task instance to return (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\InlineResponse200
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskInstanceById($task_instance_id, $page = null, $per_page = null)
    {
        list($response) = $this->findTaskInstanceByIdWithHttpInfo($task_instance_id, $page, $per_page);
        return $response;
    }

    /**
     * Operation findTaskInstanceByIdWithHttpInfo
     *
     * 
     *
     * @param string $task_instance_id ID of task instance to return (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\InlineResponse200, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskInstanceByIdWithHttpInfo($task_instance_id, $page = null, $per_page = null)
    {
        // verify the required parameter 'task_instance_id' is set
        if ($task_instance_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_instance_id when calling findTaskInstanceById');
        }
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findTaskInstanceById, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findTaskInstanceById, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findTaskInstanceById, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/task_instances/{task_instance_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // path params
        if ($task_instance_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_instance_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_instance_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\InlineResponse200',
                '/task_instances/{task_instance_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\InlineResponse200', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\InlineResponse200', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findTaskInstances
     *
     * 
     *
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\TaskInstanceCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskInstances($page = null, $per_page = null)
    {
        list($response) = $this->findTaskInstancesWithHttpInfo($page, $per_page);
        return $response;
    }

    /**
     * Operation findTaskInstancesWithHttpInfo
     *
     * 
     *
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\TaskInstanceCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskInstancesWithHttpInfo($page = null, $per_page = null)
    {
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findTaskInstances, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findTaskInstances, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findTaskInstances, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/task_instances";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\TaskInstanceCollection',
                '/task_instances'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\TaskInstanceCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\TaskInstanceCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findTaskInstancesByInstanceAndTaskId
     *
     * 
     *
     * @param string $instance_id ID of instance (required)
     * @param string $task_id ID of task (required)
     * @return \ProcessMaker\PMIO\Model\TaskInstanceCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskInstancesByInstanceAndTaskId($instance_id, $task_id)
    {
        list($response) = $this->findTaskInstancesByInstanceAndTaskIdWithHttpInfo($instance_id, $task_id);
        return $response;
    }

    /**
     * Operation findTaskInstancesByInstanceAndTaskIdWithHttpInfo
     *
     * 
     *
     * @param string $instance_id ID of instance (required)
     * @param string $task_id ID of task (required)
     * @return Array of \ProcessMaker\PMIO\Model\TaskInstanceCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskInstancesByInstanceAndTaskIdWithHttpInfo($instance_id, $task_id)
    {
        // verify the required parameter 'instance_id' is set
        if ($instance_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $instance_id when calling findTaskInstancesByInstanceAndTaskId');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling findTaskInstancesByInstanceAndTaskId');
        }
        // parse inputs
        $resourcePath = "/instances/{instance_id}/tasks/{task_id}/task_instances";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($instance_id !== null) {
            $resourcePath = str_replace(
                "{" . "instance_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($instance_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\TaskInstanceCollection',
                '/instances/{instance_id}/tasks/{task_id}/task_instances'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\TaskInstanceCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\TaskInstanceCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findTaskInstancesByInstanceAndTaskIdDelegated
     *
     * 
     *
     * @param string $instance_id ID of instance (required)
     * @param string $task_id ID of task (required)
     * @return \ProcessMaker\PMIO\Model\TaskInstanceCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskInstancesByInstanceAndTaskIdDelegated($instance_id, $task_id)
    {
        list($response) = $this->findTaskInstancesByInstanceAndTaskIdDelegatedWithHttpInfo($instance_id, $task_id);
        return $response;
    }

    /**
     * Operation findTaskInstancesByInstanceAndTaskIdDelegatedWithHttpInfo
     *
     * 
     *
     * @param string $instance_id ID of instance (required)
     * @param string $task_id ID of task (required)
     * @return Array of \ProcessMaker\PMIO\Model\TaskInstanceCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskInstancesByInstanceAndTaskIdDelegatedWithHttpInfo($instance_id, $task_id)
    {
        // verify the required parameter 'instance_id' is set
        if ($instance_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $instance_id when calling findTaskInstancesByInstanceAndTaskIdDelegated');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling findTaskInstancesByInstanceAndTaskIdDelegated');
        }
        // parse inputs
        $resourcePath = "/instances/{instance_id}/tasks/{task_id}/task_instances/delegated";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($instance_id !== null) {
            $resourcePath = str_replace(
                "{" . "instance_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($instance_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\TaskInstanceCollection',
                '/instances/{instance_id}/tasks/{task_id}/task_instances/delegated'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\TaskInstanceCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\TaskInstanceCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findTaskInstancesByInstanceAndTaskIdStarted
     *
     * 
     *
     * @param string $instance_id ID of instance (required)
     * @param string $task_id ID of task (required)
     * @return \ProcessMaker\PMIO\Model\TaskInstanceCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskInstancesByInstanceAndTaskIdStarted($instance_id, $task_id)
    {
        list($response) = $this->findTaskInstancesByInstanceAndTaskIdStartedWithHttpInfo($instance_id, $task_id);
        return $response;
    }

    /**
     * Operation findTaskInstancesByInstanceAndTaskIdStartedWithHttpInfo
     *
     * 
     *
     * @param string $instance_id ID of instance (required)
     * @param string $task_id ID of task (required)
     * @return Array of \ProcessMaker\PMIO\Model\TaskInstanceCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTaskInstancesByInstanceAndTaskIdStartedWithHttpInfo($instance_id, $task_id)
    {
        // verify the required parameter 'instance_id' is set
        if ($instance_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $instance_id when calling findTaskInstancesByInstanceAndTaskIdStarted');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling findTaskInstancesByInstanceAndTaskIdStarted');
        }
        // parse inputs
        $resourcePath = "/instances/{instance_id}/tasks/{task_id}/task_instances/started";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($instance_id !== null) {
            $resourcePath = str_replace(
                "{" . "instance_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($instance_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\TaskInstanceCollection',
                '/instances/{instance_id}/tasks/{task_id}/task_instances/started'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\TaskInstanceCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\TaskInstanceCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findTasks
     *
     * 
     *
     * @param string $process_id ID of Process relative to task (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\TaskCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTasks($process_id, $page = null, $per_page = null)
    {
        list($response) = $this->findTasksWithHttpInfo($process_id, $page, $per_page);
        return $response;
    }

    /**
     * Operation findTasksWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of Process relative to task (required)
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\TaskCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findTasksWithHttpInfo($process_id, $page = null, $per_page = null)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling findTasks');
        }
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findTasks, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findTasks, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findTasks, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\TaskCollection',
                '/processes/{process_id}/tasks'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\TaskCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\TaskCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findUserById
     *
     * 
     *
     * @param string $id ID of the user to return (required)
     * @return \ProcessMaker\PMIO\Model\UserItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findUserById($id)
    {
        list($response) = $this->findUserByIdWithHttpInfo($id);
        return $response;
    }

    /**
     * Operation findUserByIdWithHttpInfo
     *
     * 
     *
     * @param string $id ID of the user to return (required)
     * @return Array of \ProcessMaker\PMIO\Model\UserItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findUserByIdWithHttpInfo($id)
    {
        // verify the required parameter 'id' is set
        if ($id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $id when calling findUserById');
        }
        // parse inputs
        $resourcePath = "/users/{id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                "{" . "id" . "}",
                $this->apiClient->getSerializer()->toPathValue($id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\UserItem',
                '/users/{id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\UserItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\UserItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation findUsers
     *
     * 
     *
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\UserCollection
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findUsers($page = null, $per_page = null)
    {
        list($response) = $this->findUsersWithHttpInfo($page, $per_page);
        return $response;
    }

    /**
     * Operation findUsersWithHttpInfo
     *
     * 
     *
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\UserCollection, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function findUsersWithHttpInfo($page = null, $per_page = null)
    {
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.findUsers, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findUsers, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.findUsers, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/users";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\UserCollection',
                '/users'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\UserCollection', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\UserCollection', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation importBpmnFile
     *
     * 
     *
     * @param \ProcessMaker\PMIO\Model\BpmnImportItem $bpmn_import_item JSON API with the BPMN file to import (required)
     * @return \ProcessMaker\PMIO\Model\ProcessCollection1
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function importBpmnFile($bpmn_import_item)
    {
        list($response) = $this->importBpmnFileWithHttpInfo($bpmn_import_item);
        return $response;
    }

    /**
     * Operation importBpmnFileWithHttpInfo
     *
     * 
     *
     * @param \ProcessMaker\PMIO\Model\BpmnImportItem $bpmn_import_item JSON API with the BPMN file to import (required)
     * @return Array of \ProcessMaker\PMIO\Model\ProcessCollection1, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function importBpmnFileWithHttpInfo($bpmn_import_item)
    {
        // verify the required parameter 'bpmn_import_item' is set
        if ($bpmn_import_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $bpmn_import_item when calling importBpmnFile');
        }
        // parse inputs
        $resourcePath = "/processes/import";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($bpmn_import_item)) {
            $_tempBody = $bpmn_import_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ProcessCollection1',
                '/processes/import'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ProcessCollection1', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ProcessCollection1', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 403:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation myselfUser
     *
     * 
     *
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return \ProcessMaker\PMIO\Model\UserItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function myselfUser($page = null, $per_page = null)
    {
        list($response) = $this->myselfUserWithHttpInfo($page, $per_page);
        return $response;
    }

    /**
     * Operation myselfUserWithHttpInfo
     *
     * 
     *
     * @param int $page Page number to fetch (optional, default to 1)
     * @param int $per_page Amount of items per page (optional, default to 15)
     * @return Array of \ProcessMaker\PMIO\Model\UserItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function myselfUserWithHttpInfo($page = null, $per_page = null)
    {
        if (!is_null($page) && ($page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$page" when calling Client.myselfUser, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.myselfUser, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Client.myselfUser, must be bigger than or equal to 1.0.');
        }

        // parse inputs
        $resourcePath = "/users/myself";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // query params
        if ($page !== null) {
            $queryParams['page'] = $this->apiClient->getSerializer()->toQueryValue($page);
        }
        // query params
        if ($per_page !== null) {
            $queryParams['per_page'] = $this->apiClient->getSerializer()->toQueryValue($per_page);
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\UserItem',
                '/users/myself'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\UserItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\UserItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation removeGroupsFromTask
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $task_id Task ID (required)
     * @param \ProcessMaker\PMIO\Model\TaskRemoveGroupsItem $task_remove_groups_item JSON API response with Groups IDs to remove (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function removeGroupsFromTask($process_id, $task_id, $task_remove_groups_item)
    {
        list($response) = $this->removeGroupsFromTaskWithHttpInfo($process_id, $task_id, $task_remove_groups_item);
        return $response;
    }

    /**
     * Operation removeGroupsFromTaskWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $task_id Task ID (required)
     * @param \ProcessMaker\PMIO\Model\TaskRemoveGroupsItem $task_remove_groups_item JSON API response with Groups IDs to remove (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function removeGroupsFromTaskWithHttpInfo($process_id, $task_id, $task_remove_groups_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling removeGroupsFromTask');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling removeGroupsFromTask');
        }
        // verify the required parameter 'task_remove_groups_item' is set
        if ($task_remove_groups_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_remove_groups_item when calling removeGroupsFromTask');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}/groups";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($task_remove_groups_item)) {
            $_tempBody = $task_remove_groups_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/processes/{process_id}/tasks/{task_id}/groups'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 422:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation removeUsersFromGroup
     *
     * 
     *
     * @param string $id ID of group to be modified (required)
     * @param \ProcessMaker\PMIO\Model\GroupRemoveUsersItem $group_remove_users_item JSON API response with Users IDs to remove (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function removeUsersFromGroup($id, $group_remove_users_item)
    {
        list($response) = $this->removeUsersFromGroupWithHttpInfo($id, $group_remove_users_item);
        return $response;
    }

    /**
     * Operation removeUsersFromGroupWithHttpInfo
     *
     * 
     *
     * @param string $id ID of group to be modified (required)
     * @param \ProcessMaker\PMIO\Model\GroupRemoveUsersItem $group_remove_users_item JSON API response with Users IDs to remove (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function removeUsersFromGroupWithHttpInfo($id, $group_remove_users_item)
    {
        // verify the required parameter 'id' is set
        if ($id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $id when calling removeUsersFromGroup');
        }
        // verify the required parameter 'group_remove_users_item' is set
        if ($group_remove_users_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $group_remove_users_item when calling removeUsersFromGroup');
        }
        // parse inputs
        $resourcePath = "/groups/{id}/users";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                "{" . "id" . "}",
                $this->apiClient->getSerializer()->toPathValue($id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($group_remove_users_item)) {
            $_tempBody = $group_remove_users_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/groups/{id}/users'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 422:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation syncGroupsToTask
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $task_id ID of task to modify (required)
     * @param \ProcessMaker\PMIO\Model\TaskSyncGroupsItem $task_sync_groups_item JSON API response with groups IDs to sync (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function syncGroupsToTask($process_id, $task_id, $task_sync_groups_item)
    {
        list($response) = $this->syncGroupsToTaskWithHttpInfo($process_id, $task_id, $task_sync_groups_item);
        return $response;
    }

    /**
     * Operation syncGroupsToTaskWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID (required)
     * @param string $task_id ID of task to modify (required)
     * @param \ProcessMaker\PMIO\Model\TaskSyncGroupsItem $task_sync_groups_item JSON API response with groups IDs to sync (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function syncGroupsToTaskWithHttpInfo($process_id, $task_id, $task_sync_groups_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling syncGroupsToTask');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling syncGroupsToTask');
        }
        // verify the required parameter 'task_sync_groups_item' is set
        if ($task_sync_groups_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_sync_groups_item when calling syncGroupsToTask');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}/groups";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($task_sync_groups_item)) {
            $_tempBody = $task_sync_groups_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/processes/{process_id}/tasks/{task_id}/groups'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation syncUsersToGroup
     *
     * 
     *
     * @param string $id ID of group to be modified (required)
     * @param \ProcessMaker\PMIO\Model\GroupSyncUsersItem $group_sync_users_item JSON API with array of users IDs to sync (required)
     * @return \ProcessMaker\PMIO\Model\ResultSuccess
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function syncUsersToGroup($id, $group_sync_users_item)
    {
        list($response) = $this->syncUsersToGroupWithHttpInfo($id, $group_sync_users_item);
        return $response;
    }

    /**
     * Operation syncUsersToGroupWithHttpInfo
     *
     * 
     *
     * @param string $id ID of group to be modified (required)
     * @param \ProcessMaker\PMIO\Model\GroupSyncUsersItem $group_sync_users_item JSON API with array of users IDs to sync (required)
     * @return Array of \ProcessMaker\PMIO\Model\ResultSuccess, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function syncUsersToGroupWithHttpInfo($id, $group_sync_users_item)
    {
        // verify the required parameter 'id' is set
        if ($id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $id when calling syncUsersToGroup');
        }
        // verify the required parameter 'group_sync_users_item' is set
        if ($group_sync_users_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $group_sync_users_item when calling syncUsersToGroup');
        }
        // parse inputs
        $resourcePath = "/groups/{id}/users";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                "{" . "id" . "}",
                $this->apiClient->getSerializer()->toPathValue($id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($group_sync_users_item)) {
            $_tempBody = $group_sync_users_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ResultSuccess',
                '/groups/{id}/users'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ResultSuccess', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ResultSuccess', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation updateEvent
     *
     * 
     *
     * @param string $process_id ID of process to retrieve (required)
     * @param string $event_id ID of event to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\EventUpdateItem $event_update_item Event object to edit (required)
     * @return \ProcessMaker\PMIO\Model\EventItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateEvent($process_id, $event_id, $event_update_item)
    {
        list($response) = $this->updateEventWithHttpInfo($process_id, $event_id, $event_update_item);
        return $response;
    }

    /**
     * Operation updateEventWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of process to retrieve (required)
     * @param string $event_id ID of event to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\EventUpdateItem $event_update_item Event object to edit (required)
     * @return Array of \ProcessMaker\PMIO\Model\EventItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateEventWithHttpInfo($process_id, $event_id, $event_update_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling updateEvent');
        }
        // verify the required parameter 'event_id' is set
        if ($event_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $event_id when calling updateEvent');
        }
        // verify the required parameter 'event_update_item' is set
        if ($event_update_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $event_update_item when calling updateEvent');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/events/{event_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($event_id !== null) {
            $resourcePath = str_replace(
                "{" . "event_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($event_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($event_update_item)) {
            $_tempBody = $event_update_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PUT',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\EventItem',
                '/processes/{process_id}/events/{event_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\EventItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\EventItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation updateEventConnector
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $event_id ID of Event to fetch (required)
     * @param string $connector_id ID of Event Connector to fetch (required)
     * @param \ProcessMaker\PMIO\Model\EventConnectorUpdateItem $event_connector_update_item EventConnector object to edit (required)
     * @return \ProcessMaker\PMIO\Model\EventConnector1
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateEventConnector($process_id, $event_id, $connector_id, $event_connector_update_item)
    {
        list($response) = $this->updateEventConnectorWithHttpInfo($process_id, $event_id, $connector_id, $event_connector_update_item);
        return $response;
    }

    /**
     * Operation updateEventConnectorWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $event_id ID of Event to fetch (required)
     * @param string $connector_id ID of Event Connector to fetch (required)
     * @param \ProcessMaker\PMIO\Model\EventConnectorUpdateItem $event_connector_update_item EventConnector object to edit (required)
     * @return Array of \ProcessMaker\PMIO\Model\EventConnector1, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateEventConnectorWithHttpInfo($process_id, $event_id, $connector_id, $event_connector_update_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling updateEventConnector');
        }
        // verify the required parameter 'event_id' is set
        if ($event_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $event_id when calling updateEventConnector');
        }
        // verify the required parameter 'connector_id' is set
        if ($connector_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $connector_id when calling updateEventConnector');
        }
        // verify the required parameter 'event_connector_update_item' is set
        if ($event_connector_update_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $event_connector_update_item when calling updateEventConnector');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/events/{event_id}/connectors/{connector_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($event_id !== null) {
            $resourcePath = str_replace(
                "{" . "event_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($event_id),
                $resourcePath
            );
        }
        // path params
        if ($connector_id !== null) {
            $resourcePath = str_replace(
                "{" . "connector_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($connector_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($event_connector_update_item)) {
            $_tempBody = $event_connector_update_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PUT',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\EventConnector1',
                '/processes/{process_id}/events/{event_id}/connectors/{connector_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\EventConnector1', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\EventConnector1', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation updateFlow
     *
     * 
     *
     * @param string $process_id ID of process to retrieve (required)
     * @param string $flow_id ID of flow to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\FlowUpdateItem $flow_update_item Flow object to edit (required)
     * @return \ProcessMaker\PMIO\Model\FlowItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateFlow($process_id, $flow_id, $flow_update_item)
    {
        list($response) = $this->updateFlowWithHttpInfo($process_id, $flow_id, $flow_update_item);
        return $response;
    }

    /**
     * Operation updateFlowWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of process to retrieve (required)
     * @param string $flow_id ID of flow to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\FlowUpdateItem $flow_update_item Flow object to edit (required)
     * @return Array of \ProcessMaker\PMIO\Model\FlowItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateFlowWithHttpInfo($process_id, $flow_id, $flow_update_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling updateFlow');
        }
        // verify the required parameter 'flow_id' is set
        if ($flow_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $flow_id when calling updateFlow');
        }
        // verify the required parameter 'flow_update_item' is set
        if ($flow_update_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $flow_update_item when calling updateFlow');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/flows/{flow_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($flow_id !== null) {
            $resourcePath = str_replace(
                "{" . "flow_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($flow_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($flow_update_item)) {
            $_tempBody = $flow_update_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PUT',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\FlowItem',
                '/processes/{process_id}/flows/{flow_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\FlowItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\FlowItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation updateGateway
     *
     * 
     *
     * @param string $process_id ID of process to retrieve (required)
     * @param string $gateway_id ID of gateway to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\GatewayUpdateItem $gateway_update_item Gateway object to edit (required)
     * @return \ProcessMaker\PMIO\Model\GatewayItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateGateway($process_id, $gateway_id, $gateway_update_item)
    {
        list($response) = $this->updateGatewayWithHttpInfo($process_id, $gateway_id, $gateway_update_item);
        return $response;
    }

    /**
     * Operation updateGatewayWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of process to retrieve (required)
     * @param string $gateway_id ID of gateway to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\GatewayUpdateItem $gateway_update_item Gateway object to edit (required)
     * @return Array of \ProcessMaker\PMIO\Model\GatewayItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateGatewayWithHttpInfo($process_id, $gateway_id, $gateway_update_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling updateGateway');
        }
        // verify the required parameter 'gateway_id' is set
        if ($gateway_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $gateway_id when calling updateGateway');
        }
        // verify the required parameter 'gateway_update_item' is set
        if ($gateway_update_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $gateway_update_item when calling updateGateway');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/gateways/{gateway_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($gateway_id !== null) {
            $resourcePath = str_replace(
                "{" . "gateway_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($gateway_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($gateway_update_item)) {
            $_tempBody = $gateway_update_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PUT',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\GatewayItem',
                '/processes/{process_id}/gateways/{gateway_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\GatewayItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\GatewayItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation updateGroup
     *
     * 
     *
     * @param string $id ID of group to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\GroupUpdateItem $group_update_item Group object to edit (required)
     * @return \ProcessMaker\PMIO\Model\GroupItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateGroup($id, $group_update_item)
    {
        list($response) = $this->updateGroupWithHttpInfo($id, $group_update_item);
        return $response;
    }

    /**
     * Operation updateGroupWithHttpInfo
     *
     * 
     *
     * @param string $id ID of group to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\GroupUpdateItem $group_update_item Group object to edit (required)
     * @return Array of \ProcessMaker\PMIO\Model\GroupItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateGroupWithHttpInfo($id, $group_update_item)
    {
        // verify the required parameter 'id' is set
        if ($id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $id when calling updateGroup');
        }
        // verify the required parameter 'group_update_item' is set
        if ($group_update_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $group_update_item when calling updateGroup');
        }
        // parse inputs
        $resourcePath = "/groups/{id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                "{" . "id" . "}",
                $this->apiClient->getSerializer()->toPathValue($id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($group_update_item)) {
            $_tempBody = $group_update_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PUT',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\GroupItem',
                '/groups/{id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\GroupItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\GroupItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation updateInputOutput
     *
     * 
     *
     * @param string $process_id Process ID related to the Input/Output object (required)
     * @param string $task_id Task instance ID related to the Input/Output object (required)
     * @param string $inputoutput_uid ID of Input/Output to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\InputOutputUpdateItem $input_output_update_item Input/Output object to edit (required)
     * @return \ProcessMaker\PMIO\Model\InputOutputItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateInputOutput($process_id, $task_id, $inputoutput_uid, $input_output_update_item)
    {
        list($response) = $this->updateInputOutputWithHttpInfo($process_id, $task_id, $inputoutput_uid, $input_output_update_item);
        return $response;
    }

    /**
     * Operation updateInputOutputWithHttpInfo
     *
     * 
     *
     * @param string $process_id Process ID related to the Input/Output object (required)
     * @param string $task_id Task instance ID related to the Input/Output object (required)
     * @param string $inputoutput_uid ID of Input/Output to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\InputOutputUpdateItem $input_output_update_item Input/Output object to edit (required)
     * @return Array of \ProcessMaker\PMIO\Model\InputOutputItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateInputOutputWithHttpInfo($process_id, $task_id, $inputoutput_uid, $input_output_update_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling updateInputOutput');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling updateInputOutput');
        }
        // verify the required parameter 'inputoutput_uid' is set
        if ($inputoutput_uid === null) {
            throw new \InvalidArgumentException('Missing the required parameter $inputoutput_uid when calling updateInputOutput');
        }
        // verify the required parameter 'input_output_update_item' is set
        if ($input_output_update_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $input_output_update_item when calling updateInputOutput');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // path params
        if ($inputoutput_uid !== null) {
            $resourcePath = str_replace(
                "{" . "inputoutput_uid" . "}",
                $this->apiClient->getSerializer()->toPathValue($inputoutput_uid),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($input_output_update_item)) {
            $_tempBody = $input_output_update_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PUT',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\InputOutputItem',
                '/processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\InputOutputItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\InputOutputItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation updateInstance
     *
     * 
     *
     * @param string $process_id ID of Process to retrieve (required)
     * @param string $instance_id ID of Instance to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\InstanceUpdateItem $instance_update_item Instance object to edit (required)
     * @return \ProcessMaker\PMIO\Model\InstanceItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateInstance($process_id, $instance_id, $instance_update_item)
    {
        list($response) = $this->updateInstanceWithHttpInfo($process_id, $instance_id, $instance_update_item);
        return $response;
    }

    /**
     * Operation updateInstanceWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of Process to retrieve (required)
     * @param string $instance_id ID of Instance to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\InstanceUpdateItem $instance_update_item Instance object to edit (required)
     * @return Array of \ProcessMaker\PMIO\Model\InstanceItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateInstanceWithHttpInfo($process_id, $instance_id, $instance_update_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling updateInstance');
        }
        // verify the required parameter 'instance_id' is set
        if ($instance_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $instance_id when calling updateInstance');
        }
        // verify the required parameter 'instance_update_item' is set
        if ($instance_update_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $instance_update_item when calling updateInstance');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/instances/{instance_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($instance_id !== null) {
            $resourcePath = str_replace(
                "{" . "instance_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($instance_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($instance_update_item)) {
            $_tempBody = $instance_update_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PUT',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\InstanceItem',
                '/processes/{process_id}/instances/{instance_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\InstanceItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\InstanceItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation updateOauthClient
     *
     * 
     *
     * @param string $user_id ID of user to retrieve (required)
     * @param string $client_id ID of Oauth client to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\OauthClientUpdateItem $oauth_client_update_item Oauth Client object to edit (required)
     * @return \ProcessMaker\PMIO\Model\OauthClientItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateOauthClient($user_id, $client_id, $oauth_client_update_item)
    {
        list($response) = $this->updateOauthClientWithHttpInfo($user_id, $client_id, $oauth_client_update_item);
        return $response;
    }

    /**
     * Operation updateOauthClientWithHttpInfo
     *
     * 
     *
     * @param string $user_id ID of user to retrieve (required)
     * @param string $client_id ID of Oauth client to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\OauthClientUpdateItem $oauth_client_update_item Oauth Client object to edit (required)
     * @return Array of \ProcessMaker\PMIO\Model\OauthClientItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateOauthClientWithHttpInfo($user_id, $client_id, $oauth_client_update_item)
    {
        // verify the required parameter 'user_id' is set
        if ($user_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $user_id when calling updateOauthClient');
        }
        // verify the required parameter 'client_id' is set
        if ($client_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $client_id when calling updateOauthClient');
        }
        // verify the required parameter 'oauth_client_update_item' is set
        if ($oauth_client_update_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $oauth_client_update_item when calling updateOauthClient');
        }
        // parse inputs
        $resourcePath = "/users/{user_id}/clients/{client_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($user_id !== null) {
            $resourcePath = str_replace(
                "{" . "user_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($user_id),
                $resourcePath
            );
        }
        // path params
        if ($client_id !== null) {
            $resourcePath = str_replace(
                "{" . "client_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($client_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($oauth_client_update_item)) {
            $_tempBody = $oauth_client_update_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PUT',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\OauthClientItem',
                '/users/{user_id}/clients/{client_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\OauthClientItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\OauthClientItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation updateProcess
     *
     * 
     *
     * @param string $id ID of process to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\ProcessUpdateItem $process_update_item Process object to edit (required)
     * @return \ProcessMaker\PMIO\Model\ProcessItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateProcess($id, $process_update_item)
    {
        list($response) = $this->updateProcessWithHttpInfo($id, $process_update_item);
        return $response;
    }

    /**
     * Operation updateProcessWithHttpInfo
     *
     * 
     *
     * @param string $id ID of process to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\ProcessUpdateItem $process_update_item Process object to edit (required)
     * @return Array of \ProcessMaker\PMIO\Model\ProcessItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateProcessWithHttpInfo($id, $process_update_item)
    {
        // verify the required parameter 'id' is set
        if ($id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $id when calling updateProcess');
        }
        // verify the required parameter 'process_update_item' is set
        if ($process_update_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_update_item when calling updateProcess');
        }
        // parse inputs
        $resourcePath = "/processes/{id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                "{" . "id" . "}",
                $this->apiClient->getSerializer()->toPathValue($id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($process_update_item)) {
            $_tempBody = $process_update_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PUT',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\ProcessItem',
                '/processes/{id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\ProcessItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ProcessItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation updateTask
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $task_id ID of Task to fetch (required)
     * @param \ProcessMaker\PMIO\Model\TaskUpdateItem $task_update_item Task object to edit (required)
     * @return \ProcessMaker\PMIO\Model\TaskItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateTask($process_id, $task_id, $task_update_item)
    {
        list($response) = $this->updateTaskWithHttpInfo($process_id, $task_id, $task_update_item);
        return $response;
    }

    /**
     * Operation updateTaskWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $task_id ID of Task to fetch (required)
     * @param \ProcessMaker\PMIO\Model\TaskUpdateItem $task_update_item Task object to edit (required)
     * @return Array of \ProcessMaker\PMIO\Model\TaskItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateTaskWithHttpInfo($process_id, $task_id, $task_update_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling updateTask');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling updateTask');
        }
        // verify the required parameter 'task_update_item' is set
        if ($task_update_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_update_item when calling updateTask');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($task_update_item)) {
            $_tempBody = $task_update_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PUT',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\TaskItem',
                '/processes/{process_id}/tasks/{task_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\TaskItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\TaskItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation updateTaskConnector
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $task_id ID of Task to fetch (required)
     * @param string $connector_id ID of Task Connector to fetch (required)
     * @param \ProcessMaker\PMIO\Model\TaskConnectorUpdateItem $task_connector_update_item TaskConnector object to edit (required)
     * @return \ProcessMaker\PMIO\Model\TaskConnector1
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateTaskConnector($process_id, $task_id, $connector_id, $task_connector_update_item)
    {
        list($response) = $this->updateTaskConnectorWithHttpInfo($process_id, $task_id, $connector_id, $task_connector_update_item);
        return $response;
    }

    /**
     * Operation updateTaskConnectorWithHttpInfo
     *
     * 
     *
     * @param string $process_id ID of Process to fetch (required)
     * @param string $task_id ID of Task to fetch (required)
     * @param string $connector_id ID of Task Connector to fetch (required)
     * @param \ProcessMaker\PMIO\Model\TaskConnectorUpdateItem $task_connector_update_item TaskConnector object to edit (required)
     * @return Array of \ProcessMaker\PMIO\Model\TaskConnector1, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateTaskConnectorWithHttpInfo($process_id, $task_id, $connector_id, $task_connector_update_item)
    {
        // verify the required parameter 'process_id' is set
        if ($process_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $process_id when calling updateTaskConnector');
        }
        // verify the required parameter 'task_id' is set
        if ($task_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_id when calling updateTaskConnector');
        }
        // verify the required parameter 'connector_id' is set
        if ($connector_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $connector_id when calling updateTaskConnector');
        }
        // verify the required parameter 'task_connector_update_item' is set
        if ($task_connector_update_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_connector_update_item when calling updateTaskConnector');
        }
        // parse inputs
        $resourcePath = "/processes/{process_id}/tasks/{task_id}/connectors/{connector_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($process_id !== null) {
            $resourcePath = str_replace(
                "{" . "process_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($process_id),
                $resourcePath
            );
        }
        // path params
        if ($task_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_id),
                $resourcePath
            );
        }
        // path params
        if ($connector_id !== null) {
            $resourcePath = str_replace(
                "{" . "connector_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($connector_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($task_connector_update_item)) {
            $_tempBody = $task_connector_update_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PUT',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\TaskConnector1',
                '/processes/{process_id}/tasks/{task_id}/connectors/{connector_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\TaskConnector1', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\TaskConnector1', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation updateTaskInstance
     *
     * 
     *
     * @param string $task_instance_id ID of task instance to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\TaskInstanceUpdateItem $task_instance_update_item Task Instance object to update (required)
     * @return \ProcessMaker\PMIO\Model\InlineResponse200
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateTaskInstance($task_instance_id, $task_instance_update_item)
    {
        list($response) = $this->updateTaskInstanceWithHttpInfo($task_instance_id, $task_instance_update_item);
        return $response;
    }

    /**
     * Operation updateTaskInstanceWithHttpInfo
     *
     * 
     *
     * @param string $task_instance_id ID of task instance to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\TaskInstanceUpdateItem $task_instance_update_item Task Instance object to update (required)
     * @return Array of \ProcessMaker\PMIO\Model\InlineResponse200, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateTaskInstanceWithHttpInfo($task_instance_id, $task_instance_update_item)
    {
        // verify the required parameter 'task_instance_id' is set
        if ($task_instance_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_instance_id when calling updateTaskInstance');
        }
        // verify the required parameter 'task_instance_update_item' is set
        if ($task_instance_update_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_instance_update_item when calling updateTaskInstance');
        }
        // parse inputs
        $resourcePath = "/task_instances/{task_instance_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($task_instance_id !== null) {
            $resourcePath = str_replace(
                "{" . "task_instance_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_instance_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($task_instance_update_item)) {
            $_tempBody = $task_instance_update_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PATCH',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\InlineResponse200',
                '/task_instances/{task_instance_id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\InlineResponse200', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\InlineResponse200', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation updateUser
     *
     * 
     *
     * @param string $id ID of user to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\UserUpdateItem $user_update_item User object for update (required)
     * @return \ProcessMaker\PMIO\Model\UserItem
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateUser($id, $user_update_item)
    {
        list($response) = $this->updateUserWithHttpInfo($id, $user_update_item);
        return $response;
    }

    /**
     * Operation updateUserWithHttpInfo
     *
     * 
     *
     * @param string $id ID of user to retrieve (required)
     * @param \ProcessMaker\PMIO\Model\UserUpdateItem $user_update_item User object for update (required)
     * @return Array of \ProcessMaker\PMIO\Model\UserItem, HTTP status code, HTTP response headers (array of strings)
     * @throws \ProcessMaker\PMIO\ApiException on non-2xx response
     */
    public function updateUserWithHttpInfo($id, $user_update_item)
    {
        // verify the required parameter 'id' is set
        if ($id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $id when calling updateUser');
        }
        // verify the required parameter 'user_update_item' is set
        if ($user_update_item === null) {
            throw new \InvalidArgumentException('Missing the required parameter $user_update_item when calling updateUser');
        }
        // parse inputs
        $resourcePath = "/users/{id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = $this->apiClient->selectHeaderAccept(array('application/vnd.api+json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(array('application/vnd.api+json'));

        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                "{" . "id" . "}",
                $this->apiClient->getSerializer()->toPathValue($id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($user_update_item)) {
            $_tempBody = $user_update_item;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'PUT',
                $queryParams,
                $httpBody,
                $headerParams,
                '\ProcessMaker\PMIO\Model\UserItem',
                '/users/{id}'
            );

            return array($this->apiClient->getSerializer()->deserialize($response, '\ProcessMaker\PMIO\Model\UserItem', $httpHeader), $statusCode, $httpHeader);
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\UserItem', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                default:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\ProcessMaker\PMIO\Model\ErrorArray', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

}