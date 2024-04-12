import { base_url, forceLogout } from "../helpers";

// const get_call_module = async (path, token) => {
//   const res = await fetch(`${base_url}/${path}`, {
//     headers: {
//       "Content-Type": "application/json",
//       Authorization: `Bearer ${token}`,
//     },
//   });

//   forceLogout(res.status);

//   const res_data = res.json();

//   return res_data;
// };
const get_call_module = async (path, token, resultCode) => {
  const res = await fetch(`${base_url}/${path}?resultCode=${resultCode}`, {
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
  });

console.log(resultCode ===  resultCode);
console.log(resultCode);
  const res_data = await res.json();

  return res_data;
};

const post_call_module = async (body, path, token) => {
  const res = await fetch(`${base_url}/${path}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify(body),
  });

  forceLogout(res.status);

  const res_data = res.json();

  return res_data;
};

export { post_call_module, get_call_module };
