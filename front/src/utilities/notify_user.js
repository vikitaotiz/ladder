const notifyUser = (q, message, position, color) => {
  q.notify({
    message,
    color,
    position,
  });
};

export { notifyUser };
