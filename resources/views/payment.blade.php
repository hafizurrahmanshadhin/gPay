<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Pay Integration</title>
    <script src="https://pay.google.com/gp/p/js/pay.js" async></script>
    <script>
        function onGooglePayLoaded() {
            const paymentsClient = new google.payments.api.PaymentsClient({
                environment: 'TEST'
            });

            const button = paymentsClient.createButton({
                onClick: onGooglePaymentButtonClicked
            });
            document.getElementById('container').appendChild(button);
        }

        function onGooglePaymentButtonClicked() {
            const paymentDataRequest = getGooglePaymentDataRequest();
            const paymentsClient = new google.payments.api.PaymentsClient({
                environment: 'TEST'
            });
            paymentsClient.loadPaymentData(paymentDataRequest)
                .then(function(paymentData) {
                    processPayment(paymentData);
                }).catch(function(err) {
                    console.error(err);
                });
        }

        function getGooglePaymentDataRequest() {
            const paymentDataRequest = {
                // Required parameters
                apiVersion: 2,
                apiVersionMinor: 0,
                allowedPaymentMethods: [{
                    type: 'CARD',
                    parameters: {
                        allowedAuthMethods: ['PAN_ONLY', 'CRYPTOGRAM_3DS'],
                        allowedCardNetworks: ['MASTERCARD', 'VISA']
                    },
                    tokenizationSpecification: {
                        type: 'PAYMENT_GATEWAY',
                        parameters: {
                            'gateway': 'example',
                            'gatewayMerchantId': 'exampleMerchantId'
                        }
                    }
                }],
                merchantInfo: {
                    merchantId: 'your-merchant-id',
                    merchantName: 'Example Merchant'
                },
                transactionInfo: {
                    totalPriceStatus: 'FINAL',
                    totalPriceLabel: 'Total',
                    totalPrice: '10.00',
                    currencyCode: 'USD',
                    countryCode: 'US'
                }
            };
            return paymentDataRequest;
        }

        function processPayment(paymentData) {
            fetch('/payment/process', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        paymentData: paymentData
                    })
                }).then(response => response.json())
                .then(data => {
                    console.log(data);
                }).catch(error => {
                    console.error(error);
                });
        }
    </script>
</head>

<body onload="onGooglePayLoaded()">
    <div id="container"></div>


    <script src="https://pay.google.com/gp/p/js/pay.js" async></script>

</body>




</html>
