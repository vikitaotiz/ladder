const payment_mode_columns = [
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
    name: "user",
    align: "center",
    label: "Users",
    field: "user",
    sortable: true,
  },
  {
    name: "sales",
    align: "center",
    label: "sales",
    field: "user",
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

export { payment_mode_columns };
