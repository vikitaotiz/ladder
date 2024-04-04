const department_columns = [
  {
    name: "name",
    required: true,
    label: "Name",
    align: "left",
    field: (row) => row.name,
    format: (val) => `${val}`,
    sortable: true,
  },
  {
    name: "users",
    align: "center",
    label: "Users",
    field: "users",
    sortable: true,
  },
  {
    name: "created_at",
    align: "center",
    label: "Created On",
    field: "created_at",
    sortable: true,
  },
  {
    name: "actions",
    align: "center",
    label: "Actions",
    field: "created_at",
  },
];

export { department_columns };
