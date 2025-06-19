<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Library System Laravel</title>

    <!-- CSRF Token for JavaScript -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>📚</text></svg>">
</head>
<body>

@include('component.navbar')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center fw-bold">Welcome to the Library System</div>
                <div class="card-body text-center">
                    <p class="lead">This is a simple library management system built with Laravel.</p>
                </div>
            </div>
        </div>
    </div>

    <button id="get-token-btn">Get FCM Token</button>

    <h1>FCM Token:</h1>
    <pre id="token-box">{{ $fcmToken ?? 'Token not saved yet' }}</pre>
</div>

<!-- Firebase SDKs -->
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js"></script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const tokenBox = document.getElementById('token-box');
        const button = document.getElementById('get-token-btn');

        const firebaseConfig = {
            apiKey: "REDACTED_FIREBASE_API_KEY",
            authDomain: "REDACTED_AUTH_DOMAIN",
            projectId: "REDACTED_PROJECT_ID",
            messagingSenderId: "REDACTED_SENDER_ID",
            appId: "1:REDACTED_SENDER_ID:web:bc88c7c556bd3b1dfc7e8f"
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();


        // message styling
        messaging.onMessage(function (payload) {
            console.log('📬 Foreground message received:', payload);

            const title = payload.notification.title;
            const body = payload.notification.body;

            // Create container if not already present
            let container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                container.style.position = 'fixed';
                container.style.top = '20px';
                container.style.right = '20px';
                container.style.zIndex = '9999';
                container.style.display = 'flex';
                container.style.flexDirection = 'column';
                container.style.gap = '10px';
                document.body.appendChild(container);
            }

            // Create the toast element
            const toast = document.createElement('div');
            toast.innerHTML = `<strong>${title}</strong><p>${body}</p>`;
            toast.style.background = '#343a40';
            toast.style.color = '#fff';
            toast.style.padding = '12px 18px';
            toast.style.borderRadius = '8px';
            toast.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.2)';
            toast.style.minWidth = '250px';
            toast.style.fontFamily = 'sans-serif';
            toast.style.transition = 'opacity 0.5s ease';
            toast.style.opacity = '1';

            container.appendChild(toast);

            // Auto-remove after 3 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => container.removeChild(toast), 500);
            }, 3000);
        });
        // Get FCM token
        button.addEventListener('click', function () {
            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then(function (registration) {
                    messaging.useServiceWorker(registration);
                    return messaging.requestPermission();
                })
                .then(() => messaging.getToken({
                    vapidKey: 'BFiQX7cbfVx0BNwYb-1EMl7yoARiIVFIV8jDNK6wLNqj8mUnsAEKUMEPi4cPfN3VePZS3WPzyIlycv89faNz-7o'
                }))
                .then((currentToken) => {
                    if (currentToken) {
                        tokenBox.innerText = currentToken;
                        return fetch('/save-token', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ token: currentToken })
                        });
                    } else {
                        throw new Error('Token not generated');
                    }
                })
                .then(res => res.json())
                .then(data => console.log('✅ Token saved:', data))
                .catch(err => console.error('❌ Error:', err));
        });
    });
</script>


</body>
</html>
