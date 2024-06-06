<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PageTurner Plaza - FAQ</title>
    <link rel="stylesheet" href="faq.css">
</head>

<?php
include 'header.php';
?>

<body>
    <main>
        <h2>Frequently Asked Questions (FAQ)</h2>
        <section class="faq-section">
            <h3 class="faq-h3">How do I place an order?
                <button class="faq-toggle">
                    <span class="faq-toggle-label">+</span>
                </button>
            </h3>


            <p class="faq-p hidden">To place an order, simply follow these steps:
                Go to the product page of the item you want to purchase. <br>
                Click on the "Add to Cart" button.<br>
                Review your cart to ensure you have the correct items.<br>
                Click on the "Checkout" button and follow the prompts to complete your purchase.<br>
            </p>


        </section>
        <section class="faq-section">
            <h3 class="faq-h3">What payment methods do you accept?
                <button class="faq-toggle">
                    <span class="faq-toggle-label">+</span>
                </button>
            </h3>

            <p class="faq-p hidden">We accept all major credit cards, PayPal, and bank transfers.</p>
        </section>
        <section class="faq-section">
            <h3 class="faq-h3">How can I track my order?
                <button class="faq-toggle">
                    <span class="faq-toggle-label">+</span>
                </button>
            </h3>


            <p class="faq-p hidden">You can track your order through our website by logging into your account and viewing the order details.</p>
        </section>
        <section class="faq-section">
            <h3 class="faq-h3">How do I cancel an order?
                <button class="faq-toggle">
                    <span class="faq-toggle-label">+</span>
                </button>
            </h3>


            <p class="faq-p hidden">If you need to cancel an order, please contact our customer service team as soon as possible. We will do our best to accommodate your request.</p>
        </section>
        <section class="faq-section">
            <h3 class="faq-h3">Can I return an item?
                <button class="faq-toggle">
                    <span class="faq-toggle-label">+</span>
                </button>
            </h3>


            <p class="faq-p hidden">Yes, you can return an item within 30 days of purchase for a full refund. Please refer to our <a href="returns-policy.php">returns policy</a> for more information.</p>
        </section>
        <!-- Add more questions and answers as needed -->
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var faqSections = document.querySelectorAll('.faq-section');

            faqSections.forEach(function(section) {
                var question = section.querySelector('.faq-h3');
                var answer = section.querySelector('.faq-p');
                var toggle = section.querySelector('.faq-toggle');

                question.addEventListener('click', function() {
                    answer.classList.toggle('hidden');
                    toggle.classList.toggle('active');

                    var label = toggle.querySelector('.faq-toggle-label');
                    if (label.innerText === '+') {
                        label.innerText = '-';
                    } else {
                        label.innerText = '+';
                    }
                });
            });
        });
    </script>
</body>

</html>