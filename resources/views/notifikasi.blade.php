<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Web Android</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f4f4f9;
        }

        button {
            padding: 15px 25px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 8px;
            background: #3498db;
            color: white;
        }
    </style>
</head>

<body>

    <button id="notifyBtn">Kirim Notifikasi</button>
</body>
<script>
    const button = document.getElementById('notifyBtn');

    button.addEventListener('click', () => {
        // 1. Cek apakah browser mendukung notifikasi
        if (!("Notification" in window)) {
            alert("Browser ini tidak mendukung notifikasi desktop");
        }

        // 2. Cek apakah izin sudah diberikan
        else if (Notification.permission === "granted") {
            showNotification();
        }

        // 3. Jika belum, minta izin ke pengguna
        else if (Notification.permission !== "denied") {
            Notification.requestPermission().then(permission => {
                if (permission === "granted") {
                    showNotification();
                }
            });
        }
    });

    function showNotification() {
        const options = {
            body: 'Ini adalah pesan notifikasi dari browser Android Anda!',
            icon: 'https://cdn-icons-png.flaticon.com/512/4226/4226663.png', // Ganti dengan ikon Anda
            vibrate: [200, 100, 200], // Getaran untuk perangkat Android
            data: {
                url: 'https://google.com'
            }
        };

        const n = new Notification('Halo dari JS!', options);

        n.onclick = (e) => {
            window.open(e.target.data.url, '_blank');
        };
    }
</script>

</html>
