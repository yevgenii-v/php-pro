<!DOCTYPE html>
<html lang="ua">
<head>
    <title>Оплата</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
<h1>Оплата</h1>
<div id="payment-result"></div>
<form id="payment-form" method="POST" action="{{ route('payment.confirm', 2) }}">
    <div id="link-authentication-element"></div>
    <div id="payment-element"></div>
    <button id="submit">Pay now</button>
    <div id="error-message"></div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        // Load the publishable key from the server. The publishable key
        // is set in your .env file.
        const publishableKey = '{{ env("STRIPE_PUBLICABLE_KEY") }}';
        const stripe = Stripe(publishableKey, {
            apiVersion: '2020-08-27',
        });
        const data = await fetch("/api/v1/payment/makePayment/2", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
            },
        });
        const json = await data.json();
        const orderId = json.order.id;
        const elements = stripe.elements({clientSecret: orderId});
        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');
        // Create and mount the linkAuthentication Element to enable autofilling customer payment details
        const linkAuthenticationElement = elements.create("linkAuthentication");
        linkAuthenticationElement.mount("#link-authentication-element");
        const form = document.getElementById('payment-form');
        let submitted = false;
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Disable double submission of the form
            if (submitted) {
                return;
            }
            submitted = true;
            form.querySelector('button').disabled = true;

            const nameInput = document.querySelector('#name');

            // Confirm the payment given the clientSecret
            // from the payment intent that was just created on
            // the server.
            const {error: stripeError} = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: `${window.location.origin}/payment_stripe`,
                }
            });
        });

        const url = new URL(window.location);
        const redirectResult = url.searchParams.get('payment_intent');

        if (redirectResult) {

            fetch("/api/v1/payment/confirm/2", {
                method: "POST",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({paymentId: redirectResult})
            }).then(function (response) {
                alert(response)
            })
                .catch(function (error) {
                    console.error('Помилка при виконанні оплати через Stripe на бекенді: ', error);
                });
        }


        if (stripeError) {
            alert(stripeError.message);

            // reenable the form.
            submitted = false;
            form.querySelector('button').disabled = false;
            return;
        }

        // Initialize Stripe Elements with the PaymentIntent's clientSecret,
        // then mount the payment element.
    });
</script>
</body>
</html>
