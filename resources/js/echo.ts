import Echo from 'laravel-echo'

console.log("Passed")
console.log('Echo class: ', Echo)
try {
  window.Echo = new Echo({
    broadcaster: 'reverb',
    host: 'ws://localhost:8080',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransport: ['ws', 'wss']
  });
  console.log('✅ Echo initialized:', window.Echo);
} catch (err) {
  console.error('❌ Echo error:', err);
}
// window.Echo = new Echo({
//   broadcaster: 'reverb',
//   host: 'http://localhost:8080', // ganti dengan port Reverb kamu
// })
console.log(window.Echo)