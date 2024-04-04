const inventory_columns = [
  {
    name: "product",
    required: true,
    label: "Product",
    align: "left",
    field: (row) => row.name,
    format: (val) => `${val}`,
    sortable: true,
  },
  {
    name: "buying_price",
    align: "center",
    label: "Buying Price (Per Unit)",
    field: "buying_price",
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
    name: "total",
    align: "center",
    label: "Total Cost",
    field: "total",
    sortable: true,
  },
  {
    name: "measurement",
    align: "center",
    label: "Measurement",
    field: "measurement",
    sortable: true,
  },
  {
    name: "department",
    align: "center",
    label: "Department",
    field: "department",
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
  {
    name: "actions",
    align: "center",
    label: "Actions",
    field: "created_at",
  },
];

export { inventory_columns };
