// public/firebase-messaging-sw.js
importScripts('https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.23.0/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "REDACTED_FIREBASE_API_KEY",
    authDomain: "REDACTED_AUTH_DOMAIN",
    projectId: "REDACTED_PROJECT_ID",
    messagingSenderId: "REDACTED_SENDER_ID",
    appId: "1:REDACTED_SENDER_ID:web:bc88c7c556bd3b1dfc7e8f"
});

const messaging = firebase.messaging();

// Optional: background handler
messaging.onBackgroundMessage(function (payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
});
