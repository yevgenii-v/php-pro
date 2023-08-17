<!DOCTYPE html>
<html lang="">
<head>
    <title>Оплата через PayPal</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_SANDBOX_CLIENT_ID') }}"></script>
</head>
<body>
<h1>Оплата через PayPal</h1>
<div id="payment-result"></div>
<button onclick="payWithPaypal()">Здійснити оплату</button>

<script>
    function payWithPaypal() {
        paypal.Buttons({
            createOrder() {
                return fetch("/api/v1/payment/makePayment/1", {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                    },
                })
                    .then(function (response) {
                        return response.json()
                    })
                    .then(function (data) {
                        console.log(data.order.id)
                        return data.order.id
                    });
            },
            onApprove: function (data, actions) {
                executePaypalPaymentOnBackend(data.orderID);
            }
        }).render('body');
    }

    function executePaypalPaymentOnBackend(paypalToken) {
        axios.post('/api/v1/payment/confirm/1', {
            paymentId: paypalToken
        }).then(function (response) {
            alert(response)
        }).catch(function (error) {
            console.error('Помилка при виконанні оплати через PayPal на бекенді: ', error);
        });
    }
</script>
</body>
</html>
