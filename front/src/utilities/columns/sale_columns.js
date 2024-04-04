const sale_columns = [
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
    name: "quantity",
    align: "center",
    label: "Quantity",
    field: "quantity",
    sortable: true,
  },
  {
    name: "status",
    align: "center",
    label: "Status",
    field: "status",
    sortable: true,
  },
  {
    name: "bill_ref",
    align: "center",
    label: "Bill Ref",
    field: "bill_ref",
    sortable: true,
  },
  {
    name: "payment_mode",
    align: "center",
    label: "Mode",
    field: "payment_mode",
    sortable: true,
  },
  {
    name: "user",
    align: "center",
    label: "Created By",
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
  // {
  //   name: "actions",
  //   align: "center",
  //   label: "Actions",
  //   field: "created_at",
  // },
];

export { sale_columns };
