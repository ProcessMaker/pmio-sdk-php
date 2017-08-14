# pmio-sdk-php
# Introduction  This ProcessMaker I/O API provides access to a BPMN 2.0 compliant workflow engine API that is designed to be used as a microservice to support enterprise cloud applications. The current Alpha 1.0 version supports most of the descriptive class of the BPMN 2.0 specification.  You can use your favorite HTTP/REST library for your programming language to use PMIO API or you can use one of our SDKs: Language | GitHub Link | Download Link --- | --- | --- JAVA | [JAVA SDK](https://github.com/ProcessMaker/pmio-sdk-java) | [Download JAVA SDK](https://github.com/ProcessMaker/pmio-sdk-java/archive/master.zip) PHP | [PHP SDK](https://github.com/ProcessMaker/pmio-sdk-php) | [Download PHP SDK](https://github.com/ProcessMaker/pmio-sdk-php/archive/master.zip) Python | [Python](https://github.com/ProcessMaker/pmio-sdk-python) | [Download Python SDK](https://github.com/ProcessMaker/pmio-sdk-python/archive/master.zip) # How to create a new user  Use [addUser](#operation/addUser) API call to create a User. Oauth client and its `client_id` will be returned back along with the User details  ## Retrieving client_secret You may retrieve `client_secret` for the User via [findOauthClientById](#operation/findOauthClientById) API call  ## Getting authorization key  With both the `client_id` and `client_secret` you may use a password grant to retrieve `access_token` and `refresh_token`. You will need to pass the username and password as part of the operation. ### PHP Sample to retrieve Oauth tokens    This code will return access_token and refresh_token to perform Oauth authorization for specific user.  ```php  $args_for_bob = [  'grant_type' => 'password',  'client_id' => $bobCredentials->getData()->getId(),  'client_secret' => $bobCredentials->getData()->getAttributes()->getSecret(),  'username' => $bobAttr->getUsername(),  'password' => $bobAttr->getPassword() ];  print_r(getCredentials($args_for_bob, $host));  /_**  * @param array $args Oauth request data  * @param string $host API HOST  * @return mixed  *_/ function getCredentials($args, $host)  {  $ch = curl_init();  curl_setopt($ch, CURLOPT_URL, \"https://$host/oauth/access_token\");  curl_setopt($ch, CURLOPT_POST, 1);  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  $serverResponse = json_decode(curl_exec($ch));  curl_close($ch);  return $serverResponse; }  ```  Here you will get `access_token` and `refresh_token` to perform Oauth authorization for specific user. # How to import BPMN file  The following API call will allow you to import BPMN file: [importBpmnFile](#operation/importBpmnFile). Resulting variable $process will contain an array of created Process(es) objects. # How to create and launch a new Process  Use [addProcess](#operation/addProcess) API call to create a new Process. As result you will get `process_id`, which can be used to add objects to the Process.  ## How to assign User to a Group  You may want to delegate Tasks not just to a User, but a Group of Users.  Use [addUsersToGroup](#operation/addUsersToGroup) API call to add some Users to a Group.  ## How to add objects to a Process  Also we should add objects to our process, such as Start event and End event. (use [addEvent](#operation/addEvent) API call to add these), and at least one Task object (use [addTask](#operation/addTask) API call).  ## How to add flows between process objects  All objects in a Process need to be joined by SEQUENTIAL Flows. Use [addFlow](#operation/addFlow) API call to connect the objects with each other.  ## How to delegate Group of Users to a Task  When you have `process_id`, `task_id` and `group_id` you can assign a Group as delegate for a User Task with the following API method: [AddGroupsToTask](#operation/addGroupsToTask).  ## How to run process  To run process we just need to trigger Start event object by using [eventTrigger](#operation/eventTrigger) API call. Just pass `process_id`, Start Event `event_id`, and an input data we need for the Process as Data model attributes. Content of Data Model can be associative array keys and values.  As result, our engine creates Process instance with status **RUNNING**. To get all Process Instances belonging to Process you can retrieve using [findInstances](#operation/findInstances) API call. ## Example with using the Exclusive gateways  ![Example #1](php-sdk-usage/images/exclusive_gateway_1endevent.png \"Example #1\")  **Process** has **Exclusive** and **Inclusive** gateways and one **End event**.  First of all create **Process** and fill it with objects.  ### Create **Process**  ```php /_** @var ProcessAttributes $processAttr *_/ $processAttr = new ProcessAttributes(); $processAttr->setStatus('ACTIVE'); $processAttr->setName('Example process'); $processAttr->setDurationBy('WORKING_DAYS'); $processAttr->setType('NORMAL'); $processAttr->setDesignAccess('PUBLIC'); /_** @var ProcessItem $result *_/ $process = $apiInstance->addProcess(new ProcessCreateItem(         [             'data' => new Process(['attributes' => $processAttr])         ]    ) );  ```  ### Create **Start event**  ![Start event](php-sdk-usage/images/start_event.png \"Start event\")  ```php /_** @var EventCreateItem $eventAttr *_/ $eventAttr = new EventAttributes(); $eventAttr->setName('Start event'); $eventAttr->setType('START'); $eventAttr->setProcessId($process->getData()->getId()); $eventAttr->setDefinition('MESSAGE'); /_** @var EventItem $startEvent *_/ $startEvent = $apiInstance->addEvent(     $process->getData()->getId(),     new EventCreateItem(         [            'data' => new Event(['attributes' => $eventAttr])         ]     ) );  ```  ### Create **End event**  ![End event](php-sdk-usage/images/end_event.png \"End event\")  ```php /_** @var EventCreateItem $eventAttr *_/ $eventAttr = new EventAttributes(); $eventAttr->setName('End event'); $eventAttr->setType('END'); $eventAttr->setProcessId($process->getData()->getId()); $eventAttr->setDefinition('MESSAGE'); /_** @var EventItem $endEvent *_/ $endEvent = $apiInstance->addEvent(     $process->getData()->getId(),     new EventCreateItem(         [             'data' => new Event(['attributes' => $eventAttr])         ]     ) );  ```  ### Create two script tasks Code snippet below creates two script tasks, which do simple things, just to add 2 types of variables to our **Data model** during running **Process**  ![First direction script task](php-sdk-usage/images/first_direction_task.png \"First direction script task\")   ```php /_** @var TaskAttributes $taskAttr *_/ $taskAttr = new TaskAttributes(); $taskAttr->setName('First direction'); $taskAttr->setType('SCRIPT-TASK'); $taskAttr->setProcessId($process->getData()->getId()); $taskAttr->setAssignType('CYCLIC'); $taskAttr->setScript('$aData[\\'First_Direction\\'] = 1;'); /_** @var TaskItem $result *_/ $firstDirectTask = $apiInstance->addTask(     $process->getData()->getId(),     new TaskCreateItem(        [            'data' => new Task(['attributes' => $taskAttr])        ]     ) ); ```  ![Second direction script task](php-sdk-usage/images/second_direction_task.png \"Second direction script task\")  ```php /_** @var TaskAttributes $taskAttr *_/ $taskAttr = new TaskAttributes(); $taskAttr->setName('Second direction'); $taskAttr->setType('SCRIPT-TASK'); $taskAttr->setProcessId($process->getData()->getId()); $taskAttr->setAssignType('CYCLIC'); $taskAttr->setScript('$aData[\\'Second_Direction\\'] = 2;');  /_** @var TaskItem $result *_/ $secondDirectTask = $apiInstance->addTask(     $process->getData()->getId(),     new TaskCreateItem(         [             'data' => new Task(['attributes' => $taskAttr])         ]     ) );  ```  ### Create two types of gateways: Exclusive and Inclusive.  ![Exclusive gateway](php-sdk-usage/images/exclusive_gateway.png \"Exclusive gateway\")   ```php /_** @var GatewayAttributes $gatewayAttr *_/ $gatewayAttr = new GatewayAttributes(); $gatewayAttr->setName('Exclusive gateway'); $gatewayAttr->setType('EXCLUSIVE'); $gatewayAttr->setDirection('DIVERGENT'); $gatewayAttr->setProcessId($process->getData()->getId());  /_** @var GatewayItem $exclusiveGateway *_/ $exclusiveGateway = $apiInstance->addGateway(     $process->getData()->getId(),     new GatewayCreateItem(         [             'data' => new Gateway(['attributes' => $gatewayAttr])         ]     ) );  ```  ![Inclusive gateway](php-sdk-usage/images/exclusive_gateway.png \"Exclusive gateway\")  ```php /_** @var GatewayAttributes $gatewayAttr *_/ $gatewayAttr = new GatewayAttributes(); $gatewayAttr->setName('Exclusive gateway'); $gatewayAttr->setType('EXCLUSIVE'); $gatewayAttr->setDirection('CONVERGENT'); $gatewayAttr->setProcessId($process->getData()->getId()); /_** @var GatewayItem $inclusiveGateway *_/ $inclusiveGateway = $apiInstance->addGateway(     $process->getData()->getId(),     new GatewayCreateItem(         [            'data' => new Gateway(['attributes' => $gatewayAttr])         ]     ) );  ``` ### Create SEQUENTIAL flows between objects   ![SEQUENTIAL Flow](php-sdk-usage/images/flow.png \"SEQUENTIAL Flow\")  ```php /_** @var FlowAttributes $flowAttr *_/ $flowAttr= new FlowAttributes(); $flowAttr->setName('Flow StartEvent with Exclusive Gateway'); $flowAttr->setType('SEQUENTIAL'); $flowAttr->setProcessId($process->getData()->getId()); $flowAttr->setFromObjectId($startEvent->getData()->getId()); $flowAttr->setFromObjectType($startEvent->getData()->getType()); $flowAttr->setToObjectId($exclusiveGateway->getData()->getId()); $flowAttr->setToObjectType($exclusiveGateway->getData()->getType()); $apiInstance->addFlow(         $process->getData()->getId(),         new FlowCreateItem([             'data' => new Flow(['attributes' => $flowAttr])         ])     );  /_** @var FlowAttributes $flowAttr *_/ $flowAttr= new FlowAttributes(); $flowAttr->setName('Flow FirstDirection with Inclusive Gateway'); $flowAttr->setType('SEQUENTIAL'); $flowAttr->setProcessId($process->getData()->getId()); $flowAttr->setFromObjectId($firstDirectTask->getData()->getId()); $flowAttr->setFromObjectType($firstDirectTask->getData()->getType()); $flowAttr->setToObjectId($inclusiveGateway->getData()->getId()); $flowAttr->setToObjectType($inclusiveGateway->getData()->getType()); $apiInstance->addFlow(         $process->getData()->getId(),         new FlowCreateItem([             'data' => new Flow(['attributes' => $flowAttr])         ])     );  /_** @var FlowAttributes $flowAttr *_/ $flowAttr= new FlowAttributes(); $flowAttr->setName('Flow SecondDirection with Inclusive Gateway'); $flowAttr->setType('SEQUENTIAL'); $flowAttr->setProcessId($process->getData()->getId()); $flowAttr->setFromObjectId($secondDirectTask->getData()->getId()); $flowAttr->setFromObjectType($secondDirectTask->getData()->getType()); $flowAttr->setToObjectId($inclusiveGateway->getData()->getId()); $flowAttr->setToObjectType($inclusiveGateway->getData()->getType()); $apiInstance->addFlow(         $process->getData()->getId(),         new FlowCreateItem([            'data' => new Flow(['attributes' => $flowAttr])         ])     );  /_** @var FlowAttributes $flowAttr *_/ $flowAttr= new FlowAttributes(); $flowAttr->setName('Flow Inclusive Gateway with end Event'); $flowAttr->setType('SEQUENTIAL'); $flowAttr->setProcessId($process->getData()->getId()); $flowAttr->setFromObjectId($inclusiveGateway->getData()->getId()); $flowAttr->setFromObjectType($inclusiveGateway->getData()->getType()); $flowAttr->setToObjectId($endEvent->getData()->getId()); $flowAttr->setToObjectType($endEvent->getData()->getType()); $apiInstance->addFlow(        $process->getData()->getId(),        new FlowCreateItem([             'data' => new Flow(['attributes' => $flowAttr])        ])    );  ```  ### Create two SEQUENTIAL flows with conditions  ![SEQUENTIAL Flow with condition](php-sdk-usage/images/conditional_flow1.png \"SEQUENTIAL Flow with condition\")  ```php  /_** @var FlowAttributes $flowAttr *_/ $flowAttr= new FlowAttributes(); $flowAttr->setName('Flow Exclusive Gateway with First direction'); $flowAttr->setType('SEQUENTIAL'); $flowAttr->setProcessId($process->getData()->getId()); $flowAttr->setFromObjectId($exclusiveGateway->getData()->getId()); $flowAttr->setFromObjectType($exclusiveGateway->getData()->getType()); $flowAttr->setToObjectId($firstDirectTask->getData()->getId()); $flowAttr->setToObjectType($firstDirectTask->getData()->getType()); $flowAttr->setCondition('direction=1'); $apiInstance->addFlow(        $process->getData()->getId(),        new FlowCreateItem([             'data' => new Flow(['attributes' => $flowAttr])        ])    );  ```  ![SEQUENTIAL Flow with condition](php-sdk-usage/images/conditional_flow2.png \"SEQUENTIAL Flow with condition\")   ```php /_** @var FlowAttributes $flowAttr *_/ $flowAttr= new FlowAttributes(); $flowAttr->setName('Flow Exclusive Gateway with Second direction'); $flowAttr->setType('SEQUENTIAL'); $flowAttr->setProcessId($process->getData()->getId()); $flowAttr->setFromObjectId($exclusiveGateway->getData()->getId()); $flowAttr->setFromObjectType($exclusiveGateway->getData()->getType()); $flowAttr->setToObjectId($secondDirectTask->getData()->getId()); $flowAttr->setToObjectType($secondDirectTask->getData()->getType()); $flowAttr->setCondition('direction=2'); $apiInstance->addFlow(         $process->getData()->getId(),         new FlowCreateItem([             'data' => new Flow(['attributes' => $flowAttr])         ])     );  ```  ### Run Process with random data - `['direction' => rand(1,2)]` in  Data model  ```php /_** @var array $arrayContent *_/ $arrayContent = ['direction' => rand(1,2)]; /_** @var DataModelAttributes $dataModelAttr *_/ $dataModelAttr = new DataModelAttributes(); $dataModelAttr->setContent(json_encode($arrayContent)); /_** @var DataModelItem $result *_/ $result = $apiInstance->eventTrigger(     $process->getData()->getId(),     $startEvent->getData()->getId(),     new TriggerEventCreateItem(         [             'data' => new DataModel(['attributes' => $dataModelAttr])         ]     ) );  ```  As result engine will run **Process** and creates **Process instance** and lead it through **Process** and finishes with status **COMPLETE**, which can be retrieved: ```php /_** @var InstanceCollection $instances *_/ $instances = $apiInstance->findInstances($process->getData()->getId());  ``` Direction of our **Process instance** will be showed in **Data model** :  ```php $apiInstance->findDataModel(             $process->getData()->getId(),             $instances->getData()[0]->getId()         );  ``` Inside **Data model** you can find array with `['First_Direction'] = 1` or  `['Second_Direction'] = 2` depending on data, that have been passed to **Start event** trigger.  # Cross-Origin Resource Sharing Processmaker I/O API features Cross-Origin Resource Sharing (CORS) implemented in compliance with  [W3C spec](https://www.w3.org/TR/cors/). And that allows cross-domain communication from the browser. All responses have a wildcard same-origin which makes them completely public and accessible to everyone, including any code on any site. # Authentication Processmaker I/O API use the OAuth 2.0 protocol to give your app authorized access.  OAuth is an open standard that provides client apps with secure delegated access to server resources on behalf of a resource owner. It does this by allowing access tokens to be issued to third-party clients by an authorization server, with the approval of the resource owner. The client then uses the access token to access the protected resources hosted by the resource server. The user's privacy is protected # Extensions  ## InputOutput  #### Description  This extension lets you use different types of parameters for the chosen BPMN element.  #### BPMN XML  ```yaml &lt;bpmn:extensionElements&gt;   &lt;pmio:inputOutput&gt;     &lt;pmio:inputParameter name=\"channel\"&gt;@{user_name}&lt;/pmio:inputParameter&gt;     &lt;pmio:inputParameter name=\"token\"&gt;{bot_token}&lt;/pmio:inputParameter&gt;     &lt;pmio:outputParameter name=\"username\" /&gt;   &lt;/pmio:inputOutput&gt; &lt;/bpmn:extensionElements&gt; ```  #### Parameters  InputParameter name   outputParameter name  #### Elements  Start Event   intermediateCatchEvent   intermediateThrowEvent   ## Connector  #### Description  This is set of configurations for the connectors.  #### BPMN XML  ```yaml &lt;bpmn:extensionElements&gt;   &lt;pmio:connector&gt;  &lt;pmio:connectorId&gt;CorrelationKeys&lt;/pmio:connectorId&gt;   &lt;/pmio:connector&gt; &lt;/bpmn:extensionElements&gt; ```  #### Parameters  InputParameter name   outputParameter name  #### Elements  Start Event   ## Field  #### Description  This extension lets you inject string value to the fields of the delegated classes.  #### BPMN XML  ```yaml &lt;bpmn:extensionElements&gt;   &lt;pmio:field name=\"AppNumber\"&gt;     &lt;pmio:string&gt;@{AppNumber}&lt;/pmio:string&gt;   &lt;/pmio:field&gt; &lt;/bpmn:extensionElements&gt; ```  #### Parameters  Field name   String  #### Elements  intermediateThrowEvent   ## Properties  #### Description  A list of properties and values that can be interpreted by the engine without any restriction.  #### BPMN XML  ```yaml &lt;bpmn:extensionElements&gt;   &lt;pmio:properties&gt;     &lt;pmio:property /&gt;   &lt;/pmio:properties&gt; &lt;/bpmn:extensionElements&gt; ```  #### Parameters  Property   #### Elements  Start Event  <!-- ReDoc-Inject: <security-definitions> -->

