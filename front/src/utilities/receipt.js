import print from "print-js";
import QRCode from "qrcode";
import { business_details } from "./helpers";

// QRCode.toDataURL(`${business_details.url}`)
//   .then((url) => (qrcode_url = url))
//   .catch((err) => {
//     console.error(err);
//   });

let qrcode_url = "";

const buildHeader = (data, receipt_data) => {
  const total_cost = data.reduce((a, b) => a + b.total, 0);

  let amount_paid = () => {
    if (
      receipt_data.payment_mode === "No Payment Mode" ||
      receipt_data.payment_mode === "Debt"
    ) {
      return "N/A";
    } else {
      return receipt_data.actual_selling_price;
    }
  };

  const header = `<div style="padding: 10px; paddinng: 5px; margin-bottom: 20px; width: 100%">
    <small>
      <div style="text-align: center;">
        <b>${receipt_data.title}</b>
        <p><img src="${qrcode_url}" width="80px" height="80px" style="margin: 0px" /></p>
        <p>BILL-${receipt_data.bill_ref}</p>
      </div>
      <hr/>
        ${business_details.print_header}
      <hr/>
      <ul style="list-style-type: none; margin: 0; padding: 0;">
        <li>Total Cost : ${total_cost}</li>
        <li>Amount Paid: ${amount_paid()}</li>
        <li>Payment Mode : ${receipt_data.payment_mode}</li>
        <li>Status : ${receipt_data.status}</li>
        <li>Served By : ${receipt_data.user}</li>
        <li>Served On : ${receipt_data.created_at}</li>
      </ul>
    </small>
  </div>`;
  return header;
};

const exportDataToPdf = async (data, columns, receipt_data) => {
  let res = await QRCode.toDataURL(`${business_details.url}`);
  if (res) {
    qrcode_url = res;
    const headerSection = buildHeader(data, receipt_data);
    print({
      printable: data,
      header: headerSection,
      properties: columns,
      type: "json",
      gridHeaderStyle: "font-weight: bold; border: 0.5px solid;",
      gridStyle:
        "border-collapse: collapse; border: 0.5px solid; padding: 3px;",
    });
  } else {
    alert("There was an error generating the receipt");
  }
};

export { exportDataToPdf };
