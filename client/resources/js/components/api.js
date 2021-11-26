
export const url = "http://localhost/registerapp/server/public/api/";
export const config = {
    headers: {
      Authorization: "Bearer " + localStorage.getItem("auth.token"),
    },
  };
