import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
import { getMessaging, getToken } from "firebase/messaging";
//importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js');
//importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging.js');

// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional

const firebaseConfig = {
  apiKey: "AIzaSyC7s_dC2IfN9c6wxjZF7kv3QMVGWbMKw5c",
  authDomain: "haleemh-d7598.firebaseapp.com",
  projectId: "haleemh-d7598",
  storageBucket: "haleemh-d7598.appspot.com",
  messagingSenderId: "441518811604",
  appId: "1:441518811604:web:450545afc7820646cdce41",
  measurementId: "G-JEGXKKQ94V"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

// Get registration token. Initially this makes a network call, once retrieved
// subsequent calls to getToken will return from cache.
const messaging = getMessaging();
getToken(messaging, { vapidKey: 'BEDMnnjfpqGsA_f8yul4poW2mAtNX8-xhibescb4_3zuXx7INz8Qe890Uf5-O368jiDrddjAq_1CEuCZlfMWQUQ' }).then((currentToken) => {
  if (currentToken) {
    console.log(currentToken);
  } else {
    // Show permission request UI
    console.log('No registration token available. Request permission to generate one.');
    // ...
  }
}).catch((err) => {
  console.log('An error occurred while retrieving token. ', err);
  // ...
});

