import "https://www.gstatic.com/firebasejs/8.3.2/firebase.js";

import { base_url } from "./helpers";

const firebaseConfig = {
  apiKey: "AIzaSyCYv1F_JXhjv93TWI6chRJg8PqkTwKCAbo",
  authDomain: "notifyme-465e4.firebaseapp.com",
  projectId: "notifyme-465e4",
  storageBucket: "notifyme-465e4.appspot.com",
  messagingSenderId: "975817642381",
  appId: "1:975817642381:web:b4e7896b65eea0d762adc4",
};

firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();

const registerFCM = () => {
  messaging
    .requestPermission()
    .then(function () {
      return messaging.getToken();
    })
    .then(function (response) {
      fetch(`${base_url}/register_device_token`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${
            JSON.parse(localStorage.getItem("auth_user")).token
          }`,
        },
        body: JSON.stringify({ device_token: response }),
      })
        .then((res) => res.json())
        .then((data) => console.log(data));
    })
    .catch(function (error) {
      alert(error);
    });
};
messaging.onMessage(function (payload) {
  const title = payload.notification.title;
  const options = {
    body: payload.notification.body,
    icon: payload.notification.icon,
  };
  new Notification(title, options);
});

export { registerFCM };
