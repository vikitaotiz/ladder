const http = require('http');
const { Server } = require('socket.io');

const server = http.createServer();
const io = new Server(server);

io.on('connection', (socket) => {
  console.log('A user connected');
  // Handle Socket.IO events here
  socket.on('disconnect', () => {
    console.log('User disconnected');
  });
});

const port = process.env.SOCKET_IO_PORT || 3000;
server.listen(port, () => {
  console.log(`Socket.IO server listening on port ${port}`);
});
