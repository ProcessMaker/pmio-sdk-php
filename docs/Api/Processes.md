# ProcessMaker\PMIO\Processes

All URIs are relative to *https://CHANGEME.api.processmaker.io/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addProcess**](Processes.md#addProcess) | **POST** /processes | 
[**deleteProcess**](Processes.md#deleteProcess) | **DELETE** /processes/{id} | 
[**findProcessById**](Processes.md#findProcessById) | **GET** /processes/{id} | 
[**findProcesses**](Processes.md#findProcesses) | **GET** /processes | 
[**importBpmnFile**](Processes.md#importBpmnFile) | **POST** /processes/import | 
[**updateProcess**](Processes.md#updateProcess) | **PUT** /processes/{id} | 


# **addProcess**
> \ProcessMaker\PMIO\Model\ProcessItem addProcess($process_create_item)



This method creates a new process.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Processes();
$process_create_item = new \ProcessMaker\PMIO\Model\ProcessCreateItem(); // \ProcessMaker\PMIO\Model\ProcessCreateItem | JSON API response with the process object to add

try {
    $result = $api_instance->addProcess($process_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Processes->addProcess: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_create_item** | [**\ProcessMaker\PMIO\Model\ProcessCreateItem**](../Model/\ProcessMaker\PMIO\Model\ProcessCreateItem.md)| JSON API response with the process object to add |

### Return type

[**\ProcessMaker\PMIO\Model\ProcessItem**](../Model/ProcessItem.md)

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

$api_instance = new ProcessMaker\PMIO\Api\Processes();
$id = "id_example"; // string | Process ID to delete

try {
    $result = $api_instance->deleteProcess($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Processes->deleteProcess: ', $e->getMessage(), PHP_EOL;
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

# **findProcessById**
> \ProcessMaker\PMIO\Model\ProcessItem findProcessById($id)



This method retrieves a process using its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Processes();
$id = "id_example"; // string | ID of the process to return

try {
    $result = $api_instance->findProcessById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Processes->findProcessById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| ID of the process to return |

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

$api_instance = new ProcessMaker\PMIO\Api\Processes();
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findProcesses($page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Processes->findProcesses: ', $e->getMessage(), PHP_EOL;
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

# **importBpmnFile**
> \ProcessMaker\PMIO\Model\ProcessCollection1 importBpmnFile($bpmn_import_item)



This method imports BPMN 2.0 files. A new process(es) is/are created and its object returned back when import is successful.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Processes();
$bpmn_import_item = new \ProcessMaker\PMIO\Model\BpmnImportItem(); // \ProcessMaker\PMIO\Model\BpmnImportItem | JSON API with the BPMN file to import

try {
    $result = $api_instance->importBpmnFile($bpmn_import_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Processes->importBpmnFile: ', $e->getMessage(), PHP_EOL;
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

# **updateProcess**
> \ProcessMaker\PMIO\Model\ProcessItem updateProcess($id, $process_update_item)



This method updates an existing process.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Processes();
$id = "id_example"; // string | ID of the process to retrieve
$process_update_item = new \ProcessMaker\PMIO\Model\ProcessUpdateItem(); // \ProcessMaker\PMIO\Model\ProcessUpdateItem | Process object to edit

try {
    $result = $api_instance->updateProcess($id, $process_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Processes->updateProcess: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| ID of the process to retrieve |
 **process_update_item** | [**\ProcessMaker\PMIO\Model\ProcessUpdateItem**](../Model/\ProcessMaker\PMIO\Model\ProcessUpdateItem.md)| Process object to edit |

### Return type

[**\ProcessMaker\PMIO\Model\ProcessItem**](../Model/ProcessItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

