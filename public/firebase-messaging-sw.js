importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyC7s_dC2IfN9c6wxjZF7kv3QMVGWbMKw5c",
    authDomain: "haleemh-d7598.firebaseapp.com",
    projectId: "haleemh-d7598",
    storageBucket: "haleemh-d7598.appspot.com",
    messagingSenderId: "441518811604",
    appId: "1:441518811604:web:450545afc7820646cdce41",
    measurementId: "G-JEGXKKQ94V"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});