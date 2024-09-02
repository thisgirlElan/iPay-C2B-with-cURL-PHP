# iPay-C2B-with-cURL-PHP
iPay C2B integration with JSON callback rendering, cURL PHP functionality, HTML form and an option to by-pass the form and render the payment configuration bit if the need calls for it.

## 👔 Features include:

- An interface for the user to key in details.
- Payment gateway
- Screen with callback in JSON format

## 📋 App Preview

- The first screen allows the user to input their details.

<img src="https://github.com/user-attachments/assets/38edaa2f-0315-4f47-88d1-e1486ed8c376" height="50%" width="70%"/>


- The payment gateway screen offers the user a selection of different channels they could opt to complete payment with.

<img src="https://github.com/user-attachments/assets/a1b99cf0-20f6-4874-afac-e8099b463ddd" height="50%" width="70%"/>

 Clone this repo:

```

git clone https://github.com/thisgirlElan/iPay-C2B-with-cURL-PHP.git

```
- Note: If you're not particularly keen with the JSON bit, you may alternatively use [webhook.site](https://webhook.site/) by simply copying the unique URL provided by them and pasting it on the ```cbk param``` or your own callback URL. This will allow you to see the callback in the original format, that is, as query params.

Dependencies (Optional)
- For you to be able to see the callback on your browser, I recommend using ngrok to create a tunnel for the application.

`` The ngrok way ``

You can install ngrok from here: [ngrok download](https://ngrok.com/download) and follow the guide (It short and straight-forward).

- If you had it installed, simply start your xampp as usual and run the following command to start a tunnel (Pretty sure you knew this already 😉)

```
http ngrok 80
```

- Remember to have the codebase in htdocs.
- Copy the url that leads to the callback_payment.php file from the URL ngrok provides and update the cbk param in the payment_process.php file. e.g https://ngrok_url/test_script/callback_payment.php

When the server is up and running, open the `index.html` file on your browser.

### Good to Know

- The integration uses a simple HTML form for user input.
- Scripting has been done with PHP to fetch and render data.
- A separate PHP file has been used to extract the query params on the callback URL and convert to JSON.
- If you want to bypass the form filling, simply spin up the process_payment.php file. Amend what's needed from the comments on the file and you should be able to get it up and running.

## 👨‍💻 You're ready! Make it yours. 

- Tinker and develop!!🎉


