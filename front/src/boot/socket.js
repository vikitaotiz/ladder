import io from 'socket.io-client';

const socket = io('http://127.0.0.1:8000'); // Adjust the URL to your Socket.IO server

export default ({ app }) => {
    // Make the socket instance available globally in Vue components
    app.prototype.$socket = socket;
  };

  