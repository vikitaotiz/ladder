import axios from "axios";

const url = "https://graph.facebook.com/v17.0/113647021832228/messages";
const accessToken =
  "EAAJjpSVjrJIBO3jUZCzpvWBEOhANkscAhsUmDAheuwgmyikUNjqTXXCw00tl67K3F7RH7IZCS0bh3ZA1XIS3LgpZBKD0NhOpoQYPZA3ciFTeYiuZCaq6BYHm8gEeU26crD3DYZCdRGaLaP0mH9WCQi3ZAEmSRRXvthXGY71DDWaMRuSarRoql2heSj2HBZBorTSoZADVNrbjIEzzXPw2JAEyia";

const headers = {
  Authorization: `Bearer ${accessToken}`,
  "Content-Type": "application/json",
};

const data = {
  messaging_product: "whatsapp",
  to: "254704581595",
  type: "template",
  template: {
    name: "hello_world",
    language: {
      code: "en_US",
    },
  },
};

const notifyWhatsapp = () => {
  axios
    .post(url, data, { headers })
    .then((response) => {
      console.log("Response:", response.data);
    })
    .catch((error) => {
      console.error("Error:", error.response.data);
    });
};

export { notifyWhatsapp };
