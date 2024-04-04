const storedUser = () => {
  const usr = localStorage.getItem("auth_user");
  return usr ? JSON.parse(usr) : null;
};

export { storedUser };
