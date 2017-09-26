# ProcessMaker\PMIO\Oauth

All URIs are relative to *https://CHANGEME.api.processmaker.io/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addOauthClient**](Oauth.md#addOauthClient) | **POST** /users/{user_id}/clients | 
[**findOauthClientById**](Oauth.md#findOauthClientById) | **GET** /users/{user_id}/clients/{client_id} | 
[**findOauthClients**](Oauth.md#findOauthClients) | **GET** /users/{user_id}/clients | 


# **addOauthClient**
> \ProcessMaker\PMIO\Model\OauthClientItem addOauthClient($user_id, $oauth_client_create_item)



This method creates a new Oauth client for the user.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Oauth();
$user_id = "user_id_example"; // string | ID of the user related to the Oauth client
$oauth_client_create_item = new \ProcessMaker\PMIO\Model\OauthClientCreateItem(); // \ProcessMaker\PMIO\Model\OauthClientCreateItem | JSON API with the Oauth Client object to add

try {
    $result = $api_instance->addOauthClient($user_id, $oauth_client_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Oauth->addOauthClient: ', $e->getMessage(), PHP_EOL;
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

# **findOauthClientById**
> \ProcessMaker\PMIO\Model\OauthClientItem findOauthClientById($user_id, $client_id)



This method retrieves an Oauth client for the User based on its ID.  The response contains the `client_secret` required to obtain the `access_token`.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Oauth();
$user_id = "user_id_example"; // string | ID of user to retrieve
$client_id = "client_id_example"; // string | ID of Oauth client to retrieve

try {
    $result = $api_instance->findOauthClientById($user_id, $client_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Oauth->findOauthClientById: ', $e->getMessage(), PHP_EOL;
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



This method retrieves all existing Oauth clients belonging to a user.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Oauth();
$user_id = "user_id_example"; // string | User ID related to the Oauth clients
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findOauthClients($user_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Oauth->findOauthClients: ', $e->getMessage(), PHP_EOL;
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

