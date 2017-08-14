# ProcessMaker\PMIO\Events

All URIs are relative to *https://CHANGEME.api.processmaker.io/api/v1*

Method | HTTP request | Description
------------- | ------------- | -------------
[**addEvent**](Events.md#addEvent) | **POST** /processes/{process_id}/events | 
[**addEventConnector**](Events.md#addEventConnector) | **POST** /processes/{process_id}/events/{event_id}/connectors | 
[**deleteEvent**](Events.md#deleteEvent) | **DELETE** /processes/{process_id}/events/{event_id} | 
[**deleteEventConnector**](Events.md#deleteEventConnector) | **DELETE** /processes/{process_id}/events/{event_id}/connectors/{connector_id} | 
[**eventTrigger**](Events.md#eventTrigger) | **POST** /processes/{process_id}/events/{event_id}/trigger | 
[**eventWebhook**](Events.md#eventWebhook) | **POST** /processes/{process_id}/events/{event_id}/webhook | 
[**findEventById**](Events.md#findEventById) | **GET** /processes/{process_id}/events/{event_id} | 
[**findEventConnectorById**](Events.md#findEventConnectorById) | **GET** /processes/{process_id}/events/{event_id}/connectors/{connector_id} | 
[**findEventConnectors**](Events.md#findEventConnectors) | **GET** /processes/{process_id}/events/{event_id}/connectors | 
[**findEvents**](Events.md#findEvents) | **GET** /processes/{process_id}/events | 
[**updateEvent**](Events.md#updateEvent) | **PUT** /processes/{process_id}/events/{event_id} | 
[**updateEventConnector**](Events.md#updateEventConnector) | **PUT** /processes/{process_id}/events/{event_id}/connectors/{connector_id} | 


# **addEvent**
> \ProcessMaker\PMIO\Model\EventItem addEvent($process_id, $event_create_item)



This method creates the new event.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Events();
$process_id = "process_id_example"; // string | ID of the process related to the event
$event_create_item = new \ProcessMaker\PMIO\Model\EventCreateItem(); // \ProcessMaker\PMIO\Model\EventCreateItem | JSON API response with the Event object to add

try {
    $result = $api_instance->addEvent($process_id, $event_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Events->addEvent: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Events();
$process_id = "process_id_example"; // string | ID of Process to fetch
$event_id = "event_id_example"; // string | ID of Event to fetch
$event_connector_create_item = new \ProcessMaker\PMIO\Model\EventConnectorCreateItem(); // \ProcessMaker\PMIO\Model\EventConnectorCreateItem | JSON API with the EventConnector object to add

try {
    $result = $api_instance->addEventConnector($process_id, $event_id, $event_connector_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Events->addEventConnector: ', $e->getMessage(), PHP_EOL;
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

# **deleteEvent**
> \ProcessMaker\PMIO\Model\ResultSuccess deleteEvent($process_id, $event_id)



This method deletes an event using the event ID and process ID

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Events();
$process_id = "process_id_example"; // string | Process ID
$event_id = "event_id_example"; // string | ID of event to delete

try {
    $result = $api_instance->deleteEvent($process_id, $event_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Events->deleteEvent: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Events();
$process_id = "process_id_example"; // string | ID of of Process item
$event_id = "event_id_example"; // string | ID of item to fetch
$connector_id = "connector_id_example"; // string | ID of EventConnector to fetch

try {
    $result = $api_instance->deleteEventConnector($process_id, $event_id, $connector_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Events->deleteEventConnector: ', $e->getMessage(), PHP_EOL;
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

# **eventTrigger**
> \ProcessMaker\PMIO\Model\DataModelItem1 eventTrigger($process_id, $event_id, $trigger_event_create_item)



This method starts/triggers an event.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Events();
$process_id = "process_id_example"; // string | Process ID related to the event
$event_id = "event_id_example"; // string | ID of event to trigger
$trigger_event_create_item = new \ProcessMaker\PMIO\Model\TriggerEventCreateItem(); // \ProcessMaker\PMIO\Model\TriggerEventCreateItem | Json with some parameters

try {
    $result = $api_instance->eventTrigger($process_id, $event_id, $trigger_event_create_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Events->eventTrigger: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Events();
$process_id = "process_id_example"; // string | Process ID related to the event
$event_id = "event_id_example"; // string | ID of event to trigger
$trigger_body = "trigger_body_example"; // string | Freeform JSON structure, it will be passed to newly created DataModel

try {
    $result = $api_instance->eventWebhook($process_id, $event_id, $trigger_body);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Events->eventWebhook: ', $e->getMessage(), PHP_EOL;
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

# **findEventById**
> \ProcessMaker\PMIO\Model\EventItem findEventById($process_id, $event_id)



This method retrieves an event using its ID.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Events();
$process_id = "process_id_example"; // string | ID of process to return
$event_id = "event_id_example"; // string | ID of event to return

try {
    $result = $api_instance->findEventById($process_id, $event_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Events->findEventById: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Events();
$process_id = "process_id_example"; // string | ID of Process to fetch
$event_id = "event_id_example"; // string | ID of Event to fetch
$connector_id = "connector_id_example"; // string | ID of EventConnector to fetch

try {
    $result = $api_instance->findEventConnectorById($process_id, $event_id, $connector_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Events->findEventConnectorById: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Events();
$process_id = "process_id_example"; // string | ID of Process to fetch
$event_id = "event_id_example"; // string | ID of Task to fetch
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findEventConnectors($process_id, $event_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Events->findEventConnectors: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Events();
$process_id = "process_id_example"; // string | ID of process related to the event
$page = 1; // int | Page number to fetch
$per_page = 15; // int | Amount of items per page

try {
    $result = $api_instance->findEvents($process_id, $page, $per_page);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Events->findEvents: ', $e->getMessage(), PHP_EOL;
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

# **updateEvent**
> \ProcessMaker\PMIO\Model\EventItem updateEvent($process_id, $event_id, $event_update_item)



This method updates an existing event

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: PasswordGrant
ProcessMaker\PMIO\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$api_instance = new ProcessMaker\PMIO\Api\Events();
$process_id = "process_id_example"; // string | ID of process to retrieve
$event_id = "event_id_example"; // string | ID of event to retrieve
$event_update_item = new \ProcessMaker\PMIO\Model\EventUpdateItem(); // \ProcessMaker\PMIO\Model\EventUpdateItem | Event object to edit

try {
    $result = $api_instance->updateEvent($process_id, $event_id, $event_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Events->updateEvent: ', $e->getMessage(), PHP_EOL;
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

$api_instance = new ProcessMaker\PMIO\Api\Events();
$process_id = "process_id_example"; // string | ID of Process to fetch
$event_id = "event_id_example"; // string | ID of Event to fetch
$connector_id = "connector_id_example"; // string | ID of Event Connector to fetch
$event_connector_update_item = new \ProcessMaker\PMIO\Model\EventConnectorUpdateItem(); // \ProcessMaker\PMIO\Model\EventConnectorUpdateItem | EventConnector object to edit

try {
    $result = $api_instance->updateEventConnector($process_id, $event_id, $connector_id, $event_connector_update_item);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling Events->updateEventConnector: ', $e->getMessage(), PHP_EOL;
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

