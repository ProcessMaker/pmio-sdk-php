# ProcessMaker\PMIO\ProcessInstance

All URIs are relative to *https://CHANGEME.api.processmaker.io/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addInstance**](ProcessInstance.md#addInstance) | **POST** /processes/{process_id}/instances | 
[**deleteInstance**](ProcessInstance.md#deleteInstance) | **DELETE** /processes/{process_id}/instances/{instance_id} | 
[**findByFieldInsideDataModel**](ProcessInstance.md#findByFieldInsideDataModel) | **GET** /processes/{process_id}/datamodels/search/{search_param} | 
[**findDataModel**](ProcessInstance.md#findDataModel) | **GET** /processes/{process_id}/instances/{instance_id}/datamodel | 
[**findInstanceById**](ProcessInstance.md#findInstanceById) | **GET** /processes/{process_id}/instances/{instance_id} | 
[**findInstances**](ProcessInstance.md#findInstances) | **GET** /processes/{process_id}/instances | 
[**findTaskInstancesByInstanceAndTaskId**](ProcessInstance.md#findTaskInstancesByInstanceAndTaskId) | **GET** /instances/{instance_id}/tasks/{task_id}/task_instances | 
[**findTaskInstancesByInstanceAndTaskIdDelegated**](ProcessInstance.md#findTaskInstancesByInstanceAndTaskIdDelegated) | **GET** /instances/{instance_id}/tasks/{task_id}/task_instances/delegated | 
[**findTaskInstancesByInstanceAndTaskIdStarted**](ProcessInstance.md#findTaskInstancesByInstanceAndTaskIdStarted) | **GET** /instances/{instance_id}/tasks/{task_id}/task_instances/started | 
[**findTokens**](ProcessInstance.md#findTokens) | **GET** /processes/{process_id}/instances/{instance_id}/tokens | 
[**updateInstance**](ProcessInstance.md#updateInstance) | **PUT** /processes/{process_id}/instances/{instance_id} | 


# **addInstance**
> \ProcessMaker\PMIO\Model\InstanceItem addInstance($process_id, $instance_create_item)



This method creates a new instance.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\ProcessInstance();
$process_id = "process_id_example"; // string | Process ID related to the instance
$instance_create_item = new \ProcessMaker\PMIO\Model\InstanceCreateItem(); // \ProcessMaker\PMIO\Model\InstanceCreateItem | JSON API response with the instance object to add

try {
    $result = $api_instance->addInstance($process_id, $instance_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProcessInstance->addInstance: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID related to the instance |
 **instance_create_item** | [**\ProcessMaker\PMIO\Model\InstanceCreateItem**](../Model/\ProcessMaker\PMIO\Model\InstanceCreateItem.md)| JSON API response with the instance object to add |

### Return type

[**\ProcessMaker\PMIO\Model\InstanceItem**](../Model/InstanceItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteInstance**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteInstance($process_id, $instance_id)



This method deletes an instance using the instance ID and the process ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\ProcessInstance();
$process_id = "process_id_example"; // string | Process ID
$instance_id = "instance_id_example"; // string | ID of the instance to delete

try {
    $result = $api_instance->deleteInstance($process_id, $instance_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProcessInstance->deleteInstance: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID |
 **instance_id** | **string**| ID of the instance to delete |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findByFieldInsideDataModel**
> \ProcessMaker\PMIO\Model\DataModelCollection findByFieldInsideDataModel($process_id, $search_param, $page, $per_page)



This method returns the data model by field passed in get argument.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\ProcessInstance();
$process_id = "process_id_example"; // string | ID of the process to return
$search_param = "search_param_example"; // string | Key and value of searched field in DataModel
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findByFieldInsideDataModel($process_id, $search_param, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProcessInstance->findByFieldInsideDataModel: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of the process to return |
 **search_param** | **string**| Key and value of searched field in DataModel |
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



This method returns the instance data model and lets the user work with it directly.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\ProcessInstance();
$process_id = "process_id_example"; // string | ID of the process to return
$instance_id = "instance_id_example"; // string | ID of the instance to return
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findDataModel($process_id, $instance_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProcessInstance->findDataModel: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of the process to return |
 **instance_id** | **string**| ID of the instance to return |
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

# **findInstanceById**
> \ProcessMaker\PMIO\Model\InstanceItem findInstanceById($process_id, $instance_id)



This method retrieves an instance using its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\ProcessInstance();
$process_id = "process_id_example"; // string | ID of the process to return
$instance_id = "instance_id_example"; // string | ID of the instance to return

try {
    $result = $api_instance->findInstanceById($process_id, $instance_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProcessInstance->findInstanceById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of the process to return |
 **instance_id** | **string**| ID of the instance to return |

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



This method retrieves instances related to the process using the process ID

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\ProcessInstance();
$process_id = "process_id_example"; // string | Process ID related to the instances
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findInstances($process_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProcessInstance->findInstances: ', $e->getMessage(), PHP_EOL;
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

# **findTaskInstancesByInstanceAndTaskId**
> \ProcessMaker\PMIO\Model\TaskInstanceCollection findTaskInstancesByInstanceAndTaskId($instance_id, $task_id)



This method retrieves task instances using the instance ID and the task ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\ProcessInstance();
$instance_id = "instance_id_example"; // string | ID of the instance
$task_id = "task_id_example"; // string | ID of the task

try {
    $result = $api_instance->findTaskInstancesByInstanceAndTaskId($instance_id, $task_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProcessInstance->findTaskInstancesByInstanceAndTaskId: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **instance_id** | **string**| ID of the instance |
 **task_id** | **string**| ID of the task |

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



This method retrieves delegated task instances using the instance ID and the task ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\ProcessInstance();
$instance_id = "instance_id_example"; // string | ID of the instance
$task_id = "task_id_example"; // string | ID of the task

try {
    $result = $api_instance->findTaskInstancesByInstanceAndTaskIdDelegated($instance_id, $task_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProcessInstance->findTaskInstancesByInstanceAndTaskIdDelegated: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **instance_id** | **string**| ID of the instance |
 **task_id** | **string**| ID of the task |

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



This method retrieves started task instances using the instance ID and the task ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\ProcessInstance();
$instance_id = "instance_id_example"; // string | ID of the instance
$task_id = "task_id_example"; // string | ID of the task

try {
    $result = $api_instance->findTaskInstancesByInstanceAndTaskIdStarted($instance_id, $task_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProcessInstance->findTaskInstancesByInstanceAndTaskIdStarted: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **instance_id** | **string**| ID of the instance |
 **task_id** | **string**| ID of the task |

### Return type

[**\ProcessMaker\PMIO\Model\TaskInstanceCollection**](../Model/TaskInstanceCollection.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **findTokens**
> \ProcessMaker\PMIO\Model\TokenCollection findTokens($process_id, $instance_id, $page, $per_page)



This method retrieves tokens related to the process and instance using the process and instance IDs

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\ProcessInstance();
$process_id = "process_id_example"; // string | Process ID
$instance_id = "instance_id_example"; // string | Instance ID related to the process
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findTokens($process_id, $instance_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProcessInstance->findTokens: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID |
 **instance_id** | **string**| Instance ID related to the process |
 **page** | **int**| Page number to fetch | [optional] [default to 1]
 **per_page** | **int**| Amount of items per page | [optional] [default to 15]

### Return type

[**\ProcessMaker\PMIO\Model\TokenCollection**](../Model/TokenCollection.md)

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

$api_instance = new ProcessMaker\PMIO\Api\ProcessInstance();
$process_id = "process_id_example"; // string | ID of the process to retrieve
$instance_id = "instance_id_example"; // string | ID of the instance to retrieve
$instance_update_item = new \ProcessMaker\PMIO\Model\InstanceUpdateItem(); // \ProcessMaker\PMIO\Model\InstanceUpdateItem | Instance object to edit

try {
    $result = $api_instance->updateInstance($process_id, $instance_id, $instance_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling ProcessInstance->updateInstance: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of the process to retrieve |
 **instance_id** | **string**| ID of the instance to retrieve |
 **instance_update_item** | [**\ProcessMaker\PMIO\Model\InstanceUpdateItem**](../Model/\ProcessMaker\PMIO\Model\InstanceUpdateItem.md)| Instance object to edit |

### Return type

[**\ProcessMaker\PMIO\Model\InstanceItem**](../Model/InstanceItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

