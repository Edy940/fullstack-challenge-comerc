import MockAdapter from "axios-mock-adapter";
import api from "./api";
import { describe, it, expect, beforeEach, afterEach } from "vitest";

describe("api 422 mapping", () => {
  let mock: any;

  beforeEach(() => {
    mock = new MockAdapter(api);
  });

  afterEach(() => {
    mock.restore();
  });

  it("normaliza mensagens de validação", async () => {
    mock.onGet("/test").reply(422, {
      errors: { email: ["já existe"], nome: ["obrigatório"] }
    });

    await expect(api.get("/test")).rejects.toMatchObject({
      validation: expect.arrayContaining([
        expect.stringContaining("email"),
        expect.stringContaining("nome")
      ])
    });
  });

  it("trata erro genérico 500", async () => {
    mock.onGet("/test").reply(500, { message: "Internal Server Error" });

    await expect(api.get("/test")).rejects.toThrow();
  });

  it("trata erro de rede", async () => {
    mock.onGet("/test").networkError();

    await expect(api.get("/test")).rejects.toThrow();
  });

  it("trata erro 401 não autorizado", async () => {
    mock.onGet("/test").reply(401, { message: "Unauthorized" });

    await expect(api.get("/test")).rejects.toThrow();
  });

  it("trata erro 404 não encontrado", async () => {
    mock.onGet("/test").reply(404, { message: "Not Found" });

    await expect(api.get("/test")).rejects.toThrow();
  });
});
