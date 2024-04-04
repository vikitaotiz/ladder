const product_columns = [
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
    name: "measurement",
    align: "center",
    label: "Measurement & Qty",
    field: "measurement",
    sortable: true,
  },

  {
    name: "min_quantity",
    align: "center",
    label: "Min Qty",
    field: "min_quantity",
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
    name: "selling_price",
    align: "center",
    label: "Selling Price (Per Unit)",
    field: "selling_price",
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
    name: "category",
    align: "center",
    label: "Category",
    field: "category",
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

export { product_columns };
