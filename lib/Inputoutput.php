<?php
/**
 * Inputoutput
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
 * Inputoutput Class Doc Comment
 *
 * @category Class
 * @package  ProcessMaker\PMIO
 * @author   http://github.com/swagger-api/swagger-codegen
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class Inputoutput
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
     * @return Inputoutput
     */
    public function setApiClient(\ProcessMaker\PMIO\ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
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
            throw new \InvalidArgumentException('invalid value for "$page" when calling Inputoutput.findInputOutputs, must be bigger than or equal to 1.0.');
        }

        if (!is_null($per_page) && ($per_page > 100.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Inputoutput.findInputOutputs, must be smaller than or equal to 100.0.');
        }
        if (!is_null($per_page) && ($per_page < 1.0)) {
            throw new \InvalidArgumentException('invalid value for "$per_page" when calling Inputoutput.findInputOutputs, must be bigger than or equal to 1.0.');
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

}
