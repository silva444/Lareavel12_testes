import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
// import Pusher from 'pusher-js';

// import { useAuthStore } from "@/stores/auth.js";

// const auth = useAuthStore;
window.Pusher = Pusher;
const echo = new Echo({
    // name:'TESTE',
    broadcaster: 'reverb',
    key: '1fsg6vzngbtgherb1coz', // Deve ser igual ao PUSHER_APP_KEY do backend
    wsHost: '127.0.0.1', // Substitua pelo domínio do seu backend
    wsPort: 8080, // Porta do WebSocket
    forceTLS: false, // Use true se o backend estiver usando HTTPS
    disableStats: true,
    secret:'mi7uppuvnh8agdrylepf',
    enabledTransports: ['ws', 'wss'],
    // auth: {
    //     headers: {
    //         Authorization: `Bearer ${localStorage.getItem("token")}`, // Enviar o token JWT no cabeçalho
    //     },
    // },
    // bearerToken: localStorage.getItem("token")

});

export default echo;