# ProcessMaker\PMIO\Inputoutput

All URIs are relative to *https://CHANGEME.api.processmaker.io/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addInputOutput**](Inputoutput.md#addInputOutput) | **POST** /processes/{process_id}/tasks/{task_id}/inputoutput | 
[**deleteInputOutput**](Inputoutput.md#deleteInputOutput) | **DELETE** /processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid} | 
[**findInputOutputById**](Inputoutput.md#findInputOutputById) | **GET** /processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid} | 
[**findInputOutputs**](Inputoutput.md#findInputOutputs) | **GET** /processes/{process_id}/tasks/{task_id}/inputoutput | 
[**updateInputOutput**](Inputoutput.md#updateInputOutput) | **PUT** /processes/{process_id}/tasks/{task_id}/inputoutput/{inputoutput_uid} | 


# **addInputOutput**
> \ProcessMaker\PMIO\Model\InputOutputItem addInputOutput($process_id, $task_id, $input_output_create_item)



This method creates a new Input/Output object

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Inputoutput();
$process_id = "process_id_example"; // string | Process ID related to Input/Output object
$task_id = "task_id_example"; // string | Task instance ID related to Input/Output object
$input_output_create_item = new \ProcessMaker\PMIO\Model\InputOutputCreateItem(); // \ProcessMaker\PMIO\Model\InputOutputCreateItem | Create and add a new Input/Output object with JSON API

try {
    $result = $api_instance->addInputOutput($process_id, $task_id, $input_output_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Inputoutput->addInputOutput: ', $e->getMessage(), PHP_EOL;
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

# **deleteInputOutput**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteInputOutput($process_id, $task_id, $inputoutput_uid)



This method deletes the Input/Output based on the Input/Output ID, process ID and task ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Inputoutput();
$process_id = "process_id_example"; // string | Process ID related to the Input/Output object
$task_id = "task_id_example"; // string | Task instance ID related to Input/Output object
$inputoutput_uid = "inputoutput_uid_example"; // string | Input/Output ID to fetch

try {
    $result = $api_instance->deleteInputOutput($process_id, $task_id, $inputoutput_uid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Inputoutput->deleteInputOutput: ', $e->getMessage(), PHP_EOL;
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

# **findInputOutputById**
> \ProcessMaker\PMIO\Model\InputOutputItem findInputOutputById($process_id, $task_id, $inputoutput_uid)



This method retrieves an Input/Output object using its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Inputoutput();
$process_id = "process_id_example"; // string | Process ID related to the Input/Output object
$task_id = "task_id_example"; // string | Task instance ID related to the Input/Output object
$inputoutput_uid = "inputoutput_uid_example"; // string | ID of Input/Output to return

try {
    $result = $api_instance->findInputOutputById($process_id, $task_id, $inputoutput_uid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Inputoutput->findInputOutputById: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Inputoutput();
$process_id = "process_id_example"; // string | Process ID related to Input/Output object
$task_id = "task_id_example"; // string | Task instance ID related to Input/Output object
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findInputOutputs($process_id, $task_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Inputoutput->findInputOutputs: ', $e->getMessage(), PHP_EOL;
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

# **updateInputOutput**
> \ProcessMaker\PMIO\Model\InputOutputItem updateInputOutput($process_id, $task_id, $inputoutput_uid, $input_output_update_item)



This method updates an existing Input/Output object.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Inputoutput();
$process_id = "process_id_example"; // string | Process ID related to the Input/Output object
$task_id = "task_id_example"; // string | Task instance ID related to the Input/Output object
$inputoutput_uid = "inputoutput_uid_example"; // string | ID of Input/Output to retrieve
$input_output_update_item = new \ProcessMaker\PMIO\Model\InputOutputUpdateItem(); // \ProcessMaker\PMIO\Model\InputOutputUpdateItem | Input/Output object to edit

try {
    $result = $api_instance->updateInputOutput($process_id, $task_id, $inputoutput_uid, $input_output_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Inputoutput->updateInputOutput: ', $e->getMessage(), PHP_EOL;
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

