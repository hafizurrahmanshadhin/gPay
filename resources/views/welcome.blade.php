<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <button type="submit">Payment</button>

    <form action="" id="payment-form">
        <div id="google-pay-button"></div>
        <div id="card-container"></div>
        <button id="card-button" type="button">Pay $10.00</button>
    </form>
    <div id="payment-status-container"></div>

    <script src="https://pay.google.com/gp/p/js/pay.js"></script>
    <script href=“https://web.squarecdn.com/v1/square.js 10”></script>

    <script type="module">
        const appId = "{{ env('SQUARE_APP_ID', null) }}";
        const locationId = "{{ env('SQUARE_LOCATION_ID', null) }}";
        const payments = Square.payments(appId, locationId);

        const paymentRequest = payments.paymentRequest({
            countryCode: 'US',
            currencyCode: 'USD',
            total: {
                amount: '100.00',
                label: 'Total'
            }
        });

        const googlePay = await payments.googlePay(paymentRequest);

        await googlePay.attach('#google-pay-button');
    </script>

    <script>
        const googlePayButton = document.getElementById('google-pay-button');
        googlePayButton.addEventListner('click', async () => {
            const statusContainer = document.getElementById('payment-status-container');
            try {
                const tokenResult = await googlePay.tokenize();
                if (tokenResult.status === 'OK') {
                    console.log('Payment token is ${tokenResult.token}');
                    statusContainer.innerHTML = "Payment Successful";
                } else {
                    let errorMessage = `Tokenization failed with status: ${tokenResult.status}`;
                    if (tokenResult.errors) {
                        errorMessage += ` and errors: ${JSON.stringify(
                    tokenResult.errors
                )}`;
                    }
                    throw new Error(errorMessage);
                }
            } catch (e) {
                console.error(e);
                statusContainer.innerHTML = "Payment Failed";
            }
        })
    </script>
</body>

</html>
