# ProcessMaker\PMIO\Client

All URIs are relative to *https://CHANGEME.api.processmaker.io/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addEvent**](Client.md#addEvent) | **POST** /processes/{process_id}/events | 
[**addEventConnector**](Client.md#addEventConnector) | **POST** /processes/{process_id}/events/{event_id}/connectors | 
[**addFlow**](Client.md#addFlow) | **POST** /processes/{process_id}/flows | 
[**addGateway**](Client.md#addGateway) | **POST** /processes/{process_id}/gateways | 
[**addGroup**](Client.md#addGroup) | **POST** /groups | 
[**addGroupsToTask**](Client.md#addGroupsToTask) | **PUT** /processes/{process_id}/tasks/{task_id}/groups | 
[**addInputOutput**](Client.md#addInputOutput) | **POST** /processes/{process_id}/tasks/{task_id}/inputoutput | 
[**addInstance**](Client.md#addInstance) | **POST** /processes/{process_id}/instances | 
[**addOauthClient**](Client.md#addOauthClient) | **POST** /users/{user_id}/clients | 
[**addProcess**](Client.md#addProcess) | **POST** /processes | 
[**addTask**](Client.md#addTask) | **POST** /processes/{process_id}/tasks | 
[**addTaskConnector**](Client.md#addTaskConnector) | **POST** /processes/{process_id}/tasks/{task_id}/connectors | 
[**addUser**](Client.md#addUser) | **POST** /users | 
[**addUsersToGroup**](Client.md#addUsersToGroup) | **PUT** /groups/{id}/users | 
[**deleteEvent**](Client.md#deleteEvent) | **DELETE** /processes/{process_id}/events/{event_id} | 
[**deleteEventConnector**](Client.md#deleteEventConnector) | **DELETE** /processes/{process_id}/events/{event_id}/connectors/{connector_id} | 
[**deleteFlow**](Client.md#deleteFlow) | **DELETE** /processes/{process_id}/flows/{flow_id} | 
[**deleteGateway**](Client.md#deleteGateway) | **DELETE** /processes/{process_id}/gateways/{gateway_id} | 
[**deleteGroup**](Client.md#deleteGroup) | **DELETE** /groups/{id} | 
[**deleteInputOutput**](Client.md#deleteInputOutput) | **DELETE** /processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid} | 
[**deleteInstance**](Client.md#deleteInstance) | **DELETE** /processes/{process_id}/instances/{instance_id} | 
[**deleteOauthClient**](Client.md#deleteOauthClient) | **DELETE** /users/{user_id}/clients/{client_id} | 
[**deleteProcess**](Client.md#deleteProcess) | **DELETE** /processes/{id} | 
[**deleteTask**](Client.md#deleteTask) | **DELETE** /processes/{process_id}/tasks/{task_id} | 
[**deleteTaskConnector**](Client.md#deleteTaskConnector) | **DELETE** /processes/{process_id}/tasks/{task_id}/connectors/{connector_id} | 
[**deleteUser**](Client.md#deleteUser) | **DELETE** /users/{id} | 
[**eventTrigger**](Client.md#eventTrigger) | **POST** /processes/{process_id}/events/{event_id}/trigger | 
[**eventWebhook**](Client.md#eventWebhook) | **POST** /processes/{process_id}/events/{event_id}/webhook | 
[**findByFieldInsideDataModel**](Client.md#findByFieldInsideDataModel) | **GET** /processes/{process_id}/datamodels/search/{search_param} | 
[**findDataModel**](Client.md#findDataModel) | **GET** /processes/{process_id}/instances/{instance_id}/datamodel | 
[**findEventById**](Client.md#findEventById) | **GET** /processes/{process_id}/events/{event_id} | 
[**findEventConnectorById**](Client.md#findEventConnectorById) | **GET** /processes/{process_id}/events/{event_id}/connectors/{connector_id} | 
[**findEventConnectors**](Client.md#findEventConnectors) | **GET** /processes/{process_id}/events/{event_id}/connectors | 
[**findEvents**](Client.md#findEvents) | **GET** /processes/{process_id}/events | 
[**findFlowById**](Client.md#findFlowById) | **GET** /processes/{process_id}/flows/{flow_id} | 
[**findFlows**](Client.md#findFlows) | **GET** /processes/{process_id}/flows | 
[**findGatewayById**](Client.md#findGatewayById) | **GET** /processes/{process_id}/gateways/{gateway_id} | 
[**findGateways**](Client.md#findGateways) | **GET** /processes/{process_id}/gateways | 
[**findGroupById**](Client.md#findGroupById) | **GET** /groups/{id} | 
[**findGroups**](Client.md#findGroups) | **GET** /groups | 
[**findInputOutputById**](Client.md#findInputOutputById) | **GET** /processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid} | 
[**findInputOutputs**](Client.md#findInputOutputs) | **GET** /processes/{process_id}/tasks/{task_id}/inputoutput | 
[**findInstanceById**](Client.md#findInstanceById) | **GET** /processes/{process_id}/instances/{instance_id} | 
[**findInstances**](Client.md#findInstances) | **GET** /processes/{process_id}/instances | 
[**findOauthClientById**](Client.md#findOauthClientById) | **GET** /users/{user_id}/clients/{client_id} | 
[**findOauthClients**](Client.md#findOauthClients) | **GET** /users/{user_id}/clients | 
[**findProcessById**](Client.md#findProcessById) | **GET** /processes/{id} | 
[**findProcesses**](Client.md#findProcesses) | **GET** /processes | 
[**findTaskById**](Client.md#findTaskById) | **GET** /processes/{process_id}/tasks/{task_id} | 
[**findTaskConnectorById**](Client.md#findTaskConnectorById) | **GET** /processes/{process_id}/tasks/{task_id}/connectors/{connector_id} | 
[**findTaskConnectors**](Client.md#findTaskConnectors) | **GET** /processes/{process_id}/tasks/{task_id}/connectors | 
[**findTaskInstanceById**](Client.md#findTaskInstanceById) | **GET** /task_instances/{task_instance_id} | 
[**findTaskInstances**](Client.md#findTaskInstances) | **GET** /task_instances | 
[**findTaskInstancesByInstanceAndTaskId**](Client.md#findTaskInstancesByInstanceAndTaskId) | **GET** /instances/{instance_id}/tasks/{task_id}/task_instances | 
[**findTaskInstancesByInstanceAndTaskIdDelegated**](Client.md#findTaskInstancesByInstanceAndTaskIdDelegated) | **GET** /instances/{instance_id}/tasks/{task_id}/task_instances/delegated | 
[**findTaskInstancesByInstanceAndTaskIdStarted**](Client.md#findTaskInstancesByInstanceAndTaskIdStarted) | **GET** /instances/{instance_id}/tasks/{task_id}/task_instances/started | 
[**findTasks**](Client.md#findTasks) | **GET** /processes/{process_id}/tasks | 
[**findUserById**](Client.md#findUserById) | **GET** /users/{id} | 
[**findUsers**](Client.md#findUsers) | **GET** /users | 
[**importBpmnFile**](Client.md#importBpmnFile) | **POST** /processes/import | 
[**myselfUser**](Client.md#myselfUser) | **GET** /users/myself | 
[**removeGroupsFromTask**](Client.md#removeGroupsFromTask) | **DELETE** /processes/{process_id}/tasks/{task_id}/groups | 
[**removeUsersFromGroup**](Client.md#removeUsersFromGroup) | **DELETE** /groups/{id}/users | 
[**syncGroupsToTask**](Client.md#syncGroupsToTask) | **POST** /processes/{process_id}/tasks/{task_id}/groups | 
[**syncUsersToGroup**](Client.md#syncUsersToGroup) | **POST** /groups/{id}/users | 
[**updateEvent**](Client.md#updateEvent) | **PUT** /processes/{process_id}/events/{event_id} | 
[**updateEventConnector**](Client.md#updateEventConnector) | **PUT** /processes/{process_id}/events/{event_id}/connectors/{connector_id} | 
[**updateFlow**](Client.md#updateFlow) | **PUT** /processes/{process_id}/flows/{flow_id} | 
[**updateGateway**](Client.md#updateGateway) | **PUT** /processes/{process_id}/gateways/{gateway_id} | 
[**updateGroup**](Client.md#updateGroup) | **PUT** /groups/{id} | 
[**updateInputOutput**](Client.md#updateInputOutput) | **PUT** /processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid} | 
[**updateInstance**](Client.md#updateInstance) | **PUT** /processes/{process_id}/instances/{instance_id} | 
[**updateOauthClient**](Client.md#updateOauthClient) | **PUT** /users/{user_id}/clients/{client_id} | 
[**updateProcess**](Client.md#updateProcess) | **PUT** /processes/{id} | 
[**updateTask**](Client.md#updateTask) | **PUT** /processes/{process_id}/tasks/{task_id} | 
[**updateTaskConnector**](Client.md#updateTaskConnector) | **PUT** /processes/{process_id}/tasks/{task_id}/connectors/{connector_id} | 
[**updateTaskInstance**](Client.md#updateTaskInstance) | **PATCH** /task_instances/{task_instance_id} | 
[**updateUser**](Client.md#updateUser) | **PUT** /users/{id} | 


# **addEvent**
> \ProcessMaker\PMIO\Model\EventItem addEvent($process_id, $event_create_item)



This method creates the new event.

### Example
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

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of the process related to the event |
 **event_create_item** | [**\ProcessMaker\PMIO\Model\EventCreateItem**](../Model/\ProcessMaker\PMIO\Model\EventCreateItem.md)| JSON API response with the Event object to add |

### Return type

[**\ProcessMaker\PMIO\Model\EventItem**](../Model/EventItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **addEventConnector**
> \ProcessMaker\PMIO\Model\EventConnector1 addEventConnector($process_id, $event_id, $event_connector_create_item)



This method is intended for creating a new Event connector.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of Process to fetch
$event_id = "event_id_example"; // string | ID of Event to fetch
$event_connector_create_item = new \ProcessMaker\PMIO\Model\EventConnectorCreateItem(); // \ProcessMaker\PMIO\Model\EventConnectorCreateItem | JSON API with the EventConnector object to add

try {
    $result = $api_instance->addEventConnector($process_id, $event_id, $event_connector_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->addEventConnector: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of Process to fetch |
 **event_id** | **string**| ID of Event to fetch |
 **event_connector_create_item** | [**\ProcessMaker\PMIO\Model\EventConnectorCreateItem**](../Model/\ProcessMaker\PMIO\Model\EventConnectorCreateItem.md)| JSON API with the EventConnector object to add |

### Return type

[**\ProcessMaker\PMIO\Model\EventConnector1**](../Model/EventConnector1.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **addFlow**
> \ProcessMaker\PMIO\Model\FlowItem addFlow($process_id, $flow_create_item)



This method creates a new Sequence flow

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of the process related to the flow
$flow_create_item = new \ProcessMaker\PMIO\Model\FlowCreateItem(); // \ProcessMaker\PMIO\Model\FlowCreateItem | JSON API response with the Flow object to add

try {
    $result = $api_instance->addFlow($process_id, $flow_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->addFlow: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of the process related to the flow |
 **flow_create_item** | [**\ProcessMaker\PMIO\Model\FlowCreateItem**](../Model/\ProcessMaker\PMIO\Model\FlowCreateItem.md)| JSON API response with the Flow object to add |

### Return type

[**\ProcessMaker\PMIO\Model\FlowItem**](../Model/FlowItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **addGateway**
> \ProcessMaker\PMIO\Model\GatewayItem addGateway($process_id, $gateway_create_item)



This method creates a new gateway.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of the process related to the gateway
$gateway_create_item = new \ProcessMaker\PMIO\Model\GatewayCreateItem(); // \ProcessMaker\PMIO\Model\GatewayCreateItem | JSON API response with the gateway object to add

try {
    $result = $api_instance->addGateway($process_id, $gateway_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->addGateway: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of the process related to the gateway |
 **gateway_create_item** | [**\ProcessMaker\PMIO\Model\GatewayCreateItem**](../Model/\ProcessMaker\PMIO\Model\GatewayCreateItem.md)| JSON API response with the gateway object to add |

### Return type

[**\ProcessMaker\PMIO\Model\GatewayItem**](../Model/GatewayItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **addGroup**
> \ProcessMaker\PMIO\Model\GroupItem addGroup($group_create_item)



This method creates a new group.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$group_create_item = new \ProcessMaker\PMIO\Model\GroupCreateItem(); // \ProcessMaker\PMIO\Model\GroupCreateItem | JSON API with the Group object to add

try {
    $result = $api_instance->addGroup($group_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->addGroup: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **group_create_item** | [**\ProcessMaker\PMIO\Model\GroupCreateItem**](../Model/\ProcessMaker\PMIO\Model\GroupCreateItem.md)| JSON API with the Group object to add |

### Return type

[**\ProcessMaker\PMIO\Model\GroupItem**](../Model/GroupItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **addGroupsToTask**
> \ProcessMaker\PMIO\Model\ResultSuccess addGroupsToTask($process_id, $task_id, $task_add_groups_item)



This method assigns group(s) to the chosen task

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID
$task_id = "task_id_example"; // string | ID of task to be modified
$task_add_groups_item = new \ProcessMaker\PMIO\Model\TaskAddGroupsItem(); // \ProcessMaker\PMIO\Model\TaskAddGroupsItem | JSON API with Groups ID's to add

try {
    $result = $api_instance->addGroupsToTask($process_id, $task_id, $task_add_groups_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->addGroupsToTask: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID |
 **task_id** | **string**| ID of task to be modified |
 **task_add_groups_item** | [**\ProcessMaker\PMIO\Model\TaskAddGroupsItem**](../Model/\ProcessMaker\PMIO\Model\TaskAddGroupsItem.md)| JSON API with Groups ID&#39;s to add |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **addInputOutput**
> \ProcessMaker\PMIO\Model\InputOutputItem addInputOutput($process_id, $task_id, $input_output_create_item)



This method creates a new Input/Output object

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID related to Input/Output object
$task_id = "task_id_example"; // string | Task instance ID related to Input/Output object
$input_output_create_item = new \ProcessMaker\PMIO\Model\InputOutputCreateItem(); // \ProcessMaker\PMIO\Model\InputOutputCreateItem | Create and add a new Input/Output object with JSON API

try {
    $result = $api_instance->addInputOutput($process_id, $task_id, $input_output_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->addInputOutput: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID related to Input/Output object |
 **task_id** | **string**| Task instance ID related to Input/Output object |
 **input_output_create_item** | [**\ProcessMaker\PMIO\Model\InputOutputCreateItem**](../Model/\ProcessMaker\PMIO\Model\InputOutputCreateItem.md)| Create and add a new Input/Output object with JSON API |

### Return type

[**\ProcessMaker\PMIO\Model\InputOutputItem**](../Model/InputOutputItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **addInstance**
> \ProcessMaker\PMIO\Model\InstanceItem addInstance($process_id, $instance_create_item)



This method creates a new instance.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID related to the Instance
$instance_create_item = new \ProcessMaker\PMIO\Model\InstanceCreateItem(); // \ProcessMaker\PMIO\Model\InstanceCreateItem | JSON API response with the Instance object to add

try {
    $result = $api_instance->addInstance($process_id, $instance_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->addInstance: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID related to the Instance |
 **instance_create_item** | [**\ProcessMaker\PMIO\Model\InstanceCreateItem**](../Model/\ProcessMaker\PMIO\Model\InstanceCreateItem.md)| JSON API response with the Instance object to add |

### Return type

[**\ProcessMaker\PMIO\Model\InstanceItem**](../Model/InstanceItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **addOauthClient**
> \ProcessMaker\PMIO\Model\OauthClientItem addOauthClient($user_id, $oauth_client_create_item)



This method creates a new Oauth client for the user

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$user_id = "user_id_example"; // string | ID of the user related to the Oauth client
$oauth_client_create_item = new \ProcessMaker\PMIO\Model\OauthClientCreateItem(); // \ProcessMaker\PMIO\Model\OauthClientCreateItem | JSON API with the Oauth Client object to add

try {
    $result = $api_instance->addOauthClient($user_id, $oauth_client_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->addOauthClient: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| ID of the user related to the Oauth client |
 **oauth_client_create_item** | [**\ProcessMaker\PMIO\Model\OauthClientCreateItem**](../Model/\ProcessMaker\PMIO\Model\OauthClientCreateItem.md)| JSON API with the Oauth Client object to add |

### Return type

[**\ProcessMaker\PMIO\Model\OauthClientItem**](../Model/OauthClientItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **addProcess**
> \ProcessMaker\PMIO\Model\ProcessItem addProcess($process_create_item)



This method creates a new process

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_create_item = new \ProcessMaker\PMIO\Model\ProcessCreateItem(); // \ProcessMaker\PMIO\Model\ProcessCreateItem | JSON API response with the Process object to add

try {
    $result = $api_instance->addProcess($process_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->addProcess: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_create_item** | [**\ProcessMaker\PMIO\Model\ProcessCreateItem**](../Model/\ProcessMaker\PMIO\Model\ProcessCreateItem.md)| JSON API response with the Process object to add |

### Return type

[**\ProcessMaker\PMIO\Model\ProcessItem**](../Model/ProcessItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **addTask**
> \ProcessMaker\PMIO\Model\TaskItem addTask($process_id, $task_create_item)



This method creates a new task.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID related to the task
$task_create_item = new \ProcessMaker\PMIO\Model\TaskCreateItem(); // \ProcessMaker\PMIO\Model\TaskCreateItem | JSON API with the Task object to add

try {
    $result = $api_instance->addTask($process_id, $task_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->addTask: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID related to the task |
 **task_create_item** | [**\ProcessMaker\PMIO\Model\TaskCreateItem**](../Model/\ProcessMaker\PMIO\Model\TaskCreateItem.md)| JSON API with the Task object to add |

### Return type

[**\ProcessMaker\PMIO\Model\TaskItem**](../Model/TaskItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **addTaskConnector**
> \ProcessMaker\PMIO\Model\TaskConnector1 addTaskConnector($process_id, $task_id, $task_connector_create_item)



This method is intended for creating a new task connector.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of Process to fetch
$task_id = "task_id_example"; // string | ID of Task to fetch
$task_connector_create_item = new \ProcessMaker\PMIO\Model\TaskConnectorCreateItem(); // \ProcessMaker\PMIO\Model\TaskConnectorCreateItem | JSON API with the TaskConnector object to add

try {
    $result = $api_instance->addTaskConnector($process_id, $task_id, $task_connector_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->addTaskConnector: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of Process to fetch |
 **task_id** | **string**| ID of Task to fetch |
 **task_connector_create_item** | [**\ProcessMaker\PMIO\Model\TaskConnectorCreateItem**](../Model/\ProcessMaker\PMIO\Model\TaskConnectorCreateItem.md)| JSON API with the TaskConnector object to add |

### Return type

[**\ProcessMaker\PMIO\Model\TaskConnector1**](../Model/TaskConnector1.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **addUser**
> \ProcessMaker\PMIO\Model\UserItem addUser($user_create_item)



This method creates a new user in the system. From the result you may retrieve `client_id`  This `client_id` required to obtain `client_secret` and then you will be able to perform Oauth authorization key. Refer to [Oauth Client APIs](#tag/oauth)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$user_create_item = new \ProcessMaker\PMIO\Model\UserCreateItem(); // \ProcessMaker\PMIO\Model\UserCreateItem | JSON API with the User object to add

try {
    $result = $api_instance->addUser($user_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->addUser: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_create_item** | [**\ProcessMaker\PMIO\Model\UserCreateItem**](../Model/\ProcessMaker\PMIO\Model\UserCreateItem.md)| JSON API with the User object to add |

### Return type

[**\ProcessMaker\PMIO\Model\UserItem**](../Model/UserItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **addUsersToGroup**
> \ProcessMaker\PMIO\Model\ResultSuccess addUsersToGroup($id, $group_add_users_item)



This method adds one or more new users to a group.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$id = "id_example"; // string | ID of group to be modified
$group_add_users_item = new \ProcessMaker\PMIO\Model\GroupAddUsersItem(); // \ProcessMaker\PMIO\Model\GroupAddUsersItem | JSON API response with array of users ID's

try {
    $result = $api_instance->addUsersToGroup($id, $group_add_users_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->addUsersToGroup: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| ID of group to be modified |
 **group_add_users_item** | [**\ProcessMaker\PMIO\Model\GroupAddUsersItem**](../Model/\ProcessMaker\PMIO\Model\GroupAddUsersItem.md)| JSON API response with array of users ID&#39;s |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteEvent**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteEvent($process_id, $event_id)



This method deletes an event using the event ID and process ID

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID
$event_id = "event_id_example"; // string | ID of event to delete

try {
    $result = $api_instance->deleteEvent($process_id, $event_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->deleteEvent: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID |
 **event_id** | **string**| ID of event to delete |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteEventConnector**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteEventConnector($process_id, $event_id, $connector_id)



This method is intended for deleting a single Event connector based on Event ID, Process ID and Connector ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of of Process item
$event_id = "event_id_example"; // string | ID of item to fetch
$connector_id = "connector_id_example"; // string | ID of EventConnector to fetch

try {
    $result = $api_instance->deleteEventConnector($process_id, $event_id, $connector_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->deleteEventConnector: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of of Process item |
 **event_id** | **string**| ID of item to fetch |
 **connector_id** | **string**| ID of EventConnector to fetch |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteFlow**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteFlow($process_id, $flow_id)



This method deletes a sequence flow using the flow ID and process ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID
$flow_id = "flow_id_example"; // string | ID of flow to delete

try {
    $result = $api_instance->deleteFlow($process_id, $flow_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->deleteFlow: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID |
 **flow_id** | **string**| ID of flow to delete |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteGateway**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteGateway($process_id, $gateway_id)



This method is deletes a single item using the gateway ID and process ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID
$gateway_id = "gateway_id_example"; // string | ID of Process to delete

try {
    $result = $api_instance->deleteGateway($process_id, $gateway_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->deleteGateway: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID |
 **gateway_id** | **string**| ID of Process to delete |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteGroup**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteGroup($id)



This method deletes a group using the group ID

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$id = "id_example"; // string | ID of group to delete

try {
    $result = $api_instance->deleteGroup($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->deleteGroup: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| ID of group to delete |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteInputOutput**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteInputOutput($process_id, $task_id, $inputoutput_uid)



This method deletes the Input/Output based on the Input/Output ID, process ID and task ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID related to the Input/Output object
$task_id = "task_id_example"; // string | Task instance ID related to Input/Output object
$inputoutput_uid = "inputoutput_uid_example"; // string | Input/Output ID to fetch

try {
    $result = $api_instance->deleteInputOutput($process_id, $task_id, $inputoutput_uid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->deleteInputOutput: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID related to the Input/Output object |
 **task_id** | **string**| Task instance ID related to Input/Output object |
 **inputoutput_uid** | **string**| Input/Output ID to fetch |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteInstance**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteInstance($process_id, $instance_id)



This method deletes an instance using the instance ID and process ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID
$instance_id = "instance_id_example"; // string | ID of instance to delete

try {
    $result = $api_instance->deleteInstance($process_id, $instance_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->deleteInstance: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID |
 **instance_id** | **string**| ID of instance to delete |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteOauthClient**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteOauthClient($user_id, $client_id)



This method deletes an Oauth client using the Oauth client and user IDs.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$user_id = "user_id_example"; // string | User ID
$client_id = "client_id_example"; // string | ID of Oauth client to delete

try {
    $result = $api_instance->deleteOauthClient($user_id, $client_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->deleteOauthClient: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| User ID |
 **client_id** | **string**| ID of Oauth client to delete |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteProcess**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteProcess($id)



This method deletes a process using the process ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$id = "id_example"; // string | Process ID to delete

try {
    $result = $api_instance->deleteProcess($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->deleteProcess: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| Process ID to delete |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteTask**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteTask($process_id, $task_id)



This method deletes a task using the task ID and process ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID
$task_id = "task_id_example"; // string | ID of task to delete

try {
    $result = $api_instance->deleteTask($process_id, $task_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->deleteTask: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID |
 **task_id** | **string**| ID of task to delete |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteTaskConnector**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteTaskConnector($process_id, $task_id, $connector_id)



This method is intended for deleting a single Task connector based on Task ID, Process ID and Connector ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of Process item to fetch
$task_id = "task_id_example"; // string | ID of Task item to fetch
$connector_id = "connector_id_example"; // string | ID of TaskConnector to fetch

try {
    $result = $api_instance->deleteTaskConnector($process_id, $task_id, $connector_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->deleteTaskConnector: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of Process item to fetch |
 **task_id** | **string**| ID of Task item to fetch |
 **connector_id** | **string**| ID of TaskConnector to fetch |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteUser**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteUser($id)



This method deletes a user from the system.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$id = "id_example"; // string | ID of user to delete

try {
    $result = $api_instance->deleteUser($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->deleteUser: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| ID of user to delete |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **eventTrigger**
> \ProcessMaker\PMIO\Model\DataModelItem1 eventTrigger($process_id, $event_id, $trigger_event_create_item)



This method starts/triggers an event.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID related to the event
$event_id = "event_id_example"; // string | ID of event to trigger
$trigger_event_create_item = new \ProcessMaker\PMIO\Model\TriggerEventCreateItem(); // \ProcessMaker\PMIO\Model\TriggerEventCreateItem | Json with some parameters

try {
    $result = $api_instance->eventTrigger($process_id, $event_id, $trigger_event_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->eventTrigger: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID related to the event |
 **event_id** | **string**| ID of event to trigger |
 **trigger_event_create_item** | [**\ProcessMaker\PMIO\Model\TriggerEventCreateItem**](../Model/\ProcessMaker\PMIO\Model\TriggerEventCreateItem.md)| Json with some parameters |

### Return type

[**\ProcessMaker\PMIO\Model\DataModelItem1**](../Model/DataModelItem1.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **eventWebhook**
> string eventWebhook($process_id, $event_id, $trigger_body)



This webhook method triggers given Event object.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID related to the event
$event_id = "event_id_example"; // string | ID of event to trigger
$trigger_body = "trigger_body_example"; // string | Freeform JSON structure, it will be passed to newly created DataModel

try {
    $result = $api_instance->eventWebhook($process_id, $event_id, $trigger_body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->eventWebhook: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID related to the event |
 **event_id** | **string**| ID of event to trigger |
 **trigger_body** | **string**| Freeform JSON structure, it will be passed to newly created DataModel |

### Return type

**string**

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findByFieldInsideDataModel**
> \ProcessMaker\PMIO\Model\DataModelCollection findByFieldInsideDataModel($process_id, $search_param, $page, $per_page)



This method returns the DataModel by field passed in get argument.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of process to return
$search_param = "search_param_example"; // string | Key and value of searched field in Datamodel
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findByFieldInsideDataModel($process_id, $search_param, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findByFieldInsideDataModel: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of process to return |
 **search_param** | **string**| Key and value of searched field in Datamodel |
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\DataModelCollection**](../Model/DataModelCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findDataModel**
> \ProcessMaker\PMIO\Model\DataModelItem1 findDataModel($process_id, $instance_id, $page, $per_page)



This method returns the instance DataModel and lets the user work with it directly

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of process to return
$instance_id = "instance_id_example"; // string | ID of instance to return
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findDataModel($process_id, $instance_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findDataModel: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of process to return |
 **instance_id** | **string**| ID of instance to return |
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\DataModelItem1**](../Model/DataModelItem1.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findEventById**
> \ProcessMaker\PMIO\Model\EventItem findEventById($process_id, $event_id)



This method retrieves an event using its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of process to return
$event_id = "event_id_example"; // string | ID of event to return

try {
    $result = $api_instance->findEventById($process_id, $event_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findEventById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of process to return |
 **event_id** | **string**| ID of event to return |

### Return type

[**\ProcessMaker\PMIO\Model\EventItem**](../Model/EventItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findEventConnectorById**
> \ProcessMaker\PMIO\Model\EventConnector1 findEventConnectorById($process_id, $event_id, $connector_id)



This method returns all Event connectors related to the run Process and Event.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of Process to fetch
$event_id = "event_id_example"; // string | ID of Event to fetch
$connector_id = "connector_id_example"; // string | ID of EventConnector to fetch

try {
    $result = $api_instance->findEventConnectorById($process_id, $event_id, $connector_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findEventConnectorById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of Process to fetch |
 **event_id** | **string**| ID of Event to fetch |
 **connector_id** | **string**| ID of EventConnector to fetch |

### Return type

[**\ProcessMaker\PMIO\Model\EventConnector1**](../Model/EventConnector1.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findEventConnectors**
> \ProcessMaker\PMIO\Model\EventConnectorsCollection findEventConnectors($process_id, $event_id, $page, $per_page)



This method returns all Event connectors related to the run Process and Event.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of Process to fetch
$event_id = "event_id_example"; // string | ID of Task to fetch
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findEventConnectors($process_id, $event_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findEventConnectors: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of Process to fetch |
 **event_id** | **string**| ID of Task to fetch |
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\EventConnectorsCollection**](../Model/EventConnectorsCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findEvents**
> \ProcessMaker\PMIO\Model\EventCollection findEvents($process_id, $page, $per_page)



This method returns all events related to the process that was run.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of process related to the event
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findEvents($process_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findEvents: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of process related to the event |
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\EventCollection**](../Model/EventCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findFlowById**
> \ProcessMaker\PMIO\Model\FlowItem findFlowById($process_id, $flow_id)



This method retrieves a flow based on its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of process to return
$flow_id = "flow_id_example"; // string | ID of flow to return

try {
    $result = $api_instance->findFlowById($process_id, $flow_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findFlowById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of process to return |
 **flow_id** | **string**| ID of flow to return |

### Return type

[**\ProcessMaker\PMIO\Model\FlowItem**](../Model/FlowItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findFlows**
> \ProcessMaker\PMIO\Model\FlowCollection findFlows($process_id, $page, $per_page)



This method retrieves all existing flows.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of process related to the flow
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findFlows($process_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findFlows: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of process related to the flow |
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\FlowCollection**](../Model/FlowCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findGatewayById**
> \ProcessMaker\PMIO\Model\GatewayItem findGatewayById($process_id, $gateway_id)



This method retrieves a gateway based on its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of process to return
$gateway_id = "gateway_id_example"; // string | ID of gateway to return

try {
    $result = $api_instance->findGatewayById($process_id, $gateway_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findGatewayById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of process to return |
 **gateway_id** | **string**| ID of gateway to return |

### Return type

[**\ProcessMaker\PMIO\Model\GatewayItem**](../Model/GatewayItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findGateways**
> \ProcessMaker\PMIO\Model\GatewayCollection findGateways($process_id, $page, $per_page)



This method retrieves all existing gateways.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of process related to the gateway
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findGateways($process_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findGateways: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of process related to the gateway |
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\GatewayCollection**](../Model/GatewayCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findGroupById**
> \ProcessMaker\PMIO\Model\GroupItem findGroupById($id)



This method retrieves a group using its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$id = "id_example"; // string | ID of group to return

try {
    $result = $api_instance->findGroupById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findGroupById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| ID of group to return |

### Return type

[**\ProcessMaker\PMIO\Model\GroupItem**](../Model/GroupItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findGroups**
> \ProcessMaker\PMIO\Model\GroupCollection findGroups($page, $per_page)



This method retrieves all existing groups.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findGroups($page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findGroups: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\GroupCollection**](../Model/GroupCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findInputOutputById**
> \ProcessMaker\PMIO\Model\InputOutputItem findInputOutputById($process_id, $task_id, $inputoutput_uid)



This method retrieves an Input/Output object using its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID related to the Input/Output object
$task_id = "task_id_example"; // string | Task instance ID related to the Input/Output object
$inputoutput_uid = "inputoutput_uid_example"; // string | ID of Input/Output to return

try {
    $result = $api_instance->findInputOutputById($process_id, $task_id, $inputoutput_uid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findInputOutputById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID related to the Input/Output object |
 **task_id** | **string**| Task instance ID related to the Input/Output object |
 **inputoutput_uid** | **string**| ID of Input/Output to return |

### Return type

[**\ProcessMaker\PMIO\Model\InputOutputItem**](../Model/InputOutputItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findInputOutputs**
> \ProcessMaker\PMIO\Model\InputOutputCollection findInputOutputs($process_id, $task_id, $page, $per_page)



This method retrieves all existing Input/Output objects in the related task instance.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID related to Input/Output object
$task_id = "task_id_example"; // string | Task instance ID related to Input/Output object
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findInputOutputs($process_id, $task_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findInputOutputs: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID related to Input/Output object |
 **task_id** | **string**| Task instance ID related to Input/Output object |
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\InputOutputCollection**](../Model/InputOutputCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findInstanceById**
> \ProcessMaker\PMIO\Model\InstanceItem findInstanceById($process_id, $instance_id)



This method retrieves an instance using its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of process to return
$instance_id = "instance_id_example"; // string | ID of instance to return

try {
    $result = $api_instance->findInstanceById($process_id, $instance_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findInstanceById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of process to return |
 **instance_id** | **string**| ID of instance to return |

### Return type

[**\ProcessMaker\PMIO\Model\InstanceItem**](../Model/InstanceItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findInstances**
> \ProcessMaker\PMIO\Model\InstanceCollection findInstances($process_id, $page, $per_page)



This method retrieves related to the process using  the Process ID

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID related to the instances
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findInstances($process_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findInstances: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID related to the instances |
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\InstanceCollection**](../Model/InstanceCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findOauthClientById**
> \ProcessMaker\PMIO\Model\OauthClientItem findOauthClientById($user_id, $client_id)



This method is retrieves an Oauth client for the User based on its ID.  Response contains `client_secret` required to obtain `access_token`.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$user_id = "user_id_example"; // string | ID of user to retrieve
$client_id = "client_id_example"; // string | ID of Oauth client to retrieve

try {
    $result = $api_instance->findOauthClientById($user_id, $client_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findOauthClientById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| ID of user to retrieve |
 **client_id** | **string**| ID of Oauth client to retrieve |

### Return type

[**\ProcessMaker\PMIO\Model\OauthClientItem**](../Model/OauthClientItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findOauthClients**
> \ProcessMaker\PMIO\Model\OauthClientCollection findOauthClients($user_id, $page, $per_page)



This method retrieves all existing Oauth clients belonging to an user.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$user_id = "user_id_example"; // string | User ID related to the Oauth clients
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findOauthClients($user_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findOauthClients: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| User ID related to the Oauth clients |
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\OauthClientCollection**](../Model/OauthClientCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findProcessById**
> \ProcessMaker\PMIO\Model\ProcessItem findProcessById($id)



This method retrieves a process using its ID

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$id = "id_example"; // string | ID of process to return

try {
    $result = $api_instance->findProcessById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findProcessById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| ID of process to return |

### Return type

[**\ProcessMaker\PMIO\Model\ProcessItem**](../Model/ProcessItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findProcesses**
> \ProcessMaker\PMIO\Model\ProcessCollection findProcesses($page, $per_page)



This method retrieves all existing processes.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findProcesses($page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findProcesses: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\ProcessCollection**](../Model/ProcessCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findTaskById**
> \ProcessMaker\PMIO\Model\TaskItem findTaskById($process_id, $task_id)



This method is retrieves a task using its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of process to return
$task_id = "task_id_example"; // string | ID of task to return

try {
    $result = $api_instance->findTaskById($process_id, $task_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findTaskById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of process to return |
 **task_id** | **string**| ID of task to return |

### Return type

[**\ProcessMaker\PMIO\Model\TaskItem**](../Model/TaskItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findTaskConnectorById**
> \ProcessMaker\PMIO\Model\TaskConnector1 findTaskConnectorById($process_id, $task_id, $connector_id)



This method is intended for retrieving an Task connector based on it's ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of Process to fetch
$task_id = "task_id_example"; // string | ID of Task to fetch
$connector_id = "connector_id_example"; // string | ID of TaskConnector to fetch

try {
    $result = $api_instance->findTaskConnectorById($process_id, $task_id, $connector_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findTaskConnectorById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of Process to fetch |
 **task_id** | **string**| ID of Task to fetch |
 **connector_id** | **string**| ID of TaskConnector to fetch |

### Return type

[**\ProcessMaker\PMIO\Model\TaskConnector1**](../Model/TaskConnector1.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findTaskConnectors**
> \ProcessMaker\PMIO\Model\TaskConnectorsCollection findTaskConnectors($process_id, $task_id, $page, $per_page)



This method returns all Task connectors related to the run Process and Task.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of Process to fetch
$task_id = "task_id_example"; // string | ID of Task to fetch
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findTaskConnectors($process_id, $task_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findTaskConnectors: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of Process to fetch |
 **task_id** | **string**| ID of Task to fetch |
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\TaskConnectorsCollection**](../Model/TaskConnectorsCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findTaskInstanceById**
> \ProcessMaker\PMIO\Model\InlineResponse200 findTaskInstanceById($task_instance_id, $page, $per_page)



This method retrieves a task instance based on its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$task_instance_id = "task_instance_id_example"; // string | ID of task instance to return
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findTaskInstanceById($task_instance_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findTaskInstanceById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **task_instance_id** | **string**| ID of task instance to return |
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\InlineResponse200**](../Model/InlineResponse200.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findTaskInstances**
> \ProcessMaker\PMIO\Model\TaskInstanceCollection findTaskInstances($page, $per_page)



This method retrieves all existing task instances

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findTaskInstances($page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findTaskInstances: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\TaskInstanceCollection**](../Model/TaskInstanceCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findTaskInstancesByInstanceAndTaskId**
> \ProcessMaker\PMIO\Model\TaskInstanceCollection findTaskInstancesByInstanceAndTaskId($instance_id, $task_id)



This method retrieves an task instances using instance id and task id.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$instance_id = "instance_id_example"; // string | ID of instance
$task_id = "task_id_example"; // string | ID of task

try {
    $result = $api_instance->findTaskInstancesByInstanceAndTaskId($instance_id, $task_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findTaskInstancesByInstanceAndTaskId: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **instance_id** | **string**| ID of instance |
 **task_id** | **string**| ID of task |

### Return type

[**\ProcessMaker\PMIO\Model\TaskInstanceCollection**](../Model/TaskInstanceCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findTaskInstancesByInstanceAndTaskIdDelegated**
> \ProcessMaker\PMIO\Model\TaskInstanceCollection findTaskInstancesByInstanceAndTaskIdDelegated($instance_id, $task_id)



This method retrieves an delegated task instances using instance id and task id.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$instance_id = "instance_id_example"; // string | ID of instance
$task_id = "task_id_example"; // string | ID of task

try {
    $result = $api_instance->findTaskInstancesByInstanceAndTaskIdDelegated($instance_id, $task_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findTaskInstancesByInstanceAndTaskIdDelegated: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **instance_id** | **string**| ID of instance |
 **task_id** | **string**| ID of task |

### Return type

[**\ProcessMaker\PMIO\Model\TaskInstanceCollection**](../Model/TaskInstanceCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findTaskInstancesByInstanceAndTaskIdStarted**
> \ProcessMaker\PMIO\Model\TaskInstanceCollection findTaskInstancesByInstanceAndTaskIdStarted($instance_id, $task_id)



This method retrieves an started task instances using instance id and task id.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$instance_id = "instance_id_example"; // string | ID of instance
$task_id = "task_id_example"; // string | ID of task

try {
    $result = $api_instance->findTaskInstancesByInstanceAndTaskIdStarted($instance_id, $task_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findTaskInstancesByInstanceAndTaskIdStarted: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **instance_id** | **string**| ID of instance |
 **task_id** | **string**| ID of task |

### Return type

[**\ProcessMaker\PMIO\Model\TaskInstanceCollection**](../Model/TaskInstanceCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findTasks**
> \ProcessMaker\PMIO\Model\TaskCollection findTasks($process_id, $page, $per_page)



This method is intended for returning a list of all Tasks related to the process

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of Process relative to task
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findTasks($process_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findTasks: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of Process relative to task |
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\TaskCollection**](../Model/TaskCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findUserById**
> \ProcessMaker\PMIO\Model\UserItem findUserById($id)



This method returns a user using its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$id = "id_example"; // string | ID of the user to return

try {
    $result = $api_instance->findUserById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findUserById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| ID of the user to return |

### Return type

[**\ProcessMaker\PMIO\Model\UserItem**](../Model/UserItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findUsers**
> \ProcessMaker\PMIO\Model\UserCollection findUsers($page, $per_page)



This method returns all existing users in the system.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findUsers($page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->findUsers: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\UserCollection**](../Model/UserCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **importBpmnFile**
> \ProcessMaker\PMIO\Model\ProcessCollection1 importBpmnFile($bpmn_import_item)



This method imports BPMN 2.0 files. A new process(es) is/are created and its object returned back when import is successful.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$bpmn_import_item = new \ProcessMaker\PMIO\Model\BpmnImportItem(); // \ProcessMaker\PMIO\Model\BpmnImportItem | JSON API with the BPMN file to import

try {
    $result = $api_instance->importBpmnFile($bpmn_import_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->importBpmnFile: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **bpmn_import_item** | [**\ProcessMaker\PMIO\Model\BpmnImportItem**](../Model/\ProcessMaker\PMIO\Model\BpmnImportItem.md)| JSON API with the BPMN file to import |

### Return type

[**\ProcessMaker\PMIO\Model\ProcessCollection1**](../Model/ProcessCollection1.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **myselfUser**
> \ProcessMaker\PMIO\Model\UserItem myselfUser($page, $per_page)



This method returns user information using a token

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->myselfUser($page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->myselfUser: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\UserItem**](../Model/UserItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **removeGroupsFromTask**
> \ProcessMaker\PMIO\Model\ResultSuccess removeGroupsFromTask($process_id, $task_id, $task_remove_groups_item)



This method removes groups from a task

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID
$task_id = "task_id_example"; // string | Task ID
$task_remove_groups_item = new \ProcessMaker\PMIO\Model\TaskRemoveGroupsItem(); // \ProcessMaker\PMIO\Model\TaskRemoveGroupsItem | JSON API response with Groups IDs to remove

try {
    $result = $api_instance->removeGroupsFromTask($process_id, $task_id, $task_remove_groups_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->removeGroupsFromTask: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID |
 **task_id** | **string**| Task ID |
 **task_remove_groups_item** | [**\ProcessMaker\PMIO\Model\TaskRemoveGroupsItem**](../Model/\ProcessMaker\PMIO\Model\TaskRemoveGroupsItem.md)| JSON API response with Groups IDs to remove |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **removeUsersFromGroup**
> \ProcessMaker\PMIO\Model\ResultSuccess removeUsersFromGroup($id, $group_remove_users_item)



This method removes one or more users from a group.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$id = "id_example"; // string | ID of group to be modified
$group_remove_users_item = new \ProcessMaker\PMIO\Model\GroupRemoveUsersItem(); // \ProcessMaker\PMIO\Model\GroupRemoveUsersItem | JSON API response with Users IDs to remove

try {
    $result = $api_instance->removeUsersFromGroup($id, $group_remove_users_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->removeUsersFromGroup: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| ID of group to be modified |
 **group_remove_users_item** | [**\ProcessMaker\PMIO\Model\GroupRemoveUsersItem**](../Model/\ProcessMaker\PMIO\Model\GroupRemoveUsersItem.md)| JSON API response with Users IDs to remove |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **syncGroupsToTask**
> \ProcessMaker\PMIO\Model\ResultSuccess syncGroupsToTask($process_id, $task_id, $task_sync_groups_item)



This method synchronizes a one or more groups with a task.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID
$task_id = "task_id_example"; // string | ID of task to modify
$task_sync_groups_item = new \ProcessMaker\PMIO\Model\TaskSyncGroupsItem(); // \ProcessMaker\PMIO\Model\TaskSyncGroupsItem | JSON API response with groups IDs to sync

try {
    $result = $api_instance->syncGroupsToTask($process_id, $task_id, $task_sync_groups_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->syncGroupsToTask: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID |
 **task_id** | **string**| ID of task to modify |
 **task_sync_groups_item** | [**\ProcessMaker\PMIO\Model\TaskSyncGroupsItem**](../Model/\ProcessMaker\PMIO\Model\TaskSyncGroupsItem.md)| JSON API response with groups IDs to sync |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **syncUsersToGroup**
> \ProcessMaker\PMIO\Model\ResultSuccess syncUsersToGroup($id, $group_sync_users_item)



This method synchronizes one or more users with a group.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$id = "id_example"; // string | ID of group to be modified
$group_sync_users_item = new \ProcessMaker\PMIO\Model\GroupSyncUsersItem(); // \ProcessMaker\PMIO\Model\GroupSyncUsersItem | JSON API with array of users IDs to sync

try {
    $result = $api_instance->syncUsersToGroup($id, $group_sync_users_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->syncUsersToGroup: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| ID of group to be modified |
 **group_sync_users_item** | [**\ProcessMaker\PMIO\Model\GroupSyncUsersItem**](../Model/\ProcessMaker\PMIO\Model\GroupSyncUsersItem.md)| JSON API with array of users IDs to sync |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateEvent**
> \ProcessMaker\PMIO\Model\EventItem updateEvent($process_id, $event_id, $event_update_item)



This method updates an existing event

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of process to retrieve
$event_id = "event_id_example"; // string | ID of event to retrieve
$event_update_item = new \ProcessMaker\PMIO\Model\EventUpdateItem(); // \ProcessMaker\PMIO\Model\EventUpdateItem | Event object to edit

try {
    $result = $api_instance->updateEvent($process_id, $event_id, $event_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->updateEvent: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of process to retrieve |
 **event_id** | **string**| ID of event to retrieve |
 **event_update_item** | [**\ProcessMaker\PMIO\Model\EventUpdateItem**](../Model/\ProcessMaker\PMIO\Model\EventUpdateItem.md)| Event object to edit |

### Return type

[**\ProcessMaker\PMIO\Model\EventItem**](../Model/EventItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateEventConnector**
> \ProcessMaker\PMIO\Model\EventConnector1 updateEventConnector($process_id, $event_id, $connector_id, $event_connector_update_item)



This method lets update the existing Event connector with new parameters values

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of Process to fetch
$event_id = "event_id_example"; // string | ID of Event to fetch
$connector_id = "connector_id_example"; // string | ID of Event Connector to fetch
$event_connector_update_item = new \ProcessMaker\PMIO\Model\EventConnectorUpdateItem(); // \ProcessMaker\PMIO\Model\EventConnectorUpdateItem | EventConnector object to edit

try {
    $result = $api_instance->updateEventConnector($process_id, $event_id, $connector_id, $event_connector_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->updateEventConnector: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of Process to fetch |
 **event_id** | **string**| ID of Event to fetch |
 **connector_id** | **string**| ID of Event Connector to fetch |
 **event_connector_update_item** | [**\ProcessMaker\PMIO\Model\EventConnectorUpdateItem**](../Model/\ProcessMaker\PMIO\Model\EventConnectorUpdateItem.md)| EventConnector object to edit |

### Return type

[**\ProcessMaker\PMIO\Model\EventConnector1**](../Model/EventConnector1.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateFlow**
> \ProcessMaker\PMIO\Model\FlowItem updateFlow($process_id, $flow_id, $flow_update_item)



This method updates an existing flow.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of process to retrieve
$flow_id = "flow_id_example"; // string | ID of flow to retrieve
$flow_update_item = new \ProcessMaker\PMIO\Model\FlowUpdateItem(); // \ProcessMaker\PMIO\Model\FlowUpdateItem | Flow object to edit

try {
    $result = $api_instance->updateFlow($process_id, $flow_id, $flow_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->updateFlow: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of process to retrieve |
 **flow_id** | **string**| ID of flow to retrieve |
 **flow_update_item** | [**\ProcessMaker\PMIO\Model\FlowUpdateItem**](../Model/\ProcessMaker\PMIO\Model\FlowUpdateItem.md)| Flow object to edit |

### Return type

[**\ProcessMaker\PMIO\Model\FlowItem**](../Model/FlowItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateGateway**
> \ProcessMaker\PMIO\Model\GatewayItem updateGateway($process_id, $gateway_id, $gateway_update_item)



This method updates an existing gateway.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of process to retrieve
$gateway_id = "gateway_id_example"; // string | ID of gateway to retrieve
$gateway_update_item = new \ProcessMaker\PMIO\Model\GatewayUpdateItem(); // \ProcessMaker\PMIO\Model\GatewayUpdateItem | Gateway object to edit

try {
    $result = $api_instance->updateGateway($process_id, $gateway_id, $gateway_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->updateGateway: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of process to retrieve |
 **gateway_id** | **string**| ID of gateway to retrieve |
 **gateway_update_item** | [**\ProcessMaker\PMIO\Model\GatewayUpdateItem**](../Model/\ProcessMaker\PMIO\Model\GatewayUpdateItem.md)| Gateway object to edit |

### Return type

[**\ProcessMaker\PMIO\Model\GatewayItem**](../Model/GatewayItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateGroup**
> \ProcessMaker\PMIO\Model\GroupItem updateGroup($id, $group_update_item)



This method updates an existing group.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$id = "id_example"; // string | ID of group to retrieve
$group_update_item = new \ProcessMaker\PMIO\Model\GroupUpdateItem(); // \ProcessMaker\PMIO\Model\GroupUpdateItem | Group object to edit

try {
    $result = $api_instance->updateGroup($id, $group_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->updateGroup: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| ID of group to retrieve |
 **group_update_item** | [**\ProcessMaker\PMIO\Model\GroupUpdateItem**](../Model/\ProcessMaker\PMIO\Model\GroupUpdateItem.md)| Group object to edit |

### Return type

[**\ProcessMaker\PMIO\Model\GroupItem**](../Model/GroupItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateInputOutput**
> \ProcessMaker\PMIO\Model\InputOutputItem updateInputOutput($process_id, $task_id, $inputoutput_uid, $input_output_update_item)



This method updates an existing Input/Output object.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | Process ID related to the Input/Output object
$task_id = "task_id_example"; // string | Task instance ID related to the Input/Output object
$inputoutput_uid = "inputoutput_uid_example"; // string | ID of Input/Output to retrieve
$input_output_update_item = new \ProcessMaker\PMIO\Model\InputOutputUpdateItem(); // \ProcessMaker\PMIO\Model\InputOutputUpdateItem | Input/Output object to edit

try {
    $result = $api_instance->updateInputOutput($process_id, $task_id, $inputoutput_uid, $input_output_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->updateInputOutput: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID related to the Input/Output object |
 **task_id** | **string**| Task instance ID related to the Input/Output object |
 **inputoutput_uid** | **string**| ID of Input/Output to retrieve |
 **input_output_update_item** | [**\ProcessMaker\PMIO\Model\InputOutputUpdateItem**](../Model/\ProcessMaker\PMIO\Model\InputOutputUpdateItem.md)| Input/Output object to edit |

### Return type

[**\ProcessMaker\PMIO\Model\InputOutputItem**](../Model/InputOutputItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateInstance**
> \ProcessMaker\PMIO\Model\InstanceItem updateInstance($process_id, $instance_id, $instance_update_item)



This method updates  an existing instance.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of Process to retrieve
$instance_id = "instance_id_example"; // string | ID of Instance to retrieve
$instance_update_item = new \ProcessMaker\PMIO\Model\InstanceUpdateItem(); // \ProcessMaker\PMIO\Model\InstanceUpdateItem | Instance object to edit

try {
    $result = $api_instance->updateInstance($process_id, $instance_id, $instance_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->updateInstance: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of Process to retrieve |
 **instance_id** | **string**| ID of Instance to retrieve |
 **instance_update_item** | [**\ProcessMaker\PMIO\Model\InstanceUpdateItem**](../Model/\ProcessMaker\PMIO\Model\InstanceUpdateItem.md)| Instance object to edit |

### Return type

[**\ProcessMaker\PMIO\Model\InstanceItem**](../Model/InstanceItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateOauthClient**
> \ProcessMaker\PMIO\Model\OauthClientItem updateOauthClient($user_id, $client_id, $oauth_client_update_item)



This method updates an existing Oauth client.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$user_id = "user_id_example"; // string | ID of user to retrieve
$client_id = "client_id_example"; // string | ID of Oauth client to retrieve
$oauth_client_update_item = new \ProcessMaker\PMIO\Model\OauthClientUpdateItem(); // \ProcessMaker\PMIO\Model\OauthClientUpdateItem | Oauth Client object to edit

try {
    $result = $api_instance->updateOauthClient($user_id, $client_id, $oauth_client_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->updateOauthClient: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **user_id** | **string**| ID of user to retrieve |
 **client_id** | **string**| ID of Oauth client to retrieve |
 **oauth_client_update_item** | [**\ProcessMaker\PMIO\Model\OauthClientUpdateItem**](../Model/\ProcessMaker\PMIO\Model\OauthClientUpdateItem.md)| Oauth Client object to edit |

### Return type

[**\ProcessMaker\PMIO\Model\OauthClientItem**](../Model/OauthClientItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateProcess**
> \ProcessMaker\PMIO\Model\ProcessItem updateProcess($id, $process_update_item)



This method updates an existing process.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$id = "id_example"; // string | ID of process to retrieve
$process_update_item = new \ProcessMaker\PMIO\Model\ProcessUpdateItem(); // \ProcessMaker\PMIO\Model\ProcessUpdateItem | Process object to edit

try {
    $result = $api_instance->updateProcess($id, $process_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->updateProcess: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| ID of process to retrieve |
 **process_update_item** | [**\ProcessMaker\PMIO\Model\ProcessUpdateItem**](../Model/\ProcessMaker\PMIO\Model\ProcessUpdateItem.md)| Process object to edit |

### Return type

[**\ProcessMaker\PMIO\Model\ProcessItem**](../Model/ProcessItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateTask**
> \ProcessMaker\PMIO\Model\TaskItem updateTask($process_id, $task_id, $task_update_item)



This method is intended for updating an existing task.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of Process to fetch
$task_id = "task_id_example"; // string | ID of Task to fetch
$task_update_item = new \ProcessMaker\PMIO\Model\TaskUpdateItem(); // \ProcessMaker\PMIO\Model\TaskUpdateItem | Task object to edit

try {
    $result = $api_instance->updateTask($process_id, $task_id, $task_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->updateTask: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of Process to fetch |
 **task_id** | **string**| ID of Task to fetch |
 **task_update_item** | [**\ProcessMaker\PMIO\Model\TaskUpdateItem**](../Model/\ProcessMaker\PMIO\Model\TaskUpdateItem.md)| Task object to edit |

### Return type

[**\ProcessMaker\PMIO\Model\TaskItem**](../Model/TaskItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateTaskConnector**
> \ProcessMaker\PMIO\Model\TaskConnector1 updateTaskConnector($process_id, $task_id, $connector_id, $task_connector_update_item)



This method lets update the existing Task connector with new parameters values

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$process_id = "process_id_example"; // string | ID of Process to fetch
$task_id = "task_id_example"; // string | ID of Task to fetch
$connector_id = "connector_id_example"; // string | ID of Task Connector to fetch
$task_connector_update_item = new \ProcessMaker\PMIO\Model\TaskConnectorUpdateItem(); // \ProcessMaker\PMIO\Model\TaskConnectorUpdateItem | TaskConnector object to edit

try {
    $result = $api_instance->updateTaskConnector($process_id, $task_id, $connector_id, $task_connector_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->updateTaskConnector: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of Process to fetch |
 **task_id** | **string**| ID of Task to fetch |
 **connector_id** | **string**| ID of Task Connector to fetch |
 **task_connector_update_item** | [**\ProcessMaker\PMIO\Model\TaskConnectorUpdateItem**](../Model/\ProcessMaker\PMIO\Model\TaskConnectorUpdateItem.md)| TaskConnector object to edit |

### Return type

[**\ProcessMaker\PMIO\Model\TaskConnector1**](../Model/TaskConnector1.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateTaskInstance**
> \ProcessMaker\PMIO\Model\InlineResponse200 updateTaskInstance($task_instance_id, $task_instance_update_item)



This method updates an existing task instance.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$task_instance_id = "task_instance_id_example"; // string | ID of task instance to retrieve
$task_instance_update_item = new \ProcessMaker\PMIO\Model\TaskInstanceUpdateItem(); // \ProcessMaker\PMIO\Model\TaskInstanceUpdateItem | Task Instance object to update

try {
    $result = $api_instance->updateTaskInstance($task_instance_id, $task_instance_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->updateTaskInstance: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **task_instance_id** | **string**| ID of task instance to retrieve |
 **task_instance_update_item** | [**\ProcessMaker\PMIO\Model\TaskInstanceUpdateItem**](../Model/\ProcessMaker\PMIO\Model\TaskInstanceUpdateItem.md)| Task Instance object to update |

### Return type

[**\ProcessMaker\PMIO\Model\InlineResponse200**](../Model/InlineResponse200.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateUser**
> \ProcessMaker\PMIO\Model\UserItem updateUser($id, $user_update_item)



This method updates an existing user.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Client();
$id = "id_example"; // string | ID of user to retrieve
$user_update_item = new \ProcessMaker\PMIO\Model\UserUpdateItem(); // \ProcessMaker\PMIO\Model\UserUpdateItem | User object for update

try {
    $result = $api_instance->updateUser($id, $user_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Client->updateUser: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| ID of user to retrieve |
 **user_update_item** | [**\ProcessMaker\PMIO\Model\UserUpdateItem**](../Model/\ProcessMaker\PMIO\Model\UserUpdateItem.md)| User object for update |

### Return type

[**\ProcessMaker\PMIO\Model\UserItem**](../Model/UserItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