This PHP package is automatically generated by the [Swagger Codegen](https://github.com/swagger-api/swagger-codegen) project:

- API version: 1.0.0
- Package version: 1.0.0
- Build date: 2017-08-14T15:13:34.274+03:00
- Build package: class io.swagger.codegen.languages.PhpClientCodegen
For more information, please visit [https://www.processmaker.io/](https://www.processmaker.io/)

## Requirements

PHP 5.4.0 and later

## Installation & Usage
### Composer

To install the bindings via [Composer](http://getcomposer.org/), add the following to `composer.json`:

```
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/ProcessMaker/pmio-sdk-php.git"
    }
  ],
  "require": {
    "ProcessMaker/pmio-sdk-php": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
    require_once('/path/to/pmio-sdk-php/autoload.php');
```

## Tests

To run the unit tests:

```
composer install
./vendor/bin/phpunit lib/Tests
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of the process related to the event
$event_create_item = new \ProcessMaker\PMIO\Model\EventCreateItem(); // \ProcessMaker\PMIO\Model\EventCreateItem | JSON API response with the Event object to add

try {
    $result = $api_instance->addEvent($process_id, $event_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->addEvent: ', $e->getMessage(), PHP_EOL;
}

?>
```

## Documentation for API Endpoints

All URIs are relative to *https://CHANGEME.api.processmaker.io/api/v1*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*Client* | [**addEvent**](docs/Api/Client.md#addevent) | **POST** /processes/{process_id}/events | 
*Client* | [**addEventConnector**](docs/Api/Client.md#addeventconnector) | **POST** /processes/{process_id}/events/{event_id}/connectors | 
*Client* | [**addFlow**](docs/Api/Client.md#addflow) | **POST** /processes/{process_id}/flows | 
*Client* | [**addGateway**](docs/Api/Client.md#addgateway) | **POST** /processes/{process_id}/gateways | 
*Client* | [**addGroup**](docs/Api/Client.md#addgroup) | **POST** /groups | 
*Client* | [**addGroupsToTask**](docs/Api/Client.md#addgroupstotask) | **PUT** /processes/{process_id}/tasks/{task_id}/groups | 
*Client* | [**addInputOutput**](docs/Api/Client.md#addinputoutput) | **POST** /processes/{process_id}/tasks/{task_id}/inputoutput | 
*Client* | [**addInstance**](docs/Api/Client.md#addinstance) | **POST** /processes/{process_id}/instances | 
*Client* | [**addOauthClient**](docs/Api/Client.md#addoauthclient) | **POST** /users/{user_id}/clients | 
*Client* | [**addProcess**](docs/Api/Client.md#addprocess) | **POST** /processes | 
*Client* | [**addTask**](docs/Api/Client.md#addtask) | **POST** /processes/{process_id}/tasks | 
*Client* | [**addTaskConnector**](docs/Api/Client.md#addtaskconnector) | **POST** /processes/{process_id}/tasks/{task_id}/connectors | 
*Client* | [**addUser**](docs/Api/Client.md#adduser) | **POST** /users | 
*Client* | [**addUsersToGroup**](docs/Api/Client.md#adduserstogroup) | **PUT** /groups/{id}/users | 
*Client* | [**deleteEvent**](docs/Api/Client.md#deleteevent) | **DELETE** /processes/{process_id}/events/{event_id} | 
*Client* | [**deleteEventConnector**](docs/Api/Client.md#deleteeventconnector) | **DELETE** /processes/{process_id}/events/{event_id}/connectors/{connector_id} | 
*Client* | [**deleteFlow**](docs/Api/Client.md#deleteflow) | **DELETE** /processes/{process_id}/flows/{flow_id} | 
*Client* | [**deleteGateway**](docs/Api/Client.md#deletegateway) | **DELETE** /processes/{process_id}/gateways/{gateway_id} | 
*Client* | [**deleteGroup**](docs/Api/Client.md#deletegroup) | **DELETE** /groups/{id} | 
*Client* | [**deleteInputOutput**](docs/Api/Client.md#deleteinputoutput) | **DELETE** /processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid} | 
*Client* | [**deleteInstance**](docs/Api/Client.md#deleteinstance) | **DELETE** /processes/{process_id}/instances/{instance_id} | 
*Client* | [**deleteOauthClient**](docs/Api/Client.md#deleteoauthclient) | **DELETE** /users/{user_id}/clients/{client_id} | 
*Client* | [**deleteProcess**](docs/Api/Client.md#deleteprocess) | **DELETE** /processes/{id} | 
*Client* | [**deleteTask**](docs/Api/Client.md#deletetask) | **DELETE** /processes/{process_id}/tasks/{task_id} | 
*Client* | [**deleteTaskConnector**](docs/Api/Client.md#deletetaskconnector) | **DELETE** /processes/{process_id}/tasks/{task_id}/connectors/{connector_id} | 
*Client* | [**deleteUser**](docs/Api/Client.md#deleteuser) | **DELETE** /users/{id} | 
*Client* | [**eventTrigger**](docs/Api/Client.md#eventtrigger) | **POST** /processes/{process_id}/events/{event_id}/trigger | 
*Client* | [**eventWebhook**](docs/Api/Client.md#eventwebhook) | **POST** /processes/{process_id}/events/{event_id}/webhook | 
*Client* | [**findByFieldInsideDataModel**](docs/Api/Client.md#findbyfieldinsidedatamodel) | **GET** /processes/{process_id}/datamodels/search/{search_param} | 
*Client* | [**findDataModel**](docs/Api/Client.md#finddatamodel) | **GET** /processes/{process_id}/instances/{instance_id}/datamodel | 
*Client* | [**findEventById**](docs/Api/Client.md#findeventbyid) | **GET** /processes/{process_id}/events/{event_id} | 
*Client* | [**findEventConnectorById**](docs/Api/Client.md#findeventconnectorbyid) | **GET** /processes/{process_id}/events/{event_id}/connectors/{connector_id} | 
*Client* | [**findEventConnectors**](docs/Api/Client.md#findeventconnectors) | **GET** /processes/{process_id}/events/{event_id}/connectors | 
*Client* | [**findEvents**](docs/Api/Client.md#findevents) | **GET** /processes/{process_id}/events | 
*Client* | [**findFlowById**](docs/Api/Client.md#findflowbyid) | **GET** /processes/{process_id}/flows/{flow_id} | 
*Client* | [**findFlows**](docs/Api/Client.md#findflows) | **GET** /processes/{process_id}/flows | 
*Client* | [**findGatewayById**](docs/Api/Client.md#findgatewaybyid) | **GET** /processes/{process_id}/gateways/{gateway_id} | 
*Client* | [**findGateways**](docs/Api/Client.md#findgateways) | **GET** /processes/{process_id}/gateways | 
*Client* | [**findGroupById**](docs/Api/Client.md#findgroupbyid) | **GET** /groups/{id} | 
*Client* | [**findGroups**](docs/Api/Client.md#findgroups) | **GET** /groups | 
*Client* | [**findInputOutputById**](docs/Api/Client.md#findinputoutputbyid) | **GET** /processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid} | 
*Client* | [**findInputOutputs**](docs/Api/Client.md#findinputoutputs) | **GET** /processes/{process_id}/tasks/{task_id}/inputoutput | 
*Client* | [**findInstanceById**](docs/Api/Client.md#findinstancebyid) | **GET** /processes/{process_id}/instances/{instance_id} | 
*Client* | [**findInstances**](docs/Api/Client.md#findinstances) | **GET** /processes/{process_id}/instances | 
*Client* | [**findOauthClientById**](docs/Api/Client.md#findoauthclientbyid) | **GET** /users/{user_id}/clients/{client_id} | 
*Client* | [**findOauthClients**](docs/Api/Client.md#findoauthclients) | **GET** /users/{user_id}/clients | 
*Client* | [**findProcessById**](docs/Api/Client.md#findprocessbyid) | **GET** /processes/{id} | 
*Client* | [**findProcesses**](docs/Api/Client.md#findprocesses) | **GET** /processes | 
*Client* | [**findTaskById**](docs/Api/Client.md#findtaskbyid) | **GET** /processes/{process_id}/tasks/{task_id} | 
*Client* | [**findTaskConnectorById**](docs/Api/Client.md#findtaskconnectorbyid) | **GET** /processes/{process_id}/tasks/{task_id}/connectors/{connector_id} | 
*Client* | [**findTaskConnectors**](docs/Api/Client.md#findtaskconnectors) | **GET** /processes/{process_id}/tasks/{task_id}/connectors | 
*Client* | [**findTaskInstanceById**](docs/Api/Client.md#findtaskinstancebyid) | **GET** /task_instances/{task_instance_id} | 
*Client* | [**findTaskInstances**](docs/Api/Client.md#findtaskinstances) | **GET** /task_instances | 
*Client* | [**findTaskInstancesByInstanceAndTaskId**](docs/Api/Client.md#findtaskinstancesbyinstanceandtaskid) | **GET** /instances/{instance_id}/tasks/{task_id}/task_instances | 
*Client* | [**findTaskInstancesByInstanceAndTaskIdDelegated**](docs/Api/Client.md#findtaskinstancesbyinstanceandtaskiddelegated) | **GET** /instances/{instance_id}/tasks/{task_id}/task_instances/delegated | 
*Client* | [**findTaskInstancesByInstanceAndTaskIdStarted**](docs/Api/Client.md#findtaskinstancesbyinstanceandtaskidstarted) | **GET** /instances/{instance_id}/tasks/{task_id}/task_instances/started | 
*Client* | [**findTasks**](docs/Api/Client.md#findtasks) | **GET** /processes/{process_id}/tasks | 
*Client* | [**findUserById**](docs/Api/Client.md#finduserbyid) | **GET** /users/{id} | 
*Client* | [**findUsers**](docs/Api/Client.md#findusers) | **GET** /users | 
*Client* | [**importBpmnFile**](docs/Api/Client.md#importbpmnfile) | **POST** /processes/import | 
*Client* | [**myselfUser**](docs/Api/Client.md#myselfuser) | **GET** /users/myself | 
*Client* | [**removeGroupsFromTask**](docs/Api/Client.md#removegroupsfromtask) | **DELETE** /processes/{process_id}/tasks/{task_id}/groups | 
*Client* | [**removeUsersFromGroup**](docs/Api/Client.md#removeusersfromgroup) | **DELETE** /groups/{id}/users | 
*Client* | [**syncGroupsToTask**](docs/Api/Client.md#syncgroupstotask) | **POST** /processes/{process_id}/tasks/{task_id}/groups | 
*Client* | [**syncUsersToGroup**](docs/Api/Client.md#syncuserstogroup) | **POST** /groups/{id}/users | 
*Client* | [**updateEvent**](docs/Api/Client.md#updateevent) | **PUT** /processes/{process_id}/events/{event_id} | 
*Client* | [**updateEventConnector**](docs/Api/Client.md#updateeventconnector) | **PUT** /processes/{process_id}/events/{event_id}/connectors/{connector_id} | 
*Client* | [**updateFlow**](docs/Api/Client.md#updateflow) | **PUT** /processes/{process_id}/flows/{flow_id} | 
*Client* | [**updateGateway**](docs/Api/Client.md#updategateway) | **PUT** /processes/{process_id}/gateways/{gateway_id} | 
*Client* | [**updateGroup**](docs/Api/Client.md#updategroup) | **PUT** /groups/{id} | 
*Client* | [**updateInputOutput**](docs/Api/Client.md#updateinputoutput) | **PUT** /processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid} | 
*Client* | [**updateInstance**](docs/Api/Client.md#updateinstance) | **PUT** /processes/{process_id}/instances/{instance_id} | 
*Client* | [**updateOauthClient**](docs/Api/Client.md#updateoauthclient) | **PUT** /users/{user_id}/clients/{client_id} | 
*Client* | [**updateProcess**](docs/Api/Client.md#updateprocess) | **PUT** /processes/{id} | 
*Client* | [**updateTask**](docs/Api/Client.md#updatetask) | **PUT** /processes/{process_id}/tasks/{task_id} | 
*Client* | [**updateTaskConnector**](docs/Api/Client.md#updatetaskconnector) | **PUT** /processes/{process_id}/tasks/{task_id}/connectors/{connector_id} | 
*Client* | [**updateTaskInstance**](docs/Api/Client.md#updatetaskinstance) | **PATCH** /task_instances/{task_instance_id} | 
*Client* | [**updateUser**](docs/Api/Client.md#updateuser) | **PUT** /users/{id} | 
*Events* | [**addEvent**](docs/Api/Events.md#addevent) | **POST** /processes/{process_id}/events | 
*Events* | [**addEventConnector**](docs/Api/Events.md#addeventconnector) | **POST** /processes/{process_id}/events/{event_id}/connectors | 
*Events* | [**deleteEvent**](docs/Api/Events.md#deleteevent) | **DELETE** /processes/{process_id}/events/{event_id} | 
*Events* | [**deleteEventConnector**](docs/Api/Events.md#deleteeventconnector) | **DELETE** /processes/{process_id}/events/{event_id}/connectors/{connector_id} | 
*Events* | [**eventTrigger**](docs/Api/Events.md#eventtrigger) | **POST** /processes/{process_id}/events/{event_id}/trigger | 
*Events* | [**eventWebhook**](docs/Api/Events.md#eventwebhook) | **POST** /processes/{process_id}/events/{event_id}/webhook | 
*Events* | [**findEventById**](docs/Api/Events.md#findeventbyid) | **GET** /processes/{process_id}/events/{event_id} | 
*Events* | [**findEventConnectorById**](docs/Api/Events.md#findeventconnectorbyid) | **GET** /processes/{process_id}/events/{event_id}/connectors/{connector_id} | 
*Events* | [**findEventConnectors**](docs/Api/Events.md#findeventconnectors) | **GET** /processes/{process_id}/events/{event_id}/connectors | 
*Events* | [**findEvents**](docs/Api/Events.md#findevents) | **GET** /processes/{process_id}/events | 
*Events* | [**updateEvent**](docs/Api/Events.md#updateevent) | **PUT** /processes/{process_id}/events/{event_id} | 
*Events* | [**updateEventConnector**](docs/Api/Events.md#updateeventconnector) | **PUT** /processes/{process_id}/events/{event_id}/connectors/{connector_id} | 
*Flows* | [**addFlow**](docs/Api/Flows.md#addflow) | **POST** /processes/{process_id}/flows | 
*Flows* | [**deleteFlow**](docs/Api/Flows.md#deleteflow) | **DELETE** /processes/{process_id}/flows/{flow_id} | 
*Flows* | [**findFlowById**](docs/Api/Flows.md#findflowbyid) | **GET** /processes/{process_id}/flows/{flow_id} | 
*Flows* | [**findFlows**](docs/Api/Flows.md#findflows) | **GET** /processes/{process_id}/flows | 
*Flows* | [**updateFlow**](docs/Api/Flows.md#updateflow) | **PUT** /processes/{process_id}/flows/{flow_id} | 
*Gateways* | [**addGateway**](docs/Api/Gateways.md#addgateway) | **POST** /processes/{process_id}/gateways | 
*Gateways* | [**deleteGateway**](docs/Api/Gateways.md#deletegateway) | **DELETE** /processes/{process_id}/gateways/{gateway_id} | 
*Gateways* | [**findGatewayById**](docs/Api/Gateways.md#findgatewaybyid) | **GET** /processes/{process_id}/gateways/{gateway_id} | 
*Gateways* | [**findGateways**](docs/Api/Gateways.md#findgateways) | **GET** /processes/{process_id}/gateways | 
*Gateways* | [**updateGateway**](docs/Api/Gateways.md#updategateway) | **PUT** /processes/{process_id}/gateways/{gateway_id} | 
*Groups* | [**addGroup**](docs/Api/Groups.md#addgroup) | **POST** /groups | 
*Groups* | [**addUsersToGroup**](docs/Api/Groups.md#adduserstogroup) | **PUT** /groups/{id}/users | 
*Groups* | [**deleteGroup**](docs/Api/Groups.md#deletegroup) | **DELETE** /groups/{id} | 
*Groups* | [**findGroupById**](docs/Api/Groups.md#findgroupbyid) | **GET** /groups/{id} | 
*Groups* | [**findGroups**](docs/Api/Groups.md#findgroups) | **GET** /groups | 
*Groups* | [**removeUsersFromGroup**](docs/Api/Groups.md#removeusersfromgroup) | **DELETE** /groups/{id}/users | 
*Groups* | [**syncUsersToGroup**](docs/Api/Groups.md#syncuserstogroup) | **POST** /groups/{id}/users | 
*Groups* | [**updateGroup**](docs/Api/Groups.md#updategroup) | **PUT** /groups/{id} | 
*Inputoutput* | [**addInputOutput**](docs/Api/Inputoutput.md#addinputoutput) | **POST** /processes/{process_id}/tasks/{task_id}/inputoutput | 
*Inputoutput* | [**deleteInputOutput**](docs/Api/Inputoutput.md#deleteinputoutput) | **DELETE** /processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid} | 
*Inputoutput* | [**findInputOutputById**](docs/Api/Inputoutput.md#findinputoutputbyid) | **GET** /processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid} | 
*Inputoutput* | [**findInputOutputs**](docs/Api/Inputoutput.md#findinputoutputs) | **GET** /processes/{process_id}/tasks/{task_id}/inputoutput | 
*Inputoutput* | [**updateInputOutput**](docs/Api/Inputoutput.md#updateinputoutput) | **PUT** /processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid} | 
*Oauth* | [**addOauthClient**](docs/Api/Oauth.md#addoauthclient) | **POST** /users/{user_id}/clients | 
*Oauth* | [**findOauthClientById**](docs/Api/Oauth.md#findoauthclientbyid) | **GET** /users/{user_id}/clients/{client_id} | 
*Oauth* | [**findOauthClients**](docs/Api/Oauth.md#findoauthclients) | **GET** /users/{user_id}/clients | 
*ProcessInstances* | [**addInstance**](docs/Api/ProcessInstances.md#addinstance) | **POST** /processes/{process_id}/instances | 
*ProcessInstances* | [**deleteInstance**](docs/Api/ProcessInstances.md#deleteinstance) | **DELETE** /processes/{process_id}/instances/{instance_id} | 
*ProcessInstances* | [**findByFieldInsideDataModel**](docs/Api/ProcessInstances.md#findbyfieldinsidedatamodel) | **GET** /processes/{process_id}/datamodels/search/{search_param} | 
*ProcessInstances* | [**findDataModel**](docs/Api/ProcessInstances.md#finddatamodel) | **GET** /processes/{process_id}/instances/{instance_id}/datamodel | 
*ProcessInstances* | [**findInstanceById**](docs/Api/ProcessInstances.md#findinstancebyid) | **GET** /processes/{process_id}/instances/{instance_id} | 
*ProcessInstances* | [**findInstances**](docs/Api/ProcessInstances.md#findinstances) | **GET** /processes/{process_id}/instances | 
*ProcessInstances* | [**findTaskInstancesByInstanceAndTaskId**](docs/Api/ProcessInstances.md#findtaskinstancesbyinstanceandtaskid) | **GET** /instances/{instance_id}/tasks/{task_id}/task_instances | 
*ProcessInstances* | [**findTaskInstancesByInstanceAndTaskIdDelegated**](docs/Api/ProcessInstances.md#findtaskinstancesbyinstanceandtaskiddelegated) | **GET** /instances/{instance_id}/tasks/{task_id}/task_instances/delegated | 
*ProcessInstances* | [**findTaskInstancesByInstanceAndTaskIdStarted**](docs/Api/ProcessInstances.md#findtaskinstancesbyinstanceandtaskidstarted) | **GET** /instances/{instance_id}/tasks/{task_id}/task_instances/started | 
*ProcessInstances* | [**updateInstance**](docs/Api/ProcessInstances.md#updateinstance) | **PUT** /processes/{process_id}/instances/{instance_id} | 
*Processes* | [**addProcess**](docs/Api/Processes.md#addprocess) | **POST** /processes | 
*Processes* | [**deleteProcess**](docs/Api/Processes.md#deleteprocess) | **DELETE** /processes/{id} | 
*Processes* | [**findProcessById**](docs/Api/Processes.md#findprocessbyid) | **GET** /processes/{id} | 
*Processes* | [**findProcesses**](docs/Api/Processes.md#findprocesses) | **GET** /processes | 
*Processes* | [**importBpmnFile**](docs/Api/Processes.md#importbpmnfile) | **POST** /processes/import | 
*Processes* | [**updateProcess**](docs/Api/Processes.md#updateprocess) | **PUT** /processes/{id} | 
*Tasks* | [**addGroupsToTask**](docs/Api/Tasks.md#addgroupstotask) | **PUT** /processes/{process_id}/tasks/{task_id}/groups | 
*Tasks* | [**addTask**](docs/Api/Tasks.md#addtask) | **POST** /processes/{process_id}/tasks | 
*Tasks* | [**addTaskConnector**](docs/Api/Tasks.md#addtaskconnector) | **POST** /processes/{process_id}/tasks/{task_id}/connectors | 
*Tasks* | [**deleteTask**](docs/Api/Tasks.md#deletetask) | **DELETE** /processes/{process_id}/tasks/{task_id} | 
*Tasks* | [**deleteTaskConnector**](docs/Api/Tasks.md#deletetaskconnector) | **DELETE** /processes/{process_id}/tasks/{task_id}/connectors/{connector_id} | 
*Tasks* | [**findTaskById**](docs/Api/Tasks.md#findtaskbyid) | **GET** /processes/{process_id}/tasks/{task_id} | 
*Tasks* | [**findTaskConnectorById**](docs/Api/Tasks.md#findtaskconnectorbyid) | **GET** /processes/{process_id}/tasks/{task_id}/connectors/{connector_id} | 
*Tasks* | [**findTaskConnectors**](docs/Api/Tasks.md#findtaskconnectors) | **GET** /processes/{process_id}/tasks/{task_id}/connectors | 
*Tasks* | [**findTaskInstanceById**](docs/Api/Tasks.md#findtaskinstancebyid) | **GET** /task_instances/{task_instance_id} | 
*Tasks* | [**findTaskInstances**](docs/Api/Tasks.md#findtaskinstances) | **GET** /task_instances | 
*Tasks* | [**findTasks**](docs/Api/Tasks.md#findtasks) | **GET** /processes/{process_id}/tasks | 
*Tasks* | [**removeGroupsFromTask**](docs/Api/Tasks.md#removegroupsfromtask) | **DELETE** /processes/{process_id}/tasks/{task_id}/groups | 
*Tasks* | [**syncGroupsToTask**](docs/Api/Tasks.md#syncgroupstotask) | **POST** /processes/{process_id}/tasks/{task_id}/groups | 
*Tasks* | [**updateTask**](docs/Api/Tasks.md#updatetask) | **PUT** /processes/{process_id}/tasks/{task_id} | 
*Tasks* | [**updateTaskConnector**](docs/Api/Tasks.md#updatetaskconnector) | **PUT** /processes/{process_id}/tasks/{task_id}/connectors/{connector_id} | 
*Tasks* | [**updateTaskInstance**](docs/Api/Tasks.md#updatetaskinstance) | **PATCH** /task_instances/{task_instance_id} | 
*Users* | [**addUser**](docs/Api/Users.md#adduser) | **POST** /users | 
*Users* | [**deleteUser**](docs/Api/Users.md#deleteuser) | **DELETE** /users/{id} | 
*Users* | [**findUserById**](docs/Api/Users.md#finduserbyid) | **GET** /users/{id} | 
*Users* | [**findUsers**](docs/Api/Users.md#findusers) | **GET** /users | 
*Users* | [**myselfUser**](docs/Api/Users.md#myselfuser) | **GET** /users/myself | 
*Users* | [**updateUser**](docs/Api/Users.md#updateuser) | **PUT** /users/{id} | 


## Documentation For Models

 - [BpmnFile](docs/Model/BpmnFile.md)
 - [BpmnFileAttributes](docs/Model/BpmnFileAttributes.md)
 - [BpmnImportItem](docs/Model/BpmnImportItem.md)
 - [DataModel](docs/Model/DataModel.md)
 - [DataModelAttributes](docs/Model/DataModelAttributes.md)
 - [DataModelCollection](docs/Model/DataModelCollection.md)
 - [DataModelItem](docs/Model/DataModelItem.md)
 - [DataModelItem1](docs/Model/DataModelItem1.md)
 - [DataModelItemAttributes](docs/Model/DataModelItemAttributes.md)
 - [Error](docs/Model/Error.md)
 - [ErrorArray](docs/Model/ErrorArray.md)
 - [Event](docs/Model/Event.md)
 - [EventAttributes](docs/Model/EventAttributes.md)
 - [EventCollection](docs/Model/EventCollection.md)
 - [EventConnector](docs/Model/EventConnector.md)
 - [EventConnector1](docs/Model/EventConnector1.md)
 - [EventConnectorAttributes](docs/Model/EventConnectorAttributes.md)
 - [EventConnectorCreateItem](docs/Model/EventConnectorCreateItem.md)
 - [EventConnectorUpdateItem](docs/Model/EventConnectorUpdateItem.md)
 - [EventConnectorsCollection](docs/Model/EventConnectorsCollection.md)
 - [EventCreateItem](docs/Model/EventCreateItem.md)
 - [EventItem](docs/Model/EventItem.md)
 - [EventUpdateItem](docs/Model/EventUpdateItem.md)
 - [Flow](docs/Model/Flow.md)
 - [FlowAttributes](docs/Model/FlowAttributes.md)
 - [FlowCollection](docs/Model/FlowCollection.md)
 - [FlowCreateItem](docs/Model/FlowCreateItem.md)
 - [FlowItem](docs/Model/FlowItem.md)
 - [FlowUpdateItem](docs/Model/FlowUpdateItem.md)
 - [Gateway](docs/Model/Gateway.md)
 - [GatewayAttributes](docs/Model/GatewayAttributes.md)
 - [GatewayCollection](docs/Model/GatewayCollection.md)
 - [GatewayCreateItem](docs/Model/GatewayCreateItem.md)
 - [GatewayItem](docs/Model/GatewayItem.md)
 - [GatewayUpdateItem](docs/Model/GatewayUpdateItem.md)
 - [Group](docs/Model/Group.md)
 - [GroupAddUsersItem](docs/Model/GroupAddUsersItem.md)
 - [GroupAttributes](docs/Model/GroupAttributes.md)
 - [GroupCollection](docs/Model/GroupCollection.md)
 - [GroupCreateItem](docs/Model/GroupCreateItem.md)
 - [GroupIds](docs/Model/GroupIds.md)
 - [GroupItem](docs/Model/GroupItem.md)
 - [GroupRemoveUsersItem](docs/Model/GroupRemoveUsersItem.md)
 - [GroupSyncUsersItem](docs/Model/GroupSyncUsersItem.md)
 - [GroupUpdateItem](docs/Model/GroupUpdateItem.md)
 - [InlineResponse200](docs/Model/InlineResponse200.md)
 - [InputOutput](docs/Model/InputOutput.md)
 - [InputOutputAttributes](docs/Model/InputOutputAttributes.md)
 - [InputOutputCollection](docs/Model/InputOutputCollection.md)
 - [InputOutputCreateItem](docs/Model/InputOutputCreateItem.md)
 - [InputOutputItem](docs/Model/InputOutputItem.md)
 - [InputOutputUpdateItem](docs/Model/InputOutputUpdateItem.md)
 - [Instance](docs/Model/Instance.md)
 - [InstanceAttributes](docs/Model/InstanceAttributes.md)
 - [InstanceCollection](docs/Model/InstanceCollection.md)
 - [InstanceCreateItem](docs/Model/InstanceCreateItem.md)
 - [InstanceItem](docs/Model/InstanceItem.md)
 - [InstanceUpdateItem](docs/Model/InstanceUpdateItem.md)
 - [Meta](docs/Model/Meta.md)
 - [MetaLog](docs/Model/MetaLog.md)
 - [OauthClient](docs/Model/OauthClient.md)
 - [OauthClientAttributes](docs/Model/OauthClientAttributes.md)
 - [OauthClientCollection](docs/Model/OauthClientCollection.md)
 - [OauthClientCreateItem](docs/Model/OauthClientCreateItem.md)
 - [OauthClientItem](docs/Model/OauthClientItem.md)
 - [OauthClientUpdateItem](docs/Model/OauthClientUpdateItem.md)
 - [Pagination](docs/Model/Pagination.md)
 - [PaginationLinks](docs/Model/PaginationLinks.md)
 - [Process](docs/Model/Process.md)
 - [ProcessAttributes](docs/Model/ProcessAttributes.md)
 - [ProcessCollection](docs/Model/ProcessCollection.md)
 - [ProcessCollection1](docs/Model/ProcessCollection1.md)
 - [ProcessCreateItem](docs/Model/ProcessCreateItem.md)
 - [ProcessItem](docs/Model/ProcessItem.md)
 - [ProcessUpdateItem](docs/Model/ProcessUpdateItem.md)
 - [ResultSuccess](docs/Model/ResultSuccess.md)
 - [ResultSuccessMeta](docs/Model/ResultSuccessMeta.md)
 - [Task](docs/Model/Task.md)
 - [TaskAddGroupsItem](docs/Model/TaskAddGroupsItem.md)
 - [TaskAttributes](docs/Model/TaskAttributes.md)
 - [TaskCollection](docs/Model/TaskCollection.md)
 - [TaskConnector](docs/Model/TaskConnector.md)
 - [TaskConnector1](docs/Model/TaskConnector1.md)
 - [TaskConnectorAttributes](docs/Model/TaskConnectorAttributes.md)
 - [TaskConnectorCreateItem](docs/Model/TaskConnectorCreateItem.md)
 - [TaskConnectorUpdateItem](docs/Model/TaskConnectorUpdateItem.md)
 - [TaskConnectorsCollection](docs/Model/TaskConnectorsCollection.md)
 - [TaskCreateItem](docs/Model/TaskCreateItem.md)
 - [TaskInstance](docs/Model/TaskInstance.md)
 - [TaskInstanceAttributes](docs/Model/TaskInstanceAttributes.md)
 - [TaskInstanceCollection](docs/Model/TaskInstanceCollection.md)
 - [TaskInstanceUpdateItem](docs/Model/TaskInstanceUpdateItem.md)
 - [TaskItem](docs/Model/TaskItem.md)
 - [TaskRemoveGroupsItem](docs/Model/TaskRemoveGroupsItem.md)
 - [TaskSyncGroupsItem](docs/Model/TaskSyncGroupsItem.md)
 - [TaskUpdateItem](docs/Model/TaskUpdateItem.md)
 - [TriggerEventCreateItem](docs/Model/TriggerEventCreateItem.md)
 - [User](docs/Model/User.md)
 - [UserAttributes](docs/Model/UserAttributes.md)
 - [UserCollection](docs/Model/UserCollection.md)
 - [UserCreateItem](docs/Model/UserCreateItem.md)
 - [UserIds](docs/Model/UserIds.md)
 - [UserItem](docs/Model/UserItem.md)
 - [UserUpdateItem](docs/Model/UserUpdateItem.md)


## Documentation For Authorization


## PasswordGrant

- **Type**: OAuth
- **Flow**: password
- **Authorization URL**: /oauth/access_token
- **Scopes**: N/A


## Author

support@processmaker.io


