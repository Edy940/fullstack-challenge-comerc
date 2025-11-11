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
});