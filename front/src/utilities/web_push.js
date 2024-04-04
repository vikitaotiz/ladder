import { base_url } from "./helpers";

const send_notification = (payload) => {
  if (navigator.sendBeacon) {
    window.addEventListener("visibilitychange", (event) => {
      console.log(event);
      navigator.sendBeacon(
        `${base_url}/send_notification`,
        JSON.stringify(payload)
      );
    });
  } else {
    alert("Browser does not support send beacon.");
  }
};
export { send_notification };
