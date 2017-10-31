# ProcessMaker\PMIO\Groups

All URIs are relative to *https://CHANGEME.api.processmaker.io/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addGroup**](Groups.md#addGroup) | **POST** /groups | 
[**addUsersToGroup**](Groups.md#addUsersToGroup) | **PUT** /groups/{id}/users | 
[**deleteGroup**](Groups.md#deleteGroup) | **DELETE** /groups/{id} | 
[**findGroupById**](Groups.md#findGroupById) | **GET** /groups/{id} | 
[**listGroups**](Groups.md#listGroups) | **GET** /groups | 
[**removeUsersFromGroup**](Groups.md#removeUsersFromGroup) | **DELETE** /groups/{id}/users | 
[**syncUsersToGroup**](Groups.md#syncUsersToGroup) | **POST** /groups/{id}/users | 
[**updateGroup**](Groups.md#updateGroup) | **PUT** /groups/{id} | 


# **addGroup**
> \ProcessMaker\PMIO\Model\GroupItem addGroup($group_create_item)



This method creates a new group.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Groups();
$group_create_item = new \ProcessMaker\PMIO\Model\GroupCreateItem(); // \ProcessMaker\PMIO\Model\GroupCreateItem | JSON API with the Group object to add

try {
    $result = $api_instance->addGroup($group_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Groups->addGroup: ', $e->getMessage(), PHP_EOL;
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

# **addUsersToGroup**
> \ProcessMaker\PMIO\Model\ResultSuccess addUsersToGroup($id, $group_add_users_item)



This method adds one or more new users to a group.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Groups();
$id = "id_example"; // string | ID of group to be modified
$group_add_users_item = new \ProcessMaker\PMIO\Model\GroupAddUsersItem(); // \ProcessMaker\PMIO\Model\GroupAddUsersItem | JSON API response with array of user IDs

try {
    $result = $api_instance->addUsersToGroup($id, $group_add_users_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Groups->addUsersToGroup: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **id** | **string**| ID of group to be modified |
 **group_add_users_item** | [**\ProcessMaker\PMIO\Model\GroupAddUsersItem**](../Model/\ProcessMaker\PMIO\Model\GroupAddUsersItem.md)| JSON API response with array of user IDs |

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



This method deletes a group using the group ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Groups();
$id = "id_example"; // string | ID of group to delete

try {
    $result = $api_instance->deleteGroup($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Groups->deleteGroup: ', $e->getMessage(), PHP_EOL;
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

# **findGroupById**
> \ProcessMaker\PMIO\Model\GroupItem findGroupById($id)



This method retrieves a group using its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Groups();
$id = "id_example"; // string | ID of group to return

try {
    $result = $api_instance->findGroupById($id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Groups->findGroupById: ', $e->getMessage(), PHP_EOL;
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

# **listGroups**
> \ProcessMaker\PMIO\Model\GroupCollection listGroups($page, $per_page)



This method retrieves all existing groups.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Groups();
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->listGroups($page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Groups->listGroups: ', $e->getMessage(), PHP_EOL;
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

# **removeUsersFromGroup**
> \ProcessMaker\PMIO\Model\ResultSuccess removeUsersFromGroup($id, $group_remove_users_item)



This method removes one or more users from a group.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Groups();
$id = "id_example"; // string | ID of group to be modified
$group_remove_users_item = new \ProcessMaker\PMIO\Model\GroupRemoveUsersItem(); // \ProcessMaker\PMIO\Model\GroupRemoveUsersItem | JSON API response with Users IDs to remove

try {
    $result = $api_instance->removeUsersFromGroup($id, $group_remove_users_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Groups->removeUsersFromGroup: ', $e->getMessage(), PHP_EOL;
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

# **syncUsersToGroup**
> \ProcessMaker\PMIO\Model\ResultSuccess syncUsersToGroup($id, $group_sync_users_item)



This method synchronizes one or more users with a group.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Groups();
$id = "id_example"; // string | ID of group to be modified
$group_sync_users_item = new \ProcessMaker\PMIO\Model\GroupSyncUsersItem(); // \ProcessMaker\PMIO\Model\GroupSyncUsersItem | JSON API with array of users IDs to sync

try {
    $result = $api_instance->syncUsersToGroup($id, $group_sync_users_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Groups->syncUsersToGroup: ', $e->getMessage(), PHP_EOL;
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

# **updateGroup**
> \ProcessMaker\PMIO\Model\GroupItem updateGroup($id, $group_update_item)



This method updates an existing group.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Groups();
$id = "id_example"; // string | ID of group to retrieve
$group_update_item = new \ProcessMaker\PMIO\Model\GroupUpdateItem(); // \ProcessMaker\PMIO\Model\GroupUpdateItem | Group object to edit

try {
    $result = $api_instance->updateGroup($id, $group_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Groups->updateGroup: ', $e->getMessage(), PHP_EOL;
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

