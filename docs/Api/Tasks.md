# ProcessMaker\PMIO\Tasks

All URIs are relative to *https://CHANGEME.api.processmaker.io/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addGroupsToTask**](Tasks.md#addGroupsToTask) | **PUT** /processes/{process_id}/tasks/{task_id}/groups | 
[**addTask**](Tasks.md#addTask) | **POST** /processes/{process_id}/tasks | 
[**addTaskConnector**](Tasks.md#addTaskConnector) | **POST** /processes/{process_id}/tasks/{task_id}/connectors | 
[**deleteTask**](Tasks.md#deleteTask) | **DELETE** /processes/{process_id}/tasks/{task_id} | 
[**deleteTaskConnector**](Tasks.md#deleteTaskConnector) | **DELETE** /processes/{process_id}/tasks/{task_id}/connectors/{connector_id} | 
[**findTaskById**](Tasks.md#findTaskById) | **GET** /processes/{process_id}/tasks/{task_id} | 
[**findTaskConnectorById**](Tasks.md#findTaskConnectorById) | **GET** /processes/{process_id}/tasks/{task_id}/connectors/{connector_id} | 
[**findTaskConnectors**](Tasks.md#findTaskConnectors) | **GET** /processes/{process_id}/tasks/{task_id}/connectors | 
[**findTaskInstanceById**](Tasks.md#findTaskInstanceById) | **GET** /task_instances/{task_instance_id} | 
[**findTaskInstances**](Tasks.md#findTaskInstances) | **GET** /task_instances | 
[**findTasks**](Tasks.md#findTasks) | **GET** /processes/{process_id}/tasks | 
[**removeGroupsFromTask**](Tasks.md#removeGroupsFromTask) | **DELETE** /processes/{process_id}/tasks/{task_id}/groups | 
[**syncGroupsToTask**](Tasks.md#syncGroupsToTask) | **POST** /processes/{process_id}/tasks/{task_id}/groups | 
[**updateTask**](Tasks.md#updateTask) | **PUT** /processes/{process_id}/tasks/{task_id} | 
[**updateTaskConnector**](Tasks.md#updateTaskConnector) | **PUT** /processes/{process_id}/tasks/{task_id}/connectors/{connector_id} | 
[**updateTaskInstance**](Tasks.md#updateTaskInstance) | **PATCH** /task_instances/{task_instance_id} | 


# **addGroupsToTask**
> \ProcessMaker\PMIO\Model\ResultSuccess addGroupsToTask($process_id, $task_id, $task_add_groups_item)



This method assigns group(s) to the chosen task

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$process_id = "process_id_example"; // string | Process ID
$task_id = "task_id_example"; // string | ID of task to be modified
$task_add_groups_item = new \ProcessMaker\PMIO\Model\TaskAddGroupsItem(); // \ProcessMaker\PMIO\Model\TaskAddGroupsItem | JSON API with Groups ID's to add

try {
    $result = $api_instance->addGroupsToTask($process_id, $task_id, $task_add_groups_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->addGroupsToTask: ', $e->getMessage(), PHP_EOL;
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

# **addTask**
> \ProcessMaker\PMIO\Model\TaskItem addTask($process_id, $task_create_item)



This method creates a new task.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$process_id = "process_id_example"; // string | Process ID related to the task
$task_create_item = new \ProcessMaker\PMIO\Model\TaskCreateItem(); // \ProcessMaker\PMIO\Model\TaskCreateItem | JSON API with the Task object to add

try {
    $result = $api_instance->addTask($process_id, $task_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->addTask: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$process_id = "process_id_example"; // string | ID of Process to fetch
$task_id = "task_id_example"; // string | ID of Task to fetch
$task_connector_create_item = new \ProcessMaker\PMIO\Model\TaskConnectorCreateItem(); // \ProcessMaker\PMIO\Model\TaskConnectorCreateItem | JSON API with the TaskConnector object to add

try {
    $result = $api_instance->addTaskConnector($process_id, $task_id, $task_connector_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->addTaskConnector: ', $e->getMessage(), PHP_EOL;
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

# **deleteTask**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteTask($process_id, $task_id)



This method deletes a task using the task ID and process ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$process_id = "process_id_example"; // string | Process ID
$task_id = "task_id_example"; // string | ID of task to delete

try {
    $result = $api_instance->deleteTask($process_id, $task_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->deleteTask: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$process_id = "process_id_example"; // string | ID of Process item to fetch
$task_id = "task_id_example"; // string | ID of Task item to fetch
$connector_id = "connector_id_example"; // string | ID of TaskConnector to fetch

try {
    $result = $api_instance->deleteTaskConnector($process_id, $task_id, $connector_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->deleteTaskConnector: ', $e->getMessage(), PHP_EOL;
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

# **findTaskById**
> \ProcessMaker\PMIO\Model\TaskItem findTaskById($process_id, $task_id)



This method is retrieves a task using its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$process_id = "process_id_example"; // string | ID of process to return
$task_id = "task_id_example"; // string | ID of task to return

try {
    $result = $api_instance->findTaskById($process_id, $task_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->findTaskById: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$process_id = "process_id_example"; // string | ID of Process to fetch
$task_id = "task_id_example"; // string | ID of Task to fetch
$connector_id = "connector_id_example"; // string | ID of TaskConnector to fetch

try {
    $result = $api_instance->findTaskConnectorById($process_id, $task_id, $connector_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->findTaskConnectorById: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$process_id = "process_id_example"; // string | ID of Process to fetch
$task_id = "task_id_example"; // string | ID of Task to fetch
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findTaskConnectors($process_id, $task_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->findTaskConnectors: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$task_instance_id = "task_instance_id_example"; // string | ID of task instance to return
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findTaskInstanceById($task_instance_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->findTaskInstanceById: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findTaskInstances($page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->findTaskInstances: ', $e->getMessage(), PHP_EOL;
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

# **findTasks**
> \ProcessMaker\PMIO\Model\TaskCollection findTasks($process_id, $page, $per_page)



This method is intended for returning a list of all Tasks related to the process

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$process_id = "process_id_example"; // string | ID of Process relative to task
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findTasks($process_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->findTasks: ', $e->getMessage(), PHP_EOL;
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

# **removeGroupsFromTask**
> \ProcessMaker\PMIO\Model\ResultSuccess removeGroupsFromTask($process_id, $task_id, $task_remove_groups_item)



This method removes groups from a task

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$process_id = "process_id_example"; // string | Process ID
$task_id = "task_id_example"; // string | Task ID
$task_remove_groups_item = new \ProcessMaker\PMIO\Model\TaskRemoveGroupsItem(); // \ProcessMaker\PMIO\Model\TaskRemoveGroupsItem | JSON API response with Groups IDs to remove

try {
    $result = $api_instance->removeGroupsFromTask($process_id, $task_id, $task_remove_groups_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->removeGroupsFromTask: ', $e->getMessage(), PHP_EOL;
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

# **syncGroupsToTask**
> \ProcessMaker\PMIO\Model\ResultSuccess syncGroupsToTask($process_id, $task_id, $task_sync_groups_item)



This method synchronizes a one or more groups with a task.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$process_id = "process_id_example"; // string | Process ID
$task_id = "task_id_example"; // string | ID of task to modify
$task_sync_groups_item = new \ProcessMaker\PMIO\Model\TaskSyncGroupsItem(); // \ProcessMaker\PMIO\Model\TaskSyncGroupsItem | JSON API response with groups IDs to sync

try {
    $result = $api_instance->syncGroupsToTask($process_id, $task_id, $task_sync_groups_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->syncGroupsToTask: ', $e->getMessage(), PHP_EOL;
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

# **updateTask**
> \ProcessMaker\PMIO\Model\TaskItem updateTask($process_id, $task_id, $task_update_item)



This method is intended for updating an existing task.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$process_id = "process_id_example"; // string | ID of Process to fetch
$task_id = "task_id_example"; // string | ID of Task to fetch
$task_update_item = new \ProcessMaker\PMIO\Model\TaskUpdateItem(); // \ProcessMaker\PMIO\Model\TaskUpdateItem | Task object to edit

try {
    $result = $api_instance->updateTask($process_id, $task_id, $task_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->updateTask: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$process_id = "process_id_example"; // string | ID of Process to fetch
$task_id = "task_id_example"; // string | ID of Task to fetch
$connector_id = "connector_id_example"; // string | ID of Task Connector to fetch
$task_connector_update_item = new \ProcessMaker\PMIO\Model\TaskConnectorUpdateItem(); // \ProcessMaker\PMIO\Model\TaskConnectorUpdateItem | TaskConnector object to edit

try {
    $result = $api_instance->updateTaskConnector($process_id, $task_id, $connector_id, $task_connector_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->updateTaskConnector: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Tasks();
$task_instance_id = "task_instance_id_example"; // string | ID of task instance to retrieve
$task_instance_update_item = new \ProcessMaker\PMIO\Model\TaskInstanceUpdateItem(); // \ProcessMaker\PMIO\Model\TaskInstanceUpdateItem | Task Instance object to update

try {
    $result = $api_instance->updateTaskInstance($task_instance_id, $task_instance_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Tasks->updateTaskInstance: ', $e->getMessage(), PHP_EOL;
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

