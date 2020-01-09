# PaymentJS PHP integration

## PaymentJS Documentation

https://docs.paymentjs.firstdata.com/

## Getting Started

1. Gateway and PaymentJSv2 developer app credentials are stored in config.php. Add the credentials accordingly.
2. For the webhook callback to work, a HTTPS supported webhook url needs to be registered in the developer app for PaymentJSv2. Fill out the form from this link https://docs.firstdata.com/req/paymentjs and please allow 48 business hours to be on-boarded. 
3. Client directory contains all the browser related codes and paymentLog directory logs the successful transactions' details. 
4. There are four payment gateways and you will need to have sandbox account for each to run the integration for specific gateway.

URL: http://localhost:8080/client/index.html
