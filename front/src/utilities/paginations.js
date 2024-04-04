const paginations = (rowsPerPage) => {
  return {
    sortBy: "desc",
    descending: false,
    page: 1,
    rowsPerPage,
  };
};

export { paginations };
