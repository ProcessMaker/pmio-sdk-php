# ProcessMaker\PMIO\Flows

All URIs are relative to *https://CHANGEME.api.processmaker.io/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addFlow**](Flows.md#addFlow) | **POST** /processes/{process_id}/flows | 
[**deleteFlow**](Flows.md#deleteFlow) | **DELETE** /processes/{process_id}/flows/{flow_id} | 
[**findFlowById**](Flows.md#findFlowById) | **GET** /processes/{process_id}/flows/{flow_id} | 
[**listFlows**](Flows.md#listFlows) | **GET** /processes/{process_id}/flows | 
[**updateFlow**](Flows.md#updateFlow) | **PUT** /processes/{process_id}/flows/{flow_id} | 


# **addFlow**
> \ProcessMaker\PMIO\Model\FlowItem addFlow($process_id, $flow_create_item)



This method creates a new Sequence Flow.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Flows();
$process_id = "process_id_example"; // string | ID of the process related to the flow
$flow_create_item = new \ProcessMaker\PMIO\Model\FlowCreateItem(); // \ProcessMaker\PMIO\Model\FlowCreateItem | JSON API response with the Flow object to add

try {
    $result = $api_instance->addFlow($process_id, $flow_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Flows->addFlow: ', $e->getMessage(), PHP_EOL;
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

# **deleteFlow**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteFlow($process_id, $flow_id)



This method deletes the Sequence Flow using the flow ID and the process ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Flows();
$process_id = "process_id_example"; // string | Process ID
$flow_id = "flow_id_example"; // string | ID of the flow to delete

try {
    $result = $api_instance->deleteFlow($process_id, $flow_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Flows->deleteFlow: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID |
 **flow_id** | **string**| ID of the flow to delete |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

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

$api_instance = new ProcessMaker\PMIO\Api\Flows();
$process_id = "process_id_example"; // string | ID of the process to return
$flow_id = "flow_id_example"; // string | ID of the flow to return

try {
    $result = $api_instance->findFlowById($process_id, $flow_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Flows->findFlowById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of the process to return |
 **flow_id** | **string**| ID of the flow to return |

### Return type

[**\ProcessMaker\PMIO\Model\FlowItem**](../Model/FlowItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listFlows**
> \ProcessMaker\PMIO\Model\FlowCollection listFlows($process_id, $page, $per_page)



This method retrieves all existing flows.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Flows();
$process_id = "process_id_example"; // string | ID of the process related to the flow
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->listFlows($process_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Flows->listFlows: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of the process related to the flow |
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

# **updateFlow**
> \ProcessMaker\PMIO\Model\FlowItem updateFlow($process_id, $flow_id, $flow_update_item)



This method updates an existing flow.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Flows();
$process_id = "process_id_example"; // string | ID of the process to retrieve
$flow_id = "flow_id_example"; // string | ID of the flow to retrieve
$flow_update_item = new \ProcessMaker\PMIO\Model\FlowUpdateItem(); // \ProcessMaker\PMIO\Model\FlowUpdateItem | Flow object to edit

try {
    $result = $api_instance->updateFlow($process_id, $flow_id, $flow_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Flows->updateFlow: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of the process to retrieve |
 **flow_id** | **string**| ID of the flow to retrieve |
 **flow_update_item** | [**\ProcessMaker\PMIO\Model\FlowUpdateItem**](../Model/\ProcessMaker\PMIO\Model\FlowUpdateItem.md)| Flow object to edit |

### Return type

[**\ProcessMaker\PMIO\Model\FlowItem**](../Model/FlowItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

