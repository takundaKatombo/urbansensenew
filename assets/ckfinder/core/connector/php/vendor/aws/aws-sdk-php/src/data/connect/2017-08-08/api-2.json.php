<?php
// This file was auto-generated from sdk-root/src/data/connect/2017-08-08/api-2.json
return [ 'version' => '2.0', 'metadata' => [ 'apiVersion' => '2017-08-08', 'endpointPrefix' => 'connect', 'jsonVersion' => '1.1', 'protocol' => 'rest-json', 'serviceAbbreviation' => 'Amazon Connect', 'serviceFullName' => 'Amazon Connect Service', 'serviceId' => 'Connect', 'signatureVersion' => 'v4', 'signingName' => 'connect', 'uid' => 'connect-2017-08-08', ], 'operations' => [ 'StartOutboundVoiceContact' => [ 'name' => 'StartOutboundVoiceContact', 'http' => [ 'method' => 'PUT', 'requestUri' => '/contact/outbound-voice', ], 'input' => [ 'shape' => 'StartOutboundVoiceContactRequest', ], 'output' => [ 'shape' => 'StartOutboundVoiceContactResponse', ], 'errors' => [ [ 'shape' => 'InvalidRequestException', ], [ 'shape' => 'InvalidParameterException', ], [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'InternalServiceException', ], [ 'shape' => 'LimitExceededException', ], [ 'shape' => 'DestinationNotAllowedException', ], [ 'shape' => 'OutboundContactNotPermittedException', ], ], ], 'StopContact' => [ 'name' => 'StopContact', 'http' => [ 'method' => 'POST', 'requestUri' => '/contact/stop', ], 'input' => [ 'shape' => 'StopContactRequest', ], 'output' => [ 'shape' => 'StopContactResponse', ], 'errors' => [ [ 'shape' => 'InvalidRequestException', ], [ 'shape' => 'ContactNotFoundException', ], [ 'shape' => 'InvalidParameterException', ], [ 'shape' => 'ResourceNotFoundException', ], [ 'shape' => 'InternalServiceException', ], ], ], ], 'shapes' => [ 'AttributeName' => [ 'type' => 'string', 'max' => 32767, 'min' => 1, ], 'AttributeValue' => [ 'type' => 'string', 'max' => 32767, 'min' => 0, ], 'Attributes' => [ 'type' => 'map', 'key' => [ 'shape' => 'AttributeName', ], 'value' => [ 'shape' => 'AttributeValue', ], ], 'ClientToken' => [ 'type' => 'string', 'max' => 500, ], 'ContactFlowId' => [ 'type' => 'string', 'max' => 500, ], 'ContactId' => [ 'type' => 'string', 'max' => 256, 'min' => 1, ], 'ContactNotFoundException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'Message', ], ], 'error' => [ 'httpStatusCode' => 410, ], 'exception' => true, ], 'DestinationNotAllowedException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'Message', ], ], 'error' => [ 'httpStatusCode' => 403, ], 'exception' => true, ], 'InstanceId' => [ 'type' => 'string', ], 'InternalServiceException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'Message', ], ], 'error' => [ 'httpStatusCode' => 500, ], 'exception' => true, ], 'InvalidParameterException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'Message', ], ], 'error' => [ 'httpStatusCode' => 400, ], 'exception' => true, ], 'InvalidRequestException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'Message', ], ], 'error' => [ 'httpStatusCode' => 400, ], 'exception' => true, ], 'LimitExceededException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'Message', ], ], 'error' => [ 'httpStatusCode' => 429, ], 'exception' => true, ], 'Message' => [ 'type' => 'string', ], 'OutboundContactNotPermittedException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'Message', ], ], 'error' => [ 'httpStatusCode' => 403, ], 'exception' => true, ], 'PhoneNumber' => [ 'type' => 'string', ], 'QueueId' => [ 'type' => 'string', ], 'ResourceNotFoundException' => [ 'type' => 'structure', 'members' => [ 'Message' => [ 'shape' => 'Message', ], ], 'error' => [ 'httpStatusCode' => 404, ], 'exception' => true, ], 'StartOutboundVoiceContactRequest' => [ 'type' => 'structure', 'required' => [ 'DestinationPhoneNumber', 'ContactFlowId', 'InstanceId', ], 'members' => [ 'DestinationPhoneNumber' => [ 'shape' => 'PhoneNumber', ], 'ContactFlowId' => [ 'shape' => 'ContactFlowId', ], 'InstanceId' => [ 'shape' => 'InstanceId', ], 'ClientToken' => [ 'shape' => 'ClientToken', 'idempotencyToken' => true, ], 'SourcePhoneNumber' => [ 'shape' => 'PhoneNumber', ], 'QueueId' => [ 'shape' => 'QueueId', ], 'Attributes' => [ 'shape' => 'Attributes', ], ], ], 'StartOutboundVoiceContactResponse' => [ 'type' => 'structure', 'members' => [ 'ContactId' => [ 'shape' => 'ContactId', ], ], ], 'StopContactRequest' => [ 'type' => 'structure', 'required' => [ 'ContactId', 'InstanceId', ], 'members' => [ 'ContactId' => [ 'shape' => 'ContactId', ], 'InstanceId' => [ 'shape' => 'InstanceId', ], ], ], 'StopContactResponse' => [ 'type' => 'structure', 'members' => [], ], ],];
