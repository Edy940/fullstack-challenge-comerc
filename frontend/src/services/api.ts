import axios from "axios";

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || "http://localhost:8080",
  headers: { "Content-Type": "application/json" }
});

// Intercepta 422 do backend e normaliza mensagens
api.interceptors.response.use(
  (r: any) => r,
  (error: any) => {
    if (error.response?.status === 422) {
      const errors = error.response.data?.errors || {};
      const friendly = Object.entries(errors).map(([field, msgs]: any) => `${field}: ${msgs.join(", ")}`);
      return Promise.reject({ validation: friendly.length ? friendly : ["Dados inválidos."] });
    }
    return Promise.reject(error);
  }
);

export default api;