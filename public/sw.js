self.addEventListener("push", (event) => {
    let payload = {
        title: "Thông báo",
        body: "Bạn có thông báo mới 💌"
    };

    if (event.data) {
        try {
            payload = event.data.json(); // parse JSON từ server
        } catch(e) {
            console.warn("⚠️ Không phải JSON, dùng raw text:", event.data.text());
            payload.body = event.data.text(); // fallback nếu gửi plain text
        }
    }

    const options = {
        body: payload.body,
        icon: "/love-app/public/assets/icon.png", // thay icon theo project
        badge: "/love-app/public/assets/badge.png",
        vibrate: [200, 100, 200],
        data: { url: "/love-app/public/longdistance" }, // khi click mở trang
    };

    event.waitUntil(
        self.registration.showNotification(payload.title, options)
    );
});

self.addEventListener("notificationclick", (event) => {
    event.notification.close();
    event.waitUntil(
        clients.matchAll({ type: "window", includeUncontrolled: true }).then((clientList) => {
            for (const client of clientList) {
                if (client.url === event.notification.data.url && 'focus' in client) {
                    return client.focus();
                }
            }
            if (clients.openWindow) {
                return clients.openWindow(event.notification.data.url);
            }
        })
    );
});
