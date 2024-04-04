import { base_url, forceLogout } from "../helpers";

const post_call = async (payload, path) => {
  const res = await fetch(`${base_url}/${path}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(payload),
  });

  forceLogout(res.status);

  const res_data = res.json();

  return res_data;
};

const post_call_logout = async (path, token) => {
  const res = await fetch(`${base_url}/${path}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${token}`,
    },
  });

  forceLogout(res.status);

  const res_data = res.json();

  return res_data;
};

export { post_call, post_call_logout };
