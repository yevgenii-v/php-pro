<div id="liqpay_checkout"></div>
<script>
    window.LiqPayCheckoutCallback = function () {
        fetch("/api/v1/payment/makePayment/3", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then(function (response) {
                return response.json()
            })
            .then(function (data) {

                // const liqPayData = JSON.parse(data.order);

                console.log({
                    data: data.order.id,
                    signature: data.order.sig,
                    embedTo: "#liqpay_checkout",
                    language: "en",
                    mode: "embed" // embed || popup
                })
                LiqPayCheckout.init({
                    data: data.order.id,
                    signature: data.order.sig,
                    embedTo: "#liqpay_checkout",
                    language: "en",
                    mode: "embed" // embed || popup
                }).on("liqpay.callback", function (data) {
                    console.log(data);
                    fetch("/api/v1/payment/confirm/3", {
                        method: "POST",
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ paymentId: data.payment_id + '' })
                    }).then(function (response) {
                        console.log(response)
                    })
                        .catch(function (error) {
                            console.error('Помилка при виконанні оплати через Stripe на бекенді: ', error);
                        });
                }).on("liqpay.ready", function (data) {
                    // ready
                }).on("liqpay.close", function (data) {
                    // close
                });

            })


    };
</script>
<script src="//static.liqpay.ua/libjs/checkout.js" async></script>
