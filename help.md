---

Author: Usabilla.com
Version: 1.0

---

# Usbilla Public API Documenttion


## [Table of contents](#def-introduction)
1. [Introduction](#def-introduction)
2. [Credentials](#def-api-credentials)
3. [Authentication](#def-api-authentication)
4. [Resources](#def-resources)
    1. [Resource types](#def-resource-types)
		1. [Buttons](#def-resource-buttons)
		2. [Feedback Items](#def-resource-feedback)
		3. [Campaigns](#def-resource-campaigns)
		4. [Campaign results](#def-campaign-results)
    2. [Resource requests](#def-resource-request)
   		1. [Query parameters](#def-request-parameters)
   		2. [Request URLs](#def-request-urls)
5. [Response](#def-response)

---

<br>

<a name="def-introduction"></a>
## 1. Introduction
This documents is full specification of the API Blueprint format. For a less formal introduction to API Blueprint visit the [API Blueprint Tutorial](Tutorial.md) or check some of the [examples](examples).

Welcome to the Usabilla Public API documentation. Here you will find a detailed guide on how to access the your resources using one of our client libraries for [GO](go),[Python](py) and [PHP](php).

Currently we only support the Live for Websites product.


<a name="def-api-credentials"></a>
## 2. Acquiring the Usabilla credentials
The credentials consist in an access and a secret key used for authentication purposes.
In order to gain access to the credentials: (TODO)

<a name="def-api-authorization"></a>
## 3. Authentication
Authentication is realised by sending an authorization header. The authorization header has the following components:

* Algorithm - The name of the algorithm used to calculate the signature
* Credential - Information used to calculate the signature
	* Client Access Key
	* Date (Ymd format)
* SignedHeaders:
	* date
	* host
	* user-agent
* Signature: The computed signature

| Component   |      Description    |
|----------|-------------|
| Algorithm |  The name of the algorithm used to calculate the signature. Required value is USBL1-HMAC-SHA256 |
| Credential |    Information used to calculate the signature. Includes Client access key and a date in Ymd format.   |
| SignedHeaders | The name of the headers required to calculate the signature. |
| Signature | The resulting signature which is a 256-bit string  |

Example:


#### Example

     Authorization:

            USBL1-HMAC-SHA256 Credential=AccessKey/20130524/usbl1_request, 
			SignedHeaders=date;host;user-agent
			Signature=fe5f80f77d5fa3beca038a248ff027d0445342fe2855ddc963176630326f1024

---


<a name="def-resources"></a>
## 4. Resources

Information that is usually found on the Usabilla website.



<a name="def-resource-types"></a>
### 4.1 Resource types

The resources that can be retrieved for the Live for Websites product, using this API are the following:

* [Buttons](#def-resource-buttons)
* [Feedback Items](#def-resource-feedback)
* [Campaigns](#def-resource-campaigns)
* [Campaign results](#def-campaign-results)

<a name="def-resource-buttons"></a>
#### 4.1.1 Buttons

Buttons represent the source of feedback items. The button id can be used to request feedback items.

| Field   |      Description    |
|----------|-------------|
| id |  Unique identifier for a button. 12 characthers long. |
| name |    The name of the button given when created. Can be updated in the [button setup page](https://usabilla.com/member/live/setup).  |

####Example

```json
{
    "_id" : "8d73568ac2be",
    "name" : "My button",
}
```
<a name="def-resource-feedback"></a>
#### 4.1.2 Feedback Items

Feedback items contain information about the user that has given feedback and aditional data contained by the form.

| Field   |      Description    | Type | Optional | 
|----------|-------------|-------------|---------|
| id |  Unique identifier for a button. 12 characthers long. | string | No |
| userAgent |  Information about the browser user agent.  | string | No |
| comment |  Commentary left by the user in the feedback form. | string | Yes |
| location |  String containing geographical information about the location of the user based on his ip address. | string | Yes |
| date |  The creation date of the feedback item. | UNIX timestamp | No |
| custom |  Custom variables that have been assigned in the [button setup page](https://usabilla.com/member/live/setup).  | array | Yes |
| email |  Optional field that the user fills in in case he wishes to be contacted. | string | Yes |
| html_snippet |  The html code of the element that has been selected when given specific feedback type. | string | Yes |
| image |  The screenshot of the item that has been selected to give feedback for. | string | Yes |
| labels |  An array of labels that have been assigned to the feedback item | array | Yes |
| nps |  The Net promoter score given by the user. | integer (0-10)| Yes |
| publicUrl |  When the owner of the button has publicized the feedback item it becomes publicly accesible through this url. | string | Yes |
| rating |  Rating given by the user. | integer (1-5)  | Yes |
| buttonId |  The source button of the feedback item. | string | No |
| tags |  An array of tags assigned to the feedback item | array | Yes |
| url |  The link through which the source button can be accessed. | string | No |

####Example

```json
{
    "id" : "5499612ec4698839368b4573",
    "userAgent" : "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36",    
    "comment" : "A random comment.",    
    "location" : "Amsterdam, Netherlands",
    "date" : 1419340238,
    "custom" : {
        "form_name" : "form1"
    },
    "email" : "dev@usabilla",
    "html_snippet" : "<a href=\"#\">An anchor element</a>",    
    "image" : "http://usabilla-feedback-dev.s3.amazonaws.com/5499612ec4698839368b4573/detail",
    "labels" : [ 
        "label 1", 
        "label 2"
    ],  
    "nps" : 10,
    "publicUrl" : "http://usabilla.dev/feedback/item/a5cadaf3febf44393401a4be3ebbbf155d9f8d2c",
    "rating" : 5,    
    "buttonId" : "8d73568ac2be",
    "tags" : [ 
        "interesting", 
        "unattractive"
    ],
    "url" : "http://usabilla.com/member/live/site/8d73568ac2be",
}
```


<a name="def-resource-campaigns"></a>
#### 4.1.3 Campaigns


| Field   |      Description    | Type | Optional | 
|----------|-------------|-------------|---------|
| id |  Unique identifier for a campaign. | string | No |
| date |  The creation date of the campaign. | UNIX timestamp | No |
| buttonId |  The source button of the feedback item. | string | No |
| analyticsId |  To do. | string | No |
| status |  The  status of the campaign. Possible values are `created, active, paused, finished` | string | No |
| name |    The name of the campaign given when created. Can be updated in the [campaign setup page](https://usabilla.com/member/live/campaigns).  | string | No |


```json
{
    "id" : "5499612ec4698839368b4573",
    "date" : 1419340238,
    "buttonId" : 8d73568ac2be,
    "analyticsId" : 901f1d832a55,
    "status" : active,
    "name" : "My campaign",               
}
```

<a name="def-resource-campaign-results"></a>
#### 4.1.4 Campaign results

| Field   |      Description    | Type | Optional | 
|----------|-------------|-------------|---------|
| id |  Unique identifier for a campaign result. | string | No |
| date |  The date when the campaign result was registered. | UNIX timestamp | No |
| campaignId |  Unique identifier for the campaign it belongs. | string | No |
| userAgent |  Information about the browser user agent. | string | No |
| url |  Origin url where the campaign result was registered. | string | No |
| custom |    Custom variables that have been assigned in the [campaign setup page](https://usabilla.com/member/live/campaigns).  | array | No |
| data |  An array containing the values of the campaign form fields. | array | No |
| time |  The amount of time the user has taken to complete the survey. Expressed in miliseconds. | integer | No |
| location |  String containing geographical information about the location of the user based on his ip address. | string | No |


```json
{
    "id" : "549972d5c469885e548b4570",
    "campaignId" : "5499612ec4698839368b4573"
    "userAgent" : "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36",    
    "location" : "Amsterdam, Netherlands",
    "date" : 1419340238,
    "custom" : {
        "form_name" : "form1"
    },  
    "data" : {
        "text" : "test"
    }, 
    "time" : 5000,
    "url" : "http://usabilla.com",
}
```

<a name="def-resource-request"></a>
### 4.2 Resource request

Currently the only allowed method is "GET", making it a read-only API.
The clients posess a conversion function to translate POST request to GET.

The available requests are the following:

Description Resource type URL Parameters 

(COPY FROM Public document)

<a name="def-request-parameters"></a>
####4.2.1 Parameters

| Parameter name  |      Type    | Description | 
|----------|-------------|-------------|---------|
| limit |  integer | Limit the number of results returned. Default value is X |
| since |  UNIX timestamp | Retrieve items starting from a specific date. Default value is X |  

<a name="def-request-urls"></a>
####4.2.2 Request URLs

| Requested resource   |      Url    | Parameters | Description | 
|----------|-------------|-------------|---------|
| Buttons |  ```# GET /live/website/button ``` | none | Buttons available for your account. |
| Feedback Items |  ```# GET /live/website/<id>/button ``` | limit, since | Feedback items associated to a button id. |
| Feedback Items |  ```# GET /live/website/*/button ``` | limit, since | Feedback items from all buttons. |
| Campaigns |  ```# GET /live/website/campaign  ```| limit, since | Campaigns avaiable for your account. |
| Campaign results |  ```# GET /live/website/campaign/<id>/results  ``` | limit, since | Campaign results associated to a campaign id |


<a name="def-response"></a>
## 5. Response 

The response HTTP message

| Field name   | Type |     Description    |
|----------|-------------|-------------|
| items | array | An array of resources. |
| count |  integer | The number of resource items retrieved. |
| hasMore |  bool | A flag that indicates if there are more resources available to fetch. |
| lastTimestamp | UNIX timestamp | The timestamp of the last resources item. | 



#### Example

    + Response 201 (application/json)
        
		{
			"items": [           
						{
						    "id" : "5499612ec4698839368b4573",
						    "date" : 1419340238,
						    "buttonId" : 8d73568ac2be,
						    "analyticsId" : 901f1d832a55,
						    "status" : active,
						    "name" : "My campaign",               
						},
						{
						    "id" : "5499612ec4698839368b4573",
						    "date" : 1419340238,
						    "buttonId" : 8d73568ac2be,
						    "analyticsId" : 901f1d832a55,
						    "status" : active,
						    "name" : "My campaign",               
						}
					],
			"count" : 2,
			"hasMore" : false,
			"lastTimestamp" : 1419340238
		}

---

<br>

