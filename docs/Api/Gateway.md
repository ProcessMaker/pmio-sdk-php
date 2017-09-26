# ProcessMaker\PMIO\Gateway

All URIs are relative to *https://CHANGEME.api.processmaker.io/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addGateway**](Gateway.md#addGateway) | **POST** /processes/{process_id}/gateways | 
[**deleteGateway**](Gateway.md#deleteGateway) | **DELETE** /processes/{process_id}/gateways/{gateway_id} | 
[**findGatewayById**](Gateway.md#findGatewayById) | **GET** /processes/{process_id}/gateways/{gateway_id} | 
[**findGateways**](Gateway.md#findGateways) | **GET** /processes/{process_id}/gateways | 
[**updateGateway**](Gateway.md#updateGateway) | **PUT** /processes/{process_id}/gateways/{gateway_id} | 


# **addGateway**
> \ProcessMaker\PMIO\Model\GatewayItem addGateway($process_id, $gateway_create_item)



This method creates a new gateway.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Gateway();
$process_id = "process_id_example"; // string | ID of the process related to the gateway
$gateway_create_item = new \ProcessMaker\PMIO\Model\GatewayCreateItem(); // \ProcessMaker\PMIO\Model\GatewayCreateItem | JSON API response with the gateway object to add

try {
    $result = $api_instance->addGateway($process_id, $gateway_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Gateway->addGateway: ', $e->getMessage(), PHP_EOL;
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

# **deleteGateway**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteGateway($process_id, $gateway_id)



This method deletes a single item using the gateway ID and the process ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Gateway();
$process_id = "process_id_example"; // string | Process ID
$gateway_id = "gateway_id_example"; // string | ID of the process to delete

try {
    $result = $api_instance->deleteGateway($process_id, $gateway_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Gateway->deleteGateway: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| Process ID |
 **gateway_id** | **string**| ID of the process to delete |

### Return type

[**\ProcessMaker\PMIO\Model\ResultSuccess**](../Model/ResultSuccess.md)

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

$api_instance = new ProcessMaker\PMIO\Api\Gateway();
$process_id = "process_id_example"; // string | ID of the process to return
$gateway_id = "gateway_id_example"; // string | ID of gateway to return

try {
    $result = $api_instance->findGatewayById($process_id, $gateway_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Gateway->findGatewayById: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of the process to return |
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

$api_instance = new ProcessMaker\PMIO\Api\Gateway();
$process_id = "process_id_example"; // string | ID of the process related to the gateway
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findGateways($process_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Gateway->findGateways: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of the process related to the gateway |
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

# **updateGateway**
> \ProcessMaker\PMIO\Model\GatewayItem updateGateway($process_id, $gateway_id, $gateway_update_item)



This method updates an existing gateway.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Gateway();
$process_id = "process_id_example"; // string | ID of the process to retrieve
$gateway_id = "gateway_id_example"; // string | ID of the gateway to retrieve
$gateway_update_item = new \ProcessMaker\PMIO\Model\GatewayUpdateItem(); // \ProcessMaker\PMIO\Model\GatewayUpdateItem | Gateway object to edit

try {
    $result = $api_instance->updateGateway($process_id, $gateway_id, $gateway_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Gateway->updateGateway: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **process_id** | **string**| ID of the process to retrieve |
 **gateway_id** | **string**| ID of the gateway to retrieve |
 **gateway_update_item** | [**\ProcessMaker\PMIO\Model\GatewayUpdateItem**](../Model/\ProcessMaker\PMIO\Model\GatewayUpdateItem.md)| Gateway object to edit |

### Return type

[**\ProcessMaker\PMIO\Model\GatewayItem**](../Model/GatewayItem.md)

### Authorization

[PasswordGrant](../../README.md#PasswordGrant)

### HTTP request headers

 - **Content-Type**: application/vnd.api+json
 - **Accept**: application/vnd.api+json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

