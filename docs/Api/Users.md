# ProcessMaker\PMIO\Users

All URIs are relative to *https://CHANGEME.api.processmaker.io/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addUser**](Users.md#addUser) | **POST** /users | 
[**deleteUser**](Users.md#deleteUser) | **DELETE** /users/{id} | 
[**findUserById**](Users.md#findUserById) | **GET** /users/{id} | 
[**findUsers**](Users.md#findUsers) | **GET** /users | 
[**myselfUser**](Users.md#myselfUser) | **GET** /users/myself | 
[**updateUser**](Users.md#updateUser) | **PUT** /users/{id} | 


# **addUser**
> \ProcessMaker\PMIO\Model\UserItem addUser($user_create_item)



This method creates a new user in the system. The client_id will appear in the results.  The `client_id` is required to obtain a `client_secret` and then you will be able to use it in an Oauth authorization key. Refer to [Oauth Client APIs](#tag/oauth)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Users();
$user_create_item = new \ProcessMaker\PMIO\Model\UserCreateItem(); // \ProcessMaker\PMIO\Model\UserCreateItem | JSON API with the User object to add

try {
    $result = $api_instance->addUser($user_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Users->addUser: ', $e->getMessage(), PHP_EOL;
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

# **deleteUser**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteUser($id)



This method deletes a user from the system.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Users();
$id = "id_example"; // string | ID of user to delete

try {
    $result = $api_instance->deleteUser($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Users->deleteUser: ', $e->getMessage(), PHP_EOL;
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

# **findUserById**
> \ProcessMaker\PMIO\Model\UserItem findUserById($id)



This method returns a user using its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Users();
$id = "id_example"; // string | ID of the user to return

try {
    $result = $api_instance->findUserById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Users->findUserById: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Users();
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findUsers($page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Users->findUsers: ', $e->getMessage(), PHP_EOL;
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

# **myselfUser**
> \ProcessMaker\PMIO\Model\UserItem myselfUser($page, $per_page)



This method returns user information using a token.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Users();
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->myselfUser($page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Users->myselfUser: ', $e->getMessage(), PHP_EOL;
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

# **updateUser**
> \ProcessMaker\PMIO\Model\UserItem updateUser($id, $user_update_item)



This method updates an existing user.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Users();
$id = "id_example"; // string | ID of user to retrieve
$user_update_item = new \ProcessMaker\PMIO\Model\UserUpdateItem(); // \ProcessMaker\PMIO\Model\UserUpdateItem | User object for update

try {
    $result = $api_instance->updateUser($id, $user_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Users->updateUser: ', $e->getMessage(), PHP_EOL;
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

