// import { io } from "socket.io-client";
// Ngrok (Test)
// const base_url = "https://a53c-41-90-182-2.ngrok-free.app/api/v1";

// Localhost (Test)
const base_url = "http://localhost:8000/api/v1";

// Production (Shared hosting)
// const base_url = "https://jsg.missnadhifu.com/laravel/public/api/v1";

// const socket = io("http://localhost:5000");
// const socket = io(
//   "https://web-push-socket-2o8vibok6-victorotieno598.vercel.app"
// );

const forceLogout = (status) => {
  if (status === 500) {
    localStorage.removeItem("auth_user");
    window.location.reload(true);
  }
};

// const business_details = {
//   url: "https://reliable-cat-b5a401.netlify.app",
//   print_header: `
//   <div style="text-align: center;">
//   <b>Jam Street Grocery</b>
//   <p>Nairobi, Eastleigh Area</p>
//   </div>
// `,
// };

// const business_details = {
//   url: "https://inquisitive-pony-6e187b.netlify.app",
//   // url: "http://192.168.30.94:9000/verify_bill",

//   print_header: `
//     <div style="text-align: center;">
//     <h2>CLUB JB</h2>
//     <p><small><i>Nightlife at its best</i></small></p>
//     <p>
//      <a aria-label="Chat on WhatsApp" href="https://wa.me/+254113005660" style="font-family: bolder; font-size: 2em; color: green; text-decoration: none;">
//      <img height="25" width="25" alt="Chat on WhatsApp" src="https://png.pngtree.com/png-vector/20221018/ourmid/pngtree-whatsapp-mobile-software-icon-png-image_6315991.png" />
//       <span style="margin-bottom: 4px;"> : +254113005660</span><a /></p>
//     <p>Paybill: 400200</p>
//     <p>Account: 40040815</p>
//     </div>
// `,
// };

const business_details = {
  url: "https://velvety-kangaroo-c5d86a.netlify.app",
  // url: "http://192.168.30.94:9000/verify_bill",

  print_header: `
    <div style="text-align: center;">
    <b>DECKAR GRILLS AND LOUNGE</b>
    <p>Phone : 0710 980 300</p>
    <p>Nairobi, Ngara Opposite kcb Bank</p>
    </div>
`,
};

const hasPermission = (user_roles) => {
  if (user_roles.length > 0) {
    if (user_roles.some((role) => role["name"] === "Admin")) return true;
    if (user_roles.some((role) => role["name"] === "Cashier")) return true;
  }
  return false;
};

export { base_url, forceLogout, business_details, hasPermission };
